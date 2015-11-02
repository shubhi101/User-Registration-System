<?php
require_once (realpath(dirname(__FILE__)).'/Core/init.php');
if(Session::exists('home')){
	echo '<p>'.Session::flash('home').'</p>';
}