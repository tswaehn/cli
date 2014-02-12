<?php

  include('dbConnection.php');
  

  echo "<pre>";
  lg( "start" );
  
    
  connectToDb();
  
  getTables();
  
  $fieldnames = getFieldNames( "Teil:Artikel" );
  
  $import_tables=array( 
      
      array( "table"=>"Teil:Artikel", "search"=>"nummer=0000-00000!1999-99999"),

      array( "table"=>"Teil:Artikel", "search"=>"nummer=2000-00000!2199-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=2200-00000!2399-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=2400-00000!2599-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=2600-00000!2799-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=2800-00000!2999-99999"),

      array( "table"=>"Teil:Artikel", "search"=>"nummer=3000-00000!3999-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=4000-00000!4999-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=5000-00000!5999-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=6000-00000!6999-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=7000-00000!7999-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=8000-00000!8999-99999"),
      array( "table"=>"Teil:Artikel", "search"=>"nummer=9000-00000!9999-99999"),
      
      
      );
  
  $first=1;
  foreach ($import_tables as $table){
    $tablename = $table["table"];
    $search=$table["search"];
    
    if ($first){
      $first=0;
      $mode=_CLEAN_;
    } else {
      $mode=_UPDATE_;
    }
     
    importTable( $tablename, $search, $mode );
    
  }
  
  lg( "bye" );
  echo "</pre>";  


?>

