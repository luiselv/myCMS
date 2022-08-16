<?php if($navActive){ ?>
<div class="page-header-sub clearfix masked-relative masked" >
	<div class="btn-toolbar">
     <?php if($navSelect){ ?>
		<div class="btn-group nav-mask">
          <a class="btn" rel="tooltip" title="Select All" ><input id="select-all" data-pager="1" onclick="LBN_NAV.selectAll(this)" style="margin:1px 0 0 0;" type="checkbox" /></a>
          <span style="display: none;" id="nav-bubble" class="msg-baloon"></span>
          <a href="#" data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="javascript:void(0)" style="font-weight:normal" data-type="select" data-msg="Active" data-field="enabled" data-value="1"  onclick="LBN_NAV.actionSelected(this);" ><i class="icon-ok-circle"></i>&nbsp;&nbsp;<?php pLang('langNav','activate'); ?></a></li>
            <li><a href="javascript:void(0)" style="font-weight:normal" data-type="select" data-msg="Deactive" data-field="enabled" data-value="0" onclick="LBN_NAV.actionSelected(this);" ><i class="icon-ban-circle"></i>&nbsp;&nbsp;<?php pLang('langNav','deactivate'); ?></a></li>
            <li class="divider"></li>
            <li><a href="javascript:void(0)" style="font-weight:normal" data-type="select" data-msg="Delete" data-field="delete" onclick="LBN_NAV.actionSelected(this);" ><i class="icon-trash"></i>&nbsp;&nbsp;<?php pLang('langNav','delete'); ?></a></li>
          </ul>
        </div>
       <?php } 
	       if($navFilterStatus){ ?>
        <div class="btn-group filter nav-mask"  data-toggle="buttons-radio">
	        <button type="button" data-field="enabled" data-value="2"  class="btn btn-success active"><?php pLang('langNav','all'); ?></button>
    	    <button type="button" data-field="enabled" data-value="1" class="btn"><?php pLang('langNav','active'); ?></button>
        	<button type="button" data-field="enabled" data-value="0" class="btn"><?php pLang('langNav','inactive'); ?></button>
        </div>
        <?php }
		 if($navFilterMedia){ ?>
         <div class="btn-group filter nav-mask"  data-toggle="buttons-radio">
	        <button type="button" data-field="type" data-value="none"  class="btn btn-success active"><?php pLang('langNav','all'); ?></button>
    	   <?php p($navFilterOptions); ?>
        </div>
       <?php } 
   		if($navSort){
	   ?>       
        <div class="btn-group">
          <a href="javascript:void(0)" id="box-sortable" class="btn" onclick="LBN_NAV.sortToggle(this)" rel="tooltip" title="Active Sort" ><i class="icon-th"></i></a>
        </div>
        <?php } 
   		if($navSort1){
	   ?>       
        <div class="btn-group">
          <a href="javascript:void(0)" id="box-sortable" class="btn" onclick="LBN_NAV1.sortToggle(this)" rel="tooltip" title="Active Sort" ><i class="icon-th"></i></a>
        </div>
        <?php } ?>
		<div class="btn-group nav-mask">
        <?php if($navPreview){ ?>	
          <a href="#" class="btn " rel="tooltip" title="Preview" ><i class="icon-eye-open"></i></a>
         <?php } 
		 	if($navHelp){
		 ?>
          <a href="#" class="btn " rel="tooltip" title="Help" ><i class="icon-question-sign"></i></a>
         <?php } ?>
        </div>
        <div class="btn-group nav-mask" style="float:right;" id="guide_3" >
		<?php
			switch ($navRightButtonMode){
				case 'only-photo' :
					p('<a id="btn-default" href="javascript:LBN_FORM.openHolder(&#39#holder-queue&#39,0,&#39LBN_FILE.multiFile1(&#34#btn-default&#34)&#39);" data-params="'.$navRightButtonParams.'" data-filters="jpg,gif,png" class="btn btn-primary"><i class="icon-upload icon-white"></i>  '.$navRightButtonName.'</a>');
				break;
				case 'link' :
					p('<a href="'.$navRightButtonLink.'" class="btn btn-primary"><i class="icon-edit icon-white"></i>  '.$navRightButtonName.'</a>');
				break;
				case 'ajax' :
					p('<a href="javascript:void(0);" data-params="'.$navRightButtonParams.'" onclick="LBN_FORM.makeBox(this)" class="btn btn-primary"><i class="icon-edit icon-white"></i>  '.$navRightButtonName.'</a>');
				break;	
				case 'ajax1' :
					p('<a href="javascript:void(0);" data-params="'.$navRightButtonParams.'" onclick="LBN_FORM.makeBox1(this)" class="btn btn-primary"><i class="icon-edit icon-white"></i>  '.$navRightButtonName.'</a>');
				break;							
				case 'dropdown':
?>
             <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="icon-edit icon-white"></i>&nbsp;<?php p($navRightButtonName); ?>&nbsp;&nbsp;
                <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" style="left:0px;min-width:122px;" >
                    <?php p($navRightOptions); ?>
              </ul>
<?php
				break;
				default :
					p('<a id="guide_3" ></a>');
				break;
			}
		 ?>
        </div>
</div>
 <div class="loadmask"></div>
</div>   
<?php
	switch ($navRightButtonMode){
		case 'only-photo' :
?>
<div id="holder-queue" >
    <div style="position:relative;height:auto" >
          <div id="holder-queue-close" onclick="LBN_FORM.closeHolder(&#39#holder-queue&#39,0)" ><i class="icon-remove" ></i></div>
          <div id="holder-queue-content" ></div>
    </div>
</div>
<?php 
		break;
	}

}
 ?>  
 
