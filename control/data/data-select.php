<?php
$pPageIsPublic = false;
include '_init.php';
$table = $_REQUEST['table'];
$type = $_REQUEST['type'];
$oid = intval($_REQUEST['id']);
$objTemp = new $table();
if($oid){
	$objTemp->setUid($oid);
	$objTemp->load();
}else{echo 'OBJ : no identificado';}

switch ($type) {			
		case ($type=='config-video'):
		?><ul id="cuepoints" class="item">
        <?php
		        $oCuePoints = json_decode($objTemp->slides);
		            for ($i=0; $i<count($oCuePoints); $i++){
		    ?>  
            	<li id="item_<?php $i; ?>"  >                		
                            <div class="input" >
                              <div class="input-prepend">
                                <label class="add-on"><input type="radio" name="a" onclick="slideSelect(this)" value="<?php echo $i.'%'.$objTemp->id;?>" /></label>
                                <span id="cue-title<?php echo $i; ?>" ><em><?php echo $oCuePoints[$i]->title;?></em><span class="msg-baloon" id="cue-bubble<?php echo $i; ?>" ><?php echo $oCuePoints[$i]->time;?></span></span>
                              </div>
                            </div>
                            <a class="slidedel btn small-icon " style="float: right;" id="<?php echo $i.'-'.$objTemp->id;?>" title=""><img src="<?php p(BE_ICON_GREY_PATH);?>Trashcan.png"></a>
                            <a class="slidedel btn small-icon " style="float: right;margin-right:5px;" id="" title=""><img src="<?php p(BE_ICON_GREY_PATH);?>Clock.png"></a>
                </li>            		
        <?php } ?>
        	</ul>
        <?php
		break;				
}
?>

