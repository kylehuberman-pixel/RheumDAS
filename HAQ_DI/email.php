<?php
require_once '../config.php';
require_once '../libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

function createFile($name)
{
    ob_start();
    $renderError = null;
    try {
        include __DIR__ . '/pdf.php';
    } catch (\Throwable $e) {
        $renderError = $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine();
    }
    $html = ob_get_clean();

    error_log(sprintf(
        'createFile: html_len=%d render_err=%s html_head=%s',
        strlen($html),
        $renderError ?? 'none',
        json_encode(substr($html, 0, 300))
    ));

    $safeName = preg_replace('/[^A-Za-z0-9_-]/', '_', $name);
    $path = __DIR__ . '/save/' . $safeName . '.pdf';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->render();

    file_put_contents($path, $dompdf->output());

    return $path;
}

function send($to, $body)
{
    global $POSTMARK_TOKEN, $MAIL_FROM, $MAIL_FROM_NAME;

    $file = createFile(date("Y-m-d H:i:s") . '_' . $to);

    $payload = [
        'From'     => $MAIL_FROM_NAME . ' <' . $MAIL_FROM . '>',
        'To'       => $to,
        'Subject'  => 'HAQ DI',
        'HtmlBody' => $body,
        'TextBody' => strip_tags($body),
        'Attachments' => [[
            'Name'        => 'HAQ_DI.pdf',
            'Content'     => base64_encode(file_get_contents($file)),
            'ContentType' => 'application/pdf',
        ]],
    ];

    $ch = curl_init('https://api.postmarkapp.com/email');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'Accept: application/json',
            'Content-Type: application/json',
            'X-Postmark-Server-Token: ' . $POSTMARK_TOKEN,
        ],
        CURLOPT_POSTFIELDS     => json_encode($payload),
    ]);
    $response  = curl_exec($ch);
    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErrno = curl_errno($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    $fileBytes   = file_exists($file) ? filesize($file) : -1;
    $attachBytes = strlen($payload['Attachments'][0]['Content']);
    $bodyBytes   = strlen($payload['HtmlBody'] ?? '');

    unlink($file);

    $result = json_decode($response, true);
    $ok = ($httpCode === 200 && isset($result['ErrorCode']) && $result['ErrorCode'] === 0);

    error_log(sprintf(
        'Postmark send (HAQ_DI): ok=%d http=%d file_bytes=%d attach_b64=%d body_bytes=%d errno=%d err=%s response=%s',
        $ok ? 1 : 0,
        $httpCode,
        $fileBytes,
        $attachBytes,
        $bodyBytes,
        $curlErrno,
        $curlError,
        is_string($response) ? substr($response, 0, 500) : 'false'
    ));

    if ($ok) {
        return ['status' => 'success', 'message' => 'Message has been sent'];
    }

    $userMessage = $result['Message']
        ?? ($curlError !== '' ? "Network error: {$curlError}" : "Postmark returned HTTP {$httpCode}");

    return ['status' => 'failure', 'message' => $userMessage];
}
