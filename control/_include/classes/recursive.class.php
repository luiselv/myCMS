<?php
class Recursive{
	var $_obj;
	public function __construct($obj) {
		$this->_obj = $obj;
    }
	/* Category */
	function qTreeCategory($mode = 'menu'){
		if (! $this->_obj->rMore()){
			return false;
		} else {
			if($mode == 'accordion'){
				$this ->pAccordion($this->ofArray2ArrayTree($this->_obj->RowsArray(MYSQL_ASSOC)));
			}else if($mode == 'menu'){
				 $this ->pMenu($this->ofArray2ArrayTree($this->_obj->RowsArray(MYSQL_ASSOC)));
			}else if($mode == 'dropdown'){
				$this ->pDropdown($this->ofArray2ArrayTree($this->_obj->RowsArray(MYSQL_ASSOC)));
			}
		}
	}
	private function pMenu($items = array()) {
		$table_current =  $this->_obj->_table;
		foreach ($items as $item) {
			$count = count($item['children']);
			echo '<li><a href="#"><i class="icon-th-list"></i><span>'. $item['title'].'</span>';
			if ($count > 0) { echo '<span class="icon">&nbsp;</span>';}
			echo '</a>'; 
			
			if ($count > 0) {
				echo "<ul data-category='c-".$item[$table_current.'Id']."'>";
				$this ->pMenu($item['children']);
				echo "</ul>";
			}
			echo "</li>\n";
		}		
	}
	private function pAccordion($items = array()) {
		$table_current =  $this->_obj->_table;
		foreach ($items as $item) {
			$options = json_decode($item['options']);			
			$PARAMS = ($options->params)?'&'.$options->params:'';
			$count = count($item['children']);
			echo '<li class="'.(($_SESSION['m1']=='cat'.$item[$table_current.'Id'])?'active':'').'" >';
			echo '<a href="'.(($count > 0)?'#':$options->page.'.php?cid='.$item[$table_current.'Id']).$PARAMS.'">';
			echo Lbn::qIcon($item['icon']).'&nbsp;<span>'. $item['title'].'</span>';
			if ($count > 0) { echo '<span class="icon">&nbsp;</span>';}
			echo '</a>';
			if ($count > 0) {
				echo '<div class="accordion">';
				foreach ($item['children'] as $sitem) {
					$option = json_decode($sitem['options']);
					$PARAMS = ($option->params)?'&'.$option->params:'';
					echo '<a class="'.(($_SESSION['m2']=='cat'.$sitem[$table_current.'Id'])?'accordion-selected':'').'" href="'.$option->page.'.php?cid='.$sitem[$table_current.'Id'].$PARAMS.'">'.Lbn::qIcon($sitem['icon']).'&nbsp;&nbsp;'.$sitem['title'].'</span></a>';			
				}
				echo "</div>\n";
			}
			echo "</li>\n";
		}		
	}
	private function pDropdown($items = array()) {
		$table_current =  $this->_obj->_table;
		$ID = 0;
		foreach ($items as $item) {
			$options = json_decode($item['options']);
			$ID = $item[$table_current.'Id'];
			$PARAMS = ($options->params)?'&'.$options->params:'';
			$count = count($item['children']);
			if ($count > 0) {
				echo ' <li class="dropdown '.(($_SESSION['m1']=='cat'.$ID)?'active':'').'">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-'.$item['icon'].' icon-white" style="margin-right:5px" ></i> '.$item['title'].' <b class="caret"></b></a>
	<ul class="dropdown-menu">';				
				foreach ($item['children'] as $sitem) {
					$option = json_decode($sitem['options']);
					$PARAMS = ($option->params)?'&'.$option->params:'';
					$ID = $sitem[$table_current.'Id'];
					echo '<li class="'.(($_SESSION['m2']=='cat'.$ID)?'active':'').'" ><a href="'.$option->page.'.php?cid='.$ID.$PARAMS.'" >'.Lbn::qIcon($sitem['icon']).'&nbsp;&nbsp;<span>'.$sitem['title'].'</span></a></li>';
					
				}
				echo "</ul>\n";
			}else{
				//echo print_r($item);
				echo '<li  ><a href="'.$options->page.'.php?cid='.$ID.$PARAMS.'" ><i class="icon-'.$item['icon'].' icon-white" style="margin-right:5px" ></i> '.$item['title'].'</a></li>';			
			}
			
		}
	}	
	
	/* Tree */
	function qTreeWithRankList(){
		if (! $this->_obj->rMore()){
			return false;
		} else {
			echo "<ul class='tree-list' >\n";
			//echo "<li><label class='header' ><h4>Course</h4> <div class='options' style='text-align:center;' ><h4>Actions</h4></div><div class='states'><h4>Status</h4></div></label></li>";
			$this ->pRankList($this->ofArray2ArrayTree($this->_obj->RowsArray(MYSQL_ASSOC)));
			echo "</ul>";
		}
	}
	private function pRankList($items = array()) {
		$table_current =  $this->_obj->_table;
		//list ($href) = explode("-", $_SESSION['m2']);
		$href = 'course';
		foreach ($items as $item) {
			echo "<li id='item_". $item[$table_current.'Id'] ."' class='item' ><label for='". $item[$table_current.'Id'] ."' class='".$item['type']."' >";
				 // <span class='chk-holder' ><input class='treechecks ". (count($item['children'])>0 || $item['parentId'] == 0 ? "parent" : "")  ."' id='file-". $item[$table_current.'Id'] ."' type='checkbox' name='files[]' value='". $item[$table_current.'Id'] ."'/> </span>";
			echo "<span class='label ".$item['type']."' style='font-size:8px;margin-right:8px;' >".$item['type']."</span>";
		    echo "<span class='tree-title' >".$item['title']."</span>";
			echo "<div class='options' >";
			echo "<a class='btn small-icon primary' title='' href='$href-add.php?id=".$item[$table_current.'Id']."' ><img src='". LBN_ADMIN_IMAGES_ICONS_EDIT ."'/></a>&nbsp;&nbsp;";
			echo "<a title='' class='btn small-icon ' href='$href-add.php?id=".$item[$table_current.'Id']."&tab=items' ><img src='". LBN_ADMIN_IMAGES_ICONS_ITEMS ."'/></a>&nbsp;&nbsp;";
			echo "<a title='' class='btn small-icon'  href='javascript:void(0);' chkid='".$item[$table_current.'Id']."' onclick='LBN_NAV.actionSelected(this,&#34delete&#34)' ><img src='". LBN_ADMIN_IMAGES_ICONS_DELETE ."'/> </a>";
			echo "</div>";
			if($item['type']!='course'){			
			echo '<div class="states" >';
			$item['id'] = $item[$table_current.'Id'];
			Lbn::pDUStatus($item,'enabled','success',($item['enabled'] ? $GLOBALS['langForm']['stActive'] : $GLOBALS['langForm']['stInactive']));
			Lbn::pDUStatus($item,'isfree','success','Free');
			echo '</div>';
			}
			echo "</label>";
			if (count($item['children']) > 0) {
				echo "<ul class='tree-list' id='p".$item[$table_current.'Id']."'>";
				$this ->pRankList($item['children']);
				echo "</ul>";
			}
			echo "</li>\n";
		}		
	}
	private function pRankListx($items = array()) {
		$table_current =  $this->_obj->_table;
		list ($href) = explode("-", $_SESSION['m2']);
		
		foreach ($items as $item) {
			echo "<li id='item_". $item[$table_current.'Id'] ."' ><label for='". $item[$table_current.'Id'] ."' class='".(($item['parentId'] == 0 )? 'form' : '')."' >
				  <span class='chk-holder' ><input class='treechecks ". (count($item['children'])>0 || $item['parentId'] == 0 ? "parent" : "")  ."' id='file-". $item[$table_current.'Id'] ."' type='checkbox' name='files[]' value='". $item[$table_current.'Id'] ."'/> </span>";
		    echo "<span class='tree-title' >".$item['title']."</span>";			
			if($item['parentId'] != 0){
			//if($item['parentId'] == 0)
			//echo "<a title='' class='btn small-icon ' href='$href-messages.php?id=".$item[$table_current.'Id']."' ><img src='". LBN_ADMIN_IMAGES_ICONS_MESSAGE ."'/></a>&nbsp;&nbsp;";
			//if($item['ismessage'])
			//echo "<a title='' class='btn small-icon ' href='$href-messages.php?id=".$item[$table_current.'Id']."' ><img src='". LBN_ADMIN_IMAGES_ICONS_MESSAGE ."'/></a>&nbsp;&nbsp;";
			echo "<div class='options' >";									
			echo "<a class='btn small-icon primary' title='$href' href='$href-add.php?id=".$item[$table_current.'Id']."' ><img src='". LBN_ADMIN_IMAGES_ICONS_EDIT ."'/></a>&nbsp;&nbsp;";							
			echo "<a title='' class='btn small-icon ' href='$href-add.php?id=".$item[$table_current.'Id']."&tab=items' ><img src='". LBN_ADMIN_IMAGES_ICONS_ITEMS ."'/></a>&nbsp;&nbsp;";					
			echo "<a title='' class='btn small-icon'  href='javascript:void(0);' chkid='".$item[$table_current.'Id']."' onclick='LBN_NAV.actionSelected(this,&#34delete&#34)' ><img src='". LBN_ADMIN_IMAGES_ICONS_DELETE ."'/> </a>";
			echo "</div>";			
			echo '<div class="states" >';
			$item['id'] = $item[$table_current.'Id'];
			Lbn::pDUStatus($item,'enabled','success',($item['enabled'] ? $GLOBALS['langForm']['stActive'] : $GLOBALS['langForm']['stInactive']));
			Lbn::pDUStatus($item,'isfree','success','isFree');
			echo '</div>';
			}
			echo "</label>";
			if (count($item['children']) > 0) {
				echo "<ul class='tree-list' id='p".$item[$table_current.'Id']."'>";
				$this ->pRankList($item['children']);
				echo "</ul>";
			}
			echo "</li>\n";
		}		
	}
	function qSelectWithRankOptions($selected,$field='parentId',$text='no parent', $optional = true) {
		echo "<select name='".$field."' >\n";
		if ($optional) echo "<option value=''>(".$text.")</option>\n";
		if (!$this->_obj->rMore()) {
			//return false;
		} else {			
			$this ->pRankOptions($this ->ofArray2ArrayTree($this->_obj->RowsArray(MYSQL_ASSOC)), $selected, 0);
		}
		echo "</select>";	
	}
	private function pRankOptions($items = array(),$selected = '',$step) {
		$table_current =  $this->_obj->_table;
		foreach ($items as $item) {
			echo "<option value=\"". $item[$table_current.'Id']."\" ";
			echo (($selected == $item[$table_current.'Id']) ? "selected=true " : "").">";
			echo str_repeat('&nbsp;', $step * 3).$item['title'];
			if (count($item['children']) > 0)$this->pRankOptions($item['children'], $selected,  $step+1);
			echo "</option>";
		}		
	}

	function getUlBreakDownList($items = array(), $breakId = '') {
		foreach ($items as $item) {
			if ($item['parentId'] == 0 && count($item['children']) == 0) {
				continue;
			} else {
				echo " &rsaquo; ".$item['title'];
				if ($item['courseId'] == $breakId) break;  
				if (count($item['children']) > 0) {
					$this ->getUlBreakDownList($item['children'], $breakId);
				}
			}			
		}
	}
	
	function getUlBreakDown() {
		if (! $this->_obj->rMore()) {
			return false;
		} else {			
			$this ->getUlBreakDownList($this ->ofArray2ArrayTree($this->_obj ->RowsArray(MYSQL_ASSOC)), $this->_obj->id);
		}
	}	
			
	function ofArray2ArrayTree($items = array(), $parent_id = 0) {
		$table_current =  $this->_obj->_table;
		//echo $table_current.'Id';
		$children = array();		
		foreach($items as $item) {
			if ($item['parentId'] == $parent_id) {
				$children[$item[$table_current.'Id']] = $item;
				$children[$item[$table_current.'Id']]['children'] = $this->ofArray2ArrayTree($items, $item[$table_current.'Id']);
			}			 
		}		
		return($children); 
	}		
}
?>