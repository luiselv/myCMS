<?php
header ( 'Content-type: application/json' );
$pReferer = $_SERVER['HTTP_REFERER'];
$pMessage = stripslashes($_REQUEST['tznMessage']);
$pMessage = preg_replace("/<script[^>]*>[^<]+<\/script[^>]*>/is","", $pMessage);
$pMessage = preg_replace("/<\/?(div|span|iframe|frame|input|textarea|script|style|applet|object|embed|form)[^>]*>/is","", $pMessage);
$output['error'] = 1;
$output['msg'] = $pMessage;
echo json_encode ( $output );
?>
