<?php

  $mediaFields = array("ypdf1", "ydxf", "yxls", "ytpdf", "ytlink", "bild",
		  "bbesh", "foto", "fotoz", "catpics", "catpicsz", 
		  "catpicl", "catpiclz", "caturl" );

  $mediaIgnore = array("W:\DXF\\", "W:\Bilder\\", "WWW.", "W:\\", "" );
  
  print_r( $mediaIgnore );
  
  function filterValidMedia( $article ){
  
    global $mediaFields;
    global $mediaIgnore;

    $media = array();
    
    foreach ($mediaFields as $field ){
      if (isset( $article[$field])){
      
	$ignore=0;
	foreach ($mediaIgnore as $ignore){
	  if (strcmp( $article[$field], $ignore ) == 0){
	    $ignore=1;
	    break;
	  }
	}
	
	if ($ignore==0){
	  $media[] = $article[$field];
	}
	
      }
    }
  
    return $media;
  }
  
  function renderMedia( $article ){
    div("media");
    
    //disp('<a href="./article/download.php">download</a>');
  
    $media = filterValidMedia( $article );
    
    foreach ($media as $item){
      disp('<a href="./article/download.php?file='.$item.'">'.$item.'</a>');
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

