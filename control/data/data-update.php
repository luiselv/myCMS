<?php 
  $pPageIsPublic = false;
  include '_init.php';
  $table = $_REQUEST['table'];
  $id = intval($_REQUEST['id']);
  $json = intval($_REQUEST['json']);
  $field = $_REQUEST['field'];
  //sleep(5);
  if(!$json){
	 if($id){
			$dbupdate = new $table;						
			$dbupdate->setUid($id);
			if($dbupdate->load()){
				$dbupdate->getConnection();
				$dbupdate->$field = !intval($dbupdate->$field);
				$dbupdate->update($field);
				response($field,$dbupdate,$id);
			}
	  }else{
			  $files=$_REQUEST['files'];		  
				foreach($files as $file) {
					$dbupdate = new $table;						
					$dbupdate->setUid($file);
					$dbupdate->getConnection();
					$dbupdate->$field = $_REQUEST[$field];
					$dbupdate->update($field);
				}
				response($field,$dbupdate,0);
	  }
  }else{
	  $dbupdate = new $table; 	
	  $dbupdate->setUid($id);
	  if(!$dbupdate->load()){
		  echo "OBJ : ";
		  return;
	  }
	  switch($field){
		  default:
			$dbupdate->getConnection();
			$dbupdate->$field = $_REQUEST['value'];
			$dbupdate->update($field);			
			echo $dbupdate->$field;
	  	  break;
	  }
  }
  function response($field,$dbupdate,$id){
	  $data = array();
      $data["id"]=$id;
	  $data["event"]=$field;
	  $data["enabled"]=$dbupdate->$field;	  
	  $data["class"]="btn-success";
	  switch($field){
		  case 'enabled':
			$data["class"]="btn-success";
			$data["success"]=gLang("langStatus","active");
			$data["nosuccess"]=gLang("langStatus","inactive");
		  break;
		  case 'featured':
			$data["class"]="btn-warning";
			$data["success"]=gLang("langStatus","featured");
			$data["nosuccess"]=gLang("langStatus","featured");
		  break;	
		  case 'enqueries':
			$data["class"]="btn-success";
			$data["success"]='On';
			$data["nosuccess"]='Off';
		  break;	  
	  }
	  echo json_encode($data);
	  
  }
  
?>