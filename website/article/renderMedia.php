<?php

  $mediaFields = array("ypdf1", "ydxf", "yxls", "ytpdf", "ytlink", "bild",
		  "bbesch", "foto", "fotoz", "catpics", "catpicsz", 
		  "catpicl", "catpiclz", "caturl" );

  $mediaIgnore = array("W:\DXF\\", "W:\Bilder\\", "W:\PDF\\", "W:\Doku\\", "WWW.", "W:\\", "" );
  
  $mediaThumbnail = array( "png", "jpg", "jpeg", "gif", "tif" );
  
  function filterValidMedia( $article ){
  
    global $mediaFields;
    global $mediaIgnore;

    $media = array();
    
    foreach ($mediaFields as $field ){
      if (isset( $article[$field] )){
	$name = $article[$field];
	$ignore=0;
	foreach ($mediaIgnore as $ignore){
	  if (strcmp( $name, $ignore ) == 0){
	    $ignore=1;
	    break;
	  }
	}
	
	if ($ignore==0){
	  // replace mapped drive by unc
	  $name=str_replace("W:\\", "\\\\HSEB-SV2\\Daten\\", $name);
	  $media[] = $name;
	}
	
      }
    }
  
    return $media;
  }
  
  function renderMediaFile( $file ){
    $name = basename( $file );
    //$dir = dirname( $file );
    
    disp('<a href="./article/download.php?file='.$file.'">'.$name.'</a>');
  
  }

  function dir_contents_recursive($dir, &$result=array() ) {
      // open handler for the directory
      $iter = new DirectoryIterator($dir);

      foreach( $iter as $item ) {
	  // make sure you don't try to access the current dir or the parent
	  if ($item != '.' && $item != '..') {
		  if( $item->isDir() ) {
			  // call the function on the folder
			  dir_contents_recursive("$dir/$item", $result);
		  } else {
			  // print files
			  $file =  $dir . "/" .$item->getFilename();
			  $result[] = $file;
		  }
	  }
      }
      
      return $result;
  }

  
  function renderMediaDir( $dir ){
    $max_display = 30;
    
    $result = dir_contents_recursive( $dir );
    
    $i=0;
    foreach ( $result as $file ){
      renderMediaFile( $file );
      
      // limit results
      $i++;
      if($i>=$max_display){
	break;
      }
    }
    
    if ($i==$max_display){
      $count = sizeof($result)-$max_display;
      disp('There are about '.$count.' more items');
    }

  }
  
  function renderThumbnail( $media ){
    global $mediaThumbnail;

    foreach ($media as $item ){
      if (is_dir($item)){
	$result=dir_contents_recursive( $item );
	foreach ($result as $newitem){
	  $media[] = $newitem;
	}
      }
    }

    $images = array();
    
    foreach ($media as $item ){
      
      if (is_file($item)){
	$info = pathinfo( $item );
	
	if (isset($info["extension"])){
	  $ext = $info["extension"];
	  
	  if (in_array( $ext, $mediaThumbnail)){
	    $images[] = $item;
	  }
	}
      }
    }
     
    foreach ($images as $image){
    
      echo ('<img src="./article/download.php?file='.$image.'" width="100"  >');
    }
  
  }
  
  function renderMedia( $article ){
    div("media");
  
    $media = filterValidMedia( $article );

    // add test folder
    $media[] = "/home/tswaehn/public_html/git_dev/abas";
    
    // find a thumbnail for display
    renderThumbnail( $media );
/*    
    // render each item
    foreach ($media as $item){
      if (is_file( $item )){
	renderMediaFile( $item );
      } else if (is_dir( $item )){
	renderMediaDir( $item );
      } else {
	disp("non-existent media ".$item );
	renderMediaFile( $item );
      }
      
    }
    
*/    
    /*
    
    disp( "pdf ".$article["ypdf1"] );
    disp( "dxf ".$article["ydxf"] );
    disp( "dxf ".$article["yxls"] );
    disp( "dxf ".$article["ytpdf"] );
    disp( "dxf ".$article["ytlink"] );
    
    
    disp( "bild ".$article["bild"] );
    disp( "doku ".$article["bbesch"] );
    disp( "foto ".$article["foto"] );
    disp( "foto ".$article["fotoz"] );
    
    disp( "katalog foto ".$article["catpics"] );
    disp( "katalog foto ".$article["catpicsz"] );    

    disp( "katalog foto ".$article["catpicl"] );    
    disp( "katalog foto ".$article["catpiclz"] );    
    disp( "katalog foto ".$article["caturl"] );    
    
    */
    
    ediv();  
    
    
    
  }
  
  
?>

