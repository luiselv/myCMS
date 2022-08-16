<?php
class Form {
	/*
	 * TEXT
	 */
	function qText($objTemp, $label = 'Title', $keyval = 'title', $class = 'xlarge', $extra = '', $msg = '') {
		$oHTML = "";
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		if (is_object ( $objTemp )) {
			$oHTML .= $objTemp->qText ( $keyval, '', $class, $extra );
		} else {
			$oHTML .= Tzn::qText ( $keyval, $objTemp, $class, $extra );
		}
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );
		return $oHTML;
	}
	/*
	 * PASSWORD
	*/
	function qPassword($objTemp, $label = 'Title', $keyval = 'title', $class = 'xlarge', $extra = '', $msg = '') {
		$oHTML = "";
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		if (is_object ( $objTemp )) {
			$oHTML .= $objTemp->qPassword ( $keyval, '', $class, $extra );
		} else {
			$oHTML .= Tzn::qPassword ( $keyval, $objTemp, $class, $extra );
		}
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );
		return $oHTML;
	}	
	/*
	 * TEXTAREA
	 */
	function qTextarea($objTemp, $label = 'Description', $keyval = 'description', $class = 'xlarge', $extra = 'style="height:50px;"', $msg = '') {
		$oHTML = "";
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		if (is_object ( $objTemp )) {
			$oHTML .= $objTemp->qTextarea ( $keyval, '', $class, $extra );
		} else {
			$oHTML .= Tzn::qTextarea ( $keyval, $objTemp, $class, $extra );
		}
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );
		return $oHTML;
	}
	/*
	 * TEXTAREA HTML
	 */
	function qHtml($objTemp, $label = 'Description', $keyval = 'description', $class = 'xlarge', $extra = 'style="height:60px;"', $msg = '') {
		$oHTML = "";
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		if (is_object ( $objTemp )) {
			$oHTML .= $objTemp->qHtml ( $keyval, '', $class, $extra );
		} else {
			$oHTML .= Tzn::qHtml ( $keyval, $objTemp, $class, $extra );
		}
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );
		return $oHTML;
	}	
	/*
	*	OPTIONS DROPDOWN BAR
	*/
	function qOptionBar($params,$type,$icon='edit',$name,$event='LBN_FORM.newElement(this)'){
		$oHTML = "";
		$oHTML .='<li><a href="javascript:void(0);" style="font-weight:normal" data-params="'.$params.'" onclick="'.$event.'" data-type="'.$type.'" >'.Lbn::qIcon($icon).'&nbsp;&nbsp;'.$name.'</a></li>';
		return $oHTML;	
	}
	/*
	* FILTER BUTTONS	
	*/
	function qButtonFilter($field='type',$value='none',$name='None'){
		$oHTML = '<button type="button" data-field="'.$field.'" data-value="'.$value.'" class="btn">'.$name.'</button>';
		return $oHTML;
	}
	/*
	 * EDITOR
	 */
	function qEditor($objTemp, $label, $keyval,$w='97%', $config = array(),$toolbar=CKEDITOR_TOOLBAR_BASIC, $msg='') {
		$value = '';
		if (is_object ( $objTemp )) {
			$value = $objTemp->_value ( $keyval );
		}else{
			$value = stripslashes($objTemp);
		}		
		$default_config = array ('language' => 'en', 'uiColor' => '#eeeeee','extraPlugins' => 'autogrow', 'resize_maxWidth' => $w, 'width' => $w );		
		switch (strtolower ($toolbar)) {
			case 'lite':
				$config ['toolbar'] = array (array ('Undo', 'Redo' ), array ('Bold', 'Italic', 'Underline'),array('Format'), array ('Link', 'Unlink'), array ('RemoveFormat','Source') );
			break;
			case 'bullet':
				$config ['toolbar'] = array (array ('Undo', 'Redo' ), array ('Bold', 'Italic', 'BulletedList'),array ('RemoveFormat') );
			break;
			case 'tg':
				$config ['toolbar'] = array (array ('Undo', 'Redo' ), array ('Bold', 'Italic', 'BulletedList'),array ('Link', 'Unlink'),array ('RemoveFormat') );
			break;			
			case 'home':
				$config ['toolbar'] = array (array ('Undo', 'Redo' ), array ('Bold', 'Italic'),array ('Link', 'Unlink'),array ('RemoveFormat') );
				$config ['extraPlugins'] = "charcount";
				$config ['charcount_limit'] = 850;
				$config ['charcount_limitReachedUIColor'] = "#ff0000";
			break;						
			case 'lavan':
				$config ['toolbar'] = array (array ('Undo', 'Redo' ), array ('Bold', 'Italic', 'BulletedList'),array('Format'), array ('Image','-','RemoveFormat') );
			break;			
			default :
				$config ['toolbar'] = array (array ('Undo', 'Redo' ), array ('Bold', 'Italic', 'Underline', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-', 'BulletedList', '-', 'TextColor'), array ('Link', 'Unlink', '-','Image','-','RemoveFormat','-','Source') );
				break;
		}
		$config = array_merge ( $default_config, $config );
		$CKEditor = new CKEditor ( ABSOLUTE_CKEDITOR_PATH );
		$CKEditor->returnOutput = true;
		CKFinder::SetupCKEditor ( $CKEditor, PRJ_CKFINDER_PATH );
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		$oHTML .= $CKEditor->editor ( $keyval,$value, $config );
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );
		return $oHTML;
				
	}
	/*
	 * CHECKBOX
	 */
	function qCheckbox($objTemp, $label, $keyval,$msg='') {
		$oHTML = "";
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );		
		if (is_object ( $objTemp )) {
			//$oHTML .= $objTemp->gCheckbox ( $keyval, '' );
			$oHTML .= $objTemp->qCheckbox ( $keyval, '' );
		} else {
			$oHTML .= Tzn::qCheckbox ( $keyval, $objTemp );
		}
		$oHTML .= $msg;		
		$oHTML .= Lbn::pPart ( 0 );
		return $oHTML;
	}
	/*
	 * UPLOAD ONE FILE - FIELD
	 */
	function qUploadField($objTemp, $label = 'Image', $keyval = 'root_file', $extra = 'width:80px;', $msg = '') {
		$oHTML = "";
		$id = "";
		if (is_object ( $objTemp )) {
			$id = $objTemp->id;
		}else{
			$id = Tzn::getRdm(4,"abcdefghijklmnopqrstuvwxyz0123456789");;
		}		
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		$oHTML .= '<div id="container_upload_'.$id.'" style="border:0px solid #000;display:block;margin-bottom:10px;" >
	           		<div id="img_'.$id.'" class="'.$extra.'"  style="float:left;" >';		
	    $oHTML .= $objTemp->getImage(190);	    
	    $oHTML .= '</div>
	                <div id="filelist_'.$id.'" class="upload_files" ></div>
	                      </div>     
	                <a id="pickfiles_'.$id.'" href="javascript:;" data-id="'.$id.'"  data-filters="" class="btn btn-mini" ><i class="icon-search " ></i> Replace Picture</a>';
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );
		
		return $oHTML;
	}
	/*
	 * UPLOAD AVATAR
	 */
	function qUploadAvatar($objTemp, $label = 'Image', $keyval = 'root_file', $extra = 'width:80px;', $msg = '') {
		$oHTML = "";
		$id = "";
		if (is_object ( $objTemp )) {
			$id = $objTemp->id;
		}else{
			$id = Tzn::getRdm(4,"abcdefghijklmnopqrstuvwxyz0123456789");;
		}		
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		$oHTML .= '<div id="container_upload_'.$id.'" style="border:0px solid #000;display:block;margin-bottom:10px;" >
	           		<div id="img_'.$id.'"  style="'.$extra.'float:left;" >';		
	    $oHTML .= $objTemp->getAvatar(64);	    
	    $oHTML .= '</div>
	                <div id="filelist_'.$id.'" class="upload_files" ></div>
	                      </div>     
	                <a id="pickfiles_'.$id.'" href="javascript:;" data-id="'.$id.'"  data-filters="" class="btn btn-mini" ><i class="icon-search " ></i> Replace Picture</a>';
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );
		
		return $oHTML;
	}			
	
	/*
	 * INPUT UPLOAD AND PREVIEW
	 */
	function qUpload($objTemp, $label = 'Upload', $keyval = 'root_file', $class = 'xlarge', $extra = '', $msg = '',$root='Images:/') {
		$oHTML = "";				
		$id = Tzn::getRdm(4,"abcdefghijklmnopqrstuvwxyz0123456789");
		$extra = (!$extra)?'data-target="upreview-'.$id.'" onkeyup="LBN_UTIL.ButtonPreview(this)"':$extra;  
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		$oHTML .= '<div class="form-inline">';
		$oHTML .= '<div class="input-append">';
		if (is_object ( $objTemp )) {
			$oHTML .= $objTemp->qText ( $keyval, '', $class, $extra );
		} else {
			$oHTML .= Tzn::qText ( $keyval, $objTemp, $class, $extra );
		}
		$oHTML .='<button class="btn" type="button" rel="tooltip" title="Add or Replace File" onClick="uBrowseServer'.$id.'()" ><i class="icon-search" ></i></button>';
		$oHTML .= '</div>';
		$oHTML .='&nbsp;<button class="btn" id="upreview-'.$id.'" style="display:none" rel="tooltip" title="Preview" type="button" data-src="" data-type="" onClick="LBN_MEDIA.previewMedia(this)" ><i class="icon-picture" ></i></button>';
		$oHTML .= '</div>';
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );
		
		$oHTML .='<script type="text/javascript">
		function uBrowseServer'.$id.'(){
			var finder = new CKFinder();
			finder.selectActionFunction = uSetFileField'.$id.';
			finder.startupPath = "'.$root.'"; 
			finder.popup();
		}';
		$oHTML .= "function uSetFileField$id(fileUrl){\$('#$keyval').val(replaceAll(fileUrl,ABSOLUTE_UPLOAD_PATH,''));\$('#$keyval').keyup();}";
		$oHTML .= "function firstShow$id(){\$('#$keyval').keyup();}";
		$oHTML .= "setTimeout(\"firstShow$id()\",7500);";
		$oHTML .= "</script>";
		
		return $oHTML;
	}
		
	/*
	 * INPUT TEXT (URL) AND PREVIEW
	 */
	function qTextPreview($objTemp, $label = 'URL', $keyval = 'root_file', $class = 'xlarge', $explicit = '', $msg = '') {
		$oHTML = "";				
		$id = Tzn::getRdm(4,"abcdefghijklmnopqrstuvwxyz0123456789");;
		$extra = 'data-target="upreview-'.$id.'" onkeyup="'.((!$explicit)?'LBN_UTIL.ButtonPreview(this)':'LBN_UTIL.ButtonPreview(this,&#39'.$explicit.'&#39)').'"';  
		$oHTML .= Lbn::pPart ( 1, $label, $keyval );
		$oHTML .= '<div class="form-inline">';
		if (is_object ( $objTemp )) {
			$oHTML .= $objTemp->qText ( $keyval, '', $class, $extra );
		} else {
			$oHTML .= Tzn::qText ( $keyval, $objTemp, $class, $extra );
		}
		$oHTML .='&nbsp;<button class="btn" id="upreview-'.$id.'" style="display:none" rel="tooltip" title="Preview" type="button" data-src="" data-type="" onClick="LBN_MEDIA.previewMedia(this)" ><i class="icon-picture" ></i></button>';
		$oHTML .= '</div>';
		$oHTML .= Lbn::pPart ( 0, '', '', $msg );

		$oHTML .='<script type="text/javascript">';
		$oHTML .= "function firstShow$id(){\$('#$keyval').keyup();}";
		$oHTML .= "setTimeout(\"firstShow$id()\",4000);";
		$oHTML .= "</script>";
		
		return $oHTML;
	}
	
	/*
	 * ACTION
	 */
	function qAction1($value, $action = array('Done','Cancel'), $editor = false) {
		$event = 'LBN_FORM.sendForm();LBN_TABLE1.table.fnStandingRedraw();return false;';
		if($editor){
			$event = 'LBN_FORM.sendFormWithEditor();return false;';
		}
		$oHTML = '<div class="form-actions" >_BUTTON_</div>';
		$btnHTML = Tzn::qHidden ( 'id', $value );
		$btnHTML .= Tzn::qHidden ( 'h_id', $value );
		$btnHTML .= Tzn::qSubmit ( 'submit', $action [0], 'btn btn-primary', 'onclick="' . $event . '"' );
		$btnHTML .= '&nbsp;';
		$btnHTML .= Tzn::qReset ( 'h_id', $action [1], 'btn', 'onclick="LBN_FORM.closeHolder(0)"' );
		return str_replace ( '_BUTTON_', $btnHTML, $oHTML );
	}	 
	function qAction($value, $action = array('Done','Cancel'), $editor = false) {
		$event = 'LBN_FORM.sendForm();return false;';
		if($editor){
			$event = 'LBN_FORM.sendFormWithEditor();return false;';
		}
		$oHTML = '<div class="form-actions" >_BUTTON_</div>';
		$btnHTML = Tzn::qHidden ( 'id', $value );
		$btnHTML .= Tzn::qHidden ( 'h_id', $value );
		$btnHTML .= Tzn::qSubmit ( 'submit', $action [0], 'btn btn-primary', 'onclick="' . $event . '"' );
		$btnHTML .= '&nbsp;';
		$btnHTML .= Tzn::qReset ( 'h_id', $action [1], 'btn', 'onclick="LBN_FORM.closeHolder(0)"' );
		return str_replace ( '_BUTTON_', $btnHTML, $oHTML );
	}
	function qPageAction($value,$action = array('Done','Cancel'), $pageReturn = '') {
		$oHTML = '<div class="form-actions" id="media-actions" >_BUTTON_</div>';
		if($value){
			$btnHTML = Tzn::qHidden ('type', $value );
		}
		$btnHTML .= Tzn::qSubmit ('submit', $action [0], 'btn btn-primary');
		$btnHTML .= '&nbsp;';
		if($action [2]){
			$btnHTML .= Tzn::qSubmit('submitSecond',$action [2],'','class="btn btn-success"');
			$btnHTML .= '&nbsp;';
		}
		if($action [1]){
			$btnHTML .= Tzn::qReset ( 'reset', $action [1], 'btn',' onclick="LBN_UTIL.redirect(&#39'.$pageReturn.'&#39)"' );
		}
		return str_replace ( '_BUTTON_', $btnHTML, $oHTML );
	}
	
	/*
	* STATUS
	*/
	function qStatus($objTemp, $field, $class, $name, $lnk=true) {
		$oHTML = "";
		$a = $b = "";
		if ($lnk) {
			if (is_object ( $objTemp )) {
				$a = $objTemp->$field ? $class : '';
				$b = $objTemp->id;
			} else {
				$a = $objTemp[$field] ? $class : '';
				$b = $objTemp["id"];
			}
			$oHTML = '<a class="label '.$a.' '.$field.'" data-field="'.$field.'"  onclick="LBN_NAV.actionSelected(this)" href="javascript:void(0);" data-id="'.$b.'"  id="'.$field.'-'.$b.'" >'.$name.'</a>';
		} else {
			$oHTML = '<span class="label ' . $class . '" >' . $name . '</span>';
		}
		return $oHTML;
	}
	
	function qSEO($objTemp,$seo=TRUE,$facebook=FALSE) {
		$FORMSEO = '';
		$oHTML = '';
		$data = json_decode($objTemp->seo);
		//echo print_r($data);
		//echo $data->metaTitle;
		if($seo){
			$oHTML = '<div class="control-group"><div class="controls">';
			$oHTML .= '<i class="icon-list-alt"></i>  <a style="font-size:11px;" href="javascript:void(0)" onclick="$(&#39div#seo&#39).toggle();" >Click here to improve pages rank in search engines (SEO)</a>';
			$oHTML .= '</div></div>';
			$oHTML .= '<div id="seo" style="display:none;" ><div class="tabbable">_INPUT_</div></div>';
			
			$oSEO1  = '<li class="active"><a href="#seos" data-toggle="tab">SEO</a></li>';
			$oSEO2 .= '<div class="tab-pane active" id="seos">';
			$oSEO2 .= Form::qTextarea($data->metaTitle,'Meta Title', 'metaTitle', 'span8');
			$oSEO2 .= Form::qTextarea($data->metaDescription,'Meta Description', 'metaDescription', 'span8');
			$oSEO2 .= Form::qTextarea($data->metaKeyword,'Meta Keywords', 'metaKeyword', 'span8');
			$oSEO2 .= '</div>';			
		}
		if($facebook){
			$oSEO1 .= '<li><a href="#facebook" data-toggle="tab">Facebook</a></li>';
			$oSEO2 .= '<div class="tab-pane" id="facebook">';
			$oSEO2 .= Form::qTextarea($data->ogTitle,'OG Title', 'ogTitle', 'span8');
			$oSEO2 .= Form::qTextarea($data->ogDescription,'OG Description', 'ogDescription', 'span8');
			$oSEO2 .= Form::qUpload($data->ogImage,'OG Image','ogImage','span7','','<b>Note :</b> Only picture');
			$oSEO2 .= '</div>';
		}
		
		
		$header = '<ul class="nav nav-pills">_HEADER_</ul>';
		$body = '<div class="tab-content">_BODY_</div>';
				
		$oSEO = str_replace('_HEADER_',$oSEO1,$header).str_replace('_BODY_',$oSEO2,$body);
		$FORMSEO = str_replace('_INPUT_',$oSEO,$oHTML);

		
		return $FORMSEO;
	} //end	
	function qSEO1($objTemp,$seo=true){		
		$data = $objTemp->json2arr('seo');
		if($seo){
			$oSEO2 = '<div class="tab-pane tab-pad" id="seo">';
			$oSEO2 .= '<fieldset><legend>Page Meta</legend>';
			$oSEO2 .= Form::qTextarea($data->metaTitle,'Meta Title', 'metaTitle', 'span8');
			$oSEO2 .= Form::qTextarea($data->metaDescription,'Meta Description', 'metaDescription', 'span8');
			$oSEO2 .= Form::qTextarea($data->metaKeyword,'Meta Keywords', 'metaKeyword', 'span8');
			$oSEO2 .= '</div></fieldset>';
		}else{			
			$oSEO2 = '<div class="tab-pane tab-pad" id="facebook">';
			$oSEO2 .= '<fieldset><legend>Facebook Meta</legend>';
			$oSEO2 .= Form::qTextarea($data->ogTitle,'OG Title', 'ogTitle', 'span8');
			$oSEO2 .= Form::qTextarea($data->ogDescription,'OG Description', 'ogDescription', 'span8');
			$oSEO2 .= Form::qUpload($data->ogImage,'OG Image','ogImage','span7','','<b>Note :</b> Only picture');
			$oSEO2 .= '</div></fieldset>';
		}
		return $oSEO2;
	} //end	
}
?>