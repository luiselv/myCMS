<?php 
$pPageIsPublic = false;
include '_init.php';
if($_REQUEST['id']){
	$dbupdate = new Item();	
	$dbupdate->getConnection();
	$dbupdate->setUid($_REQUEST['id']);
	$dbupdate->description=$_REQUEST['description'];						
	$dbupdate->update('description');
	echo $dbupdate->description;
}
?>