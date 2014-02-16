<?php
  
  extract( $_GET, EXTR_PREFIX_ALL, "url" );
  extract( $_POST, EXTR_PREFIX_ALL, "url" );

  if (isset( $url_file )){
    $filename = $url_file;
    
    if (file_exists( $filename )){
    
      //$filename = 'Test.pdf'; // of course find the exact filename....        
      header('Pragma: public');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Cache-Control: private', false); // required for certain browsers 
      header('Content-Type: application/pdf');

      header('Content-Disposition: attachment; filename="'. basename($filename) . '";');
      header('Content-Transfer-Encoding: binary');
      header('Content-Length: ' . filesize($filename));

      readfile($filename);

      exit;
      
    } else {
      die();
    }
  } else {
    die();
  }
?>
