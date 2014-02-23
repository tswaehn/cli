<?php
  date_default_timezone_set('Europe/Berlin');

  extract( $_GET, EXTR_PREFIX_ALL, "url" );
  extract( $_POST, EXTR_PREFIX_ALL, "url" );

  $logging = "";
  
  function q($text){
    return "`".$text."`";
  }
  
  function lg( $text ){
    global $logging;
    $text .= "\n";
    $logging .= $text;
  }
  
  function storeAllLog(){
    global $logging;
    
    $logfile="/tmp/sql.log";
    file_put_contents( $logfile, $logging, FILE_APPEND);
    
  }

  function getGlobal( $var ){
    
    if (!isset($GLOBALS[$var])){
      $ret='';
    } else {
      $ret=$GLOBALS[$var];
    }

    return $ret;
  }

  function getUrlParam( $var ){
  
    $urlParam = 'url_'.$var;
    
    $ret = getGlobal( $urlParam );
    return $ret;
  }

  
  $search = getUrlParam('search');
  
  if ($search ==''){
    $search ='bnc';
  }
  

  function in_arrayi($needle, $haystack) {
      return in_array(strtolower($needle), array_map('strtolower', $haystack));
  }
  
  function generateColors( $count ){
    
    $red=rand(200,256);
    $green=rand(200,256);
    $blue=rand(200,256);
  
    $colors=array();
    for ($i=0;$i<$count;$i++){
      $mix["r"]=$red;
      $mix["g"]=$green;
      $mix["b"]=$blue;
      
      $red = rand(200,256);
      $green = rand(200,256);
      $blue = rand(200,256);

      // mix the color
      $red = ($red + $mix["r"]) / 2;
      $green = ($green + $mix["g"]) / 2;
      $blue = ($blue + $mix["b"]) / 2;

      $color= "rgb(".floor($red).",".floor($green).",".floor($blue).");";
      
      $colors[$i]=$color;
    }
    print_r($colors);
    return $colors;

  }
    
?> 
 
