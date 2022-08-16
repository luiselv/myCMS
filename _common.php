<?php 
//define('DOMAIN','http://altavista147.com/web/');
$pPageIsPublic = true;
include 'control/_init.php';
$_SESSION['active']='';

if(isset($_REQUEST['l'])){
	$_SESSION['nav-language']=$_REQUEST['l'];
}else{
	if(empty($_SESSION['nav-language'])){
		$_SESSION['nav-language']='en';
	}
	
}

$lang = $_SESSION['nav-language'];
?>