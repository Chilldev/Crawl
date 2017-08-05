<?php 
require_once 'init.php';

$sites=new supplier(new dbc($config));

if(isset($_GET)){
	extract($_GET);
}
	
if(isset($confirm)){

	$sites->view_confirm_delete($id);

}elseif(isset($single)){

	if(isset($message1)){

		echo $message1;
	}

	$sites->view_single($id,$single);

}elseif(isset($_GET['edit_supp'])){

	$sites->view_edit_supp($_GET['edit_supp']);

}else{

	if(isset($message)){

		echo $message;
	}
	
	$sites->view_suppliers();
}
?>
