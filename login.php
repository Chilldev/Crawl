<?php
if(!isset($_SESSION)){session_start();}

if(!isset($_SESSION['user']) && !isset($_COOKIE['user'])) {

	require_once 'views/header.php';
	require_once 'views/login.php';

}else{
		header('location:supplier.php');

}
?>
