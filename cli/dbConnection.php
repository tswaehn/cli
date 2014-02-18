<?php
  //phpinfo();
  define('_UPDATE_', 'update' );
  define('_CLEAN_', 'clean' );
  define('_FIELD_PREFIX_', 'a_' );
  
  include( 'config.txt');

  function connectToDb(){
    global $dbname,$user,$pass,$pdo;
    
    $opt = array(
      // any occurring errors wil be thrown as PDOException
      //PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
      // an SQL command to execute when connecting
      //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
    );
    
    $pdo = new PDO('mysql:host=localhost;dbname='.$dbname.';', $user, $pass, $opt);  
    $pdo->exec("set names utf8");
    
    lg("--- db connected to ".$dbname." ".date('r'));
  }
  
  function tableExists( $table ){
    global $pdo;
    
    try {
	$sql = "SELECT 1 FROM ".q($table)." LIMIT 1;";
	lg($sql);
	$result = $pdo->query( $sql);
    } catch (Exception $e) {
	lg( $e->getMessage() );
	// We got an exception == table not found
	return FALSE;
    } 
    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
  }
  
  function createTable( $table, $fields, $fieldinfo ){
    global $pdo;
    
    $field_str="";
    $count=count($fields);
    for ($i=0;$i<$count;$i++){
      $field = $fields[$i];
      
      $type=$fieldinfo[$field]['type'];
      $size=$fieldinfo[$field]['size'];
      
      $type_str = "";
      switch ($type){
	case ASCII: $type_str = "VARCHAR(".$size.")";break;
	case FLOAT: $type_str = "FLOAT";break;
	case TIMESTAMP: $type_str = "DATETIME";break;
	default:
	  $type_str = "TEXT";
	  lg( "failed to set type ");
      }
      
      $field_str .= " ".q($field)." ".$type_str;
      if ($i <($count-1)){
	$field_str.=",";
      }
    }

    try {
	$sql ="CREATE table ".q($table)." (".$field_str.") ENGINE=InnoDB;";
	
	lg( $sql) ;
	$q=$pdo->query($sql);
	

    } catch(PDOException $e) {
	lg("failed to create table ".$table);
	lg( $e->getMessage() );//Remove in production code
	return;
    }  
    
    lg("Created ".$table." Table.");
  
  }
  
  function removeTable( $table ){
    global $pdo;
    
    try {
	$sql ="DROP TABLE IF EXISTS ".q($table).";";
	
	lg( $sql) ;
	
	$pdo->exec($sql);
	
	lg("removed $table Table.");

    } catch(PDOException $e) {
	lg( $e->getMessage() );//Remove in production code
    }  
  
  }
  
  function insertIntoTable( $table, $fields, $lines ){
    global $pdo;
    
    $field_str ="";
    $last = end($fields);
    foreach ($fields as $field){
      $field_str .= $field;
      if ($field!=$last){
	$field_str .=",";
      }
    }
    
    
    $placeholder="";
    $count=count($fields);
    for ($i=0;$i<$count;$i++){
      $placeholder .= " ?";
      if ($i < ($count-1)){
	$placeholder .= ",";
      }
    }
    
    // query
    try {
      $sql = "INSERT INTO ".q($table)." VALUES (".$placeholder.")";
      //lg($sql);
      
      $q = $pdo->prepare($sql);
      
      foreach ($lines as $line){

	$data = array();
	for ($i=0;$i<$count;$i++){
	  //$data[] = preg_replace("/[^A-Za-z0-9\-\ ]/", "", $line[$i]);
	  $data[] = $line[$i];

	}
	
	$q->execute( $data );
      
      }
    } catch(PDOException $e) {
      lg( "something went wrong while inserting data");
      return;
    }
    
    lg( "insert into tables complete" );
  
  }


  function getColumns( $table ){
    global $pdo;
    
    $sql = 'SHOW COLUMNS FROM '.q($table).';';

    try {
	lg($sql);
	$result = $pdo->query( $sql);
    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
    
    $columns = array();
    foreach( $result as $item ){
      $columns[] = $item['Field'];
    }
    
    return $columns;
  }
  
  
  function searchInTable( $table, $search ){
    global $pdo;
    
    $columns = getColumns( $table );
    
    $sql = 'SELECT * FROM '.q($table).' WHERE (';
    
    $first = $columns[0];
    foreach ($columns as $item){
      if ($item == $first){
	$sql .= $item. " LIKE '%".$search."%'";
      } else {
	$sql .= ' OR '.q($item). " LIKE '%".$search."%'";
      }
    }

    //$sql .= ' );';
    $sql .= ') GROUP BY ( `nummer` );';
    
    try {
	lg($sql);
	$starttime = microtime(true); 
	$result = $pdo->query( $sql);
	$endtime = microtime(true); 
	$timediff = $endtime-$starttime;
    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
    
    lg('exec time is '.($timediff) );

    lg('found '.$result->rowCount().' items' );
    
    return $result;
  
  }
  
  function prepareTable( $table, $fields, $fieldinfo, $mode ){
    global $pdo;
    
      
    if (tableExists( $table )){
      lg( "table ".$table." exists" );
      
      if ($mode == _CLEAN_){
	removeTable( $table );
	createTable( $table, $fields, $fieldinfo );
      }
      
    } else {
      lg( "table ".$table." does not exist" );
      createTable( $table, $fields, $fieldinfo );
    }
    
    if ($mode == _UPDATE_ ){
    
    
    }
  }
  
 
  
  
  function importTable( $table, $fieldinfo, $search, $mode ){
    
    // array with 
    $data = getEDPData( $table, $search );
    
    //renderData( $data );
    
    $fields=$data['fields'];
    $lines=$data['lines'];

    prepareTable( $table, $fields, $fieldinfo, $mode );
  
    insertIntoTable( $table, $fields, $lines );
    
  }

?> 
