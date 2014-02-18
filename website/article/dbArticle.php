<?php

  
  function getArticle( $abas_nr ){
    global $pdo;
    
    $table="Teil:Artikel";
    
    $sql = "SELECT * FROM ".q($table)." WHERE ( nummer = :wie ) LIMIT 1;";
    
    try {
	lg($sql);
	$starttime = microtime(true); 
	
	$result = $pdo->prepare( $sql);
	$data = array( ":wie" => $abas_nr );
	$result->execute( $data );
	
	$endtime = microtime(true); 
	$timediff = $endtime-$starttime;

    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
      
    lg('exec time is '.($timediff) );
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
  
  function getParents( $result, $article, &$data ){
    
    //lg( "searching for ".$abas_nr );  
    $abas_nr=$article["nummer"];
    $data[$abas_nr]=array( "such" => $article["such"] );
    
    
    $result->execute( array( ":abas_nr" => $abas_nr) );

    $set = $result->fetchAll();
    
    foreach ($set as $parent){
      //lg( "found ".$parent_nr );
      getParents( $result, $parent, $data[$abas_nr] );    
    
    }
    
    //lg( "done ". $abas_nr. "<br>" );
      
  }
  
  function getAllParents( $article ){
    global $pdo;
    
    $table="Teil:Artikel";
    
    $abas_nr = $article["nummer"];
    
    $sql = "SELECT nummer,elem,such FROM ".q($table)." WHERE ( elem = :abas_nr ) GROUP BY (`nummer`);";
    
    $data = array();

    echo "<pre>";
  
    $starttime = microtime(true); 
    
    try {
    
	lg($sql);
	$result = $pdo->prepare( $sql);
	
	getParents( $result, $article, $data );

    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
    
    $endtime = microtime(true); 
    $timediff = $endtime-$starttime;

    lg('exec time is '.($timediff) );
    
    print_r( $data );
    echo "</pre>";
    //lg('found '.$result->rowCount().' items' );
    
    return $data;    
    
  
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

