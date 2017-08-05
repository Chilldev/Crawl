<div class="container">

<form id="searchform">
	<label for="search">
	                Keyword:
	</label>
	<input type="hidden" name="tab" value="tab3">
	<input type="text" name="searchkey3" id="search" class="search" placeholder="Search keyword">

	<?php 
		require_once 'init.php';
		$product =new product(new dbc($config)); 
		$sear    = new search(new dbc($config),'id');
		$product->view_archived_products();
		$count = $sear->count_archived_pro_list();
		$count = mysqli_fetch_row($count);
		$count = $count[0];

if(isset($_GET['search3'])){
		require_once'handlers/search.php';
		$y = search_handler($_GET,$config);
		$result = $y[0];
		$count  = $y[1];
		$limit2 = $y[2];
		$noPag  = $y[3];

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
		$count = $sear->count_archived_pro_list();
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

		$result= $sear->search30_subcat30_supp30($limit1,$limit2);
}
	?>
<div class="product3">
<?php 
	if(isset($_GET['message3'])){ echo $_GET['message3']; }
		echo '<p>'.$limit2.' out of '.$count." Product.</p>";
	if($count != 0){echo"
	    <form action=\"handlers/product.php\" method=\"post\">
		<input type=\"submit\" value=\"Activate Selection\" name=\"activate_selection3\"class=\"button\">
			  <ul class=\"products\">";
		while($row=mysqli_fetch_assoc($result)){
			$product->view_single_product($row['pro_id'],$row['product_url'],$row['supp_name'],$row['pro_name'],$row['price'],$row['img_url']);
		}
		echo'</ul><br><ul>';

		if(isset($_GET['search3'])){
				echo '<ul>';
				for($x=1 ; $x<=$noPag;$x++){
					echo '<a href="?tab=tab3&p='.$x.'&searchkey3='.$_GET['searchkey3'].'&filterby='.$_GET['filterby'].'&category='.$_GET['category'].'&supplier='.$_GET['supplier']
					.'&search3='.$_GET['search3'].'"><li style="display:inline-block;">'.$x.'</li></a>  ';}
				}else{
					for($x=1 ; $x<=$noPag;$x++){
						echo '<a href="?tab=tab3&p='.$x.'"><li style="display:inline-block;">'.$x.'</li></a>  ';
					}
		}
			echo'</ul></div>';
	}
?>
</div>
</div>
