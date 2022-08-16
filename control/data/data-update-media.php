<?php
	$pPageIsPublic = false;
	include '_init.php';
	
	$id = $_REQUEST['id'];
	$table = $_REQUEST['table'];
	$filename = $_REQUEST['filename'];
	$media = new $table();
	$media->setUid($id);
	$media->load();
	$media->root_file = $filename;
	$media->update('root_file');
?>