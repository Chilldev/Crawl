<?php
if($_SESSION["user_type"] != 'admin'){header('location:404.php');}
require_once'init.php';
$users = new user(new dbc($config));

if(isset($_GET)){
	extract($_GET);
}
	
if(isset($confirm)){
	$users->view_confirm_delete($id);
}else{

	if(isset($message)){

		echo $message;
	}
	
	$users->view_users();
}


?>
