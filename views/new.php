<div class="container">

<form action="" method="get" id="searchform1">
	<label for="search1">
	                Keyword:
	</label>
	<input type="text" name="searchkey1" id="search1" class="search1" placeholder="Search keyword">

	<?php 
		require_once 'init.php';
		$product=new product(new dbc($config)); 
		$sear    = new search(new dbc($config),'id');
		$product->view_new_products();

if(isset($_GET['confirm'])){

$product->view_confirm_delete($_GET['id']);

}else{

if(isset($_GET['search1'])){
			require_once'handlers/search.php';
			$y = search_handler($_GET,$config);
			$result = $y[0];
			$count  = $y[1];
			$limit2 = $y[2];
			$noPag  = $y[3];
			echo'</form>';

		
}elseif(isset($_GET['editcat']) && isset($_GET['catid'])){
	
	if(isset($_GET['r2'])){ echo $_GET['r2'] ;}
	$product->view_edit_category('1',$_GET['catid'],$_GET['editcat']);
	die;

}else{
		$stand = 32;
		$limit1 = 0;
		$limit2 = 32;

		if(isset($_GET['p'])){

			if($_GET['p'] != '1'){
				$limit1 = $stand * ($_GET['p']-1);
				$limit2 = $limit1+$stand; 
			}

		}

		$count = $sear->count_new_pro_list();
		$count = mysqli_fetch_row($count);
		$count = $count[0];

		$noPag = $count/$stand; 

		if($noPag == '0'){
			$noPag =1;
		}

       	if($count < $stand){

			$noPag = 1;

		}elseif($count%$stand == true){
       		$noPag+=1;
       	}

       	if($count < $limit2){
       		$limit2 = $count;
       	}

		$result= $sear->search10_subcat10_supp10($limit1,$limit2);
				echo'</form>';

	}

	?>

<div class="product1">
<?php  
if(isset($_GET['message1'])){ echo'<br>'. $_GET['message1']; } 

			$product->category_default_view('1');

		echo '<p>'.$limit2.' out of '.$count." Product.</p>";

			if($count != 0){
		    echo"
		    <form action=\"handlers/product.php\" method=\"post\">
			<label>Select all<input type=\"checkbox\" name=\"selectbox\" onclick=\"checkall(this)\" ></label>
			<input type=\"submit\" value=\"Delete Selection\" name=\"delete_selection1\"class=\"button\">
			<input type=\"submit\" value=\"move Selection\" name=\"move_selection1\"class=\"button\">
			<ul class=\"products\">";
			while($row=mysqli_fetch_assoc($result)){
				$product->view_single_product($row['pro_id'],$row['product_url'],$row['supp_name'],$row['pro_name'],$row['price'],$row['img_url']);
			}

			echo'</ul><br><br>';
			if(isset($_GET['search1'])){
				echo '<ul>';
				for($x=1 ; $x<=$noPag;$x++){
					echo '<a href="?tab=tab1&p='.$x.'&searchkey1='.$_GET['searchkey1'].'&filterby='.$_GET['filterby'].'&sub_category='.$_GET['sub_category'].'&supplier='.$_GET['supplier']
					.'&search1='.$_GET['search1'].'"><li style="display:inline-block;">'.$x.'</li></a>  ';
				}
			}else{
				echo '<ul>';
				for($x=1 ; $x<=$noPag;$x++){
					echo '<a href="?tab=tab1&p='.$x.'"><li style="display:inline-block;">'.$x.'</li></a>  ';
				}
				echo'</ul></div>';
			}
	}
}
?>
</div>
</div>
