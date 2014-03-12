<?php
  
  $search = getUrlParam('search');
  
  if ($search ==''){
    $search ='';
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
			<span style="margin-right:10px">Suchbegriff </span>
	      <input type="edit" name="search" value="'.$search.'" size="40">
	      <input type="submit" value="suchen">
	      </form>';
	echo 'Beispiel: <span style="color:grey;font-weight:bold">bnc kabel</span>';
	echo ' oder <span style="color:grey;font-weight:bold">lemo stecker</span> ';

  }
  
  
    
?>