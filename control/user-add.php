<?php 
	$pPageIsPublic = false;
	include '_init.php';
		
	$_SESSION['m1']='access';
	
	$pageTitle = 'New User';
	$pageButton = gLang('langForm','save');
	$pageBreadcrumbTitle = 'New';
	$id 	 = intval($_REQUEST['id']);
	$page	 = 'user-list.php';
	
	if(LBN_CONFIG_MULTIUSER){
		$pageBreadcrumb[] = array("name" => "User List", "url" => $page);		
	}else{
		if(!$id){redirectUser('No Access.');}
	}
	
	$objPerson = new Person();
	$objPerson ->setUid($id);
	if ($objPerson ->load()) {
		$pageTitle = 'Edit User';
		$pageBreadcrumbTitle = 'Edit';
		$pageButton = gLang('langForm','update');;
	}else{
		if(!LBN_CONFIG_MULTIUSER){
			redirectUser(gLang('langCommon','nofound'));
		}else{
			if($id){redirectUser(gLang('langCommon','nofound'));}
		}
	}
			
	if ($_POST['submit']) {
	        $objPerson->setAuto($_POST);
			if ($objPerson->check($_POST['password1'],$_POST['password2'])) {
				 if ($objPerson->isLoaded()) {
					    $objPerson->status='';
						$objPerson->update();
						redirectUser(gLang('langMessage','update'));
					}
				else {
					$objPerson->add();
					redirectUser(gLang('langMessage','save'));
				} 
			}											
	}
	function redirectUser($msg=''){
		if(LBN_CONFIG_MULTIUSER){
			Tzn::redirect('user-list.php?msg='.urlencode($msg));
		}else{
			Tzn::redirect('index.php?msg='.urlencode($msg));
		}		
	}
?>
<?php include("layout/layout-header.php"); ?>
	<script type="text/javascript" charset="utf-8">	
		function pageInit(){
			LBN_TABLE.tableName = 'person';
			LBN_TABLE.type = 'person';
			LBN_FILE.oneFileField('#pickfiles_<?php p($objPerson->id); ?>');
		}		
	</script>	
	<div id="iddisplay" ><span style="font-size:11px" >id:</span> <?php echo $objPerson->id; ?></div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data" name="oCForm" id="oCForm" style="margin-top:20px;" >
	     <?php 
		   		if ($objPerson->isLoaded()){
					p($objPerson->qHidden('id'));
					p($objPerson->qHidden('levelx'));
				}
		   ?>            
           <input type="hidden" name="levelx" value="1">
	<div class="row" >
	    <div class="span6">
          <fieldset>
          <legend>General Info</legend>        
           <?php 
				p(Form::qText($objPerson,'First Name','firstname','required xlarge')); 
				p(Form::qText($objPerson,'Last Name','lastname'));
				p(Form::qText($objPerson,'Email','email','required email xlarge','placeholder="@"',$objPerson->e('email'))); 
		 		p(Form::qText($objPerson,'Cellphone','phone','xlarge')); 
			    if ($objPerson->isLoaded()){
					p(Form::qUploadAvatar($objPerson,'Avatar','avatar')); 
			    }
		  ?>
          </fieldset>
         </div>
         <div class="span5" >
          <fieldset>
          <legend>Credentials</legend> 
          <?php 
		  		p(Form::qText($objPerson,'User','username','required xlarge','',$objPerson->e('username'))); 
				p(Form::qPassword($objPerson,'Password','password1','xlarge','',$objPerson->e('pass'))); 
				p(Form::qPassword($objPerson,'Rewrite Password','password2','xlarge')); 
		  ?>          
          </fieldset>            
          </div>    
       	</div>   
		<div class="form-actions">
            <?php 
				p(Tzn::qSubmit('submit',$pageButton,'','class="btn btn-primary"'));
				echo '&nbsp;&nbsp;';
				if(LBN_CONFIG_MULTIUSER){p(Tzn::qReset('reset',gLang('langForm','cancel'),'','class="btn" onClick="window.location.href=&#39'.$page.'&#39"'));}
			?>
        </div>             	
     </form>  
<?php include("layout/layout-footer.php"); ?>
