<div class="container">

<form action ="" method ="get" id="searchform">
	<label for="search2">
	                Keyword:
	</label>
	<input type="hidden" name="tab" value="tab2">
	<input type="text" name="searchkey2" id="search" class="search" placeholder="Search keyword">
	<?php 
		require_once 'init.php';
		$product=new product(new dbc($config));
		$sear    = new search(new dbc($config),'id');
		$product->view_active_products();

if(isset($_GET['search2'])){
		require_once'handlers/search.php';
		$y = search_handler($_GET,$config);
		$result = $y[0];
		$count  = $y[1];
		$limit2 = $y[2];
		$noPag  = $y[3];


}elseif(isset($_GET['editcat']) && isset($_GET['catid'])){
	if(isset($_GET['r2'])){ echo $_GET['r2'] ;}
	$product->view_edit_category('2',$_GET['catid'],$_GET['editcat']);
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

		$count = $sear->count_active_pro_list();
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

		$result= $sear->search20_subcat20_supp20($limit1,$limit2);
}

?>
<div class="product2">
<?php
if(isset($_GET['message2'])){ echo $_GET['message2'] ;}
		echo '<p>'.$limit2.' out of '.$count." Product.</p>";

	if($count != 0){
		$product->category_default_view('2');
		echo"
	    <form action=\"handlers/product.php\" method=\"post\">
		<input type=\"submit\" value=\"move Selection\" name=\"move_selection2\"class=\"button\">
		<input type=\"submit\" value=\"Archive Selection\" name=\"archive_selection2\"class=\"button\">
			  <ul class=\"products\">";
			  
		while($row=mysqli_fetch_assoc($result)){
			$product->view_single_product($row['pro_id'],$row['product_url'],$row['supp_name'],$row['pro_name'],$row['price'],$row['img_url']);
		}
		echo'</form></ul><br><br><ul>';

		if(isset($_GET['search2'])){
				echo '<ul>';
				for($x=1 ; $x<=$noPag;$x++){
					echo '<a href="?tab=tab2&p='.$x.'&searchkey2='.$_GET['searchkey2'].'&filterby='.$_GET['filterby'].'&category='.$_GET['category'].'&supplier='.$_GET['supplier']
					.'&search2='.$_GET['search2'].'"><li style="display:inline-block;">'.$x.'</li></a>  ';}
				}else{
					for($x=1 ; $x<=$noPag;$x++){
						echo '<a href="?tab=tab2&p='.$x.'"><li style="display:inline-block;">'.$x.'</li></a>  ';
					}
		}
			echo'</ul></div>';
	}
?>
</div>
