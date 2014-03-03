<?php

   


  function renderInfo( $article ){
    div("artikel");
    disp( shortArticle( $article ));
    //disp( '<span id="abas_nr">'.$article["nummer"].'</span>'.'<span id="such">'.$article["such"].'</span>' );
    //disp( $article["sucherw"] );
    disp();
    
    $na="(aktuell nicht verfügbar)";
    
    disp( "Erstellt ".$na );
    disp( "Änderung ".$na );
    disp( "Version ".$na );
    ediv();
  }
  
  


  function renderSimilar( $article ){
    div("artikel");  
    disp('<span id="caption">Ähnliche Artikel</span><br>');
    
    $result = getSimilarItems( $article );
    
    foreach ($result as $item ){
    
      disp( shortArticle( $item ) );
    }
    
    ediv();
  }

  // -------------------
  
  connectToDb();  

  echo '<div id="searchform">';
    
    $abas_nr = getUrlParam("search_abas_nr");
    
    if (!empty($abas_nr)){
    
      $result = getArticleByAbasNr( $abas_nr );
      $article = $result->fetch();
    
    } else {
    
      $article_id=getUrlParam( "article_id");

      if (!empty($article_id)){
      
	$result = getArticle( $article_id );
	$article = $result->fetch();
      
      }
      
    }
      
      
    echo '<form action="?action=article" method="POST">
	    ABAS Nr.: <input type="edit" name="search_abas_nr" value="'.$abas_nr.'">
	    <input type="submit" value="search">
	  </form>';    
      
    
  echo '</div>';

  if (empty($article)){
    die();
  }
   
  
  echo '<div id="articleview">';
   

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
  
  echo '</div>';
  
?>
