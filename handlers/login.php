<?php
require_once'../init.php';

$user = new user(new dbc($config));

if(isset($_GET['logout'])){
	$user->logout();
	die();
}

if($_SERVER['REQUEST_METHOD'] != 'POST'){header('location:../404.php'); die();}

extract($_POST);
$filter = new filter;
if(empty($username)){
	header('location:../login.php?logerr=Empty Username/Password');
	die();
}

if(empty($password)){
	header('location:../login.php?logerr=Empty Username/Password');
	die();
}

if($filter->validate_username($username) || $filter->validate_email($username)){
	$username = $filter->filter_data($username);
}else{
	header('location:../login.php?logerr=Please Enter a Valid Username');
	die();
}

if($filter->validate_password($password)){
	$password = $filter->filter_data($password);
}else{
	header('location:../login.php?logerr=Please Enter a Valid Password');
	die();
}

if($user->login($username,$password)){
	header('location:../supplier.php');
}else{
	header('location:../login.php?logerr=Wrong Username/Password');
	die();
}
?>
