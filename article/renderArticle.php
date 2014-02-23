<?php
  function shortArticle( $article ){
    $text = '<span id="abas_nr"><a href="./article.php?abas_nr='.$article["nummer"].'">'.$article["nummer"].'</a></span>';
    $text .= ' <span id="such">'.$article["such"].'</span>';
    $text .= ' <span id="desc">'.$article["name"].'</span>';
    $text .= ' <br><span >'.renderBestand( $article ) .'</span>';
    $text .= '<br>';
    
    return $text ;
  }
  
  
?>
