<?php

  function stringToArray( $array ){
	
	foreach( $array as $value ){
	
	
	}
  
  }
  
  function shortArticle( $article ){
    $link = "?action=article&article_id=".$article["article_id"];
    
	$strings = array( $article["name"], $article["ebez"], $article["bsart"], $article["ynlief"], $article["zeichn"] );
	
    $text = '<span id="abas_nr"><a href="'.$link.'">'.$article["nummer"].'</a></span>';
    $text .= ' <span id="such">'.$article["such"].'</span>';
    $text .= ' <span id="desc">';
	$text .=  implode( $strings, " ");
	$text .= ' rank:'.$article["rank"];
    $text .= ' <br>'.renderBestand( $article ) .'</span>';
    $text .= '<br>';
    
    return $text ;
  }
  
  
?>
