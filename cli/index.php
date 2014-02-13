<?php

  include( 'lib.php' );
  include( 'EDPDefinition.php');
  include( 'EDPConsole.php');
  include( 'dbConnection.php');

  echo "<pre>";
  lg( "start" );
  
    
  connectToDb();
  
  // load complete table info from EDP
  getEDPTables();

  $tables = getEDPDefinition();
  
  foreach ( $tables as $table ){
      
    // get specific table info
    $tablename = $table->tablename;
    $searches= $table->searches;

    // just load and store field definitions from EDP
    getEDPFieldNames( $tablename );

    // execute the search and insert into db
    $first=1;
    foreach ($searches as $search){
      if ($first){
	$first=0;
	$mode=_CLEAN_;
      } else {
	$mode=_UPDATE_;
      }
      importTable( $tablename, $search, $mode );
    }

  }
  
  lg( "bye" );
  echo "</pre>";  


?>

