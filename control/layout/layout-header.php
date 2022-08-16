<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php p($CONFIG['LBN_CONFIG_PANEL_NAME']); ?> - <?php p($pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
	<link rel="stylesheet" href="<?php p(LBN_CORE_REMOTE); ?>min/js.php?g=css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php p(BE_CSS_PATH); ?>custom/be.custom.css" type="text/css" media="all" />
    <link rel="shortcut icon" type="image/x-icon" href="../_img/icons/favicon.ico">    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="_img/favicon.ico">
    <script>
	   var ABSOLUTE_PATH = '<?php p(LBN_FOLDER.ROOT_ADMIN); ?>';
	   var ABSOLUTE_UPLOAD_PATH = '<?php p(ABSOLUTE_UPLOAD_PATH); ?>';
	   var LAYOUT_TOP = '<?php p($layoutMarginTop); ?>';
	   var STIME = true;
	</script>    
   	<script type="text/javascript" src="<?php p(BE_JS_PATH); ?>yepnope.js"></script> 
	<script type="text/javascript" src="<?php p(BE_JS_PATH); ?>core/be.init.js"></script>
  </head>
<body class="<?php p($layoutBody); ?>" >
<?php include("layout-loader.php"); ?>	
  <div class="<?php p($layoutContainer); ?>">
  		<?php include("layout-sidebar.php"); ?>
  		<div class="content">
			<?php include("layout-breadcrumb.php"); ?>
        	<div class="inner-content">
			<div class="page-header">
                     <h2>
                      <?php if($editTitleHeader){ ?>
                     	<span id="title-header" style="display:inline;" rel="tooltip" title="Click to edit.." ><?php p($pageTitle); ?></span>
                      <?php } else if($editPage){ ?>
                        <span id="title-header" ><?php p($pageTitle); ?></span><small><a class="btn btn-mini" href="javascript:void(0);" onclick="LBN_FORM.openForm(<?php p($pageId); ?>,&#39type=page&ctable=page&#39)"  rel="tooltip"  title="Edit" style="margin-left:15px;margin-top:-5px;" ><i class="icon-pencil"></i></a></small>
                        <?php } else if($editCategory){ ?>
                        <span id="title-header" ><?php p($pageTitle); ?></span><small><a class="btn btn-mini" href="javascript:void(0);" onclick="LBN_FORM.openForm(<?php p($categoryId); ?>,&#39type=category&ctable=category&#39)"  rel="tooltip"  title="Edit" style="margin-left:15px;margin-top:-5px;" ><i class="icon-pencil"></i></a></small>
                        <?php }else{ ?>
	                        <span id="title-header" ><?php p($pageTitle); ?></span>
                        <?php } ?>
                        </h2>                     
                    <div class="count" ></div>
			</div> <!-- Fin PageHeader -->