<?php  
	$pPageIsPublic = false;
	include '_init.php';	
	
	$objPage = new Page();
	$pageTable = 'pagemedia';
	$pageType = 'page';
	$pageTitle = 'New Item';	
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
			$pageTitle = $objPage ->title;
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
	
	$pagePrefix = 'page';
	$pageReturn = $pagePrefix.'-list.php?cid='.$objPage->category->id; 
	$pageReturnStay = $pagePrefix.'-add.php?cid='.$objPage->category->id; 
		
	// Breadcrumb	
	$pageBreadcrumb[] = array("name" =>$objPage->category->title, "url" => $pageReturn);

	// NAV BUTTON RIGHT
	$navRightButtonMode = 'dropdown'; 
	$navRightButtonName = 'New Media-item';
	$params = array();
	$params[] = 'table='.$pageTable;
	$params[] = 'pageId='.$pageId;
	$navRightButtonParams = join('&',$params);
	$navRightOptions  = Form::qOptionBar($navRightButtonParams,'photo','picture','Photo');
	$navRightOptions .= Form::qOptionBar($navRightButtonParams,'video','video','Video');
	$navRightOptions .= Form::qOptionBar($navRightButtonParams,'file','file','File');
	
	// FILTER
	$navFilterMedia=true;
	$navFilterOptions  = Form::qButtonFilter('type','photo','Photo');
	$navFilterOptions .= Form::qButtonFilter('type','video','Video');
	$navFilterOptions .= Form::qButtonFilter('type','file','File');

	// Active Menu
	if($objPage->category->parentId == 0){
		$_SESSION['m1']='cat'.$categoryId;
	}else{
		$_SESSION['m1']='cat'.$objPage->category->parentId;
		$_SESSION['m2']='cat'.$categoryId;
	}	
	
	// OPTION
	$multiLanguage = true;
	$options = new Collection();
	$options->add('multiLanguage',$multiLanguage);
	$options->add('seo',false);
	$options->add('media',true);
	$objPage->setJSON('options',$options->toArray());	
	// INPUTS
	$inputItems = array();
	
	// Name,type,class,extra,msg,native,field
	Lbn::addInput($inputItems,'Title|text|required span8|||0|title');
	Lbn::addInput($inputItems,'Content|editor|610px|||0|description');
	Lbn::addInput($inputItems,'Picture|upload|span4|||0|root_file');
		
	$objPage->setJSON('inputs',$inputItems);
	
	// TAB ITEM
	$tabItems = array();
	//Lbn::addTabItem($tabItems,'Information','info','info',true);		
	Lbn::addTabItem($tabItems,'English','en','en',true);
	Lbn::addTabItem($tabItems,'Spanish','es','es');

	// MediaTab
	$tabContext  = 'media-context';

	$defaultTitle ='';
	
	// INPUTS CUSTOM
	
	$inputNameCustom = array();
	$tabHTML = Lbn::pTabItem($objPage,$tabItems,$inputNameCustom,$defaultTitle);
	
	if($objPage ->isLoaded() && $multiLanguage){
		$pageTitle = $defaultTitle;
	}	
	
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
?>
<?php include("layout/layout-header.php"); ?>	
<link rel="stylesheet" type="text/css" href="_css/ui/ui.core.css"/>
<link rel="stylesheet" type="text/css" href="_css/ui/ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="_css/ui/ui.datepicker.css"/>
<style>
	.tab-pad{margin-left:20px;margin-top:20px;}
	#paginator-media{margin-left:0px;}
</style>
      	 <div id="iddisplay" ><span style="font-size:11px" >id:</span> <?php echo $pageId; ?></div>  
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="post" name="oCForm" id="oCForm" >         
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
                LBN_TABLE.tableName = '<?php p($pageTable); ?>';
                LBN_NAV.contextName = '#<?php p($tabContext); ?>';
                LBN_MEDIA.extra = 'pageId=<?php p($pageId); ?>';
                $(document).ready(function(){
    				$('#tab-media').click(function(event){
    					actionX = $('#submit').attr('value');
    					if(actionX == "Save"){
    						event.preventDefault();
    						alert("You need to complete and save the information before you can add media items.");
    					}
    				});							
    			});
            }	
        </script>        
<?php include("layout/layout-footer.php"); ?>