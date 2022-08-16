<?php
$pPageIsPublic = false;
include '_init.php';
$table = $_REQUEST ['table'];
setOrder ( $table );
function setOrder($table) {
	$updateRecordsArray = $_POST ['item'];
	$dbupdate = new $table ();
	switch ($table) {
		default :
			$table = $dbupdate->_table;
			break;
	}
	$dbupdate->getConnection ();
	$i = 1;
	foreach ( $updateRecordsArray as $recordIDValue ) {
		$query = "UPDATE " . TZN_DB_PREFIX . '_' . $table . " SET orderId = " . $i . " WHERE " . $table . "Id = " . $recordIDValue;
		//echo $query;
		$dbupdate->query ( $query );
		$i = $i + 1;
	}
}
?>