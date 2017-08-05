<?php
class user{
	
protected $password;
protected $email;
public    $username;
protected $usertype;
private   $hashed_pass;
protected $db;
	    
	function __construct($db){

		$this->db = $db;
	}

public function login($email,$password){

	$this->email=$email;
	$this->hashed_pass=user::passhash($password);

	if($results=$this->db->select('*','user',"username = '".$email."' or email ='".$email."'")){

		if($result=mysqli_fetch_array($results)){

			extract($result);
			if($this->hashed_pass === $pass){

				if( $this->email == $email || $this->email == $username){
					if($user_type == 1){
						$user_type = 'admin';
					}else{
						$user_type ='editor';
					}
				setcookie('user',$user_type, time() + (60 * 60));
				session_start();
				$_SESSION["user"]=$username;
				$_SESSION["user_type"]=$user_type;
				return 1;
				}
			}
		}
	}else{
		return 0;
	}
}
	


 function addUser($username,$email,$password,$usertype){
	$result=$this->db->select('*','user',"username ='$username' or email = '$email'");
	if($result->num_rows == 0){
		$password=user::passhash($password);
		$this->db->insert('user',"'','$username','$email','$password','$usertype'");
		return 1;
	}elseif($result->num_rows > 0){
		return 'this user exists';
	}else{
		return 0;
	}

}

function selectUser($id){
	 $user = $this->db->select('*','user','id='.$id);
	 return $user=mysqli_fetch_assoc($user);
}

function editUser($id,$username,$email,$password,$usertype){

	$password=user::passhash($password);
	if($this->db->update('user',"username='$username',email='$email',user_type='$usertype',pass='$password'",'id='.$id)){
		return 1;
	}else{
		return 0;
	}

}

protected function passHash($password){

	return $this->hashed_pass= md5($password);

}

function delete_user($id){
	if($this->db->delete('user','id',$id)){
		return 1;
	}else{
		return 0;
	}

}

public function logout(){

	if(isset($_COOKIE['user'])){
		unset($_COOKIE["user"]);
		setcookie("user","null",time()-20000);
		session_start();
		session_destroy();
	}

	header("location:../login.php");
}

function view_users(){

	echo'<div class="container"><table class="tablestyle" width="700px"><tr><th>UserID</th><th>Username</th><th>Email</th><th>UserType</th><th colspan="2">Action</th></tr>';

	$users  = $this->db->select_all('user','order by id');
	if($users){
		while ($user=mysqli_fetch_assoc($users)){
			extract($user);
			if($user_type ==2){
				$user_type = 'Editor';
			}else{
				$user_type = 'Admin';
			}

			$form="<form action=\"handlers/user.php?id=$id\" method=\"post\"><tr><input type=\"hidden\"name=\"id\" value=\"$id\"/><td>$id</td><td>$username</td><td>$email</td><td>$user_type</td>";

			$form1="<td><input type=\"submit\" value=\"Update\" name=\"update\" class=\"button\"></td><td><input type=\"submit\" value=\"Delete\" name=\"delete\" class=\"button\"></td></tr></form>";
			echo $form.$form1;
		}
		echo'</table></div>';		
	}
}


function view_confirm_delete($id){
	echo"
	<form method=\"post\" action=\"handlers/user.php?id=$id\">
		<input type=\"hidden\" value=\"$id\" name=\"ID\">
		<table class=\"tablestyle\" width=\"300px\">
		<tr><th colspan=\"3\"><h1>Are You Sure? </h1></th></tr>
		<tr>
			<td></td>
			<td><input type=\"submit\" value =\"Yes!\" name=\"yes\"class=\"button\"></td>
			<td><input type=\"submit\" value =\"No!\" name=\"no\" class=\"button\"></td>
		</tr>
		</table>
	</form>";
}

}
?>
