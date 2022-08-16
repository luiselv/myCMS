<?php if($layoutTop){ ?>
<div class="navbar navbar-fixed-top " style="z-index:1039;" >
<div class="navbar-inner">
  <div class="container" id="navbar-container" >
    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>     
    <a class="brand" href="index.php" style="color:#555;text-shadow:0 -1px 0 #222;padding:10px 10px 9px 0px;" ><?php p($CONFIG['LBN_CONFIG_PANEL_NAME']); ?></a>      
    <div class="nav-collapse">
    <ul class="nav">        
        <li class="divider-vertical"></li>
         <?php
                $listaI = new Category();		
				$listaI->addWhere('enabled=1');		
                $listaI->addOrder('OrderId Asc');
                $listaI->loadList();
                $listaI->pTreeCategory('dropdown');
            ?>   
        <li class="divider-vertical"></li>
     </ul>
     <!---<form class="navbar-search pull-left" action="">
        <input type="text" class="search-query span2" placeholder="Search">
      </form>--->
      <ul class="nav pull-right " style="margin-right:0px;" >
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome  <i class="icon-user icon-white" style="margin-left:5px;" ></i> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li class="current-user" >
                <a class="account-summary" href="user-add.php?id=<?php p($objUser->id); ?>" >
                    <div class="content-account">
                      <div data-user-id="" class="account-group">
                       <?php p($objUser->getAvatar()); ?>
                        <b class="fullname"><?php p(truncate_string($objUser->getFullName(),12)); ?></b>
                        <small class="metadata"><?php p($objUser->getLevelName()); ?></small>
                      </div>
                    </div>
                </a>
            </li>
            <!-- <li class="divider"></li>
            <li><a href="#"><i class="icon-envelope" style="margin-right:10px;" ></i>0 Messages</a></li> -->
            <li class="divider"></li>                        
            <li><a data-toggle="modal" href="#modal-layout" data-backdrop="static" data-keyboard="true" >
                <i class="icon-home" style="margin-right:10px;" ></i>Change layout</a></li>
            <li><a href="configuration.php"><i class="icon-cog" style="margin-right:10px;" ></i>Configuration</a></li>
             <?php if(LBN_CONFIG_HELP){ ?>                   
            <li><a data-toggle="modal" href="#modal-help" data-backdrop="static" data-keyboard="true" >
                <i class="icon-question-sign" style="margin-right:10px;" ></i><?php pLang('langMenu','help'); ?></a>                    
            </li>					
            <?php } ?>	
            <li class="divider"></li>          
            <li><a href="logout.php"><i class="icon-share-alt" style="margin-right:10px;" ></i><?php pLang('langUser','logout'); ?></a></li>
          </ul>
        </li>           
      </ul>          
    </div><!-- /.nav-collapse -->
  </div>
</div><!-- /navbar-inner -->
</div><!-- /navbar -->
<?php }else{ ?>
<div class="sidebar" >
    <div class="holder" >
        <div id="logo" >
            <a href="index.php" title="" >
                <h1 style="font-family:'PT Sans',sans-serif;letter-spacing:-1px;color:#555;" ><?php p($CONFIG['LBN_CONFIG_WEBSITE_NAME']); ?></h1>                    
             </a>
        </div>
        <div id="credentials-header">
            <i class="icon-user"></i><b style="color:#777;font-weight:700;font-size:14px;margin-left:5px;" >Welcome</b>
            <?php include("layout-support.php"); ?>
        </div>
      <div id="credentials">
            <div class="avatar" ><?php echo $objUser->getAvatar(50); ?></div>
            <div class="float_left">
                <div class="btn-group name-user">
               		<a class="btn btn-mini" href="user-add.php?id=<?php p($objUser->id); ?>" ><b><?php p(truncate_string($objUser->getFullName(),12)); ?></b></a>
                    <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                    <ul class="dropdown-menu">            
			            <!-- <li><a href="#"><i class="icon-envelope" style="margin-right:10px;" ></i>0 Messages</a></li> 
				        <li class="divider"></li> -->
                        <li><a data-toggle="modal" href="#modal-layout" data-backdrop="static" data-keyboard="true" >
                            <i class="icon-home" style="margin-right:10px;" ></i>Change layout</a></li>
                        <li><a href="configuration.php"><i class="icon-cog" style="margin-right:10px;" ></i>Configuration</a></li>
                         <?php if(LBN_CONFIG_HELP){ ?>                   
                        <li><a data-toggle="modal" href="#modal-help" data-backdrop="static" data-keyboard="true" >
                            <i class="icon-question-sign" style="margin-right:10px;" ></i><?php pLang('langMenu','help'); ?></a>                    
                        </li>					
                        <?php } ?>	
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="icon-share-alt" style="margin-right:10px;" ></i><?php pLang('langUser','logout'); ?></a></li>
                    </ul>
                </div>
                <div class="name-level" ><i class="icon-bookmark"></i>  <?php p($objUser->getLevelName()); ?></div>
            </div>
        </div>
    </div> 
    <div id="side_nav" class="side_nav" >
        <?php include("layout-menu.php"); ?>
    </div>
</div>
<?php } ?>