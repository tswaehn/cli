<?php

  $mediaFields = array("ypdf1", "ydxf", "yxls", "ytpdf", "ytlink", "bild",
		  "bbesh", "foto", "fotoz", "catpics", "catpicsz", 
		  "catpicl", "catpiclz", "caturl" );

  $mediaIgnore = array("W:\DXF\\", "W:\Bilder\\", "W:\PDF\\", "WWW.", "W:\\", "" );
  
  function filterValidMedia( $article ){
  
    global $mediaFields;
    global $mediaIgnore;

    $media = array();
    
    foreach ($mediaFields as $field ){
      $name = $article[$field];
      if (isset( $name )){
      
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
  
  function renderMediaDir( $dir ){
  
  }
  
  
  function renderMedia( $article ){
    div("media");
  
    $media = filterValidMedia( $article );
    
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

