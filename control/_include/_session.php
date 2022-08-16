<?php
session_start();
$objUser = new Person();
if (!$pPageIsPublic) {
	if ($pUserIsLogged = $objUser->isLogged($pLevel)) {	
		if ($objUser->load() != $_SESSION["tznUserId"]) {
			$objUser->logout();
			$pUserIsLogged = false;		
			Tzn::redirect('login.php');
		}else{
			$_SESSION['userid']=$objUser->id; 
		}
	} else {
		if ($pUserIsLogged = $objUser->checkAutoLogin()) {
			// user is automatically logged in
		} else {
			// user is not logged in and tries to access private page
			Tzn::redirect('login.php');
		}
	}
}
?>