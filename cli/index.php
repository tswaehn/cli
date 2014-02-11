<?php

  include('dbConnection.php');
  

  echo "<pre>";
  lg( "start" );
  
    
  connectToDb();
  
  getTables();
  
  $fieldnames = getFieldNames( "Teil:Artikel" );
  
  $import_tables=array( array( "table"=>"Teil:Artikel", "search"=>"nummer=7500-00000!7500-99999") );
  
  foreach ($import_tables as $table){
    $tablename = $table["table"];
    $search=$table["search"];

    importTable( $tablename, $search );
    
  }
  
  lg( "bye" );
  echo "</pre>";  


?>

