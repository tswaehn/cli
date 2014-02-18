<?php

  
  function getFertigungsliste( $abas_nr ){
    global $pdo;
    
    $table="Fertigungsliste:Fertigungsliste";
    
    $sql = "SELECT tabnr,elarta,elem,anzahl,elle FROM ".q($table)." WHERE ( artikel = :abas_nr );";
    
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
  
  function getAllParents( $abas_nr, $show_all ){
    global $pdo;
    
    if ($show_all != ""){
      $limit = 0;
      echo "showing all";
    } else {
      $limit = 4;
      //echo "limit results to ".$limit."<br>";
    }
    
    function parseParents( $result, $abas_nr, $branch, &$group, &$branches, &$resCount, &$maxCount ){
      
      if (($resCount >= $maxCount) && ($maxCount > 0)){
	$branches[]= "limit reached";
	return;
      }
      
      $group++;
      
      $data = array( ":abas_nr" => $abas_nr );
      $result->execute( $data );

      $branch[] = array( "artikel"=>$abas_nr, "gruppe"=>$group );      
      $count = $result->rowCount();
      
      if ($count > 0){
      
	$parents = $result->fetchAll();
	
	foreach ($parents as $parent){
	  
	  parseParents( $result, $parent["artikel"], $branch,$group, $branches, $resCount, $maxCount );
	}
	
      } else {
	
	//disp( "branch closed ".$abas_nr );
	$branches[] = $branch;
	$resCount++;
	
      }

    }

    $table="Fertigungsliste:Fertigungsliste";
    
    $sql = "SELECT artikel,elem FROM ".q($table)." WHERE ( elem = :abas_nr );";
    
    $branches = array();
    
    try {
	lg($sql);
	$starttime = microtime(true); 
	
	$result = $pdo->prepare( $sql);
	
	$group=0;
	$count=0;
	parseParents( $result,$abas_nr, array(), $group, $branches, $count, $limit);
	
	
	$endtime = microtime(true); 
	$timediff = $endtime-$starttime;
	
	
    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
      
    lg('exec time is '.($timediff) );
    //lg('found '.$result->rowCount().' items' );
	  
    return $branches;  
  }
      
?>

 
