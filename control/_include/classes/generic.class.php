<?php 
class Generic extends TznDb{
	var $_tabAjax = true;
    function Generic($table) {
		$this->addProperties(array(
			'id'				=> 'UID',
			'title'				=> 'STR',
			'description'      	=> 'TXT',						
			'date_create'       => 'DTM',
			'date_update'      	=> 'DTM',								
			'id_person_create'	=> 'NUM',			
			'status'			=> 'STR',
			'enabled'			=> 'NUM',
			'root_file'			=> 'STR',
			'type'			    => 'STR',
			'inputs'			=> 'TXT', // Otros Inputs				
			'language'			=> 'TXT', // Otros Lenguajes				 
			'featured'		    => 'STR', // Sitcky or Featured
			'options'		    => 'TXT', // Configuration
			'seo'	  		    => 'TXT', // Metas / Facebook
			'preview'  		    => 'TXT', // Por implementar
			'icon'				=> 'STR'
		));
		$this->_table=$table;
	}
	
	function getName(){return $this->title;}
		   	   
	function add() {
		$this->date_create =  date("Y-m-d H:i:s"); 
		$this->date_update =  date("Y-m-d H:i:s"); 
		$this->setNum('id_person_create', $_SESSION["tznUserId"]);
		$this->jsonAddUpdate('seo','metaTitle|metaDescription|metaKeyword|ogTitle|ogDescription|ogImage');
		return parent::add();
	}
	
	function update($fields=null,$filter=null) {
		$this->date_update =  date("Y-m-d H:i:s");
		$this->jsonAddUpdate('seo','metaTitle|metaDescription|metaKeyword|ogTitle|ogDescription|ogImage');
		return parent::update($fields,$filter);
	}
	function jsonAddUpdate($field,$seek){
		$this->$field = arr2json($_POST,$seek);
	}
	function json2arr($field){
		$arr = null;
		if($field){
			return json_decode($this->$field);
		}
		return $arr;		
	}
    function uploadFile($field,$c='root_file'){
    	$archivo = new TznFile();	
    	if($archivo->upload($field)){
				$archivo->save();
				$this->setStr($field,'');
				$this->$c=$archivo->fileName;					
				return true;
    	}else{
    		return false;
    	}
    }	
    function removeFile($field='root_file'){
    	$archivo = new TznFile();  
		$archivo->delete($this->$field);
    }
    		
    function getImage($w=0,$h=0,$zc=1,$q=95){
    	$size = '';
    	if( $w > 0 ){ $size .= 'width="'.$w.'"'; }    	
    	if( $h > 0 ){ $size .= 'height="'.$h.'"'; }
    	$str='<img id="img-'.$this->id.'" '.$size.' src="thumb.php?src=';
    	$str2='&w='.$w.'&h='.$h.'&zc='.$zc.'&q='.$q.'" alt="" />';		
		$str1= $this->getRootImage();    	
    	return $str.$str1.$str2;
    }
    	
	function getRootImage(){
		$type = Lbn::bType($this);
		$imgDefault='types/'.$type.'.jpg';
		switch ($type){
			case 'youtube':
				$imgDefault='http://img.youtube.com/vi/'.youtubeId($this->media_file).'/0.jpg';
				break;
			case 'vimeo':
				$imgid = intval(vimeoId($this->media_file));
				$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
				$imgDefault= $hash[0]['thumbnail_large'];
				break;
			case 'photo':
				$imgDefault = (strlen($this->root_file)!=0)?$this->root_file:$imgDefault;
				break;
			case 'video':
				$imgDefault = (strlen($this->root_file)!=0)?$this->root_file:$imgDefault;
				break;
			case 'file':
				if($this->root_file){
					$ext = end(explode(".", $this->root_file));
					if($ext == 'pdf'){
						$pdfWithPath = $_SERVER['DOCUMENT_ROOT'] . LBN_FOLDER . 'upload/' . $this->root_file;
						$thumb = basename($this->root_file,'.pdf');
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
		return $imgDefault;		
	}
	
	/* deprecated */
	function loadItems($orderBy = null, $filter = null) {return $this ->loadData($orderBy,$filter,$random=false);}
			
	function loadData($orderBy = null, $filterBy = null,$random=false){		
		if(!$random){
			$orderBy = empty($orderBy) ? $this ->gTable() .".orderId ASC" : str_replace("#", $this ->gTable(). ".", $orderBy) ;
			$this->addOrder($orderBy);						   		
		}else{
			$this->addOrderRnd($orderBy);			
		}
		empty($filterBy)  ? "" : $this ->addWhere(str_replace("#", $this ->gTable(). ".", $filterBy));
		$this->loadList();
		return $this->rMore();
	}
	function loadDataByFilter($filterParams = array(),$orderBy=null,$random=false) {
		$params = null;
		if(count($filterParams)>0){
			$params = join(' and ',$filterParams);
		}
		return $this->loadData($orderBy,$params,$random);
	}
	
	function arrayToSelect($_arr = array(), $name, $default = null, $optional = false, $style='tznFormSelect', $xtra='') {
		$objCollection = new TznCollection($_arr);
		return $objCollection->qSelect($name, $default, $optional, $style, $xtra);
	}	
}

/* CONTENT */

class Content extends Generic {	
	function Content($table) {
		parent::Generic($table);
		$this->addProperties(array(			
			'parentId'     => 'NUM'			
		));		
	}
	function getParentId(){return $this->parentId;}
	function setParentId($num){$this->parentId = $num;}		
	function delete() {
        if ($this->id) {
        	if (parent::delete()) {
				$this->query('DELETE FROM ' .$this->gTable().' WHERE parentId='.$this->id);
                return true;
            }
        } return false;
    }		
}

class PageContent extends Content{
	var $_native = true; 
	function PageContent($table){
		parent::Content($table);
		$this->addProperties(array(			
			'category'	=> 'OBJ',
			'enqueries'	=> 'STR'
		));		
	}
	function delete() {
        if ($this->id) {
        	if (parent::delete()) {
				if($this->_native){
					$this->query('DELETE FROM '.$this->gPrefix().'pagemedia WHERE '.$this->_table.'Id='.$this->id);
				}else{
					$this->query('DELETE FROM '.$this->gPrefix().$this->_table.'pagemedia WHERE '.$this->_table.'Id='.$this->id);
				}
		        return true;
            }
        } return false;
    }	
	function loadCategory(){
		// cambiar a $this->category->load();
		$objCategory = new Category();	
		$objCategory ->setUid(intval($this->category->id));
		$objCategory ->load();
		$this->category = $objCategory;
	}
}

/* MEDIA */

class Media extends Generic {
	public $fileName  = "";	
	function Media($table='pagemedia') {
		parent::Generic($table);
		$this->addProperties(array(			
			'media_file' => 'STR',
			'meta_data'  => 'STR'
		));
	}	
	function filterById($id, $firstDefault = true) {
		$return = $firstDefault ? $this->rNext() : null;
		$this->rReset();
		while($objItem = $this->rNext()) {
			if ($objItem->id == $id ) {
				$return = $objItem;
			}
		}
		return $return;	
	}
	function loadDataMediaByFilter($custom=null){return $this->loadData(null,$custom);}
	function loadDataAllMediaByParent($id,$parent='page'){return $this->loadData(null,'#'.$parent.'Id='.$id);}				
	function loadDataAllMediaByType($parentId,$enabled=2,$parent='page'){
	   $filterParams = array();
	   if($this->type!='none'){
	   		$filterParams[] = "#type='". $this->type."'";
	   }
	   if($parentId){		   		
			$filterParams[] = "#".$parent."Id=". $parentId;						
	   }
	   if($enabled!=2){$filterParams[] = "#enabled=". $enabled;}
	   return $this ->loadDataByFilter($filterParams);
	}
				        
}

/*
	-| Category        [category]
	---| Page          [page]
	------| PageMedia  [pagemedia]
*/
class Category extends Content{
	function Category(){
		parent::Content('category');
	}
	function pTreeCategory($mode = 'menu') {
		$oTree = new Recursive($this);
		$oTree ->qTreeCategory($mode);		
	}
	function pHorizontalCategory($mode = 'menu') {
		$oTree = new Recursive($this);
		$oTree ->qTreeCategory($mode);
	}
	function getData($field='title',$lang='en'){
		$data = $this->json2arr('language');
		$content = $field."_".$lang;
		return $data ->$content;
	}
}
class Page extends PageContent{
	public $_arrMes  = array(
		'January' => 'January',
		'February' => 'February',
		'March' => 'March',
		'April' => 'April',
		'May' => 'May',
		'June' => 'June',
		'July' => 'July',
		'August' => 'August',
		'September' => 'September',
		'October' => 'October',
		'November' => 'November',
		'December' => 'December'
	);
	public $_arrMes2  = array(
		'1' => 'January',
		'2' => 'February',
		'3' => 'March',
		'4' => 'April',
		'5' => 'May',
		'6' => 'June',
		'7' => 'July',
		'8' => 'August',
		'9' => 'September',
		'10' => 'October',
		'11' => 'November',
		'12' => 'December'
	);
	public $_arrAno  = array(
		'2012' => '2012',
		'2011' => '2011',
		'2010' => '2010',
		'2009' => '2009',
		'2008' => '2008',
		'2007' => '2007',
		'2006' => '2006',												
	);
	
	function Page(){
		parent::PageContent('page');
	}
	function loadPagesByParent(){
		return $this->loadData(null,'#parentId='.$this->parentId);
	}
	function loadPagesByCategory($enabled=2,$orderBy=null){
		$filterParams = array();
		if($this->category->id){
			$filterParams[] = "#categoryId=".$this->category->id;
		}
		if($enabled!=2){
			$filterParams[] = "#enabled=". $enabled;
		}
		return $this ->loadDataByFilter($filterParams,$orderBy);
	}
	function getData($field='title',$lang='en'){
		$data = $this->json2arr('language');
		$content = $field."_".$lang;
		return $data ->$content; 
	}
		
}
class PageMedia extends Media{
	function PageMedia() {
		parent::Media('pagemedia');
		$this->addProperties(array(
			'page'     	=> 'OBJ'
		));
		$this->type='none';
	}
	function loadMediaByPage(){
		return $this->loadDataAllMediaByParent($this->page->id);
	}
	function loadMediaByEnabled($enabled=2){
		return $this->loadDataAllMediaByType($this->page->id,$enabled,'page');
	}
	function loadMediaByFeatured(){
		return $this->loadDataMediaByFilter('#featured=1 and #pageId='.$this->page->id);
	}
	function loadMediaByID($enabled=2){
		return $this->loadDataAllMediaByType(intval($this->page->id),$enabled,'page');
	}	
	function getData($field='title',$lang='en'){
		$data = $this->json2arr('language');
		$content = $field."_".$lang;
		return $data ->$content; 
	}

}

/*
	-| Category        [category]
	---| Gallery       [page]
	------| Photo      [pagemedia]
*/

class Gallery extends Page{
	function Gallery(){
		parent::Page();
	}
}
class Photo extends PageMedia {	
	function Photo(){
		parent::PageMedia();
	}		
}

/*
	-| Category    [category]
	---| Photo     [categorymedia]
*/
class CategoryMedia extends Media{
	function CategoryMedia() {
		parent::Media('categorymedia');
		$this->addProperties(array(
			'category'    => 'OBJ'
		));
		$this->type='none';
	}
	function loadMediaByCategory(){
		return $this->loadDataAllMediaByParent($this->category->id,'category');
	}
	function loadMediaByEnabled($enabled=2){
		return $this->loadDataAllMediaByType($this->category->id,$enabled,'category');
	}
	function loadMediaByFeatured(){
		return $this->loadDataMediaByFilter('#featured=1 and #categoryId='.$this->category->id);
	}
	function loadMediaByID($enabled=2){
		return $this->loadDataAllMediaByType(intval($this->category->id),$enabled,'category');
	}		
}

/* ONLY CONTENT WITHOUT STATUS */
/* DEFAULT */

class Configuration extends TznDb{
	function Configuration(){
		$this->addProperties(array(
				'id'			  => 'UID',
				'name'		      => 'STR',
				'value'		      => 'STR',
				'label'		      => 'STR',
				'help'		      => 'STR',
				'type'		      => 'STR',
				'ext'		      => 'STR',
				'mode'		      => 'STR',
				'group'	     	  => 'STR'
		));
		$this->_table='config';
	}
}

?>