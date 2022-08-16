<?php  
	$pPageIsPublic = false;
	include '_init.php';	
	
	$objPage = new Page();
	$pageMediaTable = 'pagemedia';
	$pageTable = 'pagemedia';
	$pageType = 'page';
	$pageTitle = 'Nueva Pagina';	
	$pageBreadcrumbTitle = 'New';
	// Button Action
	$pageButton = gLang('langForm','save');
	$pageButtonSecondary = gLang('langForm','submit1');
	// Config 		
	$pageId	    = intval($_REQUEST['id']);
	$categoryId = intval($_REQUEST['cid']);

	if($pageId){
		$objPage ->setUid($pageId);
		if ($objPage ->load()){
			$pageTitle = '';
			$pageBreadcrumbTitle = 'Edit';
			$pageButton = gLang('langForm','update');		
			$categoryId = $objPage->category->id;
			$type = $objPage->type;
		}
	}else{	
		if($categoryId){
			$objPage->category->id = $categoryId;
			$objPage->loadCategory();
		}else{		
			$msg = 'Category No Found';
			Tzn::redirect('index.php?msg='.urlencode($msg));			
		}		
	}
	
	$pagePrefix = 'content';
	
	if($categoryId==8 || $categoryId==7){
		$pageReturn = 'index.php?'; 
	}else{
		$pageReturn = $pagePrefix.'-list.php?cid='.$objPage->category->id; 
	}
	$pageReturnStay = $pagePrefix.'-add.php?cid='.$objPage->category->id; 
		
	// Breadcrumb	
	if($categoryId==5){
		$pageBreadcrumb[] = array("name" =>$objPage->category->title, "url" => $pageReturn);
	}
	$navRightButtonMode = 'ajax'; 
	$navRightButtonName = 'New Employee';
	$params = array();
	$params[] = 'table='.$pageTable;
	$params[] = 'type=photo';
	if($categoryId==8){
		$params[] = 'template=text'; // photo or text
	}
	$params[] = 'pageId='.$pageId;
	$navRightButtonParams = join('&',$params);	

	// Active Menu
	$_SESSION['m1']='cat'.$objPage->category->parentId;
	$_SESSION['m2']='cat'.$categoryId;
	
	
	// OPTION
	$multiLanguage = false;
	$options = new Collection();
	$options->add('multiLanguage',$multiLanguage);
	$options->add('seo',false);
	
	$media = false;
	$options->add('media',$media);	
	$objPage->setJSON('options',$options->toArray());	
	// INPUTS
	$inputItems = array();
	// Name,type,class,extra,msg,native,field
	//Lbn::addInput($inputItems,'Title|text|required span8|||1|title');
	//Lbn::addInput($inputItems,'Optional|text|span9||test test|0|');
	Lbn::addInput($inputItems,'Linkedin|text|span5|||1|title');	
	Lbn::addInput($inputItems,'Contact|textarea|span5|||1|description');	
		
	
	$objPage->setJSON('inputs',$inputItems);
	// TAB ITEM
	$tabItems = array();
	Lbn::addTabItem($tabItems,'Information','info','info',true);
	//Lbn::addTabItem($tabItems,'English','en','en',true);	
	//Lbn::addTabItem($tabItems,'Spanish','es','es');	
	$tabContext  = 'media-context';

	$defaultTitle ='';
	// INPUTS CUSTOM
	$inputNameCustom = array();
	$tabHTML = Lbn::pTabItem($objPage,$tabItems,$inputNameCustom,$defaultTitle);
	
	if($objPage ->isLoaded() && $multiLanguage){
		//$pageTitle = $defaultTitle;
	}
	
	// Active Menu
	$_SESSION['m1']='cat'.$objPage->category->parentId;
	$_SESSION['m2']='cat'.$categoryId;
	
	if ($_POST['submit'] || $_POST['submitSecond']) {
		$objPage->setAuto($_POST);	
		$objPage->jsonAddUpdate('language',join('|',$inputNameCustom));	
		 if ($objPage->isLoaded()) {
			$objPage->update();
			
			Tzn::redirect($pageReturn.'&msg='.urlencode(gLang('langMessage','update')));
			
		} else {
			$objPage->add();
			if($_POST['submitSecond']){
				Tzn::redirect($pageReturnStay.'&id='.$objPage->id.'&tab=media&msg='.urlencode(gLang('langMessage','save')));	
			}
			Tzn::redirect($pageReturn.'&msg='.urlencode(gLang('langMessage','save')));
		}											
	}
		$paramsExtra = array();
	$paramsExtra[] = 'pageId='.$pageId;
?>
<?php include("layout/layout-header.php"); ?>	
<style>
	.tab-pad{margin-left:20px;margin-top:20px;}
	#paginator-media{margin-left:0px;}
	.flujo-column {width:187px; border-right:dotted 1px #999; float:left;}
.flujo-title { width:148px; height:39px; background-image:url(../images/flujo-head.png); background-repeat:no-repeat; color:#fff; font-weight:bold; padding:15px; margin-left:7px;}
.flujo-txt {padding:20px;}
</style>
      	 <div id="iddisplay" ></div>  
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  class="form-horizontal"  method="post" name="oCForm" id="oCForm" >         
		 <?php 
              if ($objPage->isLoaded()){p($objPage->qHidden('id'));}				
              p(Tzn::qHidden('cid',$categoryId));
          ?>            
         <div class="tabbable">       
         <?php 
		 	p($tabHTML); 
		 // MEDIA SECTION
		 if($objPage->isLoaded()){  ?>
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
                LBN_TABLE.tableName = '<?php p($pageMediaTable); ?>';
                LBN_NAV.contextName = '#<?php p($tabContext); ?>';
				LBN_MEDIA.extra = '<?php p(join('&',$paramsExtra)); ?>';
            }			
        </script>        
<?php include("layout/layout-footer.php"); ?>