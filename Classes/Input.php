<?php
class Input{
	public static function exists($type='post'){
		switch($type){
			case 'post':
				return (!empty($_POST))? true:false;
			break;
			case 'get':
				return (!empty($_GET))? true:false;
			break;

			default :
				echo "Default";
				return false;
			break;
		}
	}

	public static function get ($item){
		if(isset($_POST[$item]))
			return $_POST[$item];

		if(isset($GET[$item]))
			return $GET[$item];

		return "";
	}
}