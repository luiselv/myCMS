<?php
$pPageIsPublic = false;
include '_init.php';
$FORM_oHTML = $FORM_MSG = $FORM_ERROR = 0;
$FORM_ACTION_LABEL = array();
$FORM_ACTION_LABEL[] = gLang('langForm','done');
$FORM_ACTION_LABEL[] = gLang('langForm','cancel');
$FORM_TABLE	 = $_REQUEST ['table'];
$FORM_TYPE 	 = $_REQUEST ['type'];
$FORM_cTABLE = $_REQUEST ['ctable'];
$FORM_ID 	 = intval ( $_REQUEST ['id'] );
if($FORM_cTABLE){$FORM_TABLE=$FORM_cTABLE;}
$objTemp = new $FORM_TABLE ();
if ($FORM_ID){
	$objTemp->setUid ( $FORM_ID );
	if($objTemp->load()){
		$FORM_ACTION_LABEL[0] = gLang('langForm','save');		
	}
}else{
	$FORM_MSG = 'OBJ : ?';
	$FORM_ERROR = 1;
}

$multiLanguage = false;
switch ($FORM_TYPE) {
	case 'audio' :
		$FORM_oHTML  = getHeader ( $FORM_ID );
		$FORM_oHTML .= Form::qText ( $objTemp, 'Title', 'title', 'required span6' );
		$FORM_oHTML .= Form::qTextarea ( $objTemp, 'Description', 'description', 'span6' );		
		//$FORM_oHTML .= Form::qUpload($objTemp,'<span class="label">Audio</span>','root_file','span5','','','Audios:/');
		$FORM_oHTML .= Form::qUpload($objTemp,'<span class="label">Audio</span>','root_file','span5','','');
		$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);	
		break;
		
	case 'file' :
		$FORM_oHTML  = getHeader ( $FORM_ID );
		$FORM_oHTML .= Form::qText ( $objTemp, 'Title', 'title', 'required span6' );
		$FORM_oHTML .= Form::qTextarea ( $objTemp, 'Description', 'description', 'span6' );
		$FORM_oHTML .= Form::qUpload($objTemp,'<span class="label">File</span>','root_file','span5','','<b>Support:</b> PDF only.','Files:/');
		$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);
		break;
		
	case 'photo' :
		if($multiLanguage){
			// OPTION
			$options = new Collection();
			$options->add('multiLanguage',$multiLanguage);
			$options->add('seo',false);
			$options->add('media',false);
			$objTemp->setJSON('options',$options->toArray());
			// INPUTS
			$inputItems = array();
			Lbn::addInput($inputItems,'Title|text|required span6|||0|title');
			Lbn::addInput($inputItems,'Description|textarea|span6|||0|description');
			$objTemp->setJSON('inputs',$inputItems);
			// TAB ITEM
			$tabItems = array();
			Lbn::addTabItem($tabItems,'English','en','en',true);
			Lbn::addTabItem($tabItems,'Spanish','es','es');
			Lbn::addTabItem($tabItems,'Portuguese','pt','pt');
			$defaultTitle ='';
			// INPUTS CUSTOM
			$inputNameCustom = array();
			$tabHTML = Lbn::pTabItem($objTemp,$tabItems,$inputNameCustom,$defaultTitle);
			$FORM_oHTML  = getHeader ($FORM_ID);
			$FORM_oHTML  = $tabHTML;
			$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);
			$FORM_oHTML .= Tzn::qHidden ('inputcustom','title_en|title_es|title_pt|description_en|description_es|description_pt');
		}else{
			$FORM_oHTML  = getHeader ($FORM_ID);
			$FORM_oHTML .= Form::qText ($objTemp, 'Title', 'title', 'required span6');
			$FORM_oHTML .= Form::qTextarea ($objTemp, 'Description', 'description', 'span6');
			$FORM_oHTML .= Tzn::qHidden ('field', 'preview,description,title');
			$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);
		}
		break;
								
	case 'video' :
		if($multiLanguage){
			// OPTION
			$options = new Collection();
			$options->add('multiLanguage',$multiLanguage);
			$options->add('seo',false);
			$options->add('media',false);
			$objTemp->setJSON('options',$options->toArray());
			// INPUTS
			$inputItems = array();
			Lbn::addInput($inputItems,'Title|text|required span6|||0|title');
			Lbn::addInput($inputItems,'Description|textarea|span6|||0|description');
			//Lbn::addDropdown($inputItems,'Ciudad|dropdown|Page|lbn_page.categoryId=23|id|description||Select one|required span5|||0|ciudad');
			Lbn::addInput($inputItems,'Video|upload|span5||<b>Support:</b> Local Video, Youtube URL, Vimeo URL|0|video');
			$objTemp->setJSON('inputs',$inputItems);
			// TAB ITEM
			$tabItems = array();
			Lbn::addTabItem($tabItems,'English','en','en',true);
			Lbn::addTabItem($tabItems,'Spanish','es','es');
			Lbn::addTabItem($tabItems,'Portuguese','pt','pt');
			$defaultTitle ='';
			// INPUTS CUSTOM
			$inputNameCustom = array();
			$tabHTML = Lbn::pTabItem($objTemp,$tabItems,$inputNameCustom,$defaultTitle);
			$FORM_oHTML  = getHeader($FORM_ID);
			$FORM_oHTML  = $tabHTML;
			$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);
			//$FORM_oHTML .= Tzn::qHidden ('inputcustom','title_en|title_es|title_pt|description_en|description_es|description_pt|ciudad_en|ciudad_es|ciudad_pt|video_en|video_es|video_pt');
			$FORM_oHTML .= Tzn::qHidden ('inputcustom','title_en|title_es|title_pt|description_en|description_es|description_pt|video_en|video_es|video_pt');
		}else{
			$FORM_oHTML  = getHeader($FORM_ID);
			$FORM_oHTML .= Form::qText($objTemp, 'Title', 'title', 'required span6');
			$FORM_oHTML .= Form::qTextarea($objTemp, 'Description', 'description', 'span6');		
			//$FORM_oHTML .= Form::qUpload($objTemp,'<span class="label">Video</span>','media_file','span5','','<b>Support:</b> Local Video, Youtube URL, Vimeo URL','Videos:/');
			$FORM_oHTML .= Form::qUpload($objTemp,'<span class="label">Video</span>','media_file','span5','','<b>Support:</b> Local Video, Youtube URL, Vimeo URL');
			$FORM_oHTML .= Form::qAction($FORM_ID,$FORM_ACTION_LABEL);
		}
		break;
		
	case 'box' :
		$FORM_oHTML  = getHeader ( $FORM_ID );
		$FORM_oHTML .= Form::qText ( $objTemp, 'Title', 'title', 'required span6' );
		$FORM_oHTML .= Form::qTextarea ( $objTemp, 'Description', 'description', 'span6' );		
		$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);	
		break;
		
	case 'category' :
		if($multiLanguage){
			// OPTION
			$options = new Collection();
			$options->add('multiLanguage',$multiLanguage);
			$options->add('seo',false);
			$options->add('media',false);
			$objTemp->setJSON('options',$options->toArray());
			// INPUTS
			$inputItems = array();
			
			// Name,type,class,extra,msg,native,field
			Lbn::addInput($inputItems,'Title|text|required span6|||0|title');
			Lbn::addInput($inputItems,'Description|textarea|span6|||0|description');
			
			$objTemp->setJSON('inputs',$inputItems);
			
			// TAB ITEM
			$tabItems = array();
			//Lbn::addTabItem($tabItems,'Information','info','info',true);
			Lbn::addTabItem($tabItems,'English','en','en',true);
			Lbn::addTabItem($tabItems,'Spanish','es','es');
			Lbn::addTabItem($tabItems,'Portuguese','pt','pt');
			
			$defaultTitle ='';
			
			// INPUTS CUSTOM
			$inputNameCustom = array();
			$tabHTML = Lbn::pTabItem($objTemp,$tabItems,$inputNameCustom,$defaultTitle);
			
			if($objTemp ->isLoaded() && $multiLanguage){
				$pageTitle = $defaultTitle;
			}
			
			$FORM_oHTML  = getHeader ($FORM_ID);
			$FORM_oHTML  = $tabHTML;
			$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);
			$FORM_oHTML .= Tzn::qHidden ('inputcustom','title_en|title_es|title_pt|description_en|description_es|description_pt');
		}else{
			$FORM_oHTML  = getHeader($FORM_ID);
			$FORM_oHTML .= Form::qText($objTemp, 'Title', 'title', 'required span6');
			$FORM_oHTML .= Form::qTextarea($objTemp, 'Description', 'description', 'span6');
			$FORM_oHTML .= Form::qCheckbox($objTemp, 'Visible', 'featured','');
			$FORM_oHTML .= Form::qAction($FORM_ID,$FORM_ACTION_LABEL);
		}
		break;
		
	case 'logo' :
		$FORM_oHTML  = getHeader ( $FORM_ID );		
		$FORM_oHTML .= Form::qText( $objTemp, 'Title', 'description', 'span6' );
		$FORM_oHTML .= Form::qText ( $objTemp, 'Link', 'language', 'span6' );
		//$FORM_oHTML .= Form::qUpload($objTemp,'<span class="label">Mask</span>','preview','span5','','');		
		$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);	
		$FORM_oHTML .= Tzn::qHidden ( 'field', 'description,preview,status,options,language');
		break;
										
	case 'seo' :
		$FORM_oHTML  = getHeader ( $FORM_ID );		
		$FORM_oHTML .= Form::qText( $objTemp, 'Title', 'icon', 'span6' );
		$FORM_oHTML .= Form::qTextarea ( $objTemp, 'Description', 'description', 'span6' );
		$FORM_oHTML .= Form::qTextarea ( $objTemp, 'Keywords', 'preview', 'span6' );
		$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);	
		$FORM_oHTML .= Tzn::qHidden ( 'field', 'icon,description,preview,status,options,language');
		break;
												
	default :		
		// OPTION
		$multiLanguage = true;
		$options = new Collection();
		$options->add('multiLanguage',$multiLanguage);
		$options->add('seo',false);
		$options->add('media',false);
		//$options->add('media','');
		//{"page":"banner-grid","params":""}
		$objTemp->setJSON('options',$options->toArray());	
		// INPUTS
		$inputItems = array();		
		Lbn::addInput($inputItems,'Title|text|required span6|||0|title');
		/*if( $objTemp->page->id==3 ){
			Lbn::addInput($inputItems,'SubTitle|text|span6|||0|title');
		}*/
		
		// Name,type,class,extra,msg,native,field
		//Lbn::addInput($inputItems,'Image|upload|span5|||0|root_file');
		//Lbn::addInput($inputItems,'Optional|text|span9||test test|0|');
		//Lbn::addInput($inputItems,'title|text|span6|||1|title');
		
		Lbn::addInput($inputItems,'Contents|editor|450px|||0|description');
		
		$objTemp->setJSON('inputs',$inputItems);
		// TAB ITEM
		$tabItems = array();
		//Lbn::addTabItem($tabItems,'Information','info','info',true);
		//Lbn::addTabItem($tabItems,'English','enn','enn',true);
		Lbn::addTabItem($tabItems,'Information','enn','enn',true);
		//Lbn::addTabItem($tabItems,'Spanish','ess','ess');	
	
		$defaultTitle ='';
		// INPUTS CUSTOM
		$inputNameCustom = array();
		$tabHTML = Lbn::pTabItem($objTemp,$tabItems,$inputNameCustom,$defaultTitle);
		
		//$FORM_oHTML  = getHeader ( $FORM_ID );
		$FORM_oHTML  = $tabHTML;
		//$FORM_oHTML .= Form::qText ( $objTemp, 'Title', 'title', 'required span6' );
		//$FORM_oHTML .= Form::qTextarea ( $objTemp, 'Description', 'description', 'span6' );
		$FORM_oHTML .= Form::qAction ($FORM_ID,$FORM_ACTION_LABEL);
		$FORM_oHTML .= Tzn::qHidden ( 'root_file',$objTemp->root_file);
		$FORM_oHTML .= Tzn::qHidden ( 'inputcustom','title_enn|contents_enn|subtitle_enn|title_ess|contents_ess|subtitle_ess');	
		$FORM_oHTML .= Tzn::qHidden ( 'field', 'options,language,title,description,icon,status,root_file');			
		break;
}
$FORM_oHTML .= Tzn::qHidden ( 'type', $FORM_TYPE );
if ($FORM_cTABLE) {
	$FORM_oHTML .= Tzn::qHidden ( 'ctable', $FORM_cTABLE );
}
response($objTemp,$FORM_oHTML,$FORM_TYPE,$FORM_MSG,$FORM_ERROR);

/*
* HEADER
*/
function getHeader($oid) {
	$oHTML = '<h2>';
	$oHTML .= ($oid) ? gLang('langForm','lblEdit') : gLang('langForm','lblNew');
	$oHTML .= '</h2><hr />';
	return $oHTML; 
}
/*
 * FUNCTION
 */
function response($objTemp, $oHTML = '', $type = '', $msg = '', $error = 0) {
	$data = array ();
	$data ["id"] = $objTemp->id;
	$data ["html"] = ' <div class="tabbable form-fly">'.$oHTML.'</div>';
	$data ["type"] = $type;
	$data ["msg"] = $msg;
	$data ["error"] = $error;
	echo json_encode ( $data );
}
?>
