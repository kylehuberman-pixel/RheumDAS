<?php
require_once 'config.php';
require_once 'lib/csrf.php';
require_once 'lib/temp_gc.php';

csrf_check();

define('UPLOAD_DIR', 'temp/');

temp_gc(UPLOAD_DIR);

$success = false;
$valid_email = false;
$file = null;
$return_data = [];

try {
  if (isset($_POST['emailTo'])) {
    $email_to = $_POST['emailTo'];
    $valid_email = filter_var($email_to, FILTER_VALIDATE_EMAIL) !== false;
  }

  if (isset($_POST['imgBase64'])) {
    $img = $_POST['imgBase64'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $filename = uniqid() . '.png';
    $file = UPLOAD_DIR . $filename;
    $success = file_put_contents($file, $data);
  }

  if ($success && $valid_email) {
    $payload = [
      'From'     => $MAIL_FROM_NAME . ' <' . $MAIL_FROM . '>',
      'To'       => $email_to,
      'Subject'  => 'Disease Activity Score Export',
      'HtmlBody' => 'Attached is your Disease Activity Score Report.',
      'TextBody' => 'Attached is your Disease Activity Score Report.',
      'Attachments' => [[
        'Name'        => 'disease-activity-score.png',
        'Content'     => base64_encode(file_get_contents($file)),
        'ContentType' => 'image/png',
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
    $response  = curl_exec($ch);
    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErrno = curl_errno($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if ($httpCode === 200 && isset($result['ErrorCode']) && $result['ErrorCode'] === 0) {
      $return_data['status'] = 'success';
      $return_data['message'] = 'Message has been sent';
    } else {
      error_log(sprintf(
        'Postmark send failed (export): http=%d curl_errno=%d curl_error=%s response=%s',
        $httpCode,
        $curlErrno,
        $curlError,
        is_string($response) ? substr($response, 0, 500) : 'false'
      ));
      $return_data['status'] = 'failure';
      $return_data['message'] = $result['Message']
        ?? ($curlError !== '' ? "Network error: {$curlError}" : "Postmark returned HTTP {$httpCode}");
    }
  } else {
    if (!$valid_email) {
      $return_data['message'] = 'Could not send file, missing email address.';
      $return_data['status'] = 'missing_email';
    } else {
      $return_data['message'] = 'Unable to send the file.';
      $return_data['status'] = 'failure';
    }
  }
} finally {
  // Always clean up the saved PNG, regardless of which branch ran or which
  // exception fired. temp_gc covers the catastrophic-crash case.
  if ($file !== null && file_exists($file)) {
    @unlink($file);
  }
}

echo json_encode($return_data);
