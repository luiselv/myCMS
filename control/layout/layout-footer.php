 <div class="clearfix"></div>						
	     </div> 
         <div style="font-size:10px;color:#ccc;margin-top:-5px;" ><span id="times" ></span></div>
    </div>
  </div>
  <div id="notification-holder" style="position:fixed;top:55px;right:20px;" ></div>
  <div id="form-holder" >
	<div style="position:relative;height:auto" >
		<div id="form-holder-close" onclick="LBN_FORM.closeHolder(0)" ><i class="icon-remove" ></i></div>
        <div id="form-content" >
            <form  class="form-horizontal" method="post" name="oForm" id="oForm" >        	
            </form>  
    	</div>
    </div>
   </div>
    <?php include("layout-modal.php"); ?>   
<script type="text/javascript" >
	function init() {
		LBN_UTIL.pageInit();
		 <?php if($_SESSION['chatMODE']=='support'){ ?>
			$.timer(10000, function (timer) {
				var jqxhr = $.getJSON('<?php echo $_SESSION['chatBASEURL']; ?>cometchat_live.php?callback=?');
				jqxhr.success(function(data) {	
					$('#support-state').attr('title',data.s).find('#support-icon').attr('src','<?php p(BE_IMG_PATH);?>'+data.s+'.png');
				});	
			});		
		<?php } 
		// message	
		if($_REQUEST["msg"]){$pageMessage=$_REQUEST["msg"];}
		if($_REQUEST["m"]){$pageMessageMode=$_REQUEST["m"];}
		if($pageMessage){			
		?>	
			LBN_UTIL.openMessage('<?php p($pageMessage); ?>',LBN_SUCCESS);
		<?php }	?>
	};
</script>
<?php include("layout-template.php"); ?>
</body>
</html>