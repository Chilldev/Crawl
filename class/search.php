<?php
class search extends product{

public    $db;
public    $filter;
public    $status;

	function __construct($db,$filter){
		$this->db = $db;
		if($filter == 'Name'){
			$this->filter = 'pro_name';
		}elseif($filter == 'Price'){
			$this->filter = 'price';
		}elseif($filter == 'ID'){
			$this->filter = 'pro_id';
		}else{
			$this->filter ='pro_name';
		}
	}

//beg of new products search

	function count_new_pro_list(){
		return $this->db->select('count(*)','product_list','status = 3');
	}

	//empty searchkey

	function search10_subcat10_supp10($lim1,$lim2){
		return $this->db->select('*',' product_list',' status = 3  order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search10_subcat11_supp10($subcat){
		return $this->db->select('count(*)','product_list','status = 3 and sub_cat_id='.$subcat);
	}
    function search10_subcat11_supp10($subcat,$lim1,$lim2){
		return $this->db->select('*',' product_list',' sub_cat_id='.$subcat.' and status = 3 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search10_subcat10_supp11($supplier){
		return $this->db->select('count(*)','product_list',' status = 3 and supp_id = '.$supplier);
	}

	function search10_subcat10_supp11($supplier,$lim1,$lim2){
		return $this->db->select('*','product_list',' status = 3 and supp_id = '.$supplier.' order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search10_subcat11_supp11($subcat,$supplier){
		return $this->db->select('count(*)','product_list','sub_cat_id ='.$subcat.' and supp_id = '.$supplier.' and status = 3 ');
	}

	function search10_subcat11_supp11($subcat,$supplier,$lim1,$lim2){
		return $this->db->select('*','product_list','sub_cat_id ='.$subcat.' and supp_id = '.$supplier.' and status = 3 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	//!empty searchkey

	function count_search11_subcat10_supp10($key){
		return $this->db->select('count(*)',' product_list',' status = 3  and '.$this->filter.' like "%'.$key.'%"');
	}

	function search11_subcat10_supp10($key,$lim1,$lim2){
		return $this->db->select('*',' product_list', 'status = 3  and '.$this->filter.' like "%'.$key.'%" order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search11_subcat11_supp10($subcat,$key){
		return $this->db->select('count(*)','product_list','status = 3 and sub_cat_id='.$subcat.' and '.$this->filter.' like "%'.$key.'%"');
	}
    function search11_subcat11_supp10($subcat,$key,$lim1,$lim2){
		return $this->db->select('*',' product_list',' sub_cat_id='.$subcat.' and status = 3 and '.$this->filter.' like "%'.$key.'%"  order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search11_subcat10_supp11($supplier,$key){
		return $this->db->select('count(*)','product_list',' status = 3 and supp_id = '.$supplier.' and '.$this->filter.' like "%'.$key.'%"' );
	}

	function search11_subcat10_supp11($supplier,$key,$lim1,$lim2){
		return $this->db->select('*','product_list',' status = 3 and supp_id = '.$supplier.' and '.$this->filter.' like "%'.$key.'%" order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search11_subcat11_supp11($subcat,$supplier,$key){
		return $this->db->select('count(*)','product_list','sub_cat_id ='.$subcat.' and '.$this->filter.' like "%'.$key.'%" and supp_id = '.$supplier.' and status = 3 ');
	}

	function search11_subcat11_supp11($subcat,$supplier,$key,$lim1,$lim2){
		return $this->db->select('*',' product_list',' sub_cat_id ='.$subcat.' and '.$this->filter.' like "%'.$key.'%" and supp_id = '.$supplier.' and status = 3 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

//end of new products search 

//beg of active products search

	function count_active_pro_list(){
		return $this->db->select('count(*)','product_list','status = 1');
	}

	//empty search key

	function search20_subcat20_supp20($lim1,$lim2){
		return $this->db->select('*',' product_list',' status = 1  order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search20_subcat21_supp20($cat){
		return $this->db->select('count(*)','product_list','status = 1 and cat_id='.$cat);
	}
    function search20_subcat21_supp20($cat,$lim1,$lim2){
		return $this->db->select('*',' product_list',' cat_id='.$cat.' and status = 1 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search20_subcat20_supp21($supplier){
		return $this->db->select('count(*)','product_list',' status = 1 and supp_id = '.$supplier);
	}

	function search20_subcat20_supp21($supplier,$lim1,$lim2){
		return $this->db->select('*','product_list',' status = 1 and supp_id = '.$supplier.' order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search20_subcat21_supp21($cat,$supplier){
		return $this->db->select('count(*)','product_list','cat_id ='.$cat.' and supp_id = '.$supplier.' and status = 1 ');
	}

	function search20_subcat21_supp21($cat,$supplier,$lim1,$lim2){
		return $this->db->select('*','product_list','cat_id ='.$cat.' and supp_id = '.$supplier.' and status = 1 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	//!empty search key2

	function count_search21_subcat20_supp20($key){
		return $this->db->select('count(*)',' product_list',' status = 1  and '.$this->filter.' like "%'.$key.'%"');
	}

	function search21_subcat20_supp20($key,$lim1,$lim2){
		return $this->db->select('*',' product_list', 'status = 1  and '.$this->filter.' like "%'.$key.'%" order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search21_subcat21_supp20($cat,$key){
		return $this->db->select('count(*)','product_list','status = 1 and cat_id='.$cat.' and '.$this->filter.' like "%'.$key.'%"');
	}
    function search21_subcat21_supp20($cat,$key,$lim1,$lim2){
		return $this->db->select('*',' product_list',' cat_id='.$cat.' and status = 1 and '.$this->filter.' like "%'.$key.'%"  order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search21_subcat20_supp21($supplier,$key){
		return $this->db->select('count(*)','product_list',' status = 1 and supp_id = '.$supplier.' and '.$this->filter.' like "%'.$key.'%"' );
	}

	function search21_subcat20_supp21($supplier,$key,$lim1,$lim2){
		return $this->db->select('*','product_list',' status = 1 and supp_id = '.$supplier.' and '.$this->filter.' like "%'.$key.'%" order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search21_subcat21_supp21($cat,$supplier,$key){
		return $this->db->select('count(*)','product_list','cat_id ='.$cat.' and '.$this->filter.' like "%'.$key.'%" and supp_id = '.$supplier.' and status = 1 ');
	}

	function search21_subcat21_supp21($cat,$supplier,$key,$lim1,$lim2){
		return $this->db->select('*',' product_list',' cat_id ='.$cat.' and '.$this->filter.' like "%'.$key.'%" and supp_id = '.$supplier.' and status = 1 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

//end of active products search

//beg of archived products search

	function count_archived_pro_list(){
		return $this->db->select('count(*)','product_list','status = 0');
	}

//empty searchkey3

	function search30_subcat30_supp30($lim1,$lim2){
		return $this->db->select('*','product_list','status = 0  order by pro_id limit '.$lim1.','.$lim2);
	}

	function count_search30_subcat31_supp30($cat){
		return $this->db->select('count(*)','product_list','status = 0 and cat_id='.$cat);
	}
    function search30_subcat31_supp30($cat,$lim1,$lim2){
		return $this->db->select('*',' product_list',' cat_id='.$cat.' and status = 0 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search30_subcat30_supp31($supplier){
		return $this->db->select('count(*)','product_list',' status = 0 and supp_id = '.$supplier);
	}

	function search30_subcat30_supp31($supplier,$lim1,$lim2){
		return $this->db->select('*','product_list',' status = 0 and supp_id = '.$supplier.' order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search30_subcat31_supp31($cat,$supplier){
		return $this->db->select('count(*)','product_list','cat_id ='.$cat.' and supp_id = '.$supplier.' and status = 0 ');
	}

	function search30_subcat31_supp31($cat,$supplier,$lim1,$lim2){
		return $this->db->select('*','product_list','cat_id ='.$cat.' and supp_id = '.$supplier.' and status = 0 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}


//!empty searchkey3

	function count_search31_subcat30_supp30($key){
		return $this->db->select('count(*)',' product_list',' status = 0  and '.$this->filter.' like "%'.$key.'%"');
	}

	function search31_subcat30_supp30($key,$lim1,$lim2){
		return $this->db->select('*',' product_list', 'status = 0  and '.$this->filter.' like "%'.$key.'%" order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search31_subcat31_supp30($cat,$key){
		return $this->db->select('count(*)','product_list','status = 0 and cat_id='.$cat.' and '.$this->filter.' like "%'.$key.'%"');
	}
    function search31_subcat31_supp30($cat,$key,$lim1,$lim2){
		return $this->db->select('*',' product_list',' cat_id='.$cat.' and status = 0 and '.$this->filter.' like "%'.$key.'%"  order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search31_subcat30_supp31($supplier,$key){
		return $this->db->select('count(*)','product_list',' status = 0 and supp_id = '.$supplier.' and '.$this->filter.' like "%'.$key.'%"' );
	}

	function search31_subcat30_supp31($supplier,$key,$lim1,$lim2){
		return $this->db->select('*','product_list',' status = 0 and supp_id = '.$supplier.' and '.$this->filter.' like "%'.$key.'%" order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

	function count_search31_subcat31_supp31($cat,$supplier,$key){
		return $this->db->select('count(*)','product_list','cat_id ='.$cat.' and '.$this->filter.' like "%'.$key.'%" and supp_id = '.$supplier.' and status = 0 ');
	}

	function search31_subcat31_supp31($cat,$supplier,$key,$lim1,$lim2){
		return $this->db->select('*',' product_list',' cat_id ='.$cat.' and '.$this->filter.' like "%'.$key.'%" and supp_id = '.$supplier.' and status = 0 order by '.$this->filter.' limit '.$lim1.','.$lim2);
	}

//end of archived products search
}

?>
