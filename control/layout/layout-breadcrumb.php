<ul class="breadcrumb">
	<?php if($dashboard){ ?>
    <li><i class="icon-home" ></i></li>
    <?php }else{ ?>
    <li ><a href="index.php" data-placement="left" rel='tooltip' title='Dashboard' ><i class="icon-home" style="margin-right:5px;margin-left:5px" ></i> Dashboard</a> <span class="divider">/</span></li>
    <?php 
		}
		for ($i = 0; $i < count($pageBreadcrumb); $i++) {
			echo '<li><a href="'.$pageBreadcrumb[$i]['url'].'">'.$pageBreadcrumb[$i]['name'].'</a> <span class="divider">/</span></li>';
		}
	?>    
    <li class="active"><?php echo $pageBreadcrumbTitle; ?></li>
    <li style="float:right;width:auto;"><a class="brand" href="index.php" style="color:#CCC;text-shadow:0 -1px 0 #fff;font-size:19px;font-weight:700;" ><?php if($layoutMode=='sidebar'){ p($CONFIG['LBN_CONFIG_PANEL_NAME']);} ?>&nbsp;</a><a style="float:right;width:auto;" href="<?php echo(LBN_FOLDER);?>" target="_blank" class="btn btn-mini"><strong>PREVIEW SITE</strong></a></li>  
</ul>