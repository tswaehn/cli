<?php
/*
 * Created on 16.01.2010
 * file showRemoteInfos.php
 * part of OpenImageShop_news
 * 
 * by tswaehn (http://sourceforge.net/users/tswaehn/)
 */
 
  function getRemoteIP(){

	  if (isset($_SERVER['HTTP_X_REMOTE_ADDR'])) {
	    $ip = $_SERVER['HTTP_X_REMOTE_ADDR'];
	  } else {
	    $ip = $_SERVER['REMOTE_ADDR'];
	  }
	  
	  return $ip; 	
  }
 
  function getRemoteInfos(){

    if (isset($_SERVER['HTTP_X_REMOTE_ADDR'])) {
      $ip = $_SERVER['HTTP_X_REMOTE_ADDR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }

    $host = gethostbyaddr($ip);
    
    // package infos
    $info["ip"] = $ip;
    $info["host"] = $host;
    
    return $info;    
  }
 

 
?>
 
