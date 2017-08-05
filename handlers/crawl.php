<?php
ini_set('max_execution_time', 60*60);
require_once '../init.php';
if($_SERVER['REQUEST_METHOD']!='POST'){header('location:../404.php');}

extract($_POST);
extract($_GET);

$crawl = new crawl(new dbc($config),new iniDOM(1,new dbc($config)));

if(isset($alldata)){
if($crawl->get_all_data()){
	header('location:../crawl.php?message=all data has been inserted');
}else{
	header('location:../crawl.php?message=failed to get/insert data');
}
}

if(isset($allimages)){

if($crawl->get_all_images()){
	header('location:../crawl.php?message=images has been downloaded');
}else{
	header('location:../crawl.php?message=failed to download images');
}

}

if(isset($data)){
	if($crawl->get_data($id)){
		header('location:../crawl.php?message=data has been inserted');
	}else{
		header('location:../crawl.php?message=failed to insert data');
	}
}

if(isset($images)){
	if($crawl->get_images($id)){
		header('location:../crawl.php?message=images has been downloaded');
	}else{
		header('location:../crawl.php?message=failed to download images');
	}
}


?>
