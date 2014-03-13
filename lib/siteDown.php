<?php

  
  if (defined("SITE_DOWN")){
    
    if (SITE_DOWN){
  
      echo '<div id="down">';
      echo "<h1>Service ist momentan nicht verfügbar</h1>";
      echo date("r");
      echo '</div>';
      die();
    }
  
  
  
  }



?>
