<?php

  
  function getArticle( $abas_nr ){
    global $pdo;
    
    $table="Teil:Artikel";
    
    $sql = "SELECT * FROM ".q($table)." WHERE ( nummer = :abas_nr ) LIMIT 1;";
    
    try {
	lg($sql);
	$starttime = microtime(true); 
	
	$result = $pdo->prepare( $sql);
	$data = array( ":abas_nr" => $abas_nr );
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
  /*
  function getAllParents( $article ){
    global $pdo;
    
    
    function parseArticleParents( $result, $abas_nr, $branch, &$group, &$branches ){

      $group++;
      
      $data = array( ":abas_nr" => $abas_nr );
      $result->execute( $data );

      $branch[] = array( "nummer"=>$abas_nr, "gruppe"=>$group );      
      $count = $result->rowCount();
      
      if ($count > 0){
      
	$parents = $result->fetchAll();
	
	foreach ($parents as $parent){
	  
	  parseArticleParents( $result, $parent["nummer"], $branch,$group, $branches );
	}
	
      } else {
	
	disp( "branch closed ".$abas_nr );
	print_r( $branch );	
      }

    }

    $table="Teil:Artikel";
    
    $sql = "SELECT nummer,elem FROM ".q($table)." WHERE ( elem = :abas_nr );";
    
    $branches = array();
    
    try {
	lg($sql);
	$starttime = microtime(true); 
	
	$result = $pdo->prepare( $sql);
	
	$group=0;
	parseArticleParents( $result,$article["nummer"], array(), $group, $branches);
	
	
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
  */
  
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

