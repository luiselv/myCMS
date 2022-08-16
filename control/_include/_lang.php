<?php
	/*
	include PRJ_PLUGINS_PATH.'geolocation/util.php';
	if($_REQUEST['lng']){
		$_SESSION['lng']=$_REQUEST['lng'];
	}else{
		if($_SESSION['lng']==''){
			$paises = array('US','FR','CA','GB','AU','IT','CN');
			if (in_array(get_country_code(), $paises)) {
				$_SESSION['lng']='en';
			}else{
				$_SESSION['lng']=LBN_LANGUAGE;
			}
		}
	}
	*/
	$_SESSION['lng']='en';
	//echo $_SESSION['lng'];
	include PRJ_INCLUDE_PATH.'language/'.$_SESSION['lng'].'/common.php';
?>