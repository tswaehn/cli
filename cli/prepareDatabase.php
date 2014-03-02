<?php
  
  function dbCreateTableArticle(){
  
    $table = DB_ARTICLE;
    
    
    if (tableExists( $table ) == true ){
      removeTable( $table );
    }
    $fields = array( "article_id", "rank", "nummer", "such", "name", "ebez", 
		     "bsart", "ynlief", "zuplatz", "abplatz", "elart", "elarta", 
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

    
    $fieldinfo["elart"]["type"]=ASCII;
    $fieldinfo["elart"]["size"]=3;
    
    $fieldinfo["elarta"]["type"]=ASCII;
    $fieldinfo["elarta"]["size"]=16;

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
		     "bsart", "ynlief", "zuplatz", "abplatz", "elart", "elarta", 
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
    $fields = array( "list_nr", "article_id", "elem_id", "cnt", "row",  );

    $fieldinfo["list_nr"]["type"]=ASCII;
    $fieldinfo["list_nr"]["size"]=15;

    
    $fieldinfo["article_id"]["type"]=INT;
    $fieldinfo["article_id"]["size"]=0;

    $fieldinfo["elem_id"]["type"]=INT;
    $fieldinfo["elem_id"]["size"]=0;
    
    $fieldinfo["cnt"]["type"]=FLOAT;
    $fieldinfo["cnt"]["size"]=0;

    $fieldinfo["row"]["type"]=INT;
    $fieldinfo["row"]["size"]=0;
    
    
    createTable( $table, $fields, $fieldinfo );

    $sel_fields = array(  "list_nr", "article_id", "elem_id", "cnt", "row"  );
    $fieldStr = "`".implode( "`,`", $sel_fields )."`";
    
    $sql = "INSERT INTO ".q(DB_PRODUCTION_LIST)." (".$fieldStr.") ";
    $sql .= "SELECT d0.nummer AS liste_nr,d0.anzahl AS cnt,d0.tabnr AS `row`,d1.article_id,d2.article_id AS elem_id FROM (SELECT * FROM `Fertigungsliste:Fertigungsliste` WHERE 1) AS d0,(SELECT article_id,nummer FROM `article` WHERE 1) AS d1, (SELECT article_id,nummer FROM `article` WHERE 1) AS d2 WHERE d0.artikel=d1.nummer AND d0.elem=d2.nummer";
    
    dbExecute( $sql );  
  }

  function prepareDatabase(){
  
    dbCreateTableArticle();
    dbCreateProductionList();
  }



?>
