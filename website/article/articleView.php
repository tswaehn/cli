<?php

   
  if ($abas_nr == ""){
    die();
  }
  
  function shortArticle( $article ){
    $text = '<span id="abas_nr"><a href="./article.php?abas_nr='.$article["nummer"].'">'.$article["nummer"].'</a></span>';
    $text .= ' <span id="such">'.$article["such"].'</span>';
    $text .= ' <span id="desc">'.$article["name"].'</span>';
    $text .= ' <br><span >'.renderBestand( $article ) .'</span>';
    $text .= '<br>';
    disp( $text );
  }
  
  
  function renderInfo( $article ){
    div("artikel");
    shortArticle( $article );
    //disp( '<span id="abas_nr">'.$article["nummer"].'</span>'.'<span id="such">'.$article["such"].'</span>' );
    //disp( $article["sucherw"] );
    disp();
    disp( "Erstellt ".$article["erfass"] );
    disp( "Änderung ".$article["stand"] );
    disp( "Version ".$article["versionn"] );
    ediv();
  }
  
  


  function renderSimilar( $article ){
    div("artikel");  
    disp('<span id="caption">Ähnliche Artikel</span><br>');
    
    $result = getSimilarItems( $article );
    
    foreach ($result as $item ){
      shortArticle( $item );
    }
    
    ediv();
  }
  

  

  connectToDb();
  echo "<pre>";
  $result = getArticle( $abas_nr );
  echo "</pre>";
  
  $article = $result->fetch();

  echo "<table>";
  echo "<tr><td>";
    renderMedia( $article );
  echo "</td><td>";
    renderInfo( $article );
    renderLager($article );    
    
    renderSimilar( $article );
  echo "</td></tr>";
  echo "</table>";
  
  renderVerwendungen($article );

  //renderFertigung($article);
  
  renderFertingsliste( $article );  
?>
