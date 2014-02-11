<?php
  //phpinfo();
  define('_UPDATE_', 'update' );
  define('_CLEAN_', 'clean' );
  
  include( 'config.txt');
  include( 'lib.php' );
  include( 'EDPConsole.php');

  echo "<pre>";
  lg( "start" );
  $pdo = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);

  function tableExists( $table ){
    global $pdo;
    
    try {
	$sql = "SELECT 1 FROM ".q($table)." LIMIT 1;";
	lg($sql);
	$result = $pdo->query( $sql);
    } catch (Exception $e) {
	// We got an exception == table not found
	return FALSE;
    } 
    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
  }
  
  function createTable( $table, $fields ){
    global $pdo;
    
    try {
	$sql ="CREATE table ".q($table)." (";
	
	$count=count($fields);
	$i=1;
	foreach ($fields as $field) {
	  //$sql .= " ".q($field)." VARCHAR(20)";
	  $sql .= " ".q($field)." TEXT";	  
	  $i++;
	  if ( $i <= $count){
	    $sql.=",";
	  }
	}
	
	$sql .= ");" ;
	
	lg( $sql) ;
	
	$pdo->exec($sql);
	
	lg("Created ".$table." Table.");

    } catch(PDOException $e) {
	lg( $e->getMessage() );//Remove in production code
    }  
  
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
    
    $insert=array();
    foreach ($fields as $field ){
      $insert[] = ":".$field;
    }
    
    $insert_str="";
    $last = end($insert);
    foreach ($insert as $elem){
      $insert_str .= $elem;
      if ($elem!=$last){
	$insert_str .=",";
      }
    }
    
    // query
    $sql = "INSERT INTO ".q($table)." (".$field_str.") VALUES (".$insert_str.")";
    $q = $pdo->prepare($sql);
    
    foreach ($lines as $line){
      $values = array();
      $count = count( $line );
      for ($i=0;$i<$count;$i++){
	$key = $insert[$i];
	$value = $line[$i];
	$values[$key] = $value;
      }
      
      $q->execute( $values );
    
    }
  
  }
  
  
  function importTable( $table, $search ){
    
    // array with 
    $data = getData( $table, $search );
    
    //renderData( $data );
    
    $fields=$data['fields'];
    $lines=$data['lines'];
    
    prepareTable( $table, $fields, _CLEAN_ );
  
    insertIntoTable( $table, $fields, $lines );
    
  }
  
  
  $import_tables=array( array( "table"=>"Teil:Artikel", "search"=>"nummer=7500-00000!7500-99999") );
  
  foreach ($import_tables as $table){
    $tablename = $table["table"];
    $search=$table["search"];

    importTable( $tablename, $search );
    
  }
  
  lg( "bye" );
  echo "</pre>";
?> 
