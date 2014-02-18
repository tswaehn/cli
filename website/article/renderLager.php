<?php
  
  function renderBestand( $article ){
  
    $einheit = " ". $article["ve"] ;
    $bestand = "Bestand -";
    if ($article["bestand"] != $article["lgbestand"]){
      $bestand .= " ges: ".$article["bestand"].$einheit;
      $bestand .= ", intern: ".$article["lgbestand"].$einheit;	
    } else {
      $bestand .= " ges: ".$article["bestand"].$einheit;
    }
    if ($article["zbestand"] != 0){
      $bestand .= ", zugeteilt: ".$article["zbestand"].$einheit;
    }
    if ($article["dbestand"] != 0){
      if ($article["dbestand"] != $article["lgdbestand"]){
	$bestand .= ", dispo: ".$article["dbestand"].$einheit;
	$bestand .= ", dispo intern: ".$article["lgdbestand"].$einheit;
      } else {
	$bestand .= ", dispo: ".$article["dbestand"].$einheit;
      }
    }
    
    return $bestand;
  
  }
  
  function renderLager( $article ){
    div("artikel");
    disp('<span id="caption">Lager</span><br>');
    disp( "Ein-/Ausgang ".$article["zuplatz"]."/".$article["abplatz"] );
    
    $bestand = renderBestand( $article );
    disp( $bestand );
    
    ediv();
  
  }
  
  
?>
