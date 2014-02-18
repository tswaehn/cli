<?php
  
  $edp_conf = '
  [Teil:Artikel]
    fieldlist=nummer,name,such,sucherw,erfass,stand,ebez,bsart,ynlief,zuplatz,abplatz,ypdf1,ydxf,yxls,ytpdf,ytlink,bild,bbesch,foto,fotoz,catpics,catpicsz,catpicl,catpiclz,caturl,zn,tabnr,anzahl,elanzahl,elart,elarta,elem,elex,bestand,lgbestand,zbestand,dbestand,lgdbestand,ve,fve,versionn
    sortby=nummer
    maxdatasize=100000
    byrows=0
    sortasc=1
    search-and=1

  [Einkauf:Bestellung]
    fieldlist=id,nummer,such,betreff,art,artex,artikel,tename,ls,re,aumge,planmge,bem,ysenddat,ysendusr,lief
    sortby=nummer
    maxdatasize=100000
    byrows=1
    sortasc=1
    search-and=1

  [Fertigungsliste:Fertigungsliste]
    fieldlist=id,nummer,artikel,anzahl,elem,elart,elarta,elle,zid,tabnr
    sortby=nummer
    maxdatasize=100000
    byrows=1
    sortasc=1
    search-and=1

  ';
  
  // create config for EDPConsole
  $ini_filename = "EDP.ini";
  file_put_contents( $ini_filename, $edp_conf );
  
  class EDPImport {
    
    public $tablename;
    public $searches;
    
    function __construct( $name ){
      $this->tablename= $name;
      $this->fields=array();
      $this->searches=array();
    
    }
    
    function addSearch( $search ){
      
      $this->searches[] = $search;
    
    }
  }

  // -----------------------------------------------------------------
  //
  $teil_artikel = new EDPImport( "Teil:Artikel" );
  
  $teil_artikel->addSearch("nummer=0!0000-00000");    
  $teil_artikel->addSearch("nummer=0000-00000!1999-99999");  
  $teil_artikel->addSearch( "nummer=2000-00000!2199-99999" );  
  $teil_artikel->addSearch( "nummer=2200-00000!2399-99999" );  
  $teil_artikel->addSearch( "nummer=2400-00000!2599-99999" );  
  $teil_artikel->addSearch( "nummer=2600-00000!2799-99999" );  
  $teil_artikel->addSearch( "nummer=2800-00000!2999-99999" );  
  $teil_artikel->addSearch( "nummer=3000-00000!3999-99999" );  
  $teil_artikel->addSearch( "nummer=4000-00000!4999-99999" );  
  $teil_artikel->addSearch( "nummer=5000-00000!5999-99999" );  
  $teil_artikel->addSearch( "nummer=6000-00000!6999-99999" );  
  $teil_artikel->addSearch( "nummer=7000-00000!7999-99999" );  
  $teil_artikel->addSearch( "nummer=8000-00000!8999-99999" );  
  $teil_artikel->addSearch( "nummer=9000-00000!9999-99999" );  

  // -----------------------------------------------------------------
  //
  $einkauf_bestellung = new EDPImport( "Einkauf:Bestellung" );
  $einkauf_bestellung->addSearch("id=");      

  // -----------------------------------------------------------------
  //
  $fertigungs_liste = new EDPImport( "Fertigungsliste:Fertigungsliste" );
  $fertigungs_liste->addSearch("id=;flistestd=ja");
  
  // -----------------------------------------------------------------
  //
  // ...
  
  
  
  // -----------------------------------------------------------------
  //
  function getEDPDefinition(){
    global $teil_artikel;
    global $einkauf_bestellung;
    global $fertigungs_liste;
    
    $import = array(
      
	    $teil_artikel,
	    $fertigungs_liste,
	    $einkauf_bestellung
	    
	  );
	  
    return $import;
  }


?>
