<?php  
	$pPageIsPublic = false;
	include '_init.php';	
	$_SESSION['m1']='config';		
	// Config 
	$pageBreadcrumbTitle ="Configuration";
	$pageTitle= $pageBreadcrumbTitle;	
	$pageAction = 'edit';
	$pageTable  = 'config';
	// Fields
	$pageFields =0;
	// Button
	$pageButton = gLang('langForm','update');		
	// Nav
	$navMode = '';
	$pageType   = '';
	
	// Config
	$listaI = new Configuration();		
	$listaI->addGroup(TZN_DB_PREFIX.'_config.group');
	$listaI->addWhere('enabled = 1');
	$listaI->addOrder('gorderId ASC');
	$listaI->loadList();
	$first="";
	$open=false;
		
	$tabItems = array();	
	$tabContext  = 'media-context';	
	if ($listaI->rMore()) {
		while ($objItem = $listaI->rNext()) {			
			$pageTabItem[] = array("name" => ucfirst($objItem->group),"value" => $objItem->group,"url" => $objItem->group);						
		}
	}
	$pageTabActive  = isset($_REQUEST['tab'])? $_REQUEST['tab'] : $pageTabItem[0]['value'];
	$pageTabContext  = $pageTabActive.'-context';
	
	$tabHTML = Lbn::pTabItemLink($pageTabItem,$pageTabActive,0);
		
	$Group = new Configuration();
	if ($_POST['submit']) {
		$cGroup = $_POST['group'];
		$chActive = false;
		//$Group->delete(TZN_DB_PREFIX."_config.group='".$cGroup."'");
		foreach ($_POST as $key => $value) {
			if(is_array($value)){
				if(count($value)==2){$value = $value[1]; }
				updateConfig($key,$value,$cGroup);
			}
		}		
		unset($_SESSION['config']);
		include('_include/_var.php');
		$pageMessage = 'Updated!!..';
	}	
	function updateConfig($key,$value,$cGroup){
		$objGroup = new Configuration();
		$objGroup->getConnection();
		$objGroup->value = $value[0];
		$objGroup->update("value","name='".$key."' and ".TZN_DB_PREFIX."_config.group='".$cGroup."'");
	}
	include("layout/layout-header.php"); 
?> 
         <?php p($tabHTML);  ?>
         <div id="my-tab-content" class="tab-content">
         <div class="active tab-pane tab-pad">        
		 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="<?php echo $pageTabContext; ?> form-horizontal" method="post" enctype="multipart/form-data" name="oCForm" id="oCForm" >  
                <?php	
					$listaI = new Configuration();
					$listaI->addWhere(TZN_DB_PREFIX."_config.group='".$pageTabActive."'");
					$listaI->addWhere('enabled = 1');
					$listaI->addOrder('orderId ASC');
					$listaI->loadList();
					if ($listaI->rMore()) {
						while ($objItem = $listaI->rNext()) {
							switch($objItem->type){
								case 'text':
									p(Form::qText($objItem->value,$objItem->label,$objItem->name.'[]','required xlarge','',$objItem->help)); 
								break;
								case 'textarea':
									p(Form::qTextarea($objItem->value,$objItem->label,$objItem->name.'[]','required xlarge','style="height:70px;"',$objItem->help)); 
								break;
								case 'checkbox':
									$chkDisplay = true;
									if(!LBN_CONFIG_CHAT){if($objItem->name==LBN_CONFIG_CHAT_KEY){$chkDisplay = false;}}
									if($chkDisplay){
										p(Tzn::qHidden($objItem->name.'[]',0));
										p(Form::qCheckbox($objItem->value,$objItem->label,$objItem->name.'[]'));
									}
								break;
								case 'media':
									
								break;
							}							
						}
					}		 
					p(Tzn::qHidden('group',$pageTabActive));
					p(Tzn::qHidden('tab',$pageTabActive));
					p(Form::qPageAction(false,array($pageButton,gLang('langForm','cancel')),'index.php'));
                ?>
              </div>  
            </form>
         </div>
	</div>    
<?php include("layout/layout-footer.php");?>
