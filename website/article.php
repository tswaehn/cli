<html>
<head>
<link rel="stylesheet" type="text/css" href="format.css">
<link rel="stylesheet" type="text/css" href="./article/article.css">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<?php 
    
    include('lib.php');
    
    include('../cli/dbConnection.php');
    
    include('./article/articleHelpers.php');
    include('./article/renderMedia.php');
    include('./article/renderLager.php');
    include('./article/renderFertigung.php');
    include('./article/renderVerwendung.php');
    include('./article/dbArticle.php');
    include('./article/dbFertigung.php');
    
    
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
  
  
  <?php storeAllLog(); ?>
</html>
 
