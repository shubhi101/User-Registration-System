<?php
class Config{
	public static function get($path=null){
		if($path){
			$config=$GLOBALS['config'];
			$path=explode('/', $path);

			foreach($path as $bit){
				if(isset($config[$bit])){
					$config=$config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
}

/*Check for corner cases . What isf the path isnt correct?
like "mysql/hello" or "hello/localhost" etc.
*/