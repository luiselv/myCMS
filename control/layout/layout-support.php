<?php if(LBN_CONFIG_SUPPORT){ ?>
 <ul class="unstyled" style="width:100px;float:right;margin-bottom:0px;margin-right:3px;" >
					<?php if($_SESSION['chatMODE']=='local'){ ?>
                    <li style="float:right;width:10px;margin-right:5px;margin-top:0px;" >
                    <a style="float:left;" href="?s-action=support" data-placement="right" rel='twipsy' title='<?php pLang('langSupport','active') ?>' ><img height="20" width="20" src="<?php p(BE_IMG_PATH);?>activar.png" /></a>
                    </li>
                    <?php } ?>
                    <?php if($_SESSION['chatMODE']=='support'){ ?>
                    <li style="float:right;width:50px;margin-right:-5px;margin-top:-3px;" >
                        <div style="float:left;position:relative;" >
                            <a id="support-state" data-placement="below" rel='twipsy' title='offline' >
                                <img style="margin-top:1px;" width="22" height="22" src="<?php p(BE_IMG_PATH);?>webmasters.png" />
                                <img width="20" height="20" id="support-icon" style="position:absolute;top:-10px;left:11px;" src="<?php p(BE_IMG_PATH);?>offline.png" />
                            </a>
                        </div>
                        <a href="?s-action=unsupport" data-placement="right" rel='twipsy' title='<?php pLang('langSupport','close') ?>' style="float:right;margin-top:4px;" ><span style="font-size:24px;font-weight:bold;color:#ccc;" >&times;</span></a>       
                    </li>
                    <?php } ?>
                </ul>
   <?php } ?>