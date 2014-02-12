<?php

  
  function getArticle( $abas_nr ){
    global $pdo;
    
    $table="Teil:Artikel";
    
    $sql = "SELECT * FROM `abas-shadow`.".q($table)." WHERE ( nummer = :wie ) LIMIT 1;";
    
    try {
	lg($sql);
	$result = $pdo->prepare( $sql);
	$data = array( ":wie" => $abas_nr );
	$result->execute( $data );
	
    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
    
    //lg('found '.$result->rowCount().' items' );
    
    return $result;
  
  }
  
  function getAllItems( $abas_nr ){
    global $pdo;
    
    $table="Teil:Artikel";
    
    $sql = "SELECT * FROM `abas-shadow`.".q($table)." WHERE ( nummer = :wie ) GROUP BY (`zn`);";
    
    try {
	lg($sql);
	$result = $pdo->prepare( $sql);
	$data = array( ":wie" => $abas_nr );
	$result->execute( $data );
	
    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
    
    //lg('found '.$result->rowCount().' items' );
    
    return $result;
  
  }



?>

