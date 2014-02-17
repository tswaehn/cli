<?php

  
  function getArticle( $abas_nr ){
    global $pdo;
    
    $table="Teil:Artikel";
    
    $sql = "SELECT * FROM ".q($table)." WHERE ( nummer = :wie ) LIMIT 1;";
    
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
    
    $sql = "SELECT * FROM ".q($table)." WHERE ( nummer = :wie ) GROUP BY (`zn`);";
    
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
  
  function getSimilarItems( $article ){
    global $pdo;
    
    $s_abasNr = '%'. substr($article["nummer"],0,-1) .'%';
    //$s_such = '%'.preg_replace('/[^\da-z]/i', '%', $article["such"] ).'%';
    //$s_such = '%'. preg_replace("/[^A-Za-z\.\/]/", '%', $article["such"]) .'%';  
    $table="Teil:Artikel";
    
    $sql = "SELECT * FROM ".q($table)." WHERE ( nummer like :abasNr AND nummer <> :nummer ) GROUP BY (`nummer`);";
    
    try {
	lg($sql);
	$result = $pdo->prepare( $sql);
	//$data = array( ":nummer"=> substr($article["nummer"],0,-1), ":name" => $article["name"], ":such" => $article["such"] );
	//$data = array( ":nummer"=> '%'.substr($article["nummer"],0,-1).'%', ":abas_nr"=> 'x'.$article["nummer"] );
	$data = array( ":abasNr"=> $s_abasNr, ":nummer" => $article["nummer"] );

	$result->execute( $data );
	
    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
    
    //lg('found '.$result->rowCount().' items' );
    
    return $result; 
  
  
  }



?>

