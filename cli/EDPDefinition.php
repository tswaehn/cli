<?php
  
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
  // ...
  
  
  
  // -----------------------------------------------------------------
  //
  function getEDPDefinition(){
      $import = array(
      
	    $teil_artikel;
  
	  );
	  
    return $import;
  }


?>
