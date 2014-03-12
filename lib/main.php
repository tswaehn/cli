<?php
  
  define( "BUILD_NR", "v0.2.0");
  $scriptStartTime = microtime(true);
  
  include('./lib/lib.php');
  include('./cli/dbConnection.php');  
      
  include('./lib/jsUpdate.php');

    include('./search/dbSearch.php');
    include('./search/mySearchEngine.php');
    
    include('./article/dbArticle.php');
    include('./article/dbFertigung.php');
    
    include('./article/articleHelpers.php');
    include('./article/renderMedia.php');
    include('./article/renderLager.php');
    include('./article/renderFertigung.php');
    include('./article/renderVerwendung.php');
    include('./article/renderArticle.php');    

    include('./stats/getRemoteInfo.php');
 
  $action = getUrlParam("action");

  connectToDb();
  
  switch ($action){	
    case "raw": 
		$title="Raw";
		$script="./article/raw.php";
		break;
		
    case "article": 
		$title ="Artikel";
		$script="./article/articleView.php";
		break;
		
    case "overdrive":
		$title="oVerdRive Search";
		$script="./overdrive/search.php";
		break;
		
    case "stats":
		$title="Statistik";
		$script="./stats/stats.php";
		break;
		
    default:
	      $title="Suchen";
	      $script="./search/search.php";
  
  }
  
  
  
  function footer(){
  
    global $scriptStartTime;
    $scriptStopTime=microtime(true);
    
    $delta = number_format( $scriptStopTime-$scriptStartTime, 3 );
    
    echo "<hr>";
    echo "request finished in ".$delta."sec<br>";
	echo 'Glaskugel <a href="history.txt" target="_blank">'.BUILD_NR.'</a>';
  
    echo "<p>";
    
    $info=getRemoteInfos();
    
    print_r( $info );
    
  }
  

?>
