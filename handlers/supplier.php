<?php
require_once'../init.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){header('location:../404.php');}

$supplier = new supplier(new dbc($config));
$filter   = new filter;

extract($_POST);
extract($_GET);

if(isset($uploadlogo)){
	$message= $supplier->upload_sup_logo($_FILES['logofile']['tmp_name'],$filename);
	header("location:../supplier.php?tab=tab2&message=$message");die;	
}

if(isset($cancel_supp)){
header('location:../supplier.php?tab=tab2&message=Editing has been cancelled.'); die;
}

if(isset($updatepathes) || isset($addpathes)){

	$state;
	$state1;

	if (isset($addpathes)){$state='add'; $state1='added';}else{$state='update';$state1='updated';}

	if(empty($links)){
		$err='links Xpath is required all fields are rquired';
	}
	if(empty($list)){
		$err1='Category XPath is required';
	}
	if(empty($urls)){
		$urls='0';
	}
	if(empty($pname)){
		$err3='product name XPath is required';
	}
	if(empty($img)){
		$err4='image XPath is required';
	}
	if(empty($price)){
		$err5='price XPath is required';
	}

	if(isset($err)||isset($err1)||isset($err2)||isset($err3)||isset($err4) || isset($err5)){
		if(!isset($_SESSION)){session_start;}
		$_SESSION['sitename']=$siten;
		header('location:../subdata.php?id='.$id.'&err='.$err.'&err1='.$err1.'&err2='.$err2.'&err3='.$err3.'&err4='.$err4.'&err5='.$err5);
		die;
	}

	if($xpath_id=$supplier->xpath_exists($links,$urls,$list,$pname,$img,$price)!=0){
		$supplier->updatepathes($id,$xpath_id);
		header('location:../supplier.php?tab=tab2&message1=supplier xpath has been '.$state1."&single=$sup_name&id=$id");
		die;
	}else{
		$supplier->addpathes($id,$links,$urls,$list,$pname,$img,$price);
		header('location:../supplier.php?tab=tab2&message1=supplier xpath has been '.$state1."&single=$sup_name&id=$id");
		die;
	}
		header('location:../supplier.php?tab=tab2&message1=failed to '.$state.' supplier xpath please try again'."&single=$sup_name&id=$id");
		die;
		
}

if(isset($deletexpath)){
	if($supplier->remove_xpath($xpath_id,$sup_id)){

		header("location:../supplier.php?tab=tab2&message1=XPath has been removed!&single=$sup_name&id=$sup_id");
	}else{
		header("location:../supplier.php?tab=tab2&message1=Failed to remove xpath!&single=$sup_name&id=$sup_id");
		die;
	}
}

if(isset($goback)){
	header('location:../supplier.php');
}

/*if(isset($delete)){
	header('location:../supplier.php?tab=tab2&confirm=delete&id='.$id);
}

if(isset($no)){
	header('location:../supplier.php?tab=tab2&message=deletion has been cancled!');
}

if(isset($yes)){

	$sites=new supplier(new dbc($config));

	if($sites->delete_supplier($ID)){
		header('location:../supplier.php?tab=tab2&message=supplier has been Successfully deleted!');
	}else{
		header('location:../supplier.php?tab=tab2&message=Failed to delete!');	
	}
}*/

if(isset($update)){
	header('location:../subdata.php?id='.$sup_id);
}

if(isset($sub) || isset($edit_supp)){

	if(empty($url)){
		$err1 = 'urlerr=url can not be empty';
	}

	if(empty($sname)){
		$err2 = 'nameerr=name can not be empty';
	}
	if(isset($sub)){
		if(isset($err1) || isset($err2)){
			header('location:../supplier.php?tab=tab1&'.$err1.'&'.$err2);
			die;
		}
	}

	if(isset($edit_supp)){
		if(isset($err1) || isset($err2)){
			header('location:../supplier.php?tab=tab2&edit_supp='.$supp_id.'&'.$err1.'&'.$err2);
			die;
		}
	}
	if($filter->validate_url($url)){
		$supplier_url = $filter->filter_data($url);
	}else{
	 	$err1 = 'urlerr=please enter a valid url';
	}

	if($filter->validate_username($sname) === true){
		$supplier_name = $filter->filter_data($sname);
	}else{
		$err2='nameerr='.$filter->validate_username($sname);
	}

	if(isset($sub)){

		if(isset($err1) || isset($err2)){
			header('location:../supplier.php?tab=tab1&'.$err1.'&'.$err2);
			die;
		}

		$results = $supplier->add_supplier($supplier_url,$supplier_name);

		if($results === 11){
			header("location:../subdata.php?sitename=".$supplier_name);
		}elseif($results === 0){
			header('location:../supplier.php?tab=tab1&urlerr=Sorry we failed to add supplier');
		}else{
			header('location:../supplier.php?tab=tab1&urlerr='.$results);
		}
	}

	if(isset($edit_supp)){

		if(isset($err1) || isset($err2)){
			header('location:../supplier.php?tab=tab2&edit_supp='.$supp_id.'&'.$err1.'&'.$err2);
			die;
		}

		$message = $supplier->edit_supp($supp_id,$sname,$url);

		if($message){

			header('location:../supplier.php?tab=tab2&message='.$message); die;

		}else{
			header('location:../supplier.php?tab=tab2&message=Failed to edit.'); die;
		}
	}
			

}
?>
