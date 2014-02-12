<?php
  //phpinfo();
  define('_UPDATE_', 'update' );
  define('_CLEAN_', 'clean' );
  define('_FIELD_PREFIX_', 'a_' );
  
  include( 'config.txt');
  include( 'lib.php' );
  include( 'EDPConsole.php');

  function connectToDb(){
    global $dbname,$user,$pass,$pdo;
    
    $opt = array(
      // any occurring errors wil be thrown as PDOException
      //PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
      // an SQL command to execute when connecting
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
    );
    
    $pdo = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass, $opt);  
    
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
  
  function createTable( $table, $fields ){
    global $pdo;
    
    $field_str="";
    $count=count($fields);
    for ($i=0;$i<$count;$i++){
      $field_str .= " ".q($fields[$i])." TEXT";
      if ($i <($count-1)){
	$field_str.=",";
      }
    }

    try {
	$sql ="CREATE table ".q($table)." (".$field_str.");";
	
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
	  $data[] = preg_replace("/[^A-Za-z0-9]/", "", $line[$i]);

	}
	
	$q->execute( $data );
      
      }
    } catch(PDOException $e) {
      lg( "something went wrong while inserting data");
      return;
    }
    
    lg( "insert into tables complete" );
  
  }
  
  function prepareTable( $table, $fields, $mode ){
    global $pdo;
    
      
    if (tableExists( $table )){
      lg( "table ".$table." exists" );
      
      if ($mode == _CLEAN_){
	removeTable( $table );
	createTable( $table, $fields );
      }
      
    } else {
      lg( "table ".$table." does not exist" );
      createTable( $table, $fields );
    }
    
    if ($mode == _UPDATE_ ){
    
    
    }
  }
  
 
  
  
  function importTable( $table, $search, $mode ){
    
    // array with 
    $data = getData( $table, $search );
    
    //renderData( $data );
    
    $f=$data['fields'];
    $lines=$data['lines'];
    /*
    $fields=array();
    for ($i=0;$i<70;$i++){
      if ($i==58){
	//continue;
      }
      $fields[]=$f[$i];
    }
    */
    $fields = $f;
    
    prepareTable( $table, $fields, $mode );
  
    insertIntoTable( $table, $fields, $lines );
    
  }

?> 
