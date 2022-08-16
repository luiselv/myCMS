<?php
$pPageIsPublic = false;
include '_init.php';
$pTabActive = $_REQUEST ['tab'];
$pTable = $_REQUEST ['table'];
$navMode = $_REQUEST ['navmode'];
$pTabContext = $pTabActive . '-context';
$pId = intval ( $_REQUEST ['id'] );
$pQuicksand = ($_REQUEST ['quicksand']);
$enabled = 2;
if (isset ( $_REQUEST ['enabled'] )) {
	$enabled = intval ( $_REQUEST ['enabled'] );
	;
}
$pageType = $pTabActive;
$pField = 'page';
// sleep(15);
?>
<?php if($pQuicksand){ ?><ul id="<?php echo $pTabContext; ?>"
	class="media-grid"><?php } ?>
<?php

switch ($pTable) {
	case ($pTable == 'banner') :
		$pField = 'gallery';
		$navMode = 'only-photo';
		pDataByFilter ();
		break;
	case ($pTable == 'clients') :
		$pField = 'gallery';
		pDataByFilter ();
		break;	
	case ($pTable == 'photo') :
		pDataByFilter ();
		break;
	case ($pTable == 'portfoliomedia') :
		$pField = 'portfolio';
		//$pageType = 'portfoliomedia';
		pDataByFilter ();
		break;
	default :
		// pDataByFilter();
		break;
}
?>
<?php if($pQuicksand){ ?></ul><?php } ?>
<?php

function pDataByFilter() {
	global $pId, $pageType, $enabled, $pField, $pTable,$navMode;
	$objMedia = new $pTable ();
	if ($objMedia->loadDataMediaByFilter ( $pId, $pageType, $enabled, $pField )) {
		while ( $objTemp = $objMedia->rNext () ) {
			include ('data-util.php');
			Tzn::pHtm ( $oHTML );
		}
	}
}
?>