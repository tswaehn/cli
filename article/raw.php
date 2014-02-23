<pre>

<?php
  

  $abas_nr = getUrlParam('abas_nr'); 
  
  echo '<form action="index.php?action=raw" method="POST">
ABAS Nr.: <input type="edit" name="abas_nr" value="'.$abas_nr.'">
<input type="submit" value="search">
</form>';
   
  connectToDb();
  
  $result = getArticle( $abas_nr );


  foreach ($result as $item){
    print_r($item );
  }
    

?>


</pre>
