<?php
session_start();

if(!isset($_SESSION['user']) && !isset($_COOKIE['user']) ){
	header('location:login.php');
}else{
	include 'views/header.php';
	include 'views/navbar.php';
}
?>
