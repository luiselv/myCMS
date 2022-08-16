<?php  
	$pPageIsPublic = false;
	include '_init.php';	

	$objCategory = new Category();
	$table = 'categorymedia';
	$categoryId	 = intval($_REQUEST['cid']);
	if($categoryId){
		$objCategory->setUid($categoryId);
		$objCategory->load();
	}else{
		$msg = 'Page No Found';
		Tzn::redirect('index.php?msg='.urlencode($msg));
	}	
	
	// Config
	$pageBreadcrumbTitle = $objCategory->title;
	$pageTitle= $pageBreadcrumbTitle;
	$editCategory=true;
	
    // NAV BUTTON RIGHT
	$navRightButtonMode = 'dropdown'; 
	$navRightButtonName = 'New Media-item';
	$params = array();
	$params[] = 'table='.$table;
	$params[] = 'categoryId='.$categoryId;
	$navRightButtonParams = join('&',$params);
	$navRightOptions  = Form::qOptionBar($navRightButtonParams,'photo','picture','Photo');
	$navRightOptions .= Form::qOptionBar($navRightButtonParams,'video','video','Video');
	//$navRightOptions .= Form::qOptionBar($navRightButtonParams,'file','file','PDF');
	
	// FILTER
	$navFilterMedia=true;
	$navFilterOptions  = Form::qButtonFilter('type','photo','Photo');
	$navFilterOptions .= Form::qButtonFilter('type','video','Video');
	
	// MediaTab 
	$tabContext  = 'media-context';
	
	// MENU ACTIVE
	$_SESSION['m1']='cat'.$objCategory->parentId;
	$_SESSION['m1']='cat'.$objCategory->id;
	
	$paramsExtra = array();
	$paramsExtra[] = 'categoryId='.$categoryId;
?>
	<?php include("layout/layout-header.php"); ?>
    <script type="text/javascript">
	 function pageInit(){ 
	   // Config
	    LBN_NAV.tab = true;
		LBN_TABLE.tableName = '<?php p($table); ?>';
		LBN_NAV.contextName = '#<?php p($tabContext); ?>';
		LBN_MEDIA.extra = '<?php p(join('&',$paramsExtra)); ?>';
		LBN_MEDIA.loadAllMedia(1);
	}
	</script>
	<?php include("layout/layout-submenu-boxes.php"); ?> 
    <div id="banner-holder"  >    	 
    	<ul id="<?php echo $tabContext; ?>" class="media-grid" ></ul>            
    </div>
	<?php include("layout/layout-footer.php"); ?>