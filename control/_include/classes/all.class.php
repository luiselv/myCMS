<?php
class Seo extends Page{
	function Seo(){
		parent::Page();
	}
}

class Project extends Page{
	function Project(){
		parent::Page();
	}
}	
class Client extends Page{
	function Client(){
		parent::Page();
	}
}	
class Education extends Page{
	function Education(){
		parent::Page();
	}
}	
class License extends Page{
	function License(){
		parent::Page();
	}
}	
class ProjectPerson extends TznDb{
	function ProjectPerson(){
		$this->addProperties(array(
				'id'			  => 'UID',
				'page'	      => 'OBJ',
				'projectId'		  => 'NUM'
		));
		$this->_table='projectperson';
	}
	function delete1($id) {
		$this->getConnection();
	    $this->query('DELETE FROM '.$this->gPrefix().'projectperson WHERE projectId ='.intval($id));
    }	
}
class ProjectExpertise extends TznDb{
	function ProjectExpertise(){
		$this->addProperties(array(
				'id'		  => 'UID',
				'page'	      => 'OBJ',
				'projectId'	  => 'NUM'
		));
		$this->_table='projectexpertise';
	}
	function delete1($id) {
		$this->getConnection();
	    $this->query('DELETE FROM '.$this->gPrefix().'projectexpertise WHERE projectId ='.intval($id));
    }	
}
class ProjectServiceType extends TznDb{
	function ProjectServiceType(){
		$this->addProperties(array(
				'id'		  => 'UID',
				'page'	      => 'OBJ',
				'projectId'	  => 'NUM'
		));
		$this->_table='projectservicetype';
	}
	function delete1($id) {
		$this->getConnection();
	    $this->query('DELETE FROM '.$this->gPrefix().'projectservicetype WHERE projectId ='.intval($id));
    }	
}

class ProjectMarket extends TznDb{
	function ProjectMarket(){
		$this->addProperties(array(
				'id'		  => 'UID',
				'page'	      => 'OBJ',
				'projectId'	  => 'NUM'
		));
		$this->_table='projectmarket';
	}
	function delete1($id) {
		$this->getConnection();
	    $this->query('DELETE FROM '.$this->gPrefix().'projectmarket WHERE projectId ='.intval($id));
    }	
}

class ProjectDeliveryMethod extends TznDb{
	function ProjectDeliveryMethod(){
		$this->addProperties(array(
				'id'		  => 'UID',
				'page'	      => 'OBJ',
				'projectId'	  => 'NUM'
		));
		$this->_table='projectdeliverymethod';
	}
	function delete1($id) {
		$this->getConnection();
	    $this->query('DELETE FROM '.$this->gPrefix().'projectdeliverymethod WHERE projectId ='.intval($id));
    }	
}

class Workorders extends TznDb{
	function Workorders(){
		$this->addProperties(array(
				'id'		  => 'UID',
				'workorderID' => 'STR',
				'workorderTitle' => 'STR',
				'workorderLocation' => 'STR',
				'workorderManager' => 'STR',
				'workorderManagerEmail' => 'STR',
				'workorderStatus' => 'STR',
				'workorderUpdatedOn' => 'DTM',
				'workorderBidDate' => 'DTM',
				'workorderBidTime' => 'STR'				
		));
		$this->_table='workorders';
	}
}
?>