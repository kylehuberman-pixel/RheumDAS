<?php
require_once '../config.php';
require_once '../libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

function createFile($name)
{
    ob_start();
    include 'pdf.php';
    $path = 'save/' . $name . '.pdf';

    $dompdf = new Dompdf();
    $dompdf->loadHtml(ob_get_clean());
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

    $ch = curl_init('https://api.postmarkapp.com/email/withAttachments');
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
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    unlink($file);

    $result = json_decode($response, true);

    if ($httpCode === 200 && isset($result['ErrorCode']) && $result['ErrorCode'] === 0) {
        return ['status' => 'success', 'message' => 'Message has been sent'];
    }

    return [
        'status'  => 'failure',
        'message' => $result['Message'] ?? 'Message could not be sent.',
    ];
}
