<?php
// HTTP headers for no cache etc
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header ( 'Content-type: application/json' );
header("Pragma: no-cache");
$pPageIsPublic = true;
include '_init.php';
$itemNew = 'new';

$UPLOAD_NEW    = 'new';
$UPLOAD_TABLE  = $_REQUEST ['table'];
$UPLOAD_TYPE   = $_REQUEST ['type'];
$UPLOAD_TEMPLATE  = $_REQUEST ['template'];
$UPLOAD_PAGEID = intval($_REQUEST ['pageId']);
$UPLOAD_CATEGORYID = intval($_REQUEST ['categoryId']);
$UPLOAD_RID = intval($_REQUEST ['id']);
if(!$UPLOAD_TABLE){$UPLOAD_TABLE='pagemedia';}

//ob_start(array('Redirector', 'redirectOnError'));
$objTemp = new $UPLOAD_TABLE();
//ob_end_flush();  

$objTemp->setAuto ( $_GET );
$UPLOAD_ID = intval ( $objTemp->id );
if(!$UPLOAD_ID){if($UPLOAD_RID){$UPLOAD_ID=$UPLOAD_RID;}}
//$targetDir = $_SERVER['DOCUMENT_ROOT'].ABSOLUTE_THUMB_UPLOAD_PATH;

if ( ! isset($_SERVER['DOCUMENT_ROOT'] ) )
$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF']) ) );

//$targetDir = $_SERVER['DOCUMENT_ROOT'].ABSOLUTE_THUMB_UPLOAD_PATH;
switch($UPLOAD_TYPE){
	case 'photo':
		$targetDir = $_SERVER['DOCUMENT_ROOT'].ABSOLUTE_THUMB_UPLOAD_PATH.'/images/';
		break;
	case 'video':
		$targetDir = $_SERVER['DOCUMENT_ROOT'].ABSOLUTE_THUMB_UPLOAD_PATH.'/videos/';
		break;
	case 'file':
		$targetDir = $_SERVER['DOCUMENT_ROOT'].ABSOLUTE_THUMB_UPLOAD_PATH.'/files/';
		break;
	default:
		$targetDir = $_SERVER['DOCUMENT_ROOT'].ABSOLUTE_THUMB_UPLOAD_PATH;
}

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds
// 5 minutes execution time
@set_time_limit(5 * 60);
// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
// Clean the fileName for security reasons
$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
// Make sure the fileName is unique but only if chunking is disabled
if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
	$ext = strrpos($fileName, '.');
	$fileName_a = substr($fileName, 0, $ext);
	$fileName_b = substr($fileName, $ext);
	$count = 1;
	while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
		$count++;
	$fileName = $fileName_a . '_' . $count . $fileName_b;
}
$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
// Create target dir
if (!file_exists($targetDir))
	@mkdir($targetDir);
// Remove old temp files	
if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))){
	while (($file = readdir($dir)) !== false){
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
			@unlink($tmpfilePath);
		}
	}
	closedir($dir);
}else
	die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	
// Look for the content type header
if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
	$contentType = $_SERVER["CONTENT_TYPE"];
// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
if (strpos($contentType, "multipart") !== false) {
	if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
		// Open temp file
		$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
		if ($out){
			// Read binary input stream and append it to temp file
			$in = fopen($_FILES['file']['tmp_name'],"rb");
			if ($in) {
				while ($buff = fread($in, 4096))
					fwrite($out, $buff);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			fclose($in);
			fclose($out);
			@unlink($_FILES['file']['tmp_name']);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
	// Open temp file
	$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
	if ($out) {
		// Read binary input stream and append it to temp file
		$in = fopen("php://input", "rb");

		if ($in) {
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

		fclose($in);
		fclose($out);
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}
// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {rename("{$filePath}.part", $filePath);}
// Return JSON-RPC response
//die('{"jsonrpc" : "2.0", "result" : null, "id" : '.$_REQUEST['id'].' "image" = '.$fileName.' }');

if($UPLOAD_ID){
	if($objTemp->load()){
		if(!$UPLOAD_TYPE){$UPLOAD_TYPE=$objTemp->type;}
		if (in_array($UPLOAD_TYPE,array("banner", "box", "photo","logo"))){$UPLOAD_TYPE="photo";}
		switch($UPLOAD_TYPE){
			case 'person':
				$objTemp->avatar=$fileName;
				$objTemp->update('avatar');
				response($objTemp);
			break;
			case 'photo':
				$objTemp->root_file='images/' . $fileName;
				$objTemp->status='';
				$objTemp->update('root_file,date_update,status');
				$output['aaData'][] = Lbn::getDataMedia($objTemp,$UPLOAD_TEMPLATE);
				response($objTemp,$output);
			break;
			default:
				$objTemp->root_file=$fileName;
				$objTemp->status='';
				$objTemp->update('root_file,date_update,status');			
				response($objTemp);
			break;
		}							
		return;
	}	
}else{
	if(!$UPLOAD_TYPE){$UPLOAD_TYPE=$objTemp->type;}
	if (in_array($UPLOAD_TYPE,array("banner", "box", "photo","logo"))){$UPLOAD_TYPE="photo";}
	$folder = '';
	switch($UPLOAD_TYPE){
		case 'photo':
			$folder = 'images/';
			break;
		case 'file':
			$folder = 'files/';
			break;
	}
	if($UPLOAD_PAGEID){
		$objTemp->title='No Title';
		$objTemp->description='';	
		$objTemp->root_file=$folder.$fileName;
		$objTemp->type=$UPLOAD_TYPE;
		$objTemp->status='new';
		$objTemp->page->id=$UPLOAD_PAGEID;
		if($objTemp->add()){		
			response($objTemp);
		}else{
			echo 'error';
		}		
	}else if($UPLOAD_CATEGORYID){
		$objTemp->title='No Title';
		$objTemp->description='';
		$objTemp->root_file=$folder.$fileName;
		$objTemp->type=$UPLOAD_TYPE;
		$objTemp->status='';
		$objTemp->category->id=$UPLOAD_CATEGORYID;
		if($objTemp->add()){		
			response($objTemp);
		}else{
			echo 'error';
		}		
	}		
}
/*
 * Function
 */
function response($objTemp,$extra=array()){
	global $UPLOAD_TYPE;
	$data = array(); 
	$data["id"]=$_REQUEST['id'];
	$data["type"]=$objTemp->type;

	if($UPLOAD_TYPE!='person'){
		$data["name"]=$objTemp->root_file;
	}else{
		$data["name"]=$objTemp->avatar;
		$data["type"]=$UPLOAD_TYPE;
	}

	if(count($extra)){
	   echo	json_encode(array_merge($data, $extra));
	}else{
	   echo json_encode($data);
	}
}

?>