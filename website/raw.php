<pre>

<?php
  
  include('lib.php');
  include('../cli/dbConnection.php');
  include('./article/dbArticle.php');

  $abas_nr = getUrlParam('abas_nr'); 
  
  include('./article/articleSelect.php');
  

  connectToDb();
  
  $result = getArticle( $abas_nr );


  foreach ($result as $item){
    print_r($item );
  }
    

?>


</pre>
