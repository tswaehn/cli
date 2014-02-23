
  <div id="searchform">
    <?php 

        
    $abas_nr=getUrlParam( "abas_nr");
    
  echo '<form action="?action=article" method="POST">
	  ABAS Nr.: <input type="edit" name="abas_nr" value="'.$abas_nr.'">
	  <input type="submit" value="search">
	</form>';    
    
    
    ?>    
  </div>
  
  <div id="articleview">
    <?php include('./article/articleView.php'); ?>  
  </div>
  
   
