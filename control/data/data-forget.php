<?php
$pPageIsPublic = true;
include '_init.php';
if (isset ( $_POST ["email"] )) {
	$objUserFound = new Person ();
	$objUserFound->setEml ( 'email', $_POST ['email'] );
	if ($objUserFound->email) {
		if ($newpass = $objUserFound->forgotPassword ( "email", $_POST ['email'] )) {
			// send email
			$bodyMessage = "\r\n\r\n\tusername : " . $objUserFound->username . "\r\n\tpassword : " . $newpass;
			mail ( $objUserFound->get ( "email" ), 'Recuperar Contraseña', $bodyMessage );
			$pErrorMessage = 'Su nueva contrasena fue enviada a su email.';
		} else {
			$pErrorMessage = 'Error: ' . $objUserFound->e ( "forgot" );
		}
	} else {
		$pErrorMessage = 'Error: email address not valid';
	}
	echo $pErrorMessage;
}
?>