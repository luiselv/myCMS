<?php
$pPageIsPublic = false;
include '_init.php';
$aParams = array ();
$table = $_REQUEST ['table'];
$aColumns = explode ( ',', $_REQUEST ['column'] );
$categoryId = intval ( $_GET ['categoryId'] );
$parentId = intval ( $_GET ['parentId'] );
$pEnabled = intval ( $_GET ['enabled'] );
$pType = $_GET ['type'];


if ($table == 'admin'){$table='person';}

$listaI = new $table ();
if ($pEnabled != 2){
	$aParams [] = $listaI->gTable().'.enabled='.$pEnabled;
}
if ($pType != 'none' && isset($_GET ['type'])){
	$aParams [] = $listaI->gTable().'.type="'.$pType.'"';
}
$sIndexColumn = $listaI->getIdKey();
$and = ' and ';
$comp = "";
$actionHolder = '<div style="position:relative" ><div class="btn-group action-holder">_BUTTON_</div><div class="arrow" ></div></div>';
/*
 * Paging
 */
$sLimit = "";
if (isset ( $_GET ['iDisplayStart'] ) && $_GET ['iDisplayLength'] != '-1') {
	$sLimit = "LIMIT " . mysql_real_escape_string ( $_GET ['iDisplayStart'] ) . ", " . mysql_real_escape_string ( $_GET ['iDisplayLength'] );
}
/*
 * Ordering
 */
$sOrder = "orderId Asc,".$sIndexColumn." Desc";
/*
 * if ( isset( $_GET['iSortCol_0'] ) ) { $sOrder = ""; for ( $i=0 ; $i<intval(
 * $_GET['iSortingCols'] ) ; $i++ ) { if ( $_GET[
 * 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) { $sOrder .=
 * $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".mysql_real_escape_string(
 * $_GET['sSortDir_'.$i] ) .", "; } } $sOrder = substr_replace( $sOrder, "", -2
 * ); }
 */
// if(!$objUser->isAdmin()){$comp = " lbn_item.personId=".$objUser->id;}
$sWhere = "";
if (isset ( $_GET ['sSearch'] ) && $_GET ['sSearch'] != "") {
	$sWhere = "(";
	for($i = 0; $i < count ( $aColumns ); $i ++) {
		$sWhere .= $aColumns [$i] . " LIKE '%" . mysql_real_escape_string ( $_GET ['sSearch'] ) . "%' OR ";
	}
	$sWhere = substr_replace ( $sWhere, "", - 3 );
	$sWhere .= ')';
}
for($i = 0; $i < count ( $aColumns ); $i ++) {
	if (isset ( $_GET ['bSearchable_' . $i] ) && $_GET ['bSearchable_' . $i] == "true" && $_GET ['sSearch_' . $i] != '') {
		if ($sWhere == "") {
			$sWhere = "WHERE ";
		} else {
			$sWhere .= " AND ";
		}
		$sWhere .= $aColumns [$i] . " LIKE '%" . mysql_real_escape_string ( $_GET ['sSearch_' . $i] ) . "%' ";
	}
}

switch ($table) {
	case 'person' :		
		$sOrder = "personId desc";
		
		if ($_REQUEST ['table'] == 'admin'){
			$aParams [] = $listaI->gTable().'.levelx=1';
		}else{
			$aParams [] = $listaI->gTable().'.levelx=0';
		}
		if (strlen ( $sWhere ) > 0) {
			$aParams [] = $sWhere;
		}
		loadData ( $listaI, $aParams );
		break;
	case 'category' :
		if ($categoryId) {
			$aParams [] = $listaI->gTable().'.parentId=' . $categoryId;
		}
		if (strlen ( $sWhere ) > 0) {
			$aParams [] = $sWhere;
		}
		$sOrder = "title Desc";
		loadData ( $listaI, $aParams );
	break;			
	default :
		if ($parentId) {
			$aParams [] = $listaI->gTable().'.parentId=' . $parentId;
		}
		if ($categoryId) {
			$aParams [] = $listaI->gTable().'.categoryId=' . $categoryId;
		}		
		if (strlen ( $sWhere ) > 0) {
			$aParams [] = $sWhere;
		}
		loadData ( $listaI, $aParams );
		break;
}
/*
 * Output
 */
$output = array ("sEcho" => intval ( $_GET ['sEcho'] ), "iTotalRecords" => $iTotal, "iTotalDisplayRecords" => $iFilteredTotal, "aaData" => array () );

if ($listaI->rMore ()) {
	while ( $objTemp = $listaI->rNext () ) {
		$btnHTML = '';
        $btnHTML2 = '';
		$row = array ();
		if(!in_array($_GET ['displaymode'],array("content-status", "content"))){
			$row[] = '<input class="checks" id="' . $objTemp->id . '" name="files[]" onclick="LBN_NAV.selectOne(this)" value="' . $objTemp->id . '" type="checkbox" />';
		}
		switch ($table) {
			case 'person' :
				$row [] = $objTemp->getAvatar (24);
				$row [] = $objTemp->firstname . ' ' . $objTemp->lastname;
				$row [] = $objTemp->email;
				$row [] = $objTemp->phone;
				$row [] = $objTemp->typeuser->title;
				$row [] = ($objTemp->status!='new')?gButton($objTemp,'status'):gButton($objTemp,'new');
				if ($objUser->isAdmin ()) {
					$btnHTML .= gButton($objTemp,'edit').gButton($objTemp,'delete');
				} else {
					if ($objTemp->id == $objUser->id) {
						$btnHTML .= gButton($objTemp,'edit');
					}
				}
				$row [] = str_replace('_BUTTON_',$btnHTML,$actionHolder);
			break;			
			case 'page' :
				$options = $objTemp->json2arr('options');
                if ($options->multiLanguage) {
                    $data = $objTemp->json2arr('language');
                    // CONFIG MANUAL
                    $row [] = $data->title_en;
                } else {
					$row [] = $objTemp->title;
				}
                $row [] = getFechaFormat($objTemp->date_update);
                
                /*if ($_GET ['displaymode'] == 'content-status') {
                    $row [] = gButton($objTemp, 'status');
                    $btnHTML = gButton($objTemp, 'edit');
                } else if ($_GET ['displaymode'] == 'content') {
                    $btnHTML = gButton($objTemp, 'edit');
                } else {
                	if ($_GET['pagename'] == 'blog' || $_GET['pagename'] == 'page') { // muestra la opcion "featured"
                		$row [] = Lbn::bStatus($objTemp,true);
					}else{
	                    $row [] = gButton($objTemp, 'status');
					}
                    $btnHTML .= gButton($objTemp, 'edit');
                    $btnHTML .= gButton($objTemp, 'delete');
                }
                $row [] = str_replace('_BUTTON_', $btnHTML, $actionHolder);*/
                
                if($_GET['requiredButton'] == 'true'){
                	$btnHTML2 .= '<span class="label btn-danger">Required</span>';
                	$btnHTML .= gButton($objTemp, 'edit');
                }else{
                	if($_GET['statusButton'] == 'true'){
                		$btnHTML2 .= gButton($objTemp, 'status');
                	}
                	if($_GET['featuredButton'] == 'true'){
                		$btnHTML2 .= '&nbsp;'.Form::qStatus($objTemp,'featured','btn-warning',gLang('langStatus','featured'));
                	}
                	if($_GET['editButton'] == 'true'){
                		$btnHTML .= gButton($objTemp, 'edit');
                	}
                	if($_GET['deleteButton'] == 'true'){
                		$btnHTML .= gButton($objTemp, 'delete');
                	}
                }
                $row [] = $btnHTML2;
                $row [] = str_replace('_BUTTON_', $btnHTML, $actionHolder);
                break;
                
			case 'program' :
				$row [] = $objTemp->title;
				$cProd = new Level();
				$cProd->addWhere('budokon_level.programId='.$objTemp->id);
				$row [] = '<a href="javascript:void(0);" data-id="'.$objTemp->id .'" data-type="'.$table.'" data-params="" onclick="LBN_FORM.openConfig(this)" class="btn btn-mini btn-inverse">'.$cProd->loadCount().' Levels</a>';
				$row [] = '<a href="course-list.php?cid=3&p='.$objTemp->id . '" class="btn btn-mini btn-warning">View Library</a>';
				$row [] = Lbn::bStatus($objTemp);
				$btnHTML .= gButton($objTemp,'edit').gButton($objTemp,'delete');
	    		$row [] = str_replace('_BUTTON_',$btnHTML,$actionHolder);
			break;									
			case 'category' :
				$row = array ();
				$row [] = $objTemp->title;								
				$row [] = gButton($objTemp,'status');
				$btnHTML .= gButton($objTemp,'custom','javascript:LBN_FORM.openForm(' . $objTemp->id . ',&#39navmode=ajax&type=' . $table . '&#39)',BE_ICON_EDIT,'primary');
				$btnHTML .= gButton($objTemp,'delete');
				$row [] = str_replace('_BUTTON_',$btnHTML,$actionHolder);
			break;	
			case 'shopcategory' :
				$row [] = $objTemp->title;								
				$cProd = new Product();
				$cProd->addWhere('budokon_product.shopcategoryId='.$objTemp->id);				
				//$row [] = '<a href="product-list.php?cid=15&sc='.$objTemp->id . '" class="btn btn-mini btn-info" >'.$cProd->loadCount().' Products</a>';	
				$row [] = '<a href="javascript:void(0);" data-id="'.$objTemp->id .'" data-type="'.$table.'" data-params="" onclick="LBN_FORM.openConfig(this)" class="btn btn-mini btn-inverse">'.$cProd->loadCount().' Products</a>';			
				$row [] = gButton($objTemp,'status');
				$btnHTML = gButton($objTemp,'edit').gButton($objTemp,'delete');
				$row [] = str_replace('_BUTTON_',$btnHTML,$actionHolder);
			break;	
			case 'eventtype' :
				$row [] = $objTemp->title;		
				$cProd = new Pagemedia();
				$cProd->addWhere('budokon_pagemedia.pageId='.$objTemp->id);
				$row [] = '<a href="event-type-add.php?id='.$objTemp->id . '#media" class="btn btn-mini btn-info" >'.$cProd->loadCount().' Events</a>';														
				$row [] = '<a href="javascript:void(0);" data-id="'.$objTemp->id .'" data-type="'.$table.'" data-params="" onclick="LBN_FORM.openConfig(this)" class="btn btn-mini btn-inverse">Schedule</a>';				
				$row [] = gButton($objTemp,'status');
				$btnHTML = gButton($objTemp,'edit').gButton($objTemp,'delete');
				$row [] = str_replace('_BUTTON_',$btnHTML,$actionHolder);
			break;				
			case 'product' :
				$row [] = $objTemp->shopcategory->title;			
				$row [] = $objTemp->title;								
				$row [] = gButton($objTemp,'status');
				$btnHTML = gButton($objTemp,'edit').gButton($objTemp,'delete');
				$row [] = str_replace('_BUTTON_',$btnHTML,$actionHolder);								
			default :
				/*$row [] = $objTemp->title;								
				$row [] = getFechaFormat ( $objTemp->date_update );
				$row [] = gButton($objTemp,'status');
				$btnHTML = gButton($objTemp,'custom',$table.'-add.php?cid='.$objTemp->category->id.'&id='.$objTemp->id);
				if($objTemp->active_media){
					$btnHTML .= gButton($objTemp,'custom',$table.'-add.php?cid='.$objTemp->category->id.'&id='.$objTemp->id.'&tab=photo',BE_ICON_IMAGE);
				}
				$btnHTML .= gButton($objTemp,'delete');
				$btnHTML .= '<div class="arrow" ></div></div>';
				$row [] = str_replace('_BUTTON_',$btnHTML,$actionHolder);*/
			break;
		
		}
		$output ['aaData'] [] = $row;
	}
}
echo json_encode ( $output );

/* Function */
function loadData($listaI, $aParams = array()) {
	global $sOrder, $sLimit, $iTotal, $iFilteredTotal, $and;
	$params = "";
	if (count ( $aParams ) > 1) {
		$params = join ( $and, $aParams );
	} else {
		$params = $aParams [0];
	}
	$listaI->addWhere ( $params );
	$listaI->loadList ();
	$iTotal = $listaI->rCount ();
	$iFilteredTotal = $iTotal;
	$listaI->addOrderLimit ( $sOrder . ' ' . $sLimit );
	$listaI->loadList ();
}
function gButton($objTemp,$type,$icon=BE_ICON_EDIT) {
	global $table;
	$page = ($_GET ['pagename'])?$_GET ['pagename']:'page';
	$oButton = '';
	switch($type){
		case 'edit':
			if($_GET ['editmode']!='ajax'){
				$oButton = '<a href="' . $page . '-add.php?id=' . $objTemp->id . '" class="btn btn-mini btn-primary">'.Lbn::qIcon($icon,'icon-white').'</a>';
			}else{
				$oButton = '<a href="javascript:void(0);" data-id="'.$objTemp->id .'" data-params="type='.$table.'" onclick="LBN_FORM.openForm(this)" class="btn btn-mini btn-primary">'.Lbn::qIcon($icon,'icon-white').'</a>';
			}
		break;
		case 'status':
			$oButton = Lbn::bStatus($objTemp);
		break;		
		case 'new':
			$oButton = Form::qStatus('','','btn-info','new',false);
		break;
		case 'delete':			
			$oButton = '<a data-id="'.$objTemp->id.'" data-table="'.$table.'" href="javascript:void(0)" onclick="LBN_TABLE.removeItem(this);" class="btn btn-mini">'.Lbn::qIcon('trash').'</a>';
		break;
		case 'custom':
			$oButton = "<a href='" . $page. "' class='".$oClass.' '.$class."' >".gIMG($icon)."</a>&nbsp;";
		break;						
	}
	return $oButton;
}
function gIMG($icon = BE_ICON_EDIT ){
	return "<img src='".$icon."'  width='24' height='24' />";
}
?>