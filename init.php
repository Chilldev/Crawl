<?php
require_once 'class/config.php';

spl_autoload_register(
	function($class){
		require_once'class/'.$class.'.php';
	}
);
?>
