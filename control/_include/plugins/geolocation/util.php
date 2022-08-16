<?php
include ('ipinfodb.class.php');

function get_country_code() {
	$geolocation = new ipinfodb();	
	$geolocation->setKey('b111cb2765c2e7b5667014f7cf4a35a2b67ed726a959bc2c87320bf784aba274');
	
	$visitorGeolocation = $geolocation->getGeoLocation(get_ip());
	return ($visitorGeolocation ['Status'] == 'OK') ? $visitorGeolocation ['CountryCode'] : null;
}


function get_ip() {
	if (getenv ( 'HTTP_CLIENT_IP' )) {
		$ip = getenv ( 'HTTP_CLIENT_IP' );
	} elseif (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
		$ip = getenv ( 'HTTP_X_FORWARDED_FOR' );
	} elseif (getenv ( 'HTTP_X_FORWARDED' )) {
		$ip = getenv ( 'HTTP_X_FORWARDED' );
	} elseif (getenv ( 'HTTP_FORWARDED_FOR' )) {
		$ip = getenv ( 'HTTP_FORWARDED_FOR' );
	} elseif (getenv ( 'HTTP_FORWARDED' )) {
		$ip = getenv ( 'HTTP_FORWARDED' );
	} else {
		$ip = $_SERVER ['REMOTE_ADDR'];
	}
	return $ip;
}

 //echo get_country_code();

?>