<html>
<head>
<link rel="stylesheet" type="text/css" href="format.css">

<?php 
    
    include('lib.php');
    
    include('../cli/dbConnection.php');
    include('./article/dbArticle.php');
    
    
    $title = "Artikel anzeigen";
    
    $abas_nr = getUrlParam('abas_nr');    
    ?>

<title>
<?php echo $abas_nr ?> ..::Glaskugel::.. 
</title>
</head>

  <div id="head">
    
    <?php include('head.php'); ?>
    
  </div>
  
  <div id="searchform">
    <?php include('./article/articleSelect.php'); ?>    
  </div>
  
  <div id="articleview">
    <?php include('./article/articleView.php'); ?>  
  </div>
  
</html>
 
