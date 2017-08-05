<!DOCTYPE html>
<html>
<head>
	<title>
		<?php if(!include('class/config.php')){include('../class/config.php');}echo $config['sitename'];echo pagename();?>
	</title>
    <meta charset="utf8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
   	<meta name="viewport" content="width=device-width, initial-scale=1"/>
   	<link rel="icon" type="image/png" href="images/favico.png">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">	  <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <script type="text/javascript" src="js/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="js/tabs.js"></script>
    <script type="text/javascript" src="js/product.js"></script>
</head>
<body>
   
<?php
function pagename(){
  
   $full_name=$_SERVER['PHP_SELF'];
   $full_name=explode('/', $full_name);
   $full_name=$full_name[count($full_name)-1];
   $page_name=explode('.',$full_name);
   $page_name=$page_name[0];
   if($page_name == 'login'){
      $page_name =' - Admin Panel';
      return $page_name;
   }elseif($page_name == 'index'){
      $page_name =' - Suppliers';
      return $page_name;}else{
     $page_name=str_replace('_',' ',$page_name);
     return ' | '.ucwords($page_name);
   }
}



?>
