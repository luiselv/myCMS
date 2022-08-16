<div style="min-height:250px;" class="tab-pane" id="license"  >    
	<?php 
		// NAV BUTTON RIGHT
		$navFilterMedia = $navSelect = $navFilterStatus = $navSort = false;		
		$navSort1 = true;
		$navRightButtonMode = 'ajax1'; 
		$navRightButtonName = 'New License';
		$params = array();
		$params[] = 'type=page';
		$params[] = 'categoryId=14';
		$params[] = 'parentId='.$pageId;
		$navRightButtonParams = join('&',$params);	

		include("layout/layout-submenu-boxes.php"); 
	?>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="table-item1" >
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
</div>
