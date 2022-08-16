<?php
	$pPageIsPublic = false;
	include '_init.php';	
	
	$objCategory = new Category();
	$pageTable = 'categorymedia';
	$pageType = 'category';
	$pageTitle = 'New Category';	
	$pageBreadcrumbTitle = 'New';
	// Button Action
	$pageButton = gLang('langForm','save');
	$pageButtonSecondary = gLang('langForm','submit1');
	// Config 		
	$pageId	    = intval($_REQUEST['id']);
	$categoryId = intval($_REQUEST['cid']);

	if($categoryId){
		$objCategory->setUid($categoryId);
		if ($objCategory->load()){
			$pageTitle = $objCategory->title;
			$pageBreadcrumbTitle = 'Edit';
			$pageButton = gLang('langForm','update');		
			$categoryId = $objCategory->id;
			$type = $objCategory->type;
		}
	}else{			
		$msg = 'Category No Found';
		Tzn::redirect('index.php?msg='.urlencode($msg));
	}
	
	$pagePrefix = 'category';
	$pageReturn = $pagePrefix.'-list.php?cid='.$objCategory->id; 
	$pageReturnStay = $pagePrefix.'-add.php?cid='.$objCategory->id; 
		
	// Breadcrumb	
	$pageBreadcrumb[] = array("name" =>$objCategory->title, "url" => $pageReturn);

	$navRightButtonMode = 'ajax'; 
	$navRightButtonName = 'New Item';
	$params = array();
	$params[] = 'table='.$pageTable;
	$params[] = 'type=photo';
	//$params[] = 'pageId='.$pageId;
	$navRightButtonParams = join('&',$params);	

	// Active Menu
	if($objCategory->parentId == 0){
		$_SESSION['m1']='cat'.$categoryId;
	}else{
		$_SESSION['m1']='cat'.$objCategory->parentId;
		$_SESSION['m2']='cat'.$categoryId;
	}	
	
	// OPTION
	$multiLanguage = true;
	$options = new Collection();
	$options->add('multiLanguage',$multiLanguage);
	$options->add('seo',false);
	$options->add('media',false);	
	//if($pageId==3){$options->add('media',true);}
	$objCategory->setJSON('options',$options->toArray());	
	// INPUTS
	$inputItems = array();
	
	// Name,type,class,extra,msg,native,field
	Lbn::addInput($inputItems,'Title|text|required span8|||0|title');
	Lbn::addInput($inputItems,'Content|editor-lavan|610px|||0|description');
	Lbn::addInput($inputItems,'Picture|upload|span4|||0|root_file');	
		
	$objCategory->setJSON('inputs',$inputItems);
	
	// TAB ITEM
	$tabItems = array();
	//Lbn::addTabItem($tabItems,'Information','info','info',true);		
	Lbn::addTabItem($tabItems,'English','en','en',true);	
	//Lbn::addTabItem($tabItems,'Spanish','es','es');	
	$tabContext  = 'media-context';

	$defaultTitle ='';
	
	// INPUTS CUSTOM
	
	$inputNameCustom = array();
	$tabHTML = Lbn::pTabItem($objCategory,$tabItems,$inputNameCustom,$defaultTitle);
	
	if($objCategory->isLoaded() && $multiLanguage){
		$pageTitle = $defaultTitle;
	}
	
	if ($_POST['submit'] || $_POST['submitSecond']) {
		$objCategory->setAuto($_POST);	
		$objCategory->jsonAddUpdate('language',join('|',$inputNameCustom));	
		 if ($objCategory->isLoaded()) {
			$objCategory->update();
			Tzn::redirect($pageReturn.'&msg='.urlencode(gLang('langMessage','update')));
		} else {
			$objCategory->add();
			if($_POST['submitSecond']){
				Tzn::redirect($pageReturnStay.'&id='.$objCategory->id.'&tab=media&msg='.urlencode(gLang('langMessage','save')));	
			}
			Tzn::redirect($pageReturn.'&msg='.urlencode(gLang('langMessage','save')));
		}											
	}
	//$paramsExtra = array();
	//$paramsExtra[] = 'categoryId='.$categoryId;
	//$paramsExtra[] = 'template=photo';  // photo or text
?>
<?php include("layout/layout-header.php"); ?>	
<link rel="stylesheet" type="text/css" href="_css/ui/ui.core.css"/>
<link rel="stylesheet" type="text/css" href="_css/ui/ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="_css/ui/ui.datepicker.css"/>
<style>
	.tab-pad{margin-left:20px;margin-top:20px;}
	#paginator-media{margin-left:0px;}
</style>
      	 <div id="iddisplay" ><span style="font-size:11px" >id:</span> <?php echo $categoryId; ?></div>  
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="post" name="oCForm" id="oCForm" >         
		 <?php 
              if ($objCategory->isLoaded()){p($objCategory->qHidden('id'));}				
              p(Tzn::qHidden('cid',$categoryId));
          ?>            
         <div class="tabbable">       
         <?php 
		 	p($tabHTML); 
		 // MEDIA SECTION
		 if($objCategory->isLoaded()){  ?>
         	<?php include("layout/layout-tab-media.php"); ?>
         <?php } ?>                        
        </div> <!--- Close tab-content --->
        <?php p(Form::qPageAction($pageType,array($pageButton,gLang('langForm','cancel')),$pageReturn)); ?>
        </div>
	    </form>            
		<script type="text/javascript"> 
            function pageInit(){
               // LBN_NAV.fixed=false;
                LBN_NAV.navTop=157;
                LBN_NAV.tab=true;
                LBN_TABLE.tableName = '<?php p($pageTable); ?>';
                LBN_NAV.contextName = '#<?php p($tabContext); ?>';
                LBN_MEDIA.extra = 'categoryId=<?php p($categoryId); ?>';
				$(document).ready(function(){
					//$('#date_create').datepicker();							
				});
            }	
        </script>        
<?php include("layout/layout-footer.php"); ?>