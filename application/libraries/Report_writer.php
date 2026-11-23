<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Report_writer - turns a Report_engine result into a download.
 *
 *   xlsx   real .xlsx written with PHP's ZipArchive (no PHPExcel / PhpSpreadsheet needed).
 *          If ZipArchive is missing on the server it falls back to an Excel XML file (.xls),
 *          which Excel opens normally.
 *   csv    UTF-8 with a BOM so Excel shows names correctly; every section one after another.
 *   print  handled by the view report_print.php (browser: Print -> Save as PDF).
 *
 * One sheet per section. Numbers stay numbers; text (application numbers, dates) stays text.
 */
class Report_writer
{
    public function filename($report, $ext)
    {
        $t = preg_replace('/[^A-Za-z0-9]+/', '_', $report['title']);
        return 'ICCR_' . trim($t, '_') . '_' . date('d-m-Y') . '.' . $ext;
    }

    /** Sends the file and stops. */
    public function send($report, $format)
    {
        if ($format === 'csv') {
            $name = $this->filename($report, 'csv');
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $name . '"');
            header('Cache-Control: no-store');
            echo $this->csv_bytes($report);
            exit;
        }
        $bytes = class_exists('ZipArchive') ? $this->xlsx_bytes($report) : FALSE;
        if ($bytes !== FALSE) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $this->filename($report, 'xlsx') . '"');
            header('Cache-Control: no-store');
            echo $bytes;
            exit;
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $this->filename($report, 'xls') . '"');
        header('Cache-Control: no-store');
        echo $this->xml_bytes($report);
        exit;
    }

    /* -------------------- helpers -------------------- */

    private function esc($s)
    {
        $s = (string) $s;
        $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $s);
        return htmlspecialchars($s, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    private function col($i)
    {
        $s = '';
        $i++;
        while ($i > 0) { $m = ($i - 1) % 26; $s = chr(65 + $m) . $s; $i = (int) (($i - $m - 1) / 26); }
        return $s;
    }

    private function sheet_names($sections)
    {
        $used = array(); $out = array();
        foreach ($sections as $s) {
            $n = trim(preg_replace('/[\\\\\/\?\*\[\]:]+/', ' ', $s['title']));
            if ($n === '') { $n = 'Sheet'; }
            $n = function_exists('mb_substr') ? mb_substr($n, 0, 31, 'UTF-8') : substr($n, 0, 31);
            $base = $n; $k = 2;
            while (isset($used[strtolower($n)])) {
                $suffix = ' ' . $k++;
                $n = (function_exists('mb_substr') ? mb_substr($base, 0, 31 - strlen($suffix), 'UTF-8') : substr($base, 0, 31 - strlen($suffix))) . $suffix;
            }
            $used[strtolower($n)] = 1;
            $out[] = $n;
        }
        return $out;
    }

    private function widths($s)
    {
        $w = array();
        foreach ($s['columns'] as $i => $c) { $w[$i] = min(60, max(8, strlen($c) + 2)); }
        foreach ($s['rows'] as $r) {
            foreach ($r as $i => $v) {
                $l = function_exists('mb_strlen') ? mb_strlen((string) $v, 'UTF-8') : strlen((string) $v);
                if ($l + 2 > $w[$i]) { $w[$i] = min(60, $l + 2); }
            }
        }
        return $w;
    }

    private function is_num($v)
    {
        return is_int($v) || is_float($v);
    }

    /* -------------------- CSV -------------------- */

    public function csv_bytes($report)
    {
        $fh = fopen('php://temp', 'w+');
        fwrite($fh, "\xEF\xBB\xBF");
        fputcsv($fh, array($report['title']));
        if (!empty($report['params_text'])) { fputcsv($fh, array($report['params_text'])); }
        foreach ($report['sections'] as $s) {
            fputcsv($fh, array(''));
            fputcsv($fh, array($s['title']));
            if (!empty($s['note'])) { fputcsv($fh, array($s['note'])); }
            fputcsv($fh, $s['columns']);
            foreach ($s['rows'] as $r) {
                $line = array();
                foreach ($r as $v) {
                    $v = (string) $v;
                    if ($v !== '' && strpos('=+@', $v[0]) !== FALSE) { $v = "'" . $v; }   // stop spreadsheet formulas
                    $line[] = $v;
                }
                fputcsv($fh, $line);
            }
        }
        rewind($fh);
        $out = stream_get_contents($fh);
        fclose($fh);
        return $out;
    }

    /* -------------------- XLSX (ZipArchive) -------------------- */

    public function xlsx_bytes($report)
    {
        if (!class_exists('ZipArchive')) { return FALSE; }
        $tmp = tempnam(sys_get_temp_dir(), 'rep');
        $zip = new ZipArchive();
        if ($zip->open($tmp, ZipArchive::OVERWRITE) !== TRUE) { return FALSE; }
        $names = $this->sheet_names($report['sections']);
        $n = count($names);

        $ct = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>';
        for ($i = 1; $i <= $n; $i++) { $ct .= '<Override PartName="/xl/worksheets/sheet' . $i . '.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'; }
        $ct .= '</Types>';
        $zip->addFromString('[Content_Types].xml', $ct);
        $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');

        $wb = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets>';
        $rel = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
        foreach ($names as $i => $nm) {
            $wb .= '<sheet name="' . $this->esc($nm) . '" sheetId="' . ($i + 1) . '" r:id="rId' . ($i + 1) . '"/>';
            $rel .= '<Relationship Id="rId' . ($i + 1) . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet' . ($i + 1) . '.xml"/>';
        }
        $wb .= '</sheets></workbook>';
        $rel .= '<Relationship Id="rId' . ($n + 1) . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>';
        $zip->addFromString('xl/workbook.xml', $wb);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $rel);
        $zip->addFromString('xl/styles.xml', $this->styles_xml());

        foreach ($report['sections'] as $i => $s) { $zip->addFromString('xl/worksheets/sheet' . ($i + 1) . '.xml', $this->sheet_xml($report, $s)); }
        $zip->close();
        $bytes = file_get_contents($tmp);
        @unlink($tmp);
        return $bytes;
    }

    private function styles_xml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="5">'
            . '<font><sz val="10"/><name val="Arial"/></font>'
            . '<font><b/><sz val="10"/><color rgb="FFFFFFFF"/><name val="Arial"/></font>'
            . '<font><b/><sz val="14"/><name val="Arial"/></font>'
            . '<font><i/><sz val="10"/><color rgb="FF595959"/><name val="Arial"/></font>'
            . '<font><b/><sz val="10"/><name val="Arial"/></font>'
            . '</fonts>'
            . '<fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FF1F3864"/><bgColor indexed="64"/></patternFill></fill></fills>'
            . '<borders count="2"><border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border><left style="thin"><color rgb="FFBFBFBF"/></left><right style="thin"><color rgb="FFBFBFBF"/></right><top style="thin"><color rgb="FFBFBFBF"/></top><bottom style="thin"><color rgb="FFBFBFBF"/></bottom><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="6">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1"/>'
            . '<xf numFmtId="0" fontId="3" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="4" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
            . '</cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>';
    }

    private function cell($ref, $v, $style)
    {
        if ($this->is_num($v)) { return '<c r="' . $ref . '" s="' . $style . '"><v>' . $v . '</v></c>'; }
        $v = (string) $v;
        if ($v === '') { return '<c r="' . $ref . '" s="' . $style . '"/>'; }
        return '<c r="' . $ref . '" s="' . $style . '" t="inlineStr"><is><t xml:space="preserve">' . $this->esc($v) . '</t></is></c>';
    }

    private function sheet_xml($report, $s)
    {
        $w = $this->widths($s);
        $cols = '<cols>';
        foreach ($w as $i => $x) { $cols .= '<col min="' . ($i + 1) . '" max="' . ($i + 1) . '" width="' . $x . '" customWidth="1"/>'; }
        $cols .= '</cols>';

        $rows = ''; $r = 1;
        $rows .= '<row r="' . $r . '">' . $this->cell('A' . $r, $s['title'] . ' - ' . $report['title'], 2) . '</row>'; $r++;
        $sub = !empty($report['params_text']) ? $report['params_text'] : '';
        $sub .= ($sub !== '' ? '   |   ' : '') . 'Generated ' . date('d-m-Y H:i') . ' from the A2A portal';
        $rows .= '<row r="' . $r . '">' . $this->cell('A' . $r, $sub, 3) . '</row>'; $r++;
        if (!empty($s['note'])) {
            $rows .= '<row r="' . $r . '" ht="48" customHeight="1">' . $this->cell('A' . $r, $s['note'], 3) . '</row>'; $r++;
        }
        $r++;
        $hdr = $r;
        $line = '<row r="' . $r . '" ht="30" customHeight="1">';
        foreach ($s['columns'] as $i => $c) { $line .= $this->cell($this->col($i) . $r, $c, 1); }
        $rows .= $line . '</row>'; $r++;
        foreach ($s['rows'] as $row) {
            $bold = (isset($row[0]) && $row[0] === 'Total') || (isset($row[1]) && $row[1] === 'Total' && $row[0] === '');
            $line = '<row r="' . $r . '">';
            foreach ($s['columns'] as $i => $c) { $line .= $this->cell($this->col($i) . $r, isset($row[$i]) ? $row[$i] : '', $bold ? 5 : 4); }
            $rows .= $line . '</row>'; $r++;
        }
        $pane = '<sheetViews><sheetView workbookViewId="0"><pane ySplit="' . $hdr . '" topLeftCell="A' . ($hdr + 1) . '" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>';
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . $pane . '<sheetFormatPr defaultRowHeight="15"/>' . $cols . '<sheetData>' . $rows . '</sheetData></worksheet>';
    }

    /* -------------------- Excel XML fallback (.xls) -------------------- */

    public function xml_bytes($report)
    {
        $names = $this->sheet_names($report['sections']);
        $x = '<?xml version="1.0" encoding="UTF-8"?><?mso-application progid="Excel.Sheet"?>'
           . '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
           . '<Styles><Style ss:ID="h"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#1F3864" ss:Pattern="Solid"/></Style>'
           . '<Style ss:ID="t"><Font ss:Bold="1" ss:Size="14"/></Style><Style ss:ID="b"><Font ss:Bold="1"/></Style></Styles>';
        foreach ($report['sections'] as $i => $s) {
            $x .= '<Worksheet ss:Name="' . $this->esc($names[$i]) . '"><Table>';
            $x .= '<Row><Cell ss:StyleID="t"><Data ss:Type="String">' . $this->esc($s['title'] . ' - ' . $report['title']) . '</Data></Cell></Row>';
            if (!empty($report['params_text'])) { $x .= '<Row><Cell><Data ss:Type="String">' . $this->esc($report['params_text']) . '</Data></Cell></Row>'; }
            if (!empty($s['note'])) { $x .= '<Row><Cell><Data ss:Type="String">' . $this->esc($s['note']) . '</Data></Cell></Row>'; }
            $x .= '<Row/><Row>';
            foreach ($s['columns'] as $c) { $x .= '<Cell ss:StyleID="h"><Data ss:Type="String">' . $this->esc($c) . '</Data></Cell>'; }
            $x .= '</Row>';
            foreach ($s['rows'] as $row) {
                $bold = (isset($row[0]) && $row[0] === 'Total');
                $x .= '<Row>';
                foreach ($s['columns'] as $j => $c) {
                    $v = isset($row[$j]) ? $row[$j] : '';
                    $st = $bold ? ' ss:StyleID="b"' : '';
                    $x .= $this->is_num($v) ? '<Cell' . $st . '><Data ss:Type="Number">' . $v . '</Data></Cell>' : '<Cell' . $st . '><Data ss:Type="String">' . $this->esc($v) . '</Data></Cell>';
                }
                $x .= '</Row>';
            }
            $x .= '</Table></Worksheet>';
        }
        return $x . '</Workbook>';
    }
}
