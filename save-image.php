<?php
  require_once 'lib/temp_gc.php';

  define('UPLOAD_DIR', 'temp/');
  define('MAX_IMAGE_BYTES', 5 * 1024 * 1024); // 5 MB cap on decoded PNG

  temp_gc(UPLOAD_DIR);

  $success = false;
  $return_data = [];

  if (isset($_POST['imgBase64'])) {
    $img = $_POST['imgBase64'];

    // Reject oversized payloads before decoding (~4/3 expansion for base64).
    if (strlen($img) > MAX_IMAGE_BYTES * 2) {
      http_response_code(413);
      echo json_encode(['status' => 'failure', 'message' => 'Image too large.']);
      exit;
    }

    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img, true);

    if ($data === false || strlen($data) > MAX_IMAGE_BYTES) {
      http_response_code(400);
      echo json_encode(['status' => 'failure', 'message' => 'Invalid image data.']);
      exit;
    }

    // Confirm it's actually an image (and PNG, since the .png extension implies it).
    $info = @getimagesizefromstring($data);
    if ($info === false || $info['mime'] !== 'image/png') {
      http_response_code(400);
      echo json_encode(['status' => 'failure', 'message' => 'Not a valid PNG.']);
      exit;
    }

    $filename = uniqid() . '.png';
    $file = UPLOAD_DIR . $filename;
    $success = file_put_contents($file, $data);
  }

  if ($success) {
    $return_data['file'] = $file;
    $return_data['message'] = 'Success.';
    $return_data['status'] = 'success';
  } else {
    $return_data['message'] = 'Unable to write the file.';
    $return_data['status'] = 'failure';
  }

  echo json_encode($return_data);
