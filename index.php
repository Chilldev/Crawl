<?php
session_start();
if(!isset($_SESSION['user']) && !isset($_COOKIE['user']) ){
	header('location:login.php');
}else{
	header('location:supplier.php?tab=tab1');
}
?>
