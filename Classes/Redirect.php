<?php
class Redirect{
	public static function to($location=null){
		if($location){
			if(is_numeric($location)){
				switch($location){
					case 404:
						header('HTTP/1.0 Not Found');
						include 'Includes/Errors/404.php';
					break;
				}
			}
		else{
			header('Location:'. $location);
		}
		exit();
		}
		
	}
}