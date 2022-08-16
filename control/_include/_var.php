<?php
$_SESSION['m1']='';
$_SESSION['m2']='';
$_SESSION['section']='';

$pageMessage="";
$pageMessageMode=0;
$layoutTop = true;
$layoutMarginTop = '40px';
//$pageTitle = "Control Panel";
$pageBreadcrumb = array();

$navActive = true;
$navPreview = false;
$navSelect = true;
$navSort = true;
$navHelp = false;
$navDelete = true;
$navFilterMedia = false;
$navFilterStatus = true;
$editCategory = false;


$CONFIG = array();

if (!isset($_SESSION['config'])){		
	$listConfig = new Configuration();		
	$listConfig->loadList();
	if ($listConfig->rMore()) {
		while ($objItem = $listConfig->rNext()) {
			$CONFIG[$objItem->name]=$objItem->value;			
		}
	}			
	$_SESSION['config'] = $CONFIG;
}else{
	$CONFIG = $_SESSION['config'];
}	
//echo print_r($CONFIG);
// SUPPORT
if(LBN_CONFIG_SUPPORT){
	if($_REQUEST['s-action']=='support'){
		$_SESSION['chatMODE']='support';
		$_SESSION['chatBASEURL'] = 'http://support.visible.pe/';
	}else{
		if($_REQUEST['s-action']=='unsupport'){$_SESSION['chatMODE']='unsupport';}
		if($_SESSION['chatMODE']!='support'){$_SESSION['chatMODE'] = 'local';$_SESSION['chatBASEURL'] = PRJ_CHAT_PATH;}			
	}
}else{$_SESSION['chatBASEURL'] = PRJ_CHAT_PATH;}
define('BAR_DISABLED',$CONFIG['LBN_CONFIG_CHAT_DISABLED']);
$page_title = "";
$layoutMode = strtolower($CONFIG['LBN_CONFIG_LAYOUT_MODE']);
switch($layoutMode){
	case 'sidebar':
		$layoutTop = false;
		$layoutBody = 'fluid';
		$layoutContainer = 'container-fluid';
		$layoutMarginTop = '0px';
	break;
	case 'center':
		$layoutBody = '';
		$layoutContainer = 'container';
	break;
	case 'full':
		$layoutBody = '';
		$layoutContainer = 'container-full';
	break;	
	default:
		$layoutBody = '';
		$layoutContainer = 'container';
	break;	
}
?>