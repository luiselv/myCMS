<?php if($_SESSION['chatMODE']=='support'){	?>
<script>
    var userid = '10000031'; // Must be populated programmatically
   	document.cookie = "cc_data="+userid;
 </script>
<?php } ?>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $_SESSION['chatBASEURL']; ?>cometchatcss.php?z=<?php p($CONFIG['LBN_CONFIG_CHAT_DISABLED']); ?>" /> 
<script type="text/javascript" src="<?php echo $_SESSION['chatBASEURL']; ?>cometchatjs.php?z=<?php p($CONFIG['LBN_CONFIG_CHAT_DISABLED']); ?>" charset="utf-8"></script>
