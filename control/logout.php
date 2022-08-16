<?php

$pPageIsPublic=true;
include '_init.php';

if ($objUser->isLogged()) {
	$objUser->load();
}
$userTimeZone = $_SESSION['tznUserTimeZone'];
$objUser->logout();
$pUserIsLogged = false;

Tzn::redirect('index.php');

?>
