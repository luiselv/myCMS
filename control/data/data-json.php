<?php
header ( 'Content-type: application/json' );
$pPageIsPublic = false;
include '_init.php';
$output = array ("aaData" => array ());
$p = intval($_REQUEST['p']);
$enabled = intval($_REQUEST['enabled']);
$template = $_REQUEST['template'];
$table  = $_REQUEST ['table'];  // TIPO DE DATO QUE CONTROLA LA DATA
$objMedia = new $table;
$objMedia->setAuto($_GET);
//sleep(6);
if($p){
	$objMedia->setPagination(intval($_REQUEST['pager']),intval($_REQUEST['p']));
}
if ($objMedia->loadMediaByID($enabled)){
	while ($objTemp = $objMedia->rNext()) {		
		$output['aaData'][] = Lbn::getDataMedia($objTemp,$template);
	}
	if($p){
		$output['paginator'] = $objMedia->pNavegationNumeric('LBN_MEDIA.loadAllMedia','p');
	}else{
		$output['sort'] = true;
	}
}
echo json_encode ( $output );
?>    