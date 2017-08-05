<?php
class product{

	protected $db;

	function __construct($db){
		$this->db = $db;
	}

	function add_product($name,$price,$imgurl,$cat,$supp){
		if($this->db->insert('product(name,price,img_url,cat_id,supplier_id)',"'$name','$price','$imgurl','$cat','$supp'")){
			return 1;
		}else{
			return 0;
		}
	}

	function edit_product($id,$name,$price,$imgurl,$category,$site){
		if($this->db->update('product',"name='$name',price='$price',img_url='$imgurl',cat_id='$category',supplier_id='$site'",'id='.$id)){
			return 1;
		}else{
			return 0;
		}
	}

	function add_category($category){
		$query=$this->db->select('*','category',"name='".$category."'");
		if($query->num_rows == 0){
			if($this->db->insert('category(name)',"'".$category."'")){
				return 'Category has been added!';
			}else{
				return 'failed to add category!';
			}
		}else{
			return 'Category exists!';
		}
	}

	function edit_category($category,$id){
		$cat = 	$this->db->select('*','category','name="'.$category.'"');
		if($cat->num_rows == 0){
				$this->db->update('category','name="'.$category.'"','id='.$id);
				return 'category has been updated';
		}else{
			$cat = mysqli_fetch_row($cat);
			$cat = $cat[0];
			if($cat == $id){
				$this->db->update('category','name="'.$category.'"','id='.$id);
				return 'category has been updated';
			}else{
				return "Category exists!";
			}
		}
	}

	function move_product_cat1($pro,$cat){
		if(!empty($pro) && !empty($cat)){
			foreach ($pro as $key => $value) {
				$this->db->update('product','cat_id='."\"$cat\"",'id='.$value);
				$this->db->update('product','sub_cat_id = 0','id='.$value);
				$this->db->update('pro_location','status = 1','pro_id='.$value);

			}
			return 'products have been moved';
		}else{
			return 'no products/category were selected!';
		}
	}

	function move_product_cat2($pro,$cat){
		if(!empty($pro) && !empty($cat)){
			foreach ($pro as $key => $value) {
				$this->db->update('product','cat_id='."\"$cat\"",'id='.$value);
			}
			return 'products have been moved';
		}else{
			return 'no products were selected!';
		}
	}

	function archive_product($pro){
		if(!empty($pro)){
			foreach ($pro as $key => $value){
				$this->db->update('pro_location','status = 0','pro_id='.$value);
			}
			return 'products have been archived';
		}else{
			return 'no products were selected!';
		}
	}

	function activate_product($pro){
		if(!empty($pro)){
			foreach ($pro as $key => $value){
				$this->db->update('pro_location','status = 1','pro_id='.$value);
			}
			return 'products have been activated';
		}else{
			return 'no products were selected!';
		}
	}

	function select_product($id){
		$product = $this->db->select('*','product','id='.$id);
		 return $product=mysqli_fetch_assoc($product);
	}

	function pre_delete_product($id){
		if($id === 'arr'){
			if(!isset($_SESSION)){session_start();}
			if(isset($_SESSION['checkdel'])){$checkdel = $_SESSION['checkdel'];}else{header('location:../products.php?message1=nothing to be deleted');}
			foreach ($checkdel as $key=>$id) {
				if(!$this->delete_product($id)){
					return 0;
				}
			}
			return 1;
		}else{
			if($this->delete_product($id)){
				return 1;
			}else{
				return 0;
			}
		}
	}

	function delete_product($id){
		if($this->db->delete('product','id' ,"$id")){
			return 1;
		}else{
			return 0;
		}
	}

/*	function search_form_beg_view(){
		echo '<form name="searchform" id="searchform">
	            <label for="search">
	                Keyword:
	            </label>
	            <input type="text" name="searchkey" id="search" class="search" placeholder="Search keyword">';
	}

	function search_form_end_view(){
	    echo'<input type="button" value="Search" id="searchbutton"/>
	        </form>
			<div class="product">
			</div></div>';
	}*/

	function search_by_list_view(){
		echo'	<label for="filterby">
	                Search by:
	            </label>
	            <select id="filterby" class="search" name="filterby">
	                <option>Name</option> 
	                <option>Price</option>
	                <option>ID</option>
	            </select>
	            ';
	}

	function categories_list_view($status){
		echo'<label for="category">
	              	Categories:
	            </label>
	            <select id="category" class="search" name="category">
	            	<option value="*">All</option>';
	    $this->get_categories($status);

	    echo'</select>';

	}

	function sub_categories_list_view(){
	    echo'
	        <label for="sub_cat">
	        	sub_categories:
	        </label>
	        <select id="sub_cat" class="search" name="sub_category">
	        <option value="*">All</option>';

	    $this->get_sub_categories();

	    echo'</select>';

	}

	function suppliers_list_view($status){
	    echo'
	          <label for="suppliers">
	        	suppliers:
	          </label>
	          <select id="suppliers" class="search" name="supplier">
	          <option value="*">All</option>';

	    $this->get_suppliers($status);	
	    echo'</select>';
	
	}

	function view_active_products(){
		$this->search_by_list_view();
		$this->categories_list_view(1);
		$this->suppliers_list_view(1);
		echo'<input type="submit" value="Search" name="search2" id="searchbutton1"/>
		</form>';
	}

	function view_archived_products(){
		$this->search_by_list_view();
		$this->categories_list_view(0);
		$this->suppliers_list_view(0);
		echo'<input type="submit" value="Search" name="search3" id="searchbutton"/>
		</form>';
	}

	function category_default_view($tab){
		echo '<div class="category" style="width:200px; float:right;">';
		$this->view_add_category();
		echo'<h5>Select Category:</h5><div style="overflow-y: scroll; height:470px; width:200px; float:right;"><form method="post" action="handlers/product.php">';
		$this->category_radio_view($tab);
		echo'</div></div>
		';
	}

	function view_new_products(){
		$this->search_by_list_view();
		$this->sub_categories_list_view(3);
		$this->suppliers_list_view(3);
		echo'<input type="submit" value="Search" name="search1" id="searchbutton1"/>
		</form>';
	}

	function get_categories($cat_status){
		$categories=$this->db->select('distinct category.name,category.id','category,product,pro_location','category.id = product.cat_id and pro_location.pro_id=product.id and pro_location.status = '.$cat_status);
		if($categories->num_rows > 0){
		    foreach ($categories as $category => $value){
		         extract($value);
		         print("<option value=\"$id\">$name</option>");
		    }
		}else{
			return 0;
		}
	}

	function get_sub_categories()
	{
		$categories=$this->db->select('distinct sub_category.sub_cat_name , sub_category.sub_cat_id ' , ' sub_category , product , pro_location ',' sub_category.sub_cat_id = product.sub_cat_id and pro_location.pro_id=product.id and pro_location.status = 3');
		if($categories->num_rows != 0){
		    foreach ($categories as $category){
		         extract($category);
		         print("<option value=\"$sub_cat_id\">$sub_cat_name</option>");
		    }
		}else{
			return 0;
		}
	}

	function get_suppliers($supplier_status){
	 $suppliers=$this->db->select('distinct supplier.name , supplier.id','supplier,pro_location','supplier.id = pro_location.supp_id and status='.$supplier_status);
	 if($suppliers->num_rows > 0){
		foreach ($suppliers as $supplier => $value){
			extract($value);
		    print("<option value=\"$id\">$name</option>");
		}
	}else{
		return 0;
	}
	}

	function category_radio_view($tab){
		$results = $this->db->select_all('category');
		echo'<table>';
		foreach ($results as $result){
			extract($result);
			echo'
				<tr><td style="width:100px; position:relative; overflow:hidden;"><label><input type="radio" name="category" value="'.$id.'"/>'.$name.'</td><td style="width:50px; overflow:hidden;"></label><a id="a5" href="products.php?tab=tab'.$tab.'&editcat='.$name.'&catid='.$id.'">Edit</a></td></tr>';
		}
		echo'</table>';
	}

	function view_single_product($id,$url,$name,$product,$price,$img){
		echo'<li>
    		 <div style="background-color:#59c">
    			 <label>Select_________________<input type="checkbox" class="checkdel" name="checkdel[]" id="box['.$id.
    			 ']" value="'.$id.'"></label>
             </div>
        <a onclick=clicked("'.$url.'") class="popup2">
            <img src="';
        if(file_exists("images/".$name."/".$id."-".$name.".jpg")){echo"images/".$name."/".$id."-".$name.".jpg";}else{echo $img;}
           echo '"><h4>'.$product.'</h4>
            <h5>supplier: '. $name.'</h5>
            <p>price: " '.$price.'</p>
     	</a>
    	<a>
	</a>
    </li>';

	}


	function cat_image($file,$filename){
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$location=$_SERVER['DOCUMENT_ROOT'].'/gp6/crawl/images/category/';
    	$fileext=".jpg";
    	$filename=$filename.$fileext;

    	if ($_FILES['catimg']['size'] > 200000) {
      		return 'Exceeded filesize limit.';die;
   		}

		if (!isset($_FILES['catimg']['error']) || is_array($_FILES['catimg']['error'])){
			return 'Invalid parameters.';die;	
		}

		switch ($_FILES['catimg']['error']) {
      		case UPLOAD_ERR_OK:
        	    break;
        	case UPLOAD_ERR_NO_FILE:
				return 'No file sent.';die;	
        	case UPLOAD_ERR_INI_SIZE:
        	case UPLOAD_ERR_FORM_SIZE:
        		return 'Exceeded filesize limit';die;	
        	default:
        		return'Unknown errors.'; die;	
    		}
    	if ($finfo->file($_FILES['catimg']['tmp_name']) != 'image/jpeg'){
    		return 'invalid file format'; die;
    	}
 
   		if(move_uploaded_file($file,$location.$filename)){
   			return 'image has been uploaded';
   		}else{
   			return 'Failed to upload image';
   		}
	}

	function view_add_category(){
		echo'<br><form method="post" action="handlers/product.php" style="float:right;width:200px;"  enctype="multipart/form-data">
				<label for="cat">
					<span>Add category name/image: </span>
				</lable>
				<input type="text" name="cat_name" id="cat"><br>
			    <input type="file" accept="image/png" name="catimg" id="file">
				<input type="submit"  name="addcat" value="Add" class="button">
			</form>';
	}

	function view_edit_category($tab,$catid,$editcat){

		echo'<form class="formstyle" method="post" action="handlers/product.php?catid='.$catid.'" enctype="multipart/form-data">
				<h1>Edit Category</h1>
				<label for="cat">
					<span>Category:</span>
				</lable>
				<input type="text" name="editcat" value="'.$editcat.'" id="cat">
				<label for="file">
					<span>Image:</span>
				</lable>
				<input type="file" accept="image/png" name="catimg" id="file" class="button" style="margin-left:20px; background:#EBF0F6; color:#000;"/>
				<input type="submit"  name="editcat'.$tab.'" value="Edit" class="button">
			</form>';

		}

	function view_confirm_delete($id){
		echo"
			<form method=\"post\" action=\"handlers/product.php\">
			<input type=\"hidden\" value=\"$id\" name=\"id\">
			<table class=\"tablestyle\" width=\"300px\">
				<tr><th colspan=\"3\"><h1>Are You Sure? </h1></th></tr>
				<tr>
					<td></td>
					<td><input type=\"submit\" value =\"Yes!\" name=\"yes\"class=\"button\"></td>
					<td><input type=\"submit\" value =\"No!\" name=\"no\" class=\"button\"></td>
				</tr>
			</table>
			</form>";
		}
}
?>
