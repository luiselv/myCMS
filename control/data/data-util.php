<?php
$oHTML = "";
if (!$json) {
	$oHTML .= '<li id="item_' . $objTemp->id . '" class="item '.$itemNew.'" data-id="id-' . $objTemp->id . '" >';
	switch ($pageType) {
		case ($pageType == 'banner' || $pageType == 'photo' || $pageType == 'client') :
			//$oHTML .= 'sss'.$navMode;
			$oHTML .= (strlen($navMode) == 0) ? Lbn::gEMedia ($objTemp):Lbn::gEMedia($objTemp,$navMode);
			$m = false;
			//if($pagePort){$m = true;}
			$oHTML .= Lbn::gHolderEvent($objTemp,$m);
			$oHTML .= Lbn::gEIcon ( $objTemp, 'edit', $pageType );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'delete' );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'upload','','*.jpg',$navMode);			
		break;
		case ($pageType == 'photos') :
			//$oHTML .= 'sss'.$navMode;
			$oHTML .= (strlen($navMode) == 0) ? Lbn::gEMedia ($objTemp):Lbn::gEMedia($objTemp,$navMode);
			$oHTML .= Lbn::gHolderEvent($objTemp,true);
			$oHTML .= Lbn::gEIcon ( $objTemp, 'edit', $pageType );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'delete' );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'upload','','*.jpg',$navMode);			
		break;
		case ($pageType == 'demos' || $pageType == 'radio') :
			$img = (strlen ( $objTemp->root_file ) != 0) ? 'audio' : 'audio1';
			$oHTML .= Lbn::gEMedia ( $objTemp, 'audio', $img );
			$oHTML .= Lbn::gHolderEvent($objTemp);
			$oHTML .= Lbn::gEIcon ( $objTemp, 'edit', $pageType );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'delete' );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'upload','','*.mp3');
			break;
		case ($pType == 'tv') :
			$metadata = json_decode ( $objTemp->metaData );
			$img = strlen ( $metadata->videoURL ) != 0 ? 'video' : 'video1';
			$oHTML .= Lbn::gEMedia ( $objTemp, 'video', $img );
			$oHTML .= Lbn::gHolderEvent($objTemp);
			$oHTML .= Lbn::gEIcon ( $objTemp, 'edit', $pageType );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'delete' );
			$oHTML .= '<div class="nav-item"></div>';
			break;
		default :
			$oHTML .= Lbn::gEMedia ( $objTemp );
			$oHTML .= Lbn::gHolderEvent($objTemp);
			$oHTML .= Lbn::gEIcon ( $objTemp, 'edit', $pageType );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'delete' );
			$oHTML .= Lbn::gEIcon ( $objTemp, 'upload' );
			break;
	}
	$oHTML .= '<div class="arrow" ></div>';
	$oHTML .= '</li>';
} else {
	?>
<!-- Acciones JSON -->
<?php } ?>
