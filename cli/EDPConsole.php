<?php

  function splitLine( $line ){
    $elements = preg_split( '/#/', $line );
    // remove first elements
    array_shift( $elements );
    return $elements;
  }

  function stringsToArray( $contents ){

    $isFirst=1;
    $data=array( 'fields'=> array(), 'lines'=>array() );
    //$contents=preg_replace("/[^A-Za-z0-9\n#,>\-\ \ö\ä\ü\Ö\Ä\Ü\ß]/", '', $contents);
    //print_r($contents);
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $contents) as $line){

      if (strpos($line, 'DATA>') !== FALSE){
	if ($isFirst){
	  $isFirst = 0;
	  $elem = preg_split( '/>/', $line );
	  $data['fields'] = preg_split( "/,/", $elem[1] );
	} else {
	  $data['lines'][] = splitLine( $line );
	}
	
      } else {
	      // ignore
      }
	    
    } 	

    return $data;
  }
  
  function renderData( $data ){
    $fields=$data['fields'];
    $lines=$data['lines'];
  
    $field_str='';
    foreach($fields as $field){
      $field_str .= $field. '  ';
    }
    lg( $field_str);

    
    foreach($lines as $line){
      $line_str='';  
      foreach($line as $elem){
	$line_str .= $elem. '  ';
      }
      lg( $line_str);  
    }
    
  }
  
  
  function getTables(){
  
    $table = "tables";
    $search = "*";
  
    $filename='edp-'.$table.'.dat';
    $filename = preg_replace( '/:/','-',$filename);      
    
    if (_REAL_EDP_ == 1){    
      $lines = shell_exec( 'EDPConsole '.$table.' '.$search );
      
      file_put_contents( $filename, $lines );
    } else {
    
      $line = file_get_contents( $filename );
      
    }
    
  }
  
  function getFieldNames( $table ){
  
    $filename='edp-fieldnames-'.$table.'.dat';
    $filename = preg_replace( '/:/','-',$filename);
 
    $par1 = "fieldnames";
    $par2 = $table;
    if (_REAL_EDP_ == 1){    
      $line = shell_exec( 'EDPConsole '.$par1.' '.$par2 );
      
      file_put_contents( $filename, $lines );
    } else {
      
      $line = file_get_contents( $filename );
    
    }
    
    $data = stringsToArray( $line );
    $lines = $data['lines'];
    $fieldnames = array();
    $fieldnames_str='';
    foreach ($lines as $line){
      $field = $line[0];
      $fieldnames[] = $field;
      $fieldnames_str .= ','.$field;
      
    }
    
    lg( "fieldnames of ".$table." are ".count($fieldnames ) );
    lg( $fieldnames_str );
    return $fieldnames;
  }
  

  function getData( $table, $search ){

    $filename='edp-input-'.$table.'.dat';
    $filename = preg_replace( '/:/','-',$filename);

    if (_REAL_EDP_ == 1){
      lg( "table: ".$table );
      lg( "search: ".$search );
      $contents = shell_exec( 'EDPConsole '.$table.' '.$search );
      
      file_put_contents( $filename, $contents );
      
    } else {
      lg("EDPConsole - simulate" );
      $contents = file_get_contents( $filename );
    }
    
    $data = stringsToArray( $contents );
    return $data;  	
  
  
  }













?>
