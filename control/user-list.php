<?php 
	$pPageIsPublic = false;
	include '_init.php';

	// Config 
	if(!LBN_CONFIG_MULTIUSER){Tzn::redirect('index.php?msg=No access');exit;}

	// CONFIG DATA
	$table = 'person';
	$type = 'person';

	// NAV BUTTON RIGHT
	// ajax : Required CategoryID : Used TABLE
	$navRightButtonMode = 'ajax'; 
	$navRightButtonName = 'New User';
	$params = array();
	$params[] = 'type='.$type;
	$navRightButtonParams = join('&',$params);	

	// link : Required CategoryID : Used TABLE
	$navRightButtonMode = 'link'; 
	$navRightButtonName = 'New User';
	$pagePrefix = 'user';
	$navRightButtonLink = $pagePrefix.'-add.php'; 	

	// BREADCRUMB - TITLE
	$pageTitle='User List';
	$pageBreadcrumbTitle = 'List';		

	// PARAMS : DATA-TABLE 
	$tableParams = array();
	$tableParams[] = 'pagename=user';

	// MENU ACTIVE
	$_SESSION['m1']='';
	$_SESSION['m2']='';

	include("layout/layout-header.php"); 
	include("layout/layout-submenu-boxes.php");
?>
	<script type="text/javascript">			
		function pageInit(){
			LBN_NAV.mode='table';
			LBN_TABLE.tableName = '<?php p($table); ?>';
			LBN_TABLE.init('firstname,email,phone','<?php p(join('&',$tableParams)); ?>');			
		}	
	</script>	
 	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="table-item" >
		<thead>
			<tr>
            	<th width="10" ></th>
	            <th width="40" >Pic</th>
                <th>Name </th>
                <th>Email</th>
                <th>CellPhone</th>
                <th width="50" >Status</th>
                <th width="50" >Actions</th>
			</tr>
       	</thead>
		<tbody>
            <tr>
				<td colspan="7" class="dataTables_empty"><?php p(LBN_MSG_TABLE); ?></td>
			</tr>
		</tbody>
     </table> 
<?php include("layout/layout-footer.php"); ?>