<?php
  
  include("../lib/lib.php");
  include("../cli/dbConnection.php");
  include('./dbSearch.php');  


  function dictSplit( $string ){
    
    // search all in lowercase only
    $string = mb_strtolower($string,'UTF-8'); 
    
    // replace special chars/unwanted chars by separator
    $string = preg_replace( "/[^A-Za-z0-9\ö\ä\ü\Ö\Ä\Ü\ß\.]/", "-", $string );
    
    // split by separator
    $dict=preg_split( "/-/", $string, -1, PREG_SPLIT_NO_EMPTY );
    
    // remove double entries
    $dict = array_unique( $dict );
    
    // todo:
    // - remove single chars
    // - replace sub-double entries ex: remov "cable" where specific "cameracable" exists
    // - implement blacklist
    // - remove "@@ ... "
    // - add more fields to index
    
    return $dict;
  }
  
  function createIndex(){
    echo 'creating index ';
    $starttime = microtime(true); 
    
    connectToDb();

    dbCreateTableDict();
    dbCreateTableLookup();
    
    $fields = array( "nummer", "such", "name", "ebez", "bsart", "ynlief", "elart", "elarta", "bestand", "lgbestand", "zbestand", "dbestand", "lgdbestand", "ve", "fve", "version"  );
    $result = dbGetFromTable( "Teil:Artikel", $fields, "", 100000 );

    $count = $result->rowCount();
    
    $i=0;
    $k=0;
    
    $outputCount=10;
    foreach ($result as $item ){
      
      $nummer = $item["nummer"];
      $search = $item["such"]." ".$item["name"];
      
      $i++;
      $k++;
      if ($i>$outputCount){
	$i=0;
	echo "\n";
	$percent= ($k / $count) * 100;
	
	$elapsed_time = microtime(true)-$starttime; 
	
	$remain_time = ($elapsed_time/$percent)*100 - $elapsed_time;
	
	echo number_format($percent, 2, '.', '')."% ".number_format($elapsed_time, 1, '.', '')."secs remain: ".number_format($remain_time, 1, '.', '')."secs >";
	
	echo $k." of ".$count;
      }

      
      $dict = dictSplit( $search );

      dbAddToDict( $nummer, $dict, $item );
      
    
    
    }
    
    // finally create rank info from dict
    dbCreateTableDictRank();
    
    
    $endtime = microtime(true); 
    $timediff = $endtime-$starttime;
    echo '\n exec time is '.($timediff);    
    
  }
  
  function createRank(){
    connectToDb();
    dbCreateRank();
  
  }
  
  echo "<pre>";
    //createIndex();
    createRank();
  echo "</pre>";
  

?>
