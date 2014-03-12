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

  

  function dbAddClientAccess( $ip, $host, $info = "" ){
    
    $table = DB_CLIENT_ACCESS;
    
    // INSERT INTO table ( `id` ,`timestamp` ,`ip` ,`desc`) 
    //		VALUES (NULL ,CURRENT_TIMESTAMP , '".$ip."', NULL);";
    $sql = "INSERT INTO ".q($table)." ( `timestamp`, `ip`, `host`, `info` ) ";
    $sql.= "VALUES ( CURRENT_TIMESTAMP, '".$ip."', '".$host."', '".$info."' );";
      
    dbExecute( $sql );
    
  
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
    
    global $action;
    dbAddClientAccess( $ip, $host, $action );
    
    return $info;    
  }
 

 
?>
 
