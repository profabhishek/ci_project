<?php
/**
 * CLI-only diagnostic for the "two university names on one history page" issue.
 *
 * Usage (from the project root, using XAMPP's php.exe):
 *
 *     C:\xampp\php\php.exe tools\diagnose_application.php TU9339752559061
 *
 * It prints every iccr_university_response row attached to the application plus
 * the matching iccr_status_mapping row, so you can see exactly which university
 * each block on the history page was picking and confirm that the page now
 * shows the right one.
 *
 * This file deliberately refuses to run over HTTP - it dumps unredacted
 * applicant data and must never be reachable from a browser.
 */

if (PHP_SAPI !== 'cli') {
    header('HTTP/1.1 403 Forbidden');
    exit('This diagnostic can only be run from the command line.');
}

$appNo = isset($argv[1]) ? trim($argv[1]) : '';
if ($appNo === '') {
    fwrite(STDERR, "Usage: php tools/diagnose_application.php <APPLICATION_NO>\n");
    exit(1);
}

// If a base64-encoded segment was pasted straight out of the URL, decode it.
$decoded = base64_decode($appNo, true);
if (is_string($decoded) && preg_match('/^[A-Za-z]{2}[0-9]+$/', $decoded)) {
    echo "Note: input looked base64-encoded, decoded to {$decoded}\n";
    $appNo = $decoded;
}

$host = getenv('CI_DB_HOST') ?: 'localhost';
$user = getenv('CI_DB_USER') ?: 'root';
$pass = getenv('CI_DB_PASS') ?: '';
$name = getenv('CI_DB_NAME') ?: 'iccr_db';

$mysqli = @new mysqli($host, $user, $pass, $name);
if ($mysqli->connect_errno) {
    fwrite(STDERR, "DB connection failed: {$mysqli->connect_error}\n");
    exit(1);
}
$mysqli->set_charset('utf8');

function dump($mysqli, $title, $sql, $appNo) {
    echo "\n=== {$title} ===\n";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        echo "  query error: {$mysqli->error}\n";
        return array();
    }
    $stmt->bind_param('s', $appNo);
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = array();
    while ($row = $res->fetch_assoc()) {
        $rows[] = $row;
    }
    if (!$rows) {
        echo "  (no rows)\n";
    }
    foreach ($rows as $i => $row) {
        echo "  [{$i}]\n";
        foreach ($row as $k => $v) {
            if ($v === null || $v === '') continue;
            echo "      {$k}: {$v}\n";
        }
    }
    $stmt->close();
    return $rows;
}

echo "Application: {$appNo}\n";

$responses = dump(
    $mysqli,
    'iccr_university_response (one row per university the applicant was put forward to)',
    "SELECT r.id, r.regional_university, u.name AS university_name, u.status AS university_status,
            r.university_is_accept, r.confirmed_to_mission, r.scholar_acceptance,
            r.region_one_status, r.region_one_status_date, r.region_one_doc, r.course
       FROM iccr_university_response r
       LEFT JOIN iccr_univercities u ON u.id = r.regional_university
      WHERE r.application_id = ?
      ORDER BY r.id ASC",
    $appNo
);

$mapping = dump(
    $mysqli,
    'iccr_status_mapping',
    "SELECT application_no, status, scholarship_id, regional_university, mission_status,
            scholar_acceptance, medical_fitness, region_one_status, region_one_status_date
       FROM iccr_status_mapping
      WHERE application_no = ?",
    $appNo
);

dump(
    $mysqli,
    'iccr_university_response_by_hqrs (Ayush / "fourth option" flow only)',
    "SELECT id, regional_university, university_is_accept, confirmed_to_mission,
            region_one_status, region_one_status_date
       FROM iccr_university_response_by_hqrs
      WHERE application_id = ?",
    $appNo
);

// Mirror of Common_model::pickFinalUniversityResponse() so you can see which row
// the history page will now treat as the final allotment.
echo "\n=== Resolved final university (what the page will show) ===\n";
$mappingUniversityId = !empty($mapping[0]['regional_university']) ? (int) $mapping[0]['regional_university'] : null;
$pick = null;
$reason = '';
foreach (array(
    'accepted + confirmed_to_mission' => function ($r) { return (int) $r['university_is_accept'] === 1 && (int) $r['confirmed_to_mission'] === 1; },
    'confirmed_to_mission only'       => function ($r) { return (int) $r['confirmed_to_mission'] === 1; },
) as $label => $test) {
    foreach ($responses as $r) {
        if ($test($r)) { $pick = $r; $reason = $label; break 2; }
    }
}
if ($pick === null && $mappingUniversityId !== null) {
    foreach ($responses as $r) {
        if ((int) $r['university_is_accept'] === 1 && (int) $r['regional_university'] === $mappingUniversityId) {
            $pick = $r; $reason = 'accepted + matches iccr_status_mapping.regional_university'; break;
        }
    }
}
if ($pick === null) {
    foreach ($responses as $r) {
        if ((int) $r['university_is_accept'] === 1) { $pick = $r; $reason = 'first accepted row (lowest id)'; break; }
    }
}
if ($pick === null) {
    echo "  NA - no university has accepted this applicant yet.\n";
} else {
    echo "  {$pick['university_name']} (id {$pick['regional_university']}, response row {$pick['id']})\n";
    echo "  reason: {$reason}\n";
}

$accepted = array();
foreach ($responses as $r) {
    if ((int) $r['university_is_accept'] === 1) {
        $accepted[$r['regional_university']] = $r['university_name'];
    }
}
if (count($accepted) > 1) {
    echo "\n  WARNING: " . count($accepted) . " universities are flagged as having accepted this\n";
    echo "  applicant (" . implode(', ', $accepted) . ").\n";
    echo "  That is what produced two different names on the old history page.\n";
    echo "  Only the row above is confirmed onward to the mission; the others are\n";
    echo "  stale acceptances that should be reviewed by ICCR HQ.\n";
}

$mysqli->close();
echo "\nDone.\n";
