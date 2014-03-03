<?php
  
  function dbCreateTableArticle(){
  
    $table = DB_ARTICLE;
    
    
    if (tableExists( $table ) == true ){
      removeTable( $table );
    }
    $fields = array( "article_id", "rank", "nummer", "such", "name", "ebez", 
		     "bsart", "ynlief", "zuplatz", "abplatz",  
		     "bestand", "lgbestand", "zbestand", "dbestand", "lgdbestand", 
		     "ve", "fve" );

    $fieldinfo["article_id"]["type"]=INDEX;
    $fieldinfo["article_id"]["size"]=0;

    $fieldinfo["rank"]["type"]=INT;
    $fieldinfo["rank"]["size"]=0;
    
    $fieldinfo["nummer"]["type"]=ASCII;
    $fieldinfo["nummer"]["size"]=15;

    $fieldinfo["such"]["type"]=ASCII;
    $fieldinfo["such"]["size"]=30;

    $fieldinfo["name"]["type"]=ASCII;
    $fieldinfo["name"]["size"]=255;
    
    $fieldinfo["ebez"]["type"]=ASCII;
    $fieldinfo["ebez"]["size"]=38;
    
    $fieldinfo["bsart"]["type"]=ASCII;
    $fieldinfo["bsart"]["size"]=16;
    
    $fieldinfo["ynlief"]["type"]=ASCII;
    $fieldinfo["ynlief"]["size"]=8;

    $fieldinfo["zuplatz"]["type"]=ASCII;
    $fieldinfo["zuplatz"]["size"]=15;

    $fieldinfo["abplatz"]["type"]=ASCII;
    $fieldinfo["abplatz"]["size"]=15;

    $fieldinfo["bestand"]["type"]=FLOAT;
    $fieldinfo["bestand"]["size"]=0;

    $fieldinfo["lgbestand"]["type"]=FLOAT;
    $fieldinfo["lgbestand"]["size"]=0;

    $fieldinfo["zbestand"]["type"]=FLOAT;
    $fieldinfo["zbestand"]["size"]=0;

    $fieldinfo["dbestand"]["type"]=FLOAT;
    $fieldinfo["dbestand"]["size"]=0;

    $fieldinfo["lgdbestand"]["type"]=FLOAT;
    $fieldinfo["lgdbestand"]["size"]=0;
    
    $fieldinfo["ve"]["type"]=ASCII;
    $fieldinfo["ve"]["size"]=6;
        
    $fieldinfo["fve"]["type"]=FLOAT;
    $fieldinfo["fve"]["size"]=0;


    createTable( $table, $fields, $fieldinfo );

    $sel_fields = array( "nummer", "such", "name", "ebez", 
		     "bsart", "ynlief", "zuplatz", "abplatz", 
		     "bestand", "lgbestand", "zbestand", "dbestand", "lgdbestand", 
		     "ve", "fve" );
    $fieldStr = "`".implode( "`,`", $sel_fields )."`";
    
    $sql = "INSERT INTO ".q(DB_ARTICLE)." (".$fieldStr.") ";
    $sql .= "SELECT ".$fieldStr." FROM `Teil:Artikel` WHERE 1";
    
    dbExecute( $sql );
  
  }
  
  // replace all string article numbers by integer (performs much faster)
  function dbCreateProductionList(){
  
 
    $table = DB_PRODUCTION_LIST;
    
    
    if (tableExists( $table ) == true ){
      removeTable( $table );
    }
    $fields = array( "list_nr", "article_id", "elem_id", "elem_type", "cnt", "tabnr",  );

    $fieldinfo["list_nr"]["type"]=ASCII;
    $fieldinfo["list_nr"]["size"]=15;

    
    $fieldinfo["article_id"]["type"]=INT;
    $fieldinfo["article_id"]["size"]=0;

    $fieldinfo["elem_id"]["type"]=INT;
    $fieldinfo["elem_id"]["size"]=0;

    $fieldinfo["elem_type"]["type"]=INT;
    $fieldinfo["elem_type"]["size"]=0;
    
    $fieldinfo["cnt"]["type"]=FLOAT;
    $fieldinfo["cnt"]["size"]=0;

    $fieldinfo["tabnr"]["type"]=INT;
    $fieldinfo["tabnr"]["size"]=0;
    
    
    createTable( $table, $fields, $fieldinfo );

    // prepare insert fields
    $sel_fields = array(  "list_nr", "article_id", "elem_id", "elem_type", "cnt", "tabnr"  );
    $fieldStr = "`".implode( "`,`", $sel_fields )."`";
   
    // prepare insert query
    $sql_insert = "INSERT INTO ".q(DB_PRODUCTION_LIST)." (".$fieldStr.") VALUES ";
    
    // get all entries which need to be copied
    $sql = "SELECT * FROM `Fertigungsliste:Fertigungsliste` WHERE 1 ";
    $result = dbExecute($sql);
    
    foreach ($result as $item){
    
      $sql = "SELECT article_id FROM `article` WHERE nummer='".$item["artikel"]."'";
      $q = dbExecute( $sql );
      $article = $q->fetch();
      $article_id = $article["article_id"];
	  
      if ($item["elart"] == 1){
	$sql = "SELECT article_id FROM `article` WHERE nummer='".$item["elem"]."'";
	$q = dbExecute( $sql );
	$elem = $q->fetch();
	$elem_id = $elem["article_id"];
      } else {
	$elem_id = -1;
      }
      
      $values = array( $item["nummer"], $article_id, $elem_id, $item["elart"], $item["anzahl"], $item["tabnr"] );
      $valueStr = "('".implode( "','", $values )."')";
      
      dbExecute( $sql_insert.$valueStr );
      
      
    }
  
  }

  function prepareDatabase(){
  
    dbCreateTableArticle();
    dbCreateProductionList();
  }



?>
