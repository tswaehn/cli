<?php
  function shortArticle( $article ){
    $link = "?action=article&article_id=".$article["article_id"];
    
    $text = '<span id="abas_nr"><a href="'.$link.'">'.$article["nummer"].'</a></span>';
    $text .= ' <span id="such">'.$article["such"].'</span>';
    $text .= ' <span id="desc">'.$article["name"].' rank:'.$article["rank"].'</span>';
    $text .= ' <br><span >'.renderBestand( $article ) .'</span>';
    $text .= '<br>';
    
    return $text ;
  }
  
  
?>
