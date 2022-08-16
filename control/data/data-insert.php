<?php
$pPageIsPublic = false;
include '_init.php';
$INSERT_UPDATE_oHTML  = $INSERT_UPDATE_MSG = $INSERT_UPDATE_ERROR = 0;
$INSERT_UPDATE_NEW    = 'new';
$INSERT_UPDATE_TABLE  = $_REQUEST ['table'];  // TIPO DE DATO QUE CONTROLA LA DATA
$INSERT_UPDATE_TYPE   = $_REQUEST ['type'];
$INSERT_UPDATE_FIELDS = $_REQUEST ['field'];
$INSERT_UPDATE_TEMPLATE = $_REQUEST ['template'];

$INSERT_UPDATE_CUSTOM = $_REQUEST ['inputcustom'];

$navMode=$_REQUEST['navmode'];
$json = intval ( $_REQUEST ['json'] );

$objTemp = new $INSERT_UPDATE_TABLE();
$objTemp->setAuto ( $_GET );
$INSERT_UPDATE_ID = intval ( $objTemp->id );

if($INSERT_UPDATE_ID){$INSERT_UPDATE_NEW='';}
$objTemp->status = $INSERT_UPDATE_NEW;
/*if (!$INSERT_UPDATE_TABLE_ID){
	$$INSERT_UPDATE_TABLE_MSG = 'ID : ?';
	$$INSERT_UPDATE_TABLE_ERROR = 1;
}*/
if(empty($INSERT_UPDATE_FIELDS)){
	$INSERT_UPDATE_FIELDS = 'title,description,status';	
	switch ($INSERT_UPDATE_TYPE) {
		case 'audio' :	
			$INSERT_UPDATE_FIELDS .=',root_file';
			break;
		case 'file' :
			$INSERT_UPDATE_FIELDS .=',root_file';
			break;
		case 'video' :
			$INSERT_UPDATE_FIELDS .=',root_file,media_file';
			break;
	}
}
if (!$json) {
	switch ($INSERT_UPDATE_TABLE) {
		case 'photo' :
			if ($INSERT_UPDATE_ID) {				
				$objTemp->getConnection();
				$objTemp->setUid ( $INSERT_UPDATE_ID );
				$objTemp->update ( $INSERT_UPDATE_FIELDS );										
			} else {
				$objTemp->title = 'No Title';
				$objTemp->description = '';
				if (!$objTemp->add ()){
					// ERROR
				}
			}
			response ($objTemp,$INSERT_UPDATE_TYPE);
		break;
		case 'person' :
			if (!$INSERT_UPDATE_ID) {
				$objTemp->firstname = 'None';
				$objTemp->levelx = 1;
				$objTemp->status = $INSERT_UPDATE_NEW;
				if (!$objTemp->add ()){
					// ERROR
				}
			}
			response ($objTemp,$INSERT_UPDATE_TYPE);
		break;		
		default :
			if ($INSERT_UPDATE_ID) {
				$objTemp->getConnection();
				$objTemp->setUid ($INSERT_UPDATE_ID);	
				
				if($INSERT_UPDATE_TYPE=='photo'){				
					$objTemp->language = arr2json($_GET ,$INSERT_UPDATE_CUSTOM);
				}
				
				if($INSERT_UPDATE_CUSTOM){
					if($INSERT_UPDATE_TYPE=='video'){
						$objTemp->language = arr2json($_GET ,$INSERT_UPDATE_CUSTOM);
						$str = json_decode($objTemp->language);
						$objTemp->title = $str->title_en;
						$objTemp->description = $str->description_en;
						$objTemp->media_file = $str->video_en;
						$objTemp->update('title,description,media_file,language');
					}elseif($INSERT_UPDATE_TYPE=='photo'){
						$objTemp->language = arr2json($_GET ,$INSERT_UPDATE_CUSTOM);
						$str = json_decode($objTemp->language);
						$objTemp->title = $str->title_en;
						$objTemp->description = $str->description_en;
						$objTemp->update('title,description,language');
					}else{
						$objTemp->language = arr2json($_GET ,$INSERT_UPDATE_CUSTOM);
						$objTemp->update('language');
					}
				}else{
					$objTemp->update($INSERT_UPDATE_FIELDS);
				}
			} else {
				$objTemp->title = 'No Title';
				$objTemp->description = '';
				if (!$objTemp->add()){
					// ERROR
				}
			}
			response ($objTemp,$INSERT_UPDATE_TYPE);	
	}
} else {
	if (! $objTemp->load ()) {
		echo "OBJ : ";
		return;
	}
	switch ($field) {
		/*
		 * Campo de tipo JSON
		 */
	}
}

/*
 * Function
 */
function response($objTemp, $type = 'page', $msg = '', $error = 0) {
	global $INSERT_UPDATE_TEMPLATE;
	$output = array ("id" => $objTemp->id,"type" => $type,"aaData" => array ());	
	$reloadTable = true;
	switch($type){
		case 'category':
			$reloadTable = false;					
			$output['title']  = $objTemp->title;
			$output['aaData'][] = null;
		break;
		default :
			$objTemp->load();
			$output['aaData'][] = Lbn::getDataMedia($objTemp,$INSERT_UPDATE_TEMPLATE);		
		break;
	}
	$output['reload']  = $reloadTable;
	echo json_encode ($output);
}
?>