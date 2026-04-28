<?php
  require_once 'lib/temp_gc.php';

  define('UPLOAD_DIR', 'temp/');

  temp_gc(UPLOAD_DIR);

  $success = false;


  if(isset($_POST['imgBase64'])){
    $img = $_POST['imgBase64'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $filename = uniqid() . '.png';
    $file = UPLOAD_DIR . $filename;
    $success = file_put_contents($file, $data);
  }

  // print $success ? $file : 'Unable to save the file.';
  // $data['file'] = $success ? $file : 'Unable to save the file.';


  // SEND EMAIL
  if($success){ // file was successfully saved and email is valid
    $return_data['file'] = $file;
    $return_data['message'] = 'Success.';
    $return_data['status'] = 'success';
  }
  else{ // file wasn't successfully save
    $return_data['message'] = 'Unable to write the file.';
    $return_data['status'] = 'failure';
  }

  echo json_encode($return_data);

  

?>