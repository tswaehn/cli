<?php

  extract( $_GET, EXTR_PREFIX_ALL, "url" );
  extract( $_POST, EXTR_PREFIX_ALL, "url" );

  if (isset( $url_file )){
    $filename = $url_file;
    
    if(file_exists($filename)) {
	
	
	      $img = new imagick(); // [0] can be used to set page number
	      $img->setResolution(90,90);
	      $img->readImage($filename);
	      $img->setImageFormat( "jpg" );
	      $img->setImageCompression(imagick::COMPRESSION_JPEG); 
	      $img->setImageCompressionQuality(90); 

	      $img->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);

	      $imagick = $imagick->flattenImages();
	      $imagick->writeFile('pageone.jpg'); 
/*	      
	      $data = $img->getImageBlob(); 
	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=test.jpg');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . sizeof($data));
	ob_clean();
	flush();
	
	echo $data;
*/	
	exit;
      
    } else {
      die( "file does not exist" );
    }
  } else {
    sleep(5);
    die( "invalid file given" );
  }
    
   

?>
