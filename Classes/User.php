<?php
class User{
	private $_db;

	public function __construct($user=null){
		$this->_db=Database::getInstance();
	}

	public function create($fields){
		if(!$this->_db->insert('Users',$fields))
			throw new Exception('Problem in creating account');
	}
}