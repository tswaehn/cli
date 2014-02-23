<?php
  
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

 
  $action = getUrlParam("action");

  
  switch ($action){	
    case "raw": 
		$title="Raw";
		$script="./article/raw.php";
		break;
		
    case "article": 
		$title ="Artikel";
		$script="./article/view.php";
		break;
    default:
	      $title="Suchen";
	      $script="./search/search.php";
  
  }
  
  
  function showScriptTime(){
    global $scriptStartTime;
    $scriptStopTime=microtime(true);
    
    $delta = $scriptStopTime-$scriptStartTime;
    
    echo "<hr>";
    echo "request finished in ".$delta."sec";
    
  
  }
  
  function finish(){
    showScriptTime();
    
  }
  

?>
