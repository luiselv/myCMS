<?php 
	$pPageIsPublic = false;
	include '_init.php';
	
	$objCategory = new Category();	
	$categoryId = intval($_REQUEST['cid']);
	$objCategory ->setUid($categoryId);
	if (!$objCategory->load()){
		Tzn::redirect('index.php');
	}
	// CONFIG DATA
	$table = 'page';
	$type = 'page';

	// NAV BUTTON RIGHT
	$pageslist = array();
	if(!in_array($categoryId, $pageslist)){
		$navRightButtonMode = 'link';
		$navRightButtonName = 'New Item';
	}
	
	$params = array();
	$params[] = 'cid='.$categoryId;
	$navRightButtonParams = join('&',$params);
	$pagePrefix = 'page';
	$navRightButtonLink = $pagePrefix.'-add.php?'.$navRightButtonParams;

	// BREADCRUMB - TITLE
	$pageTitle=$objCategory->title;
	$pageBreadcrumbTitle = 'List';			
	$editCategory=true;
	
	// PARAMS : DATA-TABLE 
	$tableParams = array();
	$tableParams[] = 'pagename=page';
	$tableParams[] = 'editmode='.$navRightButtonMode;
	$tableParams[] = 'categoryId='.$categoryId;
	//  \__ ACTION BUTTONS : DATA-TABLE
	$tableParams[] = 'requiredButton=false';
	$tableParams[] = 'statusButton=true';
	$tableParams[] = 'featuredButton=true';
	$tableParams[] = 'editButton=true';
	$tableParams[] = 'deleteButton=true';

	// MENU ACTIVE
	if($objCategory->parentId == 0){
		$_SESSION['m1']='cat'.$objCategory->id;
	}else{
		$_SESSION['m1']='cat'.$objCategory->parentId;
		$_SESSION['m2']='cat'.$objCategory->id;
	}	
		
	include("layout/layout-header.php"); 
	include("layout/layout-submenu-boxes.php");
?>
	<script type="text/javascript" charset="utf-8">	
		function pageInit(){
			LBN_NAV.mode='table';
			LBN_TABLE.tableName = '<?php p($table); ?>';
			LBN_TABLE.init('lbn_page.title','<?php p(join('&',$tableParams)); ?>');			
		}
	</script>	
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="table-item" >
		<thead>
			<tr>
            	<th width="10" ></th>
                <th>Title</th>
                <th width="130" >Last Update</th>
                <th width="50" >Status</th>
                <th width="50" >Actions</th>
			</tr>
       	</thead>
		<tbody>
            <tr>
				<td colspan="5" class="dataTables_empty"><?php echo LBN_MSG_TABLE ?></td>
			</tr>
		</tbody>
     </table> 
<?php include("layout/layout-footer.php"); ?>