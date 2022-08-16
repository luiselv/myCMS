<div style="min-height:250px;" class="tab-pane" id="education"  >    
	<?php 
		// NAV BUTTON RIGHT
		$navFilterMedia = $navSelect = $navFilterStatus = false;		
		$navRightButtonMode = 'ajax'; 
		$navRightButtonName = 'New Education';
		$params = array();		
		$params[] = 'type=page';
		$params[] = 'categoryId=13';
		$params[] = 'parentId='.$pageId;
		$navRightButtonParams = join('&',$params);	

		include("layout/layout-submenu-boxes.php"); 
	?>
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
</div>
<script type="text/javascript"> 
		function tabInit(){
		   $('a[data-toggle="tab"]').on('shown', function (e){
			   $('#media-actions,#iddisplay').show();
				$('.count').hide();
				
				if($(e.target).data('tabid')=='education' || $(e.target).data('tabid')=='license'){
					$('#media-actions,#iddisplay').hide();
					$('.count').show();			
					LBN_UTIL.resizeContext();									
				}
				
			});
			$('.count').hide();
			//console.log($.url().fsegment(1));
			if($.url().fsegment(1)=='education'){
				$('#tab-education').click();
			}
			
			if($.url().fsegment(1)=='license'){
				$('#tab-license').click();
			}										
			
		}						
  </script>        
