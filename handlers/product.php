<?php
require_once '../init.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){header('location:../404.php');}

$products =new product(new dbc($config));
$filter = new filter;

extract($_POST);
extract($_GET);

if(isset($editcat1)){

	if(empty($editcat)){
		header('location:../products.php?tab=tab1&catid='.$catid.'&editcat=&r2=please enter category name to continue!'); die;
	}

	$r2 = $products->cat_image($_FILES['catimg']['tmp_name'],$editcat);
	
	if($r2 != 'image has been uploaded' || $r2 != 'No file sent.' ){

		header('location:../products.php?tab=tab1&catid='.$catid.'&editcat='.$editcat.'&r2='.$r2); die;

	}else{

		if($filter->validate_string($editcat)){
			$message = $products->edit_category($editcat,$catid);
			header('location:../products.php?tab=tab1&message1='.$message); die;
		}
	}
}

if(isset($editcat2)){
	if(empty($editcat)){
		header('location:../products.php?tab=tab2&catid='.$catid.'&editcat=&r2=please enter category name to continue!'); die;
	}
	
	$r2 = $products->cat_image($_FILES['catimg']['tmp_name'],$editcat);
	
	if($r2 != 'image has been uploaded' || $r2 != 'No file sent.'){

		header('location:../products.php?tab=tab2&catid='.$catid.'&editcat='.$editcat.'&r2='.$r2); die;

	}else{
		if($filter->validate_string($editcat)){
			$message = $products->edit_category($editcat,$catid);
			header('location:../products.php?tab=tab2&message2='.$message); die;
		}
	}
}

if(isset($move_selection1)){

if($message1 = $products->move_product_cat1($checkdel,$category)){
	header('location:../products.php?message1='.$message1);
}else{
	header('location:../products.php?message1=failed to change product category!');
}
}
if(isset($move_selection2)){
	if($message2 = $products->move_product_cat2($checkdel,$category)){
		header('location:../products.php?tab=tab2&message2='.$message2);
	}else{
		header('location:../products.php?tab=tab2&message2=failed to change product category!');
	}
}

if(isset($archive_selection2)){
	if($message2 = $products->archive_product($checkdel)){
		header('location:../products.php?tab=tab2&message2='.$message2);
	}else{
		header('location:../products.php?tab=tab2&message2=failed to archive products!');
	}
}

if(isset($activate_selection3)){
	if($message3 = $products->activate_product($checkdel)){
		header('location:../products.php?tab=tab3&message3='.$message3);
	}else{
		header('location:../products.php?tab=tab3&message3=failed to archive products!');
	}
}

if(isset($delete)){
    $id=$checkdel[0];
	header('location:../products.php?confirm=delete&id='.$id);
}

if(isset($delete_selection1)){
	if(!isset($_SESSION)){session_start();}
	$_SESSION['checkdel']=$checkdel;
    header('location:../products.php?confirm=delete&id=arr');
}

if(isset($yes)){
	if($products->pre_delete_product($id)){
		header('location:../products.php?message=product has been Successfully deleted!');
	}else{
		header('location:../products.php?message=Failed to delete!');	
	}
}

if(isset($no)){
	header('location:../products.php?message=deletion has been cancled!');
}

if(isset($addcat)){
	if(empty($cat_name)){
		header('location:../products.php?message1=please enter category name/image to continue!'); die;
	}

	$message = $products->cat_image($_FILES['catimg']['tmp_name'],$cat_name);
	
	if($message != 'image has been uploaded'){
		header('location:../products.php?message1='.$message); die;
	}else{

		if($filter->validate_string($cat_name)){
			$message1 = $products->add_category($cat_name);
			header('location:../products.php?message1='.$message1); die;
		}
	}

}


if(isset($addcat2)){
	if(empty($cat_name)){
		header('location:../products.php?tab=tab2&message2=please enter category name to continue!'); die;
	}

	$message2 = $products->cat_image($_FILES['catimg']['tmp_name'],$cat_name);

	if($message2 != 'image has been uploaded'){
		header('location:../products.php?message1='.$message); die;
	}else{
		if($filter->validate_string($cat_name)){
			$message2 = $products->add_category($cat_name);
			header('location:../products.php?tab=tab2&message2='.$message2); die;
		}
	}
}

?>
