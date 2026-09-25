<?php
/**
 * Standalone SMTP connectivity test (no framework, no dependencies).
 * Mirrors the mail config used by the ICCR CodeIgniter app
 * (application/controllers/Home.php -> testSmtp()).
 *
 * Usage:
 *   CLI:     php smtp_test.php you@example.com
 *   Browser: https://server/smtp_test.php?to=you@example.com
 *
 * DELETE THIS FILE FROM THE SERVER AFTER TESTING.
 */

// ---- Config extracted from the project ------------------------------------
$cfg = [
    'host'     => 'relay.nic.in',
    'port'     => 25,
    'timeout'  => 7,
    'secure'   => '',        // '' | 'tls' (STARTTLS) | 'ssl' (implicit, e.g. port 465)
    'user'     => '',        // relay.nic.in is used without auth (IP-whitelisted relay)
    'pass'     => '',
    'from'     => 'splspd.iccr@nic.in',
    'fromName' => 'ICCR SMTP Test',
    'to'       => 'jhaabhishek910@gmail.com',
];
// ---------------------------------------------------------------------------

$isCli = PHP_SAPI === 'cli';
if ($isCli && !empty($argv[1]))  $cfg['to'] = $argv[1];
if (!$isCli && !empty($_GET['to'])) $cfg['to'] = $_GET['to'];
if (!$isCli) header('Content-Type: text/plain; charset=utf-8');

function out($s) { echo $s, "\n"; @ob_flush(); flush(); }

function smtp_read($fp) {
    $data = '';
    while (($line = fgets($fp, 515)) !== false) {
        $data .= $line;
        if (isset($line[3]) && $line[3] === ' ') break; // last line of reply
    }
    out('S: ' . rtrim(str_replace("\r\n", "\n   ", $data)));
    return $data;
}

function smtp_cmd($fp, $cmd, $expect, $mask = false) {
    out('C: ' . ($mask ? '********' : $cmd));
    fwrite($fp, $cmd . "\r\n");
    $resp = smtp_read($fp);
    $code = (int) substr($resp, 0, 3);
    if (!in_array($code, (array) $expect, true)) {
        throw new RuntimeException("Unexpected reply to '" . ($mask ? '***' : $cmd) . "': $resp");
    }
    return $resp;
}

out('=== SMTP TEST ===');
out('Date        : ' . date('c'));
out('This server : ' . gethostname() . ' (' . ($_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname())) . ')');
out('PHP         : ' . PHP_VERSION . ' | OpenSSL: ' . (extension_loaded('openssl') ? 'yes' : 'NO'));
out("Target      : {$cfg['host']}:{$cfg['port']} secure=" . ($cfg['secure'] ?: 'none'));
out('DNS         : ' . $cfg['host'] . ' -> ' . implode(', ', gethostbynamel($cfg['host']) ?: ['RESOLVE FAILED']));
out('');

$ok = false;
$t0 = microtime(true);
try {
    $remote = ($cfg['secure'] === 'ssl' ? 'ssl://' : 'tcp://') . $cfg['host'] . ':' . $cfg['port'];
    $fp = @stream_socket_client($remote, $errno, $errstr, $cfg['timeout']);
    if (!$fp) {
        throw new RuntimeException("TCP connect failed: [$errno] $errstr (firewall / port blocked / host unreachable)");
    }
    stream_set_timeout($fp, $cfg['timeout']);
    out(sprintf('Connected in %.2fs', microtime(true) - $t0));

    $greet = smtp_read($fp);
    if ((int) substr($greet, 0, 3) !== 220) throw new RuntimeException("Bad greeting: $greet");

    $ehloHost = gethostname() ?: 'localhost';
    smtp_cmd($fp, "EHLO $ehloHost", 250);

    if ($cfg['secure'] === 'tls') {
        smtp_cmd($fp, 'STARTTLS', 220);
        if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            throw new RuntimeException('STARTTLS negotiation failed');
        }
        smtp_cmd($fp, "EHLO $ehloHost", 250);
    }

    if ($cfg['user'] !== '') {
        smtp_cmd($fp, 'AUTH LOGIN', 334);
        smtp_cmd($fp, base64_encode($cfg['user']), 334, true);
        smtp_cmd($fp, base64_encode($cfg['pass']), 235, true);
    }

    smtp_cmd($fp, "MAIL FROM:<{$cfg['from']}>", 250);
    smtp_cmd($fp, "RCPT TO:<{$cfg['to']}>", [250, 251]);
    smtp_cmd($fp, 'DATA', 354);

    $host = gethostname();
    $body = "SMTP test from server: $host\r\nSent at: " . date('c') . "\r\nRelay: {$cfg['host']}:{$cfg['port']}\r\n";
    $msg  = "From: {$cfg['fromName']} <{$cfg['from']}>\r\n"
          . "To: <{$cfg['to']}>\r\n"
          . "Subject: SMTP Test from $host\r\n"
          . 'Date: ' . date('r') . "\r\n"
          . 'Message-ID: <' . uniqid('', true) . '@' . $host . ">\r\n"
          . "MIME-Version: 1.0\r\n"
          . "Content-Type: text/plain; charset=utf-8\r\n\r\n"
          . preg_replace('/^\./m', '..', $body);   // dot-stuffing
    fwrite($fp, $msg . "\r\n.\r\n");
    out('C: <message body>');
    $resp = smtp_read($fp);
    if ((int) substr($resp, 0, 3) !== 250) throw new RuntimeException("Message rejected: $resp");

    smtp_cmd($fp, 'QUIT', 221);
    fclose($fp);
    $ok = true;
} catch (Throwable $e) {
    out('');
    out('ERROR: ' . $e->getMessage());
}

out('');
out(sprintf('RESULT: %s (%.2fs)', $ok ? "SUCCESS - mail accepted for {$cfg['to']}" : 'FAILED', microtime(true) - $t0));
exit($ok ? 0 : 1);
