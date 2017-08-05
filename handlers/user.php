<?php
require_once'../init.php';
if($_SERVER['REQUEST_METHOD'] != 'POST'){header('location:../404.php');}


$user   = new user(new dbc($config));
$filter = new filter;

extract($_POST);
extract($_GET);

if(isset($delete)){
	header('location:../users.php?tab=tab1&confirm=delete&id='.$id);
}

if(isset($yes)){
if($user->delete_user($id)){
		header('location:../users.php?tab=tab1&message=user has been deleted!');
	}else{
		header('location:../users.php?tab=tab1&message=Failed to delete!');	
	}
}

if(isset($no)){
	header('location:../users.php?tab=tab1&message=deletion has been cancled!');
}
if(isset($adduser)){

	if(empty($username)){
		$err='usernamerr=please enter a user name';
	}

	if(empty($email)){
		$err1 ='emailerr=please enter user email';
	}

	if(empty($password)){
		$err2='passerr=please enter user password';
	}

	if(isset($err) || isset($err1) || isset($err2)){
		header('location:../users.php?tab=tab2&'.$err.'&'.$err1.'&'.$err2);
		die();
	}

	if($filter->validate_username($username)){
		$username = $filter->filter_data($username);
	}else{
		$err = 'usernamerr=please enter a valid username';
	}


	if($filter->validate_email($email)){
		$email = $filter->filter_data($email);
	}else{
		$err1= 'emailerr=please enter a valid email';
	}

	if($filter->validate_password($password)){
		$password = $filter->filter_data($password);
	}else{
		$err2 = 'passerr=password length must be at least 8 chars';
	}

	if(isset($err) || isset($err1) || isset($err2)){
		header('location:../users.php?tab=tab2&'.$err.'&'.$err1.'&'.$err2);
		die();
	}
	if($usertype == 'Admin'){
		$usertype = 1;
	}else{
		$usertype = 2;
	}
	if($result=$user->adduser($username,$email,$password,$usertype) === 1){
		header('location:../users.php?tab=tab2&suc=user has been added');
		die();
	}elseif($result===0){
		header('location:../users.php?tab=tab2&usernamerr=failed to add user');
		die();
	}else{
		header('location:../users.php?tab=tab2&usernamerr=sorry user exist');
		die();
	}

}
if(isset($update)){
	$userdata = $user->selectUser($id);
	if(!isset($_SESSION)){session_start();}
	$_SESSION['edituser'] = $userdata;
	header('location:../users.php?tab=tab2');
}

if(isset($edituser)){
		if(empty($username)){
		$err='usernamerr=please enter a user name';
	}

	if(empty($email)){
		$err1 ='emailerr=please enter user email';
	}

	if(empty($password)){
		$err2='passerr=please enter user password';
	}

	if(isset($err) || isset($err1) || isset($err2)){
		$userdata = $user->selectUser($id);
		if(!isset($_SESSION)){session_start();}
		$_SESSION['edituser'] = $userdata;
	//	header('location:../users.php?tab=tab2');
		header('location:../users.php?tab=tab2&'.$err.'&'.$err1.'&'.$err2);
		die();
	}

	if($filter->validate_username($username)){
		$username = $filter->filter_data($username);
	}else{
		$err = 'usernamerr=please enter a valid username';
	}


	if($filter->validate_email($email)){
		$email = $filter->filter_data($email);
	}else{
		$err1= 'emailerr=please enter a valid email';
	}

	if($filter->validate_password($password)){
		$password = $filter->filter_data($password);
	}else{
		$err2 = 'passerr=password length must be at least 8 chars';
	}

	if(isset($err) || isset($err1) || isset($err2)){
		$userdata = $user->selectUser($id);
		if(!isset($_SESSION)){session_start();}
		$_SESSION['edituser'] = $userdata;
		//header('location:../users.php?tab=tab2');
		header('location:../users.php?tab=tab2&'.$err.'&'.$err1.'&'.$err2);
		die();
	}
	if($usertype == 'Admin'){
		$usertype = 1;
	}else{
		$usertype = 2;
	}

	if($user->editUser($id,$username,$email,$password,$usertype)){
		header('location:../users.php?tab=tab2&suc=user has been updated');
		unset($_SESSION['edituser']);
		die();
	}else{
		header('location:../users.php?tab=tab2&suc=failed to update user');
		die();
	}
}

?>

