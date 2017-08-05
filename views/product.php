<?php 
require_once 'init.php';
$products=new product(new dbc($config));

if(isset($_GET)){
    extract($_GET);
}
    
if(isset($confirm)){
    $products->view_confirm_delete($id);
}else{

    if(isset($message)){

        echo $message;
    }
    
    echo'<div class="container">';
	//$products->search_panel_view();
}
?>
