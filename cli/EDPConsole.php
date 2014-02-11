<?php

  function splitLine( $line ){
    $elements = preg_split( '/#/', $line );
    // remove first elements
    array_shift( $elements );
    return $elements;
  }

  function stringsToArray( $lines ){

    $isFirst=1;
    $data=array( 'fields'=> array(), 'lines'=>array() );
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $lines) as $line){

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
  
  
  function getData( $table, $search ){
    
    if (_REAL_EDP_ == 1){
      lg( "table: ".$table );
      lg( "search: ".$search );
      $lines = shell_exec( 'EDPConsole '.$table.' '.$search );
      
      $filename='edp-input.dat';
      file_put_contents( $filename, $lines );
    } else {
      lg("EDPConsole - simulate" );
      $filename='test.dat';
      $lines = file_get_contents( $filename );
    }
    
    $data = stringsToArray( $lines );
    return $data;  	
  
  
  }













?>
