<?php
  
  define("DB_DICT", "dict");
  define("DB_LOOKUP", "dict_lookup" );
  define("DB_DICT_RANK", "dict_rank" );

  function dbCreateTableDict(){
    
    $table = DB_DICT;
  
    $fields = array( "id", "str", "nummer" );
    $fieldinfo["id"]["type"]=INDEX;
    $fieldinfo["id"]["size"]=0;
    $fieldinfo["str"]["type"]=ASCII;
    $fieldinfo["str"]["size"]=30;
    $fieldinfo["nummer"]["type"]=INT;
    $fieldinfo["nummer"]["size"]=0;
    

    if (tableExists( $table ) == true ){
      removeTable( $table );
    }
    createTable( $table, $fields, $fieldinfo );
    
  }
  
  function dbCreateTableLookup(){
  
    $table = DB_LOOKUP;
    
    $fields = array( "id", "nummer", "rank", "such", "name" );
    $fieldinfo["id"]["type"]=INDEX;
    $fieldinfo["id"]["size"]=0;

    $fieldinfo["nummer"]["type"]=ASCII;
    $fieldinfo["nummer"]["size"]=20;

    $fieldinfo["rank"]["type"]=INT;
    $fieldinfo["rank"]["size"]=0;
    
    $fieldinfo["such"]["type"]=ASCII;
    $fieldinfo["such"]["size"]=30;
    
    $fieldinfo["name"]["type"]=ASCII;
    $fieldinfo["name"]["size"]=255;
    

    if (tableExists( $table ) == true ){
      removeTable( $table );
    }
    createTable( $table, $fields, $fieldinfo );
  
  }

  function dbCreateTableDictRank(){
    
    $table = DB_DICT_RANK;
    
    if (tableExists( $table ) == true ){
      removeTable( $table );
    }
     
    // CREATE TABLE dict_rank AS SELECT str,count(*) as cnt FROM `dict` WHERE 1 GROUP BY str
    $sql = "CREATE TABLE ".q($table)." AS SELECT str,count(*) as cnt FROM ".q(DB_DICT)." WHERE 1 GROUP BY str";
    dbExecute( $sql );
    
  }  
  function dbCreateRank(){
    $table = DB_LOOKUP;
    
    // get all entries by id
    $result = dbGetFromTable( $table, array("id"), "rank < 10", 100000 );
    
    foreach ($result as $item){
      
      $id = $item["id"];
      
      $sql = "SELECT nummer,sum(cnt) AS rank FROM (SELECT * FROM `dict` WHERE (nummer=".$id.")) AS d0, dict_rank AS d1 WHERE d0.str=d1.str GROUP BY d0.nummer";
      $rankRes = dbExecute( $sql );
      $rank = $rankRes->fetch();

      $sql = "UPDATE ".q(DB_LOOKUP)." SET rank = ".$rank["rank"]." WHERE id = ".$id;
      dbExecute( $sql );
            
      echo $rank["nummer"]." ".$rank["rank"];
    }
    
  }
  
  function dbGetFromTable( $table, $fields="", $search="", $limit=5, $offset=0 ){
    global $pdo;
    
    if (is_array($fields)){
      $fields_str = implode( ",", $fields );
    } else {
      $fields_str = "*";
    }
    if (empty($search)){
      $search = "1";
    }
    
    $sql = 'SELECT '.$fields_str.' FROM '.q($table).' WHERE ('.$search.') LIMIT '.$limit.' OFFSET '.$offset;
    
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
  
  // search for first word in query exact match
  function articleSearchExact( $query ){
    
    echo "exact search ".$query."<br>";
    $split = preg_split( "/ /", $query, -1, PREG_SPLIT_NO_EMPTY );
    
    $what=array();
    foreach ($split as $item){
      if (strlen($item) > 0){
	$what[] = $item;
      }
    }

    $count = count($what);
    
    if ($count == 0){
      return null;
    }

    
    // option 1:
    // SELECT * FROM 
    //		(SELECT * FROM `dict` WHERE ( str LIKE '%kabel%' ) GROUP BY nummer) AS d0 
    //		INNER JOIN 
    //		(SELECT * FROM `dict` WHERE ( str LIKE '%w%' ) GROUP BY nummer ) as d1 
    //		ON (d0.nummer=d1.nummer) 
    //
    

    // begin sql
    $sql = "SELECT d0.* FROM ";
    
    
    // add each select line
    for ($i=0;$i< $count ;$i++){
      if ($i==0){
	$match="str ='".$what[$i]."'";
      } else {
	$match="str LIKE '%".$what[$i]."%'";
      }
      $select = "(SELECT * FROM ".q(DB_DICT)." WHERE ( ".$match." ) GROUP BY nummer) AS d".$i." ";
      
      if ($i > 0){
	$sql .= "INNER JOIN ";
      }
      
      $sql .= $select;
      
      if ($i > 0){
	$sql .= "ON (d0.nummer=d".$i.".nummer) ";
      }
      
    }
    
    // finalize sql query
    // $sql .= ";" ;
    // colon will be added in execute
  
    
    return $sql;      
  
  }
  
  function articleSearchLike( $query ){
    
    $split = preg_split( "/ /", $query, -1, PREG_SPLIT_NO_EMPTY );
    
    $what=array();
    foreach ($split as $item){
      if (strlen($item) >= 2){
	$what[] = $item;
      }
    }

    $count = count($what);
    
    if ($count == 0){
      return null;
    }

    
    // option 1:
    // SELECT * FROM 
    //		(SELECT * FROM `dict` WHERE ( str LIKE '%kabel%' ) GROUP BY nummer) AS d0 
    //		INNER JOIN 
    //		(SELECT * FROM `dict` WHERE ( str LIKE '%w%' ) GROUP BY nummer ) as d1 
    //		ON (d0.nummer=d1.nummer) 
    //
    

    // begin sql
    $sql = "SELECT d0.* FROM ";
    
    
    // add each select line
    for ($i=0;$i< $count ;$i++){
      $select = "(SELECT * FROM ".q(DB_DICT)." WHERE ( str LIKE '%".$what[$i]."%' ) GROUP BY nummer) AS d".$i." ";
      
      if ($i > 0){
	$sql .= "INNER JOIN ";
      }
      
      $sql .= $select;
      
      if ($i > 0){
	$sql .= "ON (d0.nummer=d".$i.".nummer) ";
      }
      
    }
    
    // finalize sql query
    // $sql .= ";" ;
    // colon will be added in execute
  
    
    return $sql;      
  
  }

  
  function filteredKeySearch( $query ){
    global $pdo;
    
    
    if (!preg_match("/ /", $query)){
      return null;
    }

    $split = preg_split( "/ /", $query, -1, PREG_SPLIT_NO_EMPTY );
    
    if (preg_match("/ $/", $query)){
      $restrictTo = "";    
    } else {
      $currentEdit = end($split);
      $restrictTo = " AND prop.str LIKE '%".$currentEdit."%' ";
    }
    
    
    
    // get SELECT statement for "search"
    $result = dbGetFromTable(DB_DICT, array("str"), "str='".$split[0]."'" );
    if ($result->rowCount() >= 0){ // mod
        $search = articleSearchLike( $query );
    } else {
	echo "<br> exact search ";
	$search = articleSearchExact( $query );
    }
    
    // search keywords of given set of articles
    // SELECT prop.str,count(*) as cnt FROM 
    //		(SELECT * FROM `dict` WHERE (...) ) AS search
    //		INNER JOIN 
    //		`dict` AS prop
    //		ON ( search.nummer=prop.nummer AND search.str != prop.str) 
    //		GROUP BY prop.str ORDER BY cnt DESC';

    $sql = "SELECT prop.str,count(*) as cnt FROM ";
    
    $sql .= "(".$search.") AS search ";
    $sql .= "INNER JOIN ";
    $sql .= q(DB_DICT)." AS prop ";
    $sql .= "ON ( search.nummer=prop.nummer AND search.str != prop.str ".$restrictTo.") ";
    $sql .= "GROUP BY prop.str HAVING cnt > 1 ORDER BY prop.str ASC";
    
    return $sql;
  }
  
  
  /*
    searches for items similar to $what and also returns their occurence count
  */
  function globalKeySearch( $query ){
    
    $split = preg_split( "/ /", $query, -1, PREG_SPLIT_NO_EMPTY );
    
    $what=array();
    foreach ($split as $item){
      if (strlen($item) >= 2){
	$what[] = $item;
      }
    }

    $count = count($what);
    
    if ($count == 0){
      return null;
    }
    
    $sql = "SELECT str,count(*) as cnt FROM dict WHERE str LIKE '%".$what[0]."%' GROUP BY str HAVING cnt > 1 ORDER BY str ASC";
  
    return $sql;  
    
  }
     
  function dbAddToDict( $nummer, $values, $str ){
    global $pdo;

    // insert lookup entry
    $fields = array("nummer", "desc");
    insertIntoTable( DB_LOOKUP, $fields, array( array( $nummer, $str )) );
    $index = getLastInsertIndex();

    $fields = array( "str", "nummer" );
    foreach ($values as $value){
      if (is_numeric($value) == false){
	
	
	insertIntoTable( DB_DICT, $fields, array( array( $value, $index )) );
      }
      
    }
  }
  

?>
