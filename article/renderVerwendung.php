<?php


  function renderVerwendungen( $article ){
    div("artikel");
    disp('<span id="caption">Verwendung</span><br>');
    
    echo '<div id="verwendung-ajax"></div>';    
    $show_all=getUrlParam("show_all");
    
    $updateUrl = "ajax.php?action=verwendung&abas_nr=".$article["nummer"]."&show_all=".$show_all;
    $tag="verwendung-ajax";
    insertUpdateScript( $updateUrl, $tag, $cyclic = 0 );
    
    ediv();
  }
  
  
  function ajaxRenderVerwendungen(){
    $abas_nr=getUrlParam("abas_nr");
    $show_all= getUrlParam("show_all");
    
    $branches = getAllParents( $abas_nr, $show_all );
    
    if (in_array( "limit reached", $branches)){
      disp( 'There are more results <a href="?action=article&abas_nr='.$abas_nr.'&show_all=1">show all</a>' );
    }
    
    foreach ($branches as $branch){
      if ($branch == "limit reached"){
	continue;
      }
      
      $str = "";
      foreach ($branch as $leaf){
	$parent_res= getArticle( $leaf["artikel"] );
	$parent_info = $parent_res->fetch();
	
	//$str = '<ul><li>'.$leaf["artikel"].$str.'</li></ul>';
	$str = '<div id="x"><a href="?action=article&abas_nr='.$leaf["artikel"].'">'.$leaf["artikel"].'</a> '.$parent_info["such"].$str.'</div>';
      }
      disp($str);
    }    
    
  }

?>
