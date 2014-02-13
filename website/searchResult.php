<?php
 
  $search = getUrlParam('search');
  
  if ($search != ''){
    
    echo '<pre>';

    connectToDb();
    
    $result = searchInTable('Teil:Artikel', $search );
    echo '</pre>';    
    
    foreach ($result as $item){
    
      echo '<div id="item" style="border: thin solid blue; padding:10px; margin:10px">';
      
	echo '<span style="color:blue;padding:5px;">'.$item['nummer'].'</span>';
	echo '<span style="color:grey">'.$item['such'].'</span> <br>';
	echo '<span style="color:grey;font-size:small;">'.$item['name'].'</span><br>';
      /*
      foreach ($item as $key=>$value){
	echo $key.' '.$value.'<br>';
      }
      */
      echo '</div>';
    }
    
  }

?>
