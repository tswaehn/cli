<?php

    // http://www.goat1000.com/svggraph-using.php
    include('./stats/SVGGraph/SVGGraph.php');

  function graphByDay(){

    $values=array();
  
    $sql = "SELECT DATE(`timestamp`) as date,count(*) AS cnt FROM ".q(DB_CLIENT_ACCESS)." WHERE `info` LIKE '%article%' GROUP BY `date` ORDER BY `date` ASC";
    //$sql = "SELECT DATE(timestamp) as date,max(request_time) AS rmax, min(request_time) AS rmin, count(*) AS cnt FROM ".q($table)." WHERE 1 GROUP BY ip,DATE(timestamp) ORDER BY date DESC, ip ASC";
    $result = dbExecute( $sql );
    
    if ($result->rowCount() > 0){
      $line=array();
      
      foreach ($result as $item ){
	$line[$item["date"]] = $item["cnt"];
      }
      
      $values[] = $line;
    }

    $sql = "SELECT DATE(`timestamp`) as date,count(*) AS cnt FROM ".q(DB_CLIENT_ACCESS)." WHERE `info` LIKE '%search%' GROUP BY `date` ORDER BY `date` ASC";
    //$sql = "SELECT DATE(timestamp) as date,max(request_time) AS rmax, min(request_time) AS rmin, count(*) AS cnt FROM ".q($table)." WHERE 1 GROUP BY ip,DATE(timestamp) ORDER BY date DESC, ip ASC";
    $result = dbExecute( $sql );

    if ($result->rowCount() > 0){
      $line=array();
      
      foreach ($result as $item ){
	$line[$item["date"]] = $item["cnt"];
      }
      
      $values[] = $line;
    }

    $sql = "SELECT DATE(`timestamp`) as date,count(*) AS cnt FROM ".q(DB_CLIENT_ACCESS)." WHERE `info` LIKE '%stats%' GROUP BY `date` ORDER BY `date` ASC";
    //$sql = "SELECT DATE(timestamp) as date,max(request_time) AS rmax, min(request_time) AS rmin, count(*) AS cnt FROM ".q($table)." WHERE 1 GROUP BY ip,DATE(timestamp) ORDER BY date DESC, ip ASC";
    $result = dbExecute( $sql );

    if ($result->rowCount() > 0){
      $line=array();
      
      foreach ($result as $item ){
	$line[$item["date"]] = $item["cnt"];
      }
      
      $values[] = $line;
    }
    

    $settings = array(
      'back_colour'       => '#fff',    'stroke_colour'      => '#000',
      'back_stroke_width' => 0,         'back_stroke_colour' => '#eee',
      'axis_colour'       => '#333',    'axis_overlap'       => 2,
      'axis_font'         => 'Georgia', 'axis_font_size'     => 10,
      'grid_colour'       => '#666',    'label_colour'       => '#000',
      'pad_right'         => 20,        'pad_left'           => 20,
      'link_base'         => '/',       'link_target'        => '_top',
      'fill_under'        => array(true, true, true),
      'marker_size'       => 0,
      'marker_type'       => array('none', 'square'),
      'marker_colour'     => array('#000', 'red'),
      
      'axis_text_angle_h' => 90
    );
    
    $settings["legend_entries"] = array( "Artikel", "Suche", "Statistik" );
    $settings["legend_position"] = "top left";
    
    $settings["graph_title"] = "Seitenaufrufe per Tag";
    
    $colours = array(
	array('#005', 'white:0.10'), 
	array('#44d', 'white:0.10'),
	array('#5a5', 'white:0.10')
	
	);

    

    $graph = new SVGGraph(600, 600, $settings);
    
    $graph->Values($values);
    
    $graph->Colours($colours);

    echo $graph->Fetch('StackedLineGraph');
    
  }
  
  
  function graphTopUsers(){
    

    $values=array();
  
    $sql = "SELECT host,count(*) as cnt FROM ".q(DB_CLIENT_ACCESS)." WHERE 1 GROUP BY `host` ORDER BY cnt DESC";
    //$sql = "SELECT DATE(timestamp) as date,max(request_time) AS rmax, min(request_time) AS rmin, count(*) AS cnt FROM ".q($table)." WHERE 1 GROUP BY ip,DATE(timestamp) ORDER BY date DESC, ip ASC";
    $result = dbExecute( $sql );
    
    if ($result->rowCount() > 0){
      $line=array();
      
      foreach ($result as $item ){
	$line[$item["host"]] = $item["cnt"];
      }
      
      $values[] = $line;
    }

    $settings = array(
      'back_colour'       => '#fff',    'stroke_colour'      => '#000',
      'back_stroke_width' => 0,         'back_stroke_colour' => '#eee',
      'axis_colour'       => '#333',    'axis_overlap'       => 2,
      'axis_font'         => 'Georgia', 'axis_font_size'     => 10,
      'grid_colour'       => '#666',    'label_colour'       => '#000',
      'pad_right'         => 20,        'pad_left'           => 20,
      'link_base'         => '/',       'link_target'        => '_top',
      'fill_under'        => array(true, true, true),
      'marker_size'       => 0,
      'marker_type'       => array('none', 'square'),
      'marker_colour'     => array('#000', 'red'),
      
      'axis_text_angle_h' => 90
    );
    
    
    $settings["graph_title"] = "Seitenaufrufe per PC";
    
    $colours = array(
	array('#005', 'white:0.10'), 
	array('#44d', 'white:0.10'),
	array('#5a5', 'white:0.10')
	
	);

    

    $graph = new SVGGraph(600, 600, $settings);
    
    $graph->Values($values);
    
    $graph->Colours($colours);

    echo $graph->Fetch('BarGraph');
    
    
  }
  
  
?>
