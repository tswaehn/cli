<html>
<head>
<link rel="stylesheet" type="text/css" href="format.css">
<link rel="stylesheet" type="text/css" href="./article/article.css">

<?php 
    
    include('lib.php');
    include('../cli/dbConnection.php');
  
    $title = "Suchen";
    ?>

<title>
..::Glaskugel::..
</title>
</head>

  <div id="head">
    
    <?php include('./head.php'); ?>
    
  </div>
  
  <div id="searchform">
    <?php include('./searchForm.php'); ?>    
  </div>
  
  <div id="searchresult">
    <?php include('./searchResult.php'); ?>  
  </div>
  
</html>
