<?php  
	$pPageIsPublic = false;
	include '_init.php';	
	$_SESSION['m1']='';		

	if ($_REQUEST['action']) {
		$cGroup = 'layout';
		$key = 'LBN_CONFIG_LAYOUT_MODE';	
		updateConfig($key,$_REQUEST['value'],$cGroup);

		unset($_SESSION['config']);
		include('../_include/_var.php');
		$msg = 'Layout changed.';
		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
		Tzn::redirect(Tzn::concatUrl($referer,'msg='.urlencode($msg)));
	}	
	function updateConfig($key,$value,$cGroup){
		$objGroup = new Configuration();
		$objGroup->getConnection();
		$objGroup->value = $value;
		$objGroup->update("value","name='".$key."' and ".TZN_DB_PREFIX."_config.group='".$cGroup."'");
	}
?>
