<?php
$pPageIsPublic = false;
include '_init.php';
$table = $_REQUEST ['table'];
$id = intval ( $_REQUEST ['id'] );
$json = intval ( $_REQUEST ['json'] );
$field = $_REQUEST ['field'];
if (! $json) {
	if ($id) {
		$objTemp = new $table ();
		$objTemp->setUid ( $_REQUEST ['id'] );
		$objTemp->load();
		if($objTemp->delete ()){
			if($table!='workorders'){
				$objTemp->removeFile();
			}			
		}		
	} else {
		$files = $_REQUEST ['files'];
		foreach ( $files as $file ) {
			$objFile = new $table ();
			if (! $objFile->loadByKey ( $objFile->getIdKey (), $file )) {
				continue;
			} else {
				if ($objFile->delete ()){
					$objFile->removeFile();
				}
			}
		}
	}
} else {
	$objTemp = new $table ();
	$objTemp->setUid ( $id );
	if (! $objTemp->load ()) {
		echo "OBJ : Delete";
		return;
	}
	switch ($field) {
		case 'slides' :
			$list = json_decode ( $objTemp->$field );
			$i = 0;
			$json = 1;
			for($x = 0; $x < count ( $list ); $x ++) {
				if (intval ( $_REQUEST ['p'] ) != $x) {
					$oCuePoints [$i]->time = $list [$x]->time;
					$oCuePoints [$i]->title = $list [$x]->title;
					$oCuePoints [$i]->content = $list [$x]->content;
					$i ++;
				}
			}
			for($i = 0; $i < count ( $oCuePoints ); $i ++) {
				include ('data-util.php');
				Tzn::pHtm ( $oHTML );
			}
			$objTemp->getConnection ();
			$objTemp->slides = json_encode ( $oCuePoints );
			$objTemp->update ( $field );
			break;
	}
}

?>