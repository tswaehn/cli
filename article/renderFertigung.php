<?php

  function renderFertigung( $article ){
    div("fertigung");
    disp('<span id="caption">Fertigung</span><br>');
    disp( "Einkaufstext ".$article["ebez"] );
    //disp( "Dispositionsart ".$article["dispo"] );
    disp( "Beschaffung ".$article["bsart"] );
    disp( "Lieferant ".$article["ynlief"] );
    
    // create two col layout
    disp('<table><tr>');
    
    disp("<td>");
      
      echo "<pre>";
      $result = getAktuelleFertigungsParents( $article["nummer"] );
      
      foreach ($result as $item){
	
	disp( $item["nummer"]." ".$item["tename"] );
      
      }
    
      echo "</pre>";
    disp("</td>");
    
    disp("<td>");
    $result = getAktuelleFertigungsliste( $article["nummer"] );
    
    disp("aktuell zu fertigende Elemente");
    echo '<table id="fertigungsliste">';
    foreach ($result as $item){
      $line = "<tr>";
      
      $line .= "<td>".$item["tabnr"]."</td>";
      $line .= "<td>".$item["elem"]."</td>";
      //$line .= "<td>".$item["elart"]."</td>";
      $line .= "<td>".$item["elarta"]."</td>";
      $line .= "<td>".$item["elname"]."</td>";
      $line .= "<td>".$item["anzahl"]."</td>";
      //$line .= "<td>".$item["elle"]."</td>";
    
      $line .="</tr>";
      
      echo $line;
    }
    echo "</table>";
    disp("</td>");
    disp("</tr></table>");
    ediv();
  }

  function renderFertingsliste($article){

    div("fertigungsliste");
    disp('<span id="caption">Fertigungsliste (Stammdaten)</span><br>');
    $abas_nr = $article["nummer"];
    
    echo '<div id="fertigungsliste-ajax"></div>';
    
    $updateUrl = "ajax.php?action=fertigungsliste&abas_nr=".$article["nummer"];
    $tag="fertigungsliste-ajax";
    insertUpdateScript( $updateUrl, $tag, $cyclic = 0 );

    ediv();
  }  
  
  
  function ajaxRenderFertingsliste(){ 
    
    $abas_nr = getUrlParam("abas_nr");
 
    $result = getFertigungsliste( $abas_nr );
    disp( "");
    
    disp( "<table>" );

    foreach ($result as $part ){

      $result_article = getArticle( $part["elem"] );
      $part_info = $result_article->fetch();
      
      //disp( $item["zn"]." ".$item["tabnr"]." ".$item["anzahl"]." ".$item["elanzahl"]." ".$item["elart"]." ".$item["elarta"]." ".$item["elem"]." ".$item["elex"] );
      echo "<tr>";
      echo "<td>".$part["tabnr"]."</td>";
      echo '<td><a href="?action=article&abas_nr='.$part["elem"].'">'.$part["elem"]."</td>";
      echo "<td>".$part["elarta"]."</td>";
      echo "<td>".$part_info["such"]."</td>";    
      echo "<td>".$part["anzahl"]."</td>";
      echo "<td>".$part["elle"]."</td>";
      
      echo "</tr>";
    }
    disp( "</table>" ); 
  
  
  }

?>
