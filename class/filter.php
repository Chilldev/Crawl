<?php
class filter{

	function validate_username($username){
		if(preg_match('/^[a-z\d_]{2,20}$/i', $username)) {
	    	return true;
	   }else{
	   		return false;
	  }
	}

	function validate_email($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		}else{
			return false;
		}
	}

	function validate_password($password){
		if(strlen($password)<=7){
			return false;	
		}else{
			return true;
		}

	}

	function validate_url($url){
		if(filter_var($url,FILTER_VALIDATE_URL)){
			return true;
		}else{
			return false;
		}
	}

	function validate_number($number){
		if(is_numeric($number)){
			return true;
		}else{
			return false;
		}
	}

	function validate_string($string){
		if(is_string($string)){
			return true;
		}else{
			return false;
		}
	}


	function filter_data($data){
			$data = trim($data);
	  		$data = stripslashes($data);
	  		$data = htmlspecialchars($data);
	 		return $data;
	}
}
?>
