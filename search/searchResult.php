<?php
  
  function standardSearch( $search ){
     
      $result = searchInTable('Teil:Artikel', $search );
      echo '</pre>';    
      
      $count=$result->rowCount();
      
      echo "found ".$count." results";
      foreach ($result as $item){
      
	echo '<div id="item" style="border: thin solid gray; padding:10px; margin:10px">';
	  echo shortArticle( $item );
	echo '</div>';
      }
       
  }
  
  function indexedSearch( $search ){
      $result = searchInTableX('Teil:Artikel', $search );
      echo '</pre>';    
      
      $count=$result->rowCount();
      
      echo "found ".$count." results";
      foreach ($result as $item){
      
	echo '<div id="item" style="border: thin solid blue; padding:10px; margin:10px">';
	  //echo shortArticle( $item );
	  echo $item["score"]. " ".$item["nummer"]." ".$item["such"]." ".$item["sucherw"];

	echo '</div>';
      }  
  }

  function mySearch( $search ){
      
      $start=microtime(true);
      $result = mySearchInTable(DB_ARTICLE, $search );
      $end=microtime(true);
      
      $diff = number_format( $end-$start, 3) ;      
      $count=$result->rowCount();
      
      if (!empty($result)){
      
	echo "found ".$count." results in ".$diff."secs";
	foreach ($result as $item){
	
	  echo '<div id="search_item">';
	    echo shortArticle( $item );
	  echo '</div>';
	}
      } else {
	
	echo "failed to receive data";
      }
  }
  
  $search = getUrlParam('search');
  
  $mode= getUrlParam('mode');
  
  if ($search != ''){
    

    switch ($mode){
      case 'indexed':
	    indexedSearch($search);
	    break;
	    
      case 'my':
	    mySearch($search);
	    break;
	    
      default:
	    mySearch($search);
	    //standardSearch($search);
    }
    

  }

?>
