<?php
  
  function createLike( $cols, $value ){
    
    $likeStatement='';

    $likeStatement .='(';
    $first = $cols[0];
    foreach ($cols as $col){
      if ($col == $first){
	$likeStatement .= $col. " LIKE '%".$value."%'";
      } else {
	$likeStatement .= ' OR '.q($col). " LIKE '%".$value."%'";
      }
    } 
    
    $likeStatement .=')';
    
    return $likeStatement;
  }
  
  function showResultCount( $table, $searches, $cols ){
    global $pdo;
    foreach ($searches as $search){
      $sql = 'SELECT * FROM '.q($table).' WHERE (';
      
      $sql .= createLike($cols, $search);
      
      //$sql .= ' );';
      $sql .= ') GROUP BY ( `nummer` );';
      
      try {
	  lg($sql);
	  $starttime = microtime(true); 
	  $result = $pdo->query( $sql);
	  $endtime = microtime(true); 
	  $timediff = $endtime-$starttime;
      } catch (Exception $e) {
	  lg("search failed");
	  return;
      } 
      lg('exec time is '.($timediff) );      
      $count = $result->rowCount();
      
      print_r($count);
    }
  }
      
  function mySearchInTable( $table, $search ){
    global $pdo;
    
    $searches = preg_split( "/( |-)/", $search);
    //print_r($searches);
    
    $columns = getColumns( $table );
    
    $sql = 'SELECT * FROM '.q($table).' WHERE (';
    
    $last=end($searches);
    foreach ($searches as $search ){
      $sql .= createLike( $columns, $search);
      if ($search!=$last){
	$sql .= ' AND ';
      }
    }
    
    //showResultCount($table, $searches, $columns );
    
    //$sql .= ' );';
    $sql .= ') GROUP BY ( `nummer` );';
    
    try {
	lg($sql);
	$starttime = microtime(true); 
	$result = $pdo->query( $sql);
	$endtime = microtime(true); 
	$timediff = $endtime-$starttime;
    } catch (Exception $e) {
	lg("search failed");
	return;
    } 
    
    lg('exec time is '.($timediff) );

    lg('found '.$result->rowCount().' items' );
    
    return $result;

  }






?>
