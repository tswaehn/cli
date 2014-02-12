<?php

  function disp( $text ){
    
    echo $text."<br>";
    
  }
  
  function div( $id ){
    echo "<div id =".$id.">";
  }

  function ediv(){
    echo "</div>";
  }

  
  if ($abas_nr == ""){
    die();
  }
  
  function renderInfo( $article ){
    div("artikel");
    disp( $article["nummer"] );
    disp( $article["such"] );
    disp( $article["sucherw"] );
    disp( "Erstellt ".$article["erfass"] );
    disp( "Änderung ".$article["stand"] );
    ediv();
  }
  
  function renderFertigung( $article ){
    
  }
  
  function renderBestellung( $article ){
    div("artikel");
    disp( "Einkaufstext ".$article["ebez"] );
    //disp( "Dispositionsart ".$article["dispo"] );
    disp( "Beschaffung ".$article["bsart"] );
    disp( "Lieferant ".$article["ynlief"] );
    ediv();
  }
  
  function renderLager( $article ){
    div("artikel");
    disp( "Eingang ".$article["zuplatz"] );
    disp( "Ausgang ".$article["abplatz"] );
    ediv();
  
  }
  
  function renderMedia( $article ){
    div("artikel");
    
    disp('<a href="./article/download.php">download</a>');
    disp( "pdf ".$article["ypdf1"] );
    disp( "dxf ".$article["ydxf"] );
    disp( "dxf ".$article["yxls"] );
    disp( "dxf ".$article["ytpdf"] );
    disp( "dxf ".$article["ytlink"] );
    
    
    disp( "bild ".$article["bild"] );
    disp( "doku ".$article["bbesch"] );
    disp( "foto ".$article["foto"] );
    disp( "foto ".$article["fotoz"] );
    
    disp( "katalog foto ".$article["catpics"] );
    disp( "katalog foto ".$article["catpicsz"] );    

    disp( "katalog foto ".$article["catpicl"] );    
    disp( "katalog foto ".$article["catpiclz"] );    
    disp( "katalog foto ".$article["caturl"] );    
    
    
    
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
    div("artikel");
    
    $abas_nr = $article["nummer"];
    
    $result = getAllItems( $abas_nr );
    disp( "");
    foreach ($result as $item ){
      disp( $item["zn"]." ".$item["tabnr"]." ".$item["anzahl"]." ".$item["elanzahl"]." ".$item["elart"]." ".$item["elarta"]." ".$item["elem"]." ".$item["elex"] );
    }
    
    ediv();
  }
  

  connectToDb();
  echo "<pre>";
  $result = getArticle( $abas_nr );
  echo "</pre>";
  
  $article = $result->fetch();
  
  renderInfo( $article );
  renderLager($article );
  renderFertigung($article);
  renderBestellung($article);
  
  renderMedia( $article );
  renderFertingsliste( $article );  
?>
