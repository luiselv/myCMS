<?php
	$pPageIsPublic = true;
	include '_init.php';
	$pRef = '';
	if ($_REQUEST['ref']){$pRef = $_REQUEST['ref'];} 
	else if (!preg_match('/(index|register|registered|log(in|out))\.php/',$_SERVER['HTTP_REFERER'])) {
		$pRef = $_SERVER['HTTP_REFERER'];
	}
	if (isset($_POST["username"])) {
		if ($objUser->login($_POST["username"],$_POST["password"])) {
			if ($pRef) {
				Tzn::redirect($pRef);
			} else {
				Tzn::redirect('index.php');
			}
		} else {
			$pErrorMessage = $objUser->e('login');
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login</title>
<!-- Framework CSS -->
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le styles -->
<link rel="stylesheet" href="<?php p(LBN_CORE_REMOTE); ?>min/js.php?g=css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php p(BE_CSS_PATH); ?>core/be.login.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php p(BE_CSS_PATH); ?>custom/be.custom.css" type="text/css" media="all" />
<script type="text/javascript" src="<?php p(BE_JS_PATH) ?>yepnope.js"></script> 
<script type="text/javascript" src="<?php p(BE_JS_PATH) ?>core/be.init.js"></script>
<script>
   var ABSOLUTE_PATH = '';
   var ABSOLUTE_UPLOAD_PATH = '<?php p(ABSOLUTE_UPLOAD_PATH); ?>';
</script>
</head>
<body>
<img src="_img/admin/bgs/<?php p(rand(0,9)); ?>.jpg" style="opacity:0;" alt="" id="background" />
<div id="content"></div>
<div id="login">		
<?php  if ($pErrorMessage) { ?>
    <div class="alert-message error fade in" data-alert="alert">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <p><strong>Login Failed:</strong>&nbsp;&nbsp;&nbsp;<?php echo $pErrorMessage; ?></p>
     </div>
<?php } ?>
	<div id="login_panel" style="position:relative;" >
      	 <h1>CONTROL <span style="color:#CCC" >PANEL</span></h1>
		 <form  action="login.php<?php if ($_REQUEST['elogin']) echo "?".$_SERVER['QUERY_STRING']; ?>"  method="post">
            <?php $objUser->qLoginTimeZone(); ?>
            <?php p(Form::qText($_REQUEST['username'],'Username','username','span4','tabindex="1" placeholder="username"')); ?>
            <?php p(Form::qPassword('','Password','password','span4','tabindex="2" placeholder="*******"')); ?>
            <div style="position:absolute;right:20px;top:130px;" ><a style="font-size:9px" id="forget" href="javascript:;">Forgot password?</a></div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary" tabindex="3">Start Session</button>
                <div style="float:right;margin-top:15px;" >
				<a href="javascript:void(0);" rel="popover" title="Browser Support" class="version" data-content="<img src='_img/admin/browsers.png' ><br><ul style='font-size:12px;margin-top:5px;text-align:left;' ><li>Latest Safari</li><li>Latest Google Chrome</li><li>Firefox 4+</li><li>Internet Explorer 9+</li><li>Opera 11</li><li><b>Minimum resolution :</b> 1024 x 768</li></ul>" >Browser Support</a><span class="space" >|</span><a class="version" rel="tooltip" title="<?php echo LBN_WEB; ?>">ver. <?php echo LBN_VERSION; ?></a>    
                </div>
			</div>
		</form>
	</div> <!-- #login_panel -->		
</div> <!-- #login -->
 <script type="text/javascript">    
	function init() {
		$("#background").fullBg();
        $('#login_panel').tooltip({selector: "a[rel=tooltip]"});
		$("a[rel=popover]").popover({offset: 10,html:true}).click(function(e){e.preventDefault()});
		$("#forget").click(function() {
		  $.msgbox("<p>We will send you a new password to the email you registered with:</p>", {
			type    : "prompt",
			inputs  : [
			  {type: "text",label: "Email:", value: "", required: true}			
			],
			buttons : [
			  {type: "submit", value: "Done"},
			  {type: "cancel", value: "Cancel"}
			]
		  }, function(name,password) {
			  //console.log(name);
			if (name) {
				var data = "email=" + name;
				var jqxhr = $.post('data/data-forget.php',data);
				jqxhr.success(function(data) {
					$.msgbox(data, {type: "info"});
				});			  
			} else {
			  $.msgbox("No <b>email</b>.", {type: "info"});
			}
		  });
		});		
    }	
    </script>
</body>
</html>

