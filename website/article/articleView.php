<?php


  
  if ($abas_nr == ""){
    die();
  }
  
  function shortArticle( $article ){
    disp( '<a href="./article.php?abas_nr='.$article["nummer"].'"><span id="abas_nr">'.$article["nummer"].'</span></a>'.'<span id="such">'.$article["such"].'</span>'." ".'<span id="desc">'.$article["name"].'</span>');
  }
  
  
  function renderInfo( $article ){
    div("artikel");
    shortArticle( $article );
    //disp( '<span id="abas_nr">'.$article["nummer"].'</span>'.'<span id="such">'.$article["such"].'</span>' );
    disp( $article["sucherw"] );
    disp( "Erstellt ".$article["erfass"] );
    disp( "Änderung ".$article["stand"] );
    ediv();
  }
  
  function renderFertigung( $article ){
    
  }
  
  function renderBestellung( $article ){
    div("artikel");
    disp('<span id="caption">Fertigung</span><br>');
    disp( "Einkaufstext ".$article["ebez"] );
    //disp( "Dispositionsart ".$article["dispo"] );
    disp( "Beschaffung ".$article["bsart"] );
    disp( "Lieferant ".$article["ynlief"] );
    ediv();
  }
  
  function renderLager( $article ){
    div("artikel");
    disp('<span id="caption">Lager</span><br>');
    disp( "Eingang ".$article["zuplatz"] );
    disp( "Ausgang ".$article["abplatz"] );
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
  
  function renderFertingsliste($article){
  /*
    [elex] => A FL-BIEGETEIL                  
    [718] => A FL-BIEGETEIL                  
    [elem] =>             A 830
    [719] =>             A 830
    [elart] =>   3
    [720] =>   3
    [elarta] => Arbeitsgang
    [721] => Arbeitsgang
  */
    div("fertigungsliste");
    disp('<span id="caption">Fertigungsliste</span><br>');
    $abas_nr = $article["nummer"];
    
    $result = getAllItems( $abas_nr );
    disp( "");
    
    disp( "<table>" );

    foreach ($result as $item ){
      //disp( $item["zn"]." ".$item["tabnr"]." ".$item["anzahl"]." ".$item["elanzahl"]." ".$item["elart"]." ".$item["elarta"]." ".$item["elem"]." ".$item["elex"] );
      echo "<tr>";
      echo "<td>".$item["zn"]."</td>";
      echo '<td><a href="article.php?abas_nr='.$item["elem"].'">'.$item["elem"]."</td>";
      echo "<td>".$item["elarta"]."</td>";
      echo "<td>".$item["elex"]."</td>";    
      echo "<td>".$item["anzahl"]."</td>";        
      
      echo "</tr>";
    }
    disp( "</table>" );
    
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
  

  renderFertigung($article);
  renderBestellung($article);
  
  renderFertingsliste( $article );  
?>
