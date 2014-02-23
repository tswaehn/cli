<?php
  
  $search = getUrlParam('search');
  
  if ($search ==''){
    $search ='bnc kabel';
  }
  
  $mode=getUrlParam("mode");
  
  switch($mode){
    case 'indexed':
	    echo '<form action="?action=search&mode=indexed" method="POST">
		  <input type="edit" name="search" value="'.$search.'">
		  <input type="submit" value="search">
		  </form>';

	    echo '<a href="?action=search&textindex=1">create index</a>';
	    $textindex = getUrlParam( "textindex" );
	    if ($textindex){
	      connectToDb();
	      createFullTextIndex();
	    }
	    break;
	    
    case 'my':
	    echo '<form action="?action=search&mode=my" method="POST">
		  <input type="edit" name="search" value="'.$search.'" size="60">
		  <input type="submit" value="search">
		  </form>';


	    break;
  
    default:
    
	echo '<form action="?action=search" method="POST">
	      <input type="edit" name="search" value="'.$search.'" size="40">
	      <input type="submit" value="search">
	      </form>';

  }
  
  
    
?>