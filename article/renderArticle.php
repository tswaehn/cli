<?php
  function shortArticle( $article ){
    $link = "?action=article&abas_nr=".$article["nummer"];
    
    $text = '<span id="abas_nr"><a href="'.$link.'">'.$article["nummer"].'</a></span>';
    $text .= ' <span id="such">'.$article["such"].'</span>';
    $text .= ' <span id="desc">'.$article["name"].'</span>';
    $text .= ' <br><span >'.renderBestand( $article ) .'</span>';
    $text .= '<br>';
    
    return $text ;
  }
  
  
?>
