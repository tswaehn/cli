<?php
 
  function dbCreateClientAccess (){
    echo "<pre>";
    
    $table = DB_CLIENT_ACCESS;
    
    
    if (tableExists( $table ) == true ){
      removeTable( $table );
    }
    $new_table_fields = array( "id", "timestamp", "ip", "host", "info" );
    
    $fieldinfo["id"]["type"]=INDEX;
    
    $fieldinfo["timestamp"]["type"]=TIMESTAMP;
    
    $fieldinfo["ip"]["type"]=ASCII;
    $fieldinfo["ip"]["size"]=50;
    
    $fieldinfo["host"]["type"]=ASCII;
    $fieldinfo["host"]["size"]=50;

    $fieldinfo["info"]["type"]=ASCII;
    $fieldinfo["info"]["size"]=50;
    
    createTable( $table, $new_table_fields, $fieldinfo );
      
    echo "</pre>";

  }
  
  function displayAccessByIP(){
    
    $table = DB_CLIENT_ACCESS;
    
    // ---- header
    $sql = "SELECT MIN(`timestamp`) AS st,MAX(`timestamp`) AS en FROM ".q($table)." WHERE 1";
    $result = dbExecute( $sql );
    if ($result->rowCount() > 0){
      $row=$result->fetch();
      echo "interval ".$row["st"]." to ".$row["en"]."<p>";
    }
    
    
    // ---- table
    $sql = "SELECT ip,host,info,count(*) as cnt FROM ".q($table)." WHERE 1 GROUP BY `ip`,`info` ORDER BY ip ASC, cnt DESC";
    $result = dbExecute( $sql );

    echo '<table id="stats">';
    echo "<tr>";
    	echo "<th> IP </th>";
	echo "<th> Host </th>";
	echo "<th> Action </th>";
	echo "<th> Access Count </th>";	
    echo "</tr>";
    
    if ($result->rowCount() > 0){
      foreach ($result as $item ){
	echo "<tr>";
	  echo "<td>".$item["ip"]."</td>";
	  echo "<td>".$item["host"]."</td>";
	  echo "<td>".$item["info"]."</td>";	
	  echo "<td>".$item["cnt"]."</td>";	
	echo "</tr>";
      
      }
    }
    echo "</table>";
    
  }
  
  
  // ----------------
  
  
  echo "<p>";
  
  echo '<a href="?action=stats&create=1" >reset all</a>';

  $client = getUrlParam( "create" );
  
  if (!empty($client)){
    
    dbCreateClientAccess();
    
    echo "all history is cleared now<br>";
    
  }
   
  echo "<p>";
  
  displayAccessByIP();


?>