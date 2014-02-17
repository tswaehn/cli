<?php
  date_default_timezone_set('Europe/London');

  extract( $_GET, EXTR_PREFIX_ALL, "url" );
  extract( $_POST, EXTR_PREFIX_ALL, "url" );

  
  function q($text){
    return "`".$text."`";
  }
  
  function lg( $text ){
    echo "log>".$text."<br>";
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
  
    
?> 
 
