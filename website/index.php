

<?php
  
  include('dbConnection.php');
  
  date_default_timezone_set('Europe/London');

  extract( $_GET, EXTR_PREFIX_ALL, "url" );
  extract( $_POST, EXTR_PREFIX_ALL, "url" );


  function getGlobal( $var ){
    
    if (!isset($GLOBALS[$var])){
      $ret='';
    } else {
      $ret=$GLOBALS[$var];
    }

    return $ret;
  }

  function getUrlParam( $var ){
  
    $urlParam = 'url_'.$var;
    
    $ret = getGlobal( $urlParam );
    return $ret;
  }

  
  $search = getUrlParam('search');
  
  if ($search ==''){
    $search ='bnc';
  }
  
  echo '<form action="" method="GET">
<input type="edit" name="search" value="'.$search.'">
<input type="submit" value="search">
</form>';
  
  
  
  
  
  if ($search != ''){
    
    echo '<pre>';

    connectToDb();
    
    $result = searchInTable('Teil:Artikel', $search );
    echo '</pre>';    
    
    foreach ($result as $item){
    
      echo '<div id="item" style="border: thin solid blue; padding:10px; margin:10px">';
      
	echo '<span style="color:blue;padding:5px;">'.$item['nummer'].'</span>';
	echo '<span style="color:grey">'.$item['such'].'</span> <br>';
	echo '<span style="color:grey;font-size:small;">'.$item['name'].'</span>';
      /*
      foreach ($item as $key=>$value){
	echo $key.' '.$value.'<br>';
      }
      */
      echo '</div>';
    }
    
  }
  
  
?>
