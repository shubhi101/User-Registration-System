<?php

require_once ('/opt/lampp/htdocs/ooplr/Core/init.php');
/*equire_once (realpath(dirname(__FILE__)).'/Core/init.php');
Database Wrapper : Code reusability :)
PDO : PHP Data Objects
Singeton Pattern, not a constructor-Dont have to connect to DB again and againon each page
Use the DB on-the-fly 
'_' in var name implies private property
*/
class Database{
	private static $_instance=null;
	private $_pdo, //instantiated pdo obj stored here
			$_query, //last query executed
			$_error=false,
			$_results,//result set  
			$_count=0;

	private function __construct(){
		try{
			$this->_pdo=new PDO('mysql:host='. Config::get('mysql/host'). ';dbname=' .Config::get('mysql/db'),
							Config::get('mysql/username'),Config::get('mysql/password')); 
			
		}
		catch(PDOException $e){
			echo "error in construct";
			die($e->getMessage());
		}
	}

	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance=new Database();
		}
			return self::$_instance;
	}

	public function query($sql,$params=array()){
		$this->_error=false;
		
		try{
			if($this->_query=$this->_pdo->prepare($sql)){ //this step defines the type of _query obj
			echo "Prepared Query!";
			}
			$x=1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x,$param);
					$x++;
				}
			}

			if($this->_query->execute()){
				$this->_results=$this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count=$this->_query->rowCount();
				//echo "Successfully executed";
			}
			else{
				$this->_error=true;
				//echo "Error in executing";
			}
		}
		catch(PDOException $e){
			//echo "Error in query method\n";
			echo $e->getMessage();
		}
		
		return $this; //retun the instance of Database class
	}

	public function update($table,$id,$fields){
		$set='';
		$x=1;
		foreach ($fields as $name => $value) {
			$set.="{$name}=?";
			
			if($x<count($fields))
				$set.=",";
			$x++;
		}

		$sql="UPDATE {$table} SET {$set} WHERE id={$id}";
		echo $sql;
		
		if(!$this->query($sql,$fields)->error()){
			echo "success";
			return true;
		}
		return false;

	}

	public function insert ($table, $fields=array()){
		$keys=array_keys($fields);
		$x=1;
		$values='';
		foreach ($fields as $field) {
			$values.='?';
			if($x<count($fields)){
				$values.=',';
			}
			$x++;
		}
		$sql="INSERT INTO {$table} (".implode(", ", $keys).") VALUES ({$values})";
		
		if(!$this->query($sql,$fields)->error()){
			return true;
		}

		else
			return false;
	}

	public function action($action, $table,$where=array()){
		if (count($where)==3){
			$operators=array ('>','<','=','>=','<=');


			$field		=$where[0];
			$operator   =$where[1];
			$value  	=$where[2];

			if(in_array($operator, $operators)){
				$sql= "{$action} FROM {$table} WHERE {$field} {$operator} ?" ;
			

				if(!$this->query($sql,array($value))->error()){
					//echo "Returning class object";
					return $this;
				}

			}
		}
		//echo "returning false";
		return false;
	}

	public function get($table,$where=array()){
		if(count($where)==3){
			return($this->action('SELECT *',$table,$where));
		}
	}

	public function delete( $table,$where=array()){
		if(count($where)==3){
			return($this->action('DELETE',$table,$where));
		}
	}

	public function results (){
		return $this->_results;
	}

	public function first(){
		return $this->results()[0];
	}

	public function error(){
		return $this->_error;
	}
	public function count(){
		return $this->_count;
	}


}