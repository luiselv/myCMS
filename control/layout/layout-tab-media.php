<div style="min-height:250px;" class="tab-pane" id="media"  >                  		
   <?php include("layout/layout-submenu-boxes.php"); ?>
    <ul id="<?php echo $tabContext; ?>" class="media-grid" style="margin-top:20px;" ></ul>    	
 </div>
<script type="text/javascript"> 
		function tabInit(){
		   $('a[data-toggle="tab"]').on('shown', function (e){
			   $('#media-actions,#iddisplay').show();
				$('.count').hide();
				if($(e.target).data('tabid')=='media'){
					$('#media-actions,#iddisplay').hide();
					$('.count').show();			
					LBN_UTIL.resizeContext();									
					LBN_MEDIA.loadAllMedia(1);					
				}
			});
			$('.count').hide();
			//console.log($.url().fsegment(1));
			if($.url().fsegment(1)=='media'){
				$('#tab-media').click();
			}
			
		}						
  </script>        
