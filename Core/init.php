<?php
//Initialisation. Will be included in all other files

session_start();

$GLOBALS['config']=array(
	'mysql'=>array(              
		'host'=>'127.0.0.1',
		'username'=>'root',
		'password'=>'csab2013',
		'db'=>'UserDB'
		),  //arrays of key-value pairs
	'remember'=>array(
		'cookie_name'=>'hash',
		'cookie_expiry'=>604800

		),
	'session'=>array(
		'session_name'=>'user',
		'token_name'=>'token'
		)

	);

spl_autoload_register(function($class){
	require_once 'Classes/' .$class . '.php';
}); //instead of using require_once for each class, we do this 
	//require classes only when we need them,i.e. an object of the class is created
	//spl : standard php library
require_once 'Functions/sanitize.php';
//cant use spl_autoload bcs these are fns , not classes