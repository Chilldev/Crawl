<?php
require_once 'init.php';

function search_handler($query,$config){
	$result = 0;
	$stand = 32;
	$lim1 = 0;
	$lim2 = 32;

	extract($query);

	if(isset($p)){

			if($p != '1'){
				$lim1 = $stand * ($p-1);
				$lim2 = $lim1+$stand; 
			}

	}

	$sear     = new search(new dbc($config),$filterby);
	$products = new product(new dbc($config));

	//new search
	if(isset($search1)){

		if(empty($searchkey1)){
			 if($sub_category == '*' && $supplier == '*'){
			 	$count  = $sear->count_new_pro_list();
			 	$result = $sear->search10_subcat10_supp10($lim1,$lim2);
			  }
		
			if($sub_category != '*' && $supplier == '*'){
				$count  = $sear->count_search10_subcat11_supp10($sub_category);
			 	$result= $sear->search10_subcat11_supp10($sub_category,$lim1,$lim2);
			  }

			if($sub_category == '*' && $supplier != '*'){
				$count  = $sear->count_search10_subcat10_supp11($supplier);
			 	$result= $sear->search10_subcat10_supp11($supplier,$lim1,$lim2);
			  }

			  if($sub_category != '*' && $supplier != '*'){
				$count  = $sear->count_search10_subcat11_supp11($sub_category,$supplier);
			 	$result= $sear->search10_subcat11_supp11($sub_category,$supplier,$lim1,$lim2);
			  }

		}

		//active search
		if(!empty($searchkey1)){

			if($sub_category == '*' && $supplier == '*'){
			 	$count  = $sear->count_search11_subcat10_supp10($searchkey1);
			 	$result = $sear->search11_subcat10_supp10($searchkey1,$lim1,$lim2);
			  }
		
			if($sub_category != '*' && $supplier == '*'){
				$count  = $sear->count_search11_subcat11_supp10($sub_category,$searchkey1);
			 	$result= $sear->search11_subcat11_supp10($sub_category,$searchkey1,$lim1,$lim2);
			  }

			if($sub_category == '*' && $supplier != '*'){
				$count  = $sear->count_search11_subcat10_supp11($supplier,$searchkey1);
			 	$result= $sear->search11_subcat10_supp11($supplier,$searchkey1,$lim1,$lim2);
			  }

			  if($sub_category != '*' && $supplier != '*'){
				$count  = $sear->count_search11_subcat11_supp11($sub_category,$supplier,$searchkey1);
			 	$result= $sear->search11_subcat11_supp11($sub_category,$supplier,$searchkey1,$lim1,$lim2);
			  }
			}
	}

	if(isset($search2)){
		if(empty($searchkey2)){
			 if($category == '*' && $supplier == '*'){
			 	$count  = $sear->count_active_pro_list();
			 	$result = $sear->search20_subcat20_supp20($lim1,$lim2);
			  }
		
			if($category != '*' && $supplier == '*'){
				$count  = $sear->count_search20_subcat21_supp20($category);
			 	$result= $sear->search20_subcat21_supp20($category,$lim1,$lim2);
			  }

			if($category == '*' && $supplier != '*'){
				$count  = $sear->count_search20_subcat20_supp21($supplier);
			 	$result= $sear->search20_subcat20_supp21($supplier,$lim1,$lim2);
			  }

			  if($category != '*' && $supplier != '*'){
				$count  = $sear->count_search20_subcat21_supp21($category,$supplier);
			 	$result= $sear->search20_subcat21_supp21($category,$supplier,$lim1,$lim2);
			  }

		}

		if(!empty($searchkey2)){
			if($category == '*' && $supplier == '*'){
			 	$count  = $sear->count_search21_subcat20_supp20($searchkey2);
			 	$result = $sear->search21_subcat20_supp20($searchkey2,$lim1,$lim2);
			  }
		
			if($category != '*' && $supplier == '*'){
				$count  = $sear->count_search21_subcat21_supp20($category,$searchkey2);
			 	$result= $sear->search21_subcat21_supp20($category,$searchkey2,$lim1,$lim2);
			  }

			if($category == '*' && $supplier != '*'){
				$count  = $sear->count_search21_subcat20_supp21($supplier,$searchkey2);
			 	$result= $sear->search21_subcat20_supp21($supplier,$searchkey2,$lim1,$lim2);
			  }

			  if($category != '*' && $supplier != '*'){
				$count  = $sear->count_search21_subcat21_supp21($category,$supplier,$searchkey2);
			 	$result= $sear->search21_subcat21_supp21($category,$supplier,$searchkey2,$lim1,$lim2);
			  }
			}
	}

	//archived search
	if(isset($search3)){
		if(empty($searchkey3)){
			 if($category == '*' && $supplier == '*'){
			 	$count  = $sear->count_archived_pro_list();
			 	$result = $sear->search30_subcat30_supp30($lim1,$lim2);
			  }
		
			if($category != '*' && $supplier == '*'){
				$count  = $sear->count_search30_subcat31_supp30($category);
			 	$result= $sear->search30_subcat31_supp30($category,$lim1,$lim2);
			  }

			if($category == '*' && $supplier != '*'){
				$count  = $sear->count_search30_subcat30_supp31($supplier);
			 	$result= $sear->search30_subcat30_supp31($supplier,$lim1,$lim2);
			  }

			  if($category != '*' && $supplier != '*'){
				$count  = $sear->count_search30_subcat31_supp31($category,$supplier);
			 	$result= $sear->search30_subcat31_supp31($category,$supplier,$lim1,$lim2);
			  }

		}

		if(!empty($searchkey3)){

			if($category == '*' && $supplier == '*'){
			 	$count  = $sear->count_search31_subcat30_supp30($searchkey3);
			 	$result = $sear->search31_subcat30_supp30($searchkey3,$lim1,$lim2);
			  }
		
			if($category != '*' && $supplier == '*'){
				$count  = $sear->count_search31_subcat31_supp30($category,$searchkey3);
			 	$result= $sear->search31_subcat31_supp30($category,$searchkey3,$lim1,$lim2);
			  }

			if($category == '*' && $supplier != '*'){
				$count  = $sear->count_search31_subcat30_supp31($supplier,$searchkey3);
			 	$result= $sear->search31_subcat30_supp31($supplier,$searchkey3,$lim1,$lim2);
			  }

			  if($category != '*' && $supplier != '*'){
				$count  = $sear->count_search31_subcat31_supp31($category,$supplier,$searchkey3);
			 	$result= $sear->search31_subcat31_supp31($category,$supplier,$searchkey3,$lim1,$lim2);
			  }
			}
	}


	$count = mysqli_fetch_row($count);
 	$count = $count[0];

 	$noPag = $count/$stand; 

	if($noPag == '0'){
			$noPag =1;
	}

	if($noPag == '0'){
		$noPag =1;
	}

	if($count < $stand){
		$noPag = 1;
	}elseif($count%$stand == true){
       		$noPag+=1;
    }

  	if($count < $lim2){
       		$lim2 = $count;
    }
	
	return $y=array($result,$count,$lim2,$noPag);
}
?>
