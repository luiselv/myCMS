<?php
class Lbn {
	/*
	 * PARTS
	 */
	function pPart($part = 1,$label = '',$keyval = '', $msg = ''){
		$oHTML = "";
		if ($part) {
			$oHTML .= '<div class="control-group">
			<label for="' . $keyval . '" class="control-label" >' . $label . ' :</label>
			<div class="controls">';
		} else {
			$oHTML .= '<p class="help-block">'.$msg.'</p></div></div>';
		}
		return $oHTML;
	}
	function p($html){echo $html;}
	/*
	 * ICON
	*/
	function qIcon($icon='pencil',$white='') {
		return '<i class="icon-'.$icon.' '.$white.'" ></i>';
	}
	/*
	 * BUTTON MINI
	*/
	function qButtonMini($id=0,$title='',$icon='',$event='',$class='',$tooltip='',$extra=array()){
		//echo print_r($extra);
		$oHTML = '<a href="javascript:void(0)" onclick="'.$event.'" data-id="'.$id.'" '.join(' ',$extra) .'  class="btn btn-mini '.$class.'" rel="tooltip" title="'.$tooltip.'" >'.$icon.'  '.$title.'</a>';
		return $oHTML;
	}
	function isExternal($objTemp){
		$src = $objTemp->root_file;
		$ret = 0;
		if(preg_match('/youtube\.com\/watch/i', $src) || preg_match('/vimeo\.com/i', $src)){
			$ret = 1;
		}
		return $ret;
	}
	/*
	 * DETECT ICON OR TYPE
	*/
	function bType($objTemp){
		$icon = $objTemp->type;
		$src = $objTemp->root_file;
		if($icon=='video'){
			$src = $objTemp->media_file;
		}
		if(preg_match('/youtube\.com\/watch/i', $src)){
			$icon = 'youtube';
		}elseif(preg_match('/vimeo\.com/i', $src)){
			$icon = 'vimeo';
		}elseif(preg_match('/\.(jpg|jpeg|gif|png|bmp|tiff)(.*)?$/i', $src)){
			$icon = 'photo';
		}elseif(preg_match('/\.(mp4|mov)(.*)?$/i', $src)){
			$icon = 'video';
		}elseif(preg_match('/\.(mp3)(.*)?$/i', $src)){
			$icon = 'audio';
		}elseif(preg_match('/\.(pdf)(.*)?$/i', $src)){
			$icon = 'file';
		}
		return $icon;
	}
	/*
	 * ACTIONS
	 */
	function bActions($objTemp,$params=array(),$template=0){
		$oSep = '<li class="divider"></li>';
		if($template!='photo'){
			$oHTML .= Lbn::bAction($objTemp,'edit',$params['form']).$oSep;
		}			
		$vector =& $params["actions"];
		foreach($vector as $indice => $valor) {
			$icon = $objTemp->type;
			$src = $objTemp->root_file;
			if($icon=='video'){
				$src = $objTemp->media_file;
			}
			$oHTML .= Lbn::bAction($objTemp,
					'preview',
					$vector[$indice]['type'],
					Lbn::bType($objTemp),
					$vector[$indice]['title'],
					$src,
					$objTemp->title
					).$oSep;			
		}
		$oHTML .= Lbn::bAction($objTemp,'delete');
		return $oHTML;
	}
	/*
	 * SWITCH ACTION
	*/
	function bAction($objTemp, $action,$type='',$icon='',$title='',$src='',$ntitle='',$event='LBN_MEDIA.previewMedia(this)') {
		$oHTML = "";
		switch ($action) {
			case 'edit' :
				$oHTML = '<li><a href="javascript:void(0);" onclick="LBN_FORM.openForm(' . $objTemp->id . ',&#39type=' . $type . '&#39)"  >'.Lbn::qIcon().'&nbsp;&nbsp;'.gLang('langForm','lblEdit').'</a></li>';
				break;
			case 'config' :				
				break;
			case 'delete' :
				$oHTML = '<li><a href="javascript:void(0);" data-id="'.$objTemp->id.'" data-field="'.delete.'" onclick="LBN_NAV.actionSelected(this)"  >'.Lbn::qIcon("trash").'&nbsp;&nbsp;Delete</a></li>';				
				break;
			case 'preview' :
				$oHTML .= '<li><a href="javascript:void(0);" id="bpreview-'.$objTemp->id.'" onclick="'.$event.'" data-src="'.$src.'" data-type="'.$type.'" data-title="'.$ntitle.'" >'.Lbn::qIcon("eye-open").'</i>&nbsp;&nbsp;'.$title.'</a></li>';
				break;
				/* FUTURO */
			case 'custom' :
					$oHTML .= '<li><a href="javascript:void(0);" id="bpreview-'.$objTemp->id.'" onclick="'.$event.'" data-src="'.$src.'" data-external="'.Lbn::isExternal($objTemp).'" data-type="'.$type.'" data-title="'.$ntitle.'" >'.Lbn::qIcon($icon).'</i>&nbsp;&nbsp;'.$title.'</a></li>';
					break;
		}
		return $oHTML;
	}
	/*
	 * SWITCH ICON DEFAULT
	 */
	function bButton($objTemp, $icon,$extra=array()) {
		$oHTML = "";
		switch ($icon) {
			case 'edit' :
				$oHTML = Lbn::qButtonMini($objTemp->id,'',Lbn::qIcon(),'LBN_FORM.openForm(' . $objTemp->id . ',&#39type=' . $objTemp->type . '&#39)','',gLang('langForm','lblEdit'));
				break;
			case 'config' :
				$oHTML = Lbn::qButtonMini($objTemp->id,'',Lbn::qIcon('cog'),'LBN_FORM.openConfig(' . $objTemp->id . ',&#39type=config-' . $objTemp->type . '&#39,&#39' . $objTemp->type . '&#39)');
				break;
			case 'delete' :
				$oHTML = Lbn::qButtonMini($objTemp->id,'',Lbn::qIcon('trash'),'LBN_NAV.actionSelected(this,&#34delete&#34)');
				break;
			case 'upload' :
				$oHTML = Lbn::qButtonMini($objTemp->id,'',Lbn::qIcon('upload'),'LBN_FILE.oneFile1(this)','','Upload File',$extra);
				//$oHTML .= '<a class="btn btn-mini upload" rel="tooltip" title="Upload File" ></a>';
				break;
			case 'upload2' :
				$id = Tzn::getRdm(4,"abcdefghijklmnopqrstuvwxyz0123456789");
				$oHTML = Lbn::qButtonMini($objTemp->id,'',Lbn::qIcon('upload'),'uBrowseServer'.$id.'()','','Upload File',$extra);
				$oHTML .= Tzn::qHidden ('filepath', '');
				$oHTML .='<script type="text/javascript">
				function uBrowseServer'.$id.'(){
					var finder = new CKFinder();
					finder.selectActionFunction = Updatefield'.$id.';
					finder.startupPath = "Images:/";
					finder.popup();
				}';
				$oHTML .= "function Updatefield$id(fileUrl){
					fileUrl = replaceAll(fileUrl,ABSOLUTE_UPLOAD_PATH,'');
					$.ajax({
						type: 'POST',
						url: '" . LBN_FOLDER . "control/data/data-update-media.php?id=" . $objTemp->id . "&table=" . $objTemp->_table . "&filename='+fileUrl,
						success : function(response){ LBN_MEDIA.loadAllMedia(1);}
					});
				}";
				$oHTML .= "</script>";
				break;
		}
		return $oHTML;
	}


	/*
	 * _TITLE_
	 * */
	function bTitle($objTemp){
		$oHTML = '<b>'.truncate_string ( strip_tags ( $objTemp->title ), 13 ).'</b>';
		return $oHTML;
	}
	/*
	 * _P_
	* */
	function bP($objTemp){
		$oHTML = truncate_string ( strip_tags ( $objTemp->description ), 90 );
		return $oHTML;
	}
	/*
	 * _STATUS_
	*/
	function bStatus($objTemp,$bFeatured=false){
		$oHTML = Form::qStatus ( $objTemp, 'enabled', 'btn-success', ($objTemp->enabled ? gLang('langStatus','active') : gLang('langStatus','inactive')) );
		if($bFeatured){
			$oHTML .= '&nbsp;'.Form::qStatus($objTemp,'featured','btn-warning',gLang('langStatus','featured'));
		}
		return $oHTML;
	}
	/*
	 * _IMG_
	*/
	function bImage($objTemp,$template=''){		
		$type = Lbn::bType($objTemp);
		$imgDefault='types/'.$type.'.jpg';
		switch ($type){
			case 'youtube':
				$imgDefault='http://img.youtube.com/vi/' . youtubeId($objTemp->media_file) . '/0.jpg';
				break;
			case 'vimeo':
				$imgid = intval(vimeoId($objTemp->media_file));
				$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $imgid . ".php"));
				$url = $hash[0]['thumbnail_large'];
				$imgDefault = (strlen($url)!=0)?$url:$imgDefault;
				break;
			case 'photo':
				$imgDefault = (strlen($objTemp->root_file)!=0)?$objTemp->root_file:$imgDefault;
				break;
			case 'video':
				$imgDefault = (strlen($objTemp->root_file)!=0)?$objTemp->root_file:$imgDefault;
				break;
			case 'file':
				if($objTemp->root_file){
					$ext = end(explode(".", $objTemp->root_file));
					if($ext == 'pdf'){
						$pdfWithPath = $_SERVER['DOCUMENT_ROOT'] . LBN_FOLDER . 'upload/' . $objTemp->root_file;
						$thumb = basename($objTemp->root_file,'.pdf');
						$thumbDirectory = $_SERVER['DOCUMENT_ROOT'] . LBN_FOLDER . 'upload/_thumbs/';
						$thumb = $thumb . '.jpg';
						if(file_exists($thumbDirectory . $thumb) == false){
							exec("convert \"{$pdfWithPath}[0]\" -colorspace RGB -geometry 200 $thumbDirectory$thumb");
						}
						$imgDefault = (file_exists($thumbDirectory . $thumb)) ? '_thumbs/' . $thumb : $imgDefault;
					}
				}
				break;
		}
		if($template!='photo'){			
			$oThumb = 'thumb.php?src='.$imgDefault;
			$oHTML = 'style="border-radius:5px;background-image:url('.$oThumb.');"';
		}else{
			$oThumb = 'thumb.php?full=1&zc=1&w=186&h=130&src='.$imgDefault;
			$oHTML = 'style="background-image:url('.$oThumb.');background-position:center 2px;background-repeat:no-repeat;"';
		}
		return $oHTML;
	}	
	/*
	 * DATA MEDIA
	 */
	function getDataMedia($objTemp,$template=''){
	/*	$hideUpload = false;
		$src=$objTemp->root_file;
		if($objTemp->type=='video'){
			$src= $objTemp->media_file;
		}
		$params = array();
		$params['_ID_'] = $objTemp->id;
		$params['_NEW_'] = $objTemp->status;
		//if($template=='photo'){$hideUpload=false;}
		if($template=='text'){$hideUpload=true;}
		if($hideUpload){
			$params['_EDIT_'] = Lbn::bButton($objTemp,'edit');
		}else{
			$uparams = array();
			$uparams[] = 'data-filters="jpg,gif,png"';
			$uparams[] = 'data-params="id='.$objTemp->id.'&template='.$template.'"';
			$params['_EDIT_'] = Lbn::bButton($objTemp,'upload',$uparams);
			if($template!='photo'){
				$params['_EDIT_'].= Lbn::bButton($objTemp,'edit');
			}
		}
		if(strlen($src)!=0){
			$params['_TYPE_'] = Lbn::bType($objTemp);
			$params['_TYPE_NAME_'] = ucfirst($params['_TYPE_']);
		}
		$params['_TITLE_'] = Lbn::bTitle($objTemp);
		$params['_P_'] = Lbn::bP($objTemp);
		$params['_IMG_'] = Lbn::bImage($objTemp,$template);
		$params['_STATUS_'] = Lbn::bStatus($objTemp);
		
		$actions = array ("form" => $objTemp->type,"actions" => array ());
		if($template!='text'){
			$actions["actions"][] = array("title"=>"Preview","type"=>$objTemp->type);
		}
		$params['_ACTIONS_'] = Lbn::bActions($objTemp,$actions,$template);
		
		return $params;
		
	*/
		$hideUpload = false;
		$params = array();
		$params['_ID_'] = $objTemp->id;
		$params['_NEW_'] = $objTemp->status;
		$params['_TITLE_'] = Lbn::bTitle($objTemp);
		$params['_P_'] = Lbn::bP($objTemp);
		$params['_IMG_'] = Lbn::bImage($objTemp,$template);
		$params['_STATUS_'] = Lbn::bStatus($objTemp);

		$typeOBJ = $objTemp->type;
		
		$src=$objTemp->root_file;
		if($typeOBJ=='video'){$src= $objTemp->media_file;}
		if(strlen($src)!=0){
			$params['_TYPE_'] = Lbn::bType($objTemp);
			$params['_TYPE_NAME_'] = ucfirst($params['_TYPE_']);
		}

		if(in_array($typeOBJ,array("file","video","audio","vimeo"))){$hideUpload=true;}		
		if($template=='text'){$hideUpload=true;}
		
		$aTemp = array();
		/* EDIT PARAMS */
		$aTemp[] = 'type='.$typeOBJ;
		$aTemp[] = 'template='.$template;
		$editParams = array();		
		$editParams[] = Lbn::getDataParams($aTemp);
		
		if($hideUpload){
			$params['_EDIT_'] = Lbn::bButton($objTemp,'edit',$editParams);
		}else{
			$aTemp = array();
			$aTemp[] = 'template='.$template;
			$uploadParams = array();
			$uploadParams[] = 'data-filters="jpg,gif,png"';			
			$uploadParams[] = Lbn::getDataParams($aTemp);
			//$params['_EDIT_'] = Lbn::bButton($objTemp,'upload',$uploadParams);
			$params['_EDIT_'] = Lbn::bButton($objTemp,'upload2',$uploadParams);
			if($template!='photo'){
				$params['_EDIT_'].= Lbn::bButton($objTemp,'edit',$editParams);
			}
		}
		
		$actions = array ("form" => $typeOBJ,"actions" => array ());
		if($template!='text'){
			$actions["actions"][] = array("title"=>"Preview","type"=>$typeOBJ);
		}
		$params['_ACTIONS_'] = Lbn::bActions($objTemp,$actions,$template);		
		return $params;
		
	}
	 
	function getDataParams($params = array()){
		return 'data-params="'.join('&',$params).'"';
	}
	function addInput(&$inputItems,$config){
		$item = new Collection();
		$config = explode('|',$config);		
		// Name,type,class,extra,msg,native,field
		$item->add('label',$config[0]);
		$item->add('name',str_replace(' ','_',$config[0]));
		$item->add('type',$config[1]);
		$item->add('class', $config[2]);
		$item->add('extra', $config[3]);
		$item->add('msg', $config[4]);
		$item->add('native',(bool) $config[5]);
		$item->add('field', $config[6]);
		$inputItems[] = $item->toArray();
	}
	function addDropdown(&$inputItems,$config){
		$item = new Collection();
		$config = explode('|',$config);
		// Name,type,class,extra,msg,native,field
		//$name, $key, $value, $default, $nochoice, $class, $extra
		$item->add('label',$config[0]);
		$item->add('name',str_replace(' ','_',$config[0]));
		$item->add('type',$config[1]);
		$item->add('table',$config[2]);
		$item->add('where',$config[3]);
		$item->add('datavalue',$config[4]);
		$item->add('datatext',$config[5]);
		$item->add('default',$config[6]);
		$item->add('nochoice',$config[7]);
		$item->add('class', $config[8]);
		$item->add('extra', $config[9]);
		$item->add('msg', $config[10]);
		$item->add('native',(bool) $config[11]);
		$item->add('field', $config[12]);
		$inputItems[] = $item->toArray();
	}
	
	/*
	 * TAB
	*/
	
	function addTabItem(&$tabItems,$name,$value,$url,$default=false){
		$tabItem = new Collection();
		$tabItem->add('name',$name);
		$tabItem->add('value',$value);
		$tabItem->add('url', $url);
		$tabItem->add('default', $default);				
		$tabItems[] = $tabItem->toArray();		
	}
	function pTabItem($objTemp, $items = array(),&$inputNameCustom,&$dTitle) {
		//$options = $objTemp->json2arr ( 'options' );
		$options = json_decode($objTemp->options);
		
		$inputs_all = Lbn::allInput($objTemp,$items,$dTitle);
		$oHTML = '<ul class="nav nav-tabs nav-custom" >
		 <li class="dropdown active">
		  <a data-toggle="dropdown" class="dropdown-toggle" data-tabid="general" href="#"><i class="icon-list-alt"></i> General <b class="caret"></b></a>
		  <ul class="dropdown-menu">';
		if ($options->multiLanguage) {
			$oHTML .= '<li class="nav-header">Language</li>';
		}
		for($i = 0; $i < count ( $items ); $i ++) {
			$oHTML .= '<li class="' . ($items [$i] ['default'] ? 'active' : '') . '" ><a href="#' . $items [$i] ['url'] . '" data-toggle="tab" >' . $items [$i] ['name'] . '</a></li>';
		}
		if ($options->seo) {
			$oHTML .= '<li class="divider"></li>
			<li class="nav-header">Page Meta</li>                
			<li ><a data-toggle="tab" href="#seo">SEO</a></li>
			<li ><a data-toggle="tab" href="#facebook">Facebook</a></li>';
		}
		$oHTML .= '</ul>
			</li>';
		if ($options->media) {
			$oHTML .= '<li><a data-toggle="tab" id="tab-media" data-tabid="media" href="#media"><i class="icon-th"></i> Media</a></li>';
		}
		if ($options->project) {
			$oHTML .= '<li><a data-toggle="tab" id="tab-projects" data-tabid="projects" href="#projects"><i class="icon-th"></i> Projects</a></li>';
		}
		if ($options->mediauser) {
			$oHTML .= '<li><a data-toggle="tab" id="tab-market" data-tabid="user" href="#market"><i class="icon-th"></i> Markets</a></li>';			
			$oHTML .= '<li><a data-toggle="tab" id="tab-servicetype" data-tabid="user" href="#servicetype"><i class="icon-th"></i> Service Type</a></li>';			
			$oHTML .= '<li><a data-toggle="tab" id="tab-expertise" data-tabid="user" href="#expertise"><i class="icon-th"></i> Expertise</a></li>';			
			$oHTML .= '<li><a data-toggle="tab" id="tab-deliverymethod" data-tabid="user" href="#deliverymethod"><i class="icon-th"></i> Delivery Method</a></li>';			
			$oHTML .= '<li><a data-toggle="tab" id="tab-user" data-tabid="user" href="#user"><i class="icon-th"></i> Users</a></li>';			
			$oHTML .= '<li><a data-toggle="tab" id="tab-media" data-tabid="media" href="#media"><i class="icon-th"></i> Media</a></li>';			
		}
		if ($options->employee) {
			$oHTML .= '<li><a data-toggle="tab" id="tab-media" data-tabid="media" href="#media"><i class="icon-th"></i> Offices</a></li>';
		}						
		if ($options->education) {
			$oHTML .= '<li><a data-toggle="tab" id="tab-education" data-tabid="education" href="#education"><i class="icon-th"></i> Educations</a></li>';
			$oHTML .= '<li><a data-toggle="tab" id="tab-license" data-tabid="license" href="#license"><i class="icon-th"></i> Licenses</a></li>';
		}						
		$oHTML .= '</ul>';
		$oHTML .= '<div class="tab-content tab-custom">';
		for($i = 0; $i < count ( $items ); $i ++) {
			
			$oHTML .= '<div class="tab-pane tab-pad ' . ($items [$i] ['default'] ? 'active' : '') . '" id="' . $items [$i] ['url'] . '">';
			$oHTML .= '<fieldset>
			            	<legend>' . $items [$i] ['name'] . '</legend>';
			 //echo print_r($inputs_all[$items [$i] ['url']]);
			$inputs = $inputs_all[$items[$i] ['url']];
			// echo print_r($inputs_all->$items[$i]['url']);
			foreach ( $inputs as $input ) {
				$value = $input['value'];
				$name = $input['name'];
				$label = $input['label'];
				$class = $input['class'];
				$extra = $input['extra'];
				$msg = $input['msg'];
				$dddatavalue = $input['datavalue'];
				$dddatatext = $input['datatext'];
				$dddefault = $input['default'];
				$ddnochoice = $input['nochoice'];
				$ddTable = $input['table'];
				$ddWhere = $input['where'];
				$keyval = strtolower ( $name ) . '_' . $items[$i]['url'];
				$inputNameCustom[] = $keyval; 
				if ($input['native']) {
					$value = $objTemp;
					$keyval = $input['field'];
				}
				switch ($input['type']) {
					case 'text' :
						$oHTML .= Form::qText ( $value, $label, $keyval, $class, $extra, $msg);
						break;
					case 'dropdown' :
						$objddItems = new $ddTable();
						if($ddWhere){
							$objddItems->addWhere($ddWhere);
						}
						$objddItems->loadList();
						$oHTML .= Lbn::pPart ( 1, $label, $keyval );
						$oHTML .= $objddItems->qSelect2($keyval, $dddatavalue, $dddatatext, $dddefault, $ddnochoice, $class, $extra);
						$oHTML .= Lbn::pPart( 0, '', '', $msg );
						break;
					case 'text-preview' :
						$oHTML .= Form::qTextPreview( $value, $label, $keyval, $class, $extra, $msg);
						break;
					case 'one-file' :
						$oHTML .= Form::qUploadField( $value, $label, $keyval, $class, $extra, $msg);
						break;
					case 'upload' :
						$oHTML .= Form::qUpload( $value, $label, $keyval, $class, $extra, $msg);
						break;
					case 'select' :			
						//$oHTML .= $value;
						$oHTML .= Lbn::pPart ( 1, $label, $keyval );
						$oHTML .= $value->preview;
						$oHTML .= Lbn::pPart ( 0, '', '', $msg );
						break;
					case 'textarea' :
						$oHTML .= Form::qTextarea ( $value, $label, $keyval, $class, $extra, $msg);
						break;
					case 'legend' :
						$oHTML .= '<h3>'.$label.'</h3><hr>';
						break;							
					case 'html' :
						$oHTML .= Form::qHtml (stripslashes($value), $name, $keyval, $class, $extra, $msg);
						break;												
					case 'editor' :
						$oHTML .= Form::qEditor ( $value, $label, $keyval, $class, array(), '', $msg );
						break;
					case 'editor-lite' :
						$oHTML .= Form::qEditor ( $value, $label, $keyval, $class, array(), 'lite', $msg );
						break;	
					case 'editor-bullet' :
						$oHTML .= Form::qEditor ( $value, $label, $keyval, $class, array(), 'bullet', $msg );
						break;		
					case 'editor-tg' :
						$oHTML .= Form::qEditor ( $value, $label, $keyval, $class, array(), 'tg', $msg );
						break;								
					case 'editor-home' :
						$oHTML .= Form::qEditor ( $value, $label, $keyval, $class, array(), 'home', $msg );
						break;														
					case 'editor-lavan' :
						$oHTML .= Form::qEditor ( $value, $label, $keyval, $class, array(), 'lavan', $msg );
						break;			
				}
			}
			$oHTML .= '</fieldset></div>';
		}
		if ($options->seo) {
			$oHTML .= Form::qSEO1 ( $objTemp );
			$oHTML .= Form::qSEO1 ( $objTemp, false );
		}
		return $oHTML;
	}	
	function allInput($objTemp,$tabItems,&$dTitle){
		$data = array();
		$inputItems = array();
		$data = $objTemp->json2arr('language');
		$inputItems =  $objTemp->json2arr('inputs');
		//echo print_r($inputItems);
		$new_input = array();
		$default = true;
		foreach($inputItems as $input){
			foreach($tabItems as $tab){
				$value='';
				if(!$input->native){
					$fieldName = strtolower($input->name).'_'.$tab['url'];
					$value = $data->$fieldName;

					if($tab['default'] && $default){$dTitle=$value;$default=false;}
					
				}
				$new_input[$tab['url']][] = array_merge ( (array)$input, array("value" => $value ));
			}
		}
		return $new_input;
	}

  /* PAGES : CONFIGURATION */
	function pTabItemLink($items = array(),$selected,$pId) {
		$oHTML = '<ul class="nav nav-tabs nav-custom" >';		
		for($i = 0; $i < count ( $items ); $i ++) {
			$oHTML .= '<li class="' . ($items [$i] ['value'] == $selected ? 'active' : '')  . '" ><a href="?id=' . $pId . '&tab='.$items[$i]['url'].'" >' . $items [$i] ['name'] . '</a></li>';
		}
		$oHTML .= '</ul>';
		return $oHTML;
	}
}
?>