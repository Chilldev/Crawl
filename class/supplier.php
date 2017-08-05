<?php
class supplier{

	protected $db;

	function __construct($db){
		$this->db = $db;
	}

	function add_supplier($url , $name){
		$check = $this->supplier_name_url($url,$name);
		if($check){
			return $check;
		}else{
			$this->db->insert('supplier',"'','$url','$name'");
			return 11;	
		}
	}


	function supplier_name_url($url,$name){
		$x=''; $y='';

		if($this->supplier_url_exists($url)){

			$x = 'supplier url exists';
		}

		if($this->supplier_name_exists($name)){

			$y = 'supplier name exists';

		}

		if(empty($x) && empty($y)){
			return 0;
		}else{
			return "$x".' , '."$y";
		}
	}

	function supplier_url_exists($url){
		$result=$this->db->select('*','supplier',"url ='$url'");
		if($result->num_rows == 0){
			return 0;
		}else{
			return $result;
		}
	}

	function supplier_name_exists($name){
		$result=$this->db->select('*','supplier',"name = '$name'");
		if($result->num_rows == 0){
			return 0;
		}else{
			return $result;
		}
	}

	function xpath_exists($links,$urls,$list,$pname,$img,$price){
		$urls =$this->secure_xpath($urls);
		$links=$this->secure_xpath($links);
		$list =$this->secure_xpath($list);
		$pname=$this->secure_xpath($pname);
		$img  =$this->secure_xpath($img);
		$price=$this->secure_xpath($price);
		$where="links='".$links."' and list='".$list."' and pname='".$pname."' and product_url='".$urls."' and img='".$img."' and price ='".$price."'";
		$result=$this->db->selectpathes('id','xpath',$where);
		if($result->num_rows == 0){
			return 0;
		}else{
			$result=mysqli_fetch_row($result);
			return $result[0];
		}
	}

	function addpathes($id,$links,$urls,$list,$pname,$img,$price){
		$urls =$this->secure_xpath($urls);
		$links=$this->secure_xpath($links);
		$list =$this->secure_xpath($list);
		$pname=$this->secure_xpath($pname);
		$img  =$this->secure_xpath($img);
		$price=$this->secure_xpath($price);
		$value ="'','".$links."','".$list."','".$pname."','".$urls."','".$img."','".$price."'";
  		if($this->db->insertpathes('xpath',$value)){
  		   $where="links='".$links."' and list='".$list."' and pname='".$pname."' and product_url='".$urls."' and img='".$img."' and price ='".$price."'";
		   $result=$this->db->selectpathes('id','xpath',$where);
		   $result=mysqli_fetch_row($result);
  		   $xpath_id=$result[0];
  		   $value="'".$id."','".$xpath_id."'";
  		   $this->db->insert("supplier_xpath",$value);
			return 1;
		}else{
			return 0;
		}
	}

	function updatepathes($supplier_id,$xpath_id){
		if(!$this->supplier_xpath_exist($supplier_id,$xpath_id)){
			if($this->db->insert("supplier_xpath",$supplier_id.','.$xpath_id)){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 1;
		}
		
	}

	function supplier_xpath_exist($supplier_id,$xpath_id){
		$where = 'supplier_id ='.$supplier_id.' and xpath_id='.$xpath_id;
		$result=$this->db->select('*','supplier_xpath',$where);
		if($result->num_rows != true){
			return 0;
		}else{
			return 1;
		}
	}

	/*function delete_supplier($id){
		if($this->db->delete('supplier','id' ,"$id")){
			if($xpathes = $this->get_xpathes_by_supid($id)){
				$this->db->delete('supplier_xpath','supplier_id' ,"$id");
				$this->db->delete('url','supplier_id' ,"$id");
				foreach ($xpathes as $xpath) {
					extract($xpath);
					if($this->select_xpath_byID($xpath_id) == false){
						$this->db->delete('xpath','id',$xpath_id);
					}
				}
			}
			return 1;
		}else{

			return 0;
		}
	}*/
	
	function remove_xpath($xpath_id,$supplier_id){
		if($this->db->deleteand('supplier_xpath',"supplier_id=$supplier_id and xpath_id=$xpath_id")){
			if(!$this->select_xpath_byID($xpath_id)){
				$this->db->delete('xpath','id',$xpath_id);
			}
			return 1;
		}else{
			return 0;
		}
	}

	function select_xpath_byID($xpath_id){
		$xpath = $this->db->select('*','supplier_xpath',"xpath_id=".$xpath_id);
		if($xpath->num_rows == 0){
			return 0;
		}else{
			return 1;
		}
	}


	function edit_supp($id,$name,$url){
		$supplier  = $this->db->select('*','supplier','id= '.$id);
		$supplier  = mysqli_fetch_assoc($supplier);
		$supp_name = $supplier['name'];
		$supp_url  = $supplier['url'];

		if($name == $supp_name && $url == $supp_url){
			return 'Nothing changed!'; die;
		}		

		if($name != $supp_name || $url != $supp_url){
			$result = $this->db->select('*','supplier',"name = '$name'");
			if($result->num_rows == 0){
				$result1 = $this->db->select('*','supplier',"url = '$url'");
				if($result1->num_rows == 0){
					$this->db->update('supplier','name="'.$name.'" , url="'.$url.'"',' id='.$id);
					return 'supplier has been updated'; die;
				}else{

					$result1 = mysqli_fetch_assoc($result1);
					$ss_id = $result1['id'];

					if($id != $ss_id){
						return 'supplier URL exists'; die;
					}else{
						$this->db->update('supplier','name="'.$name.'" , url="'.$url.'"',' id='.$id);
						return 'supplier has been updated'; die;
					}
				}
				}else{
					$result=mysqli_fetch_assoc($result);
					$s_id = $result['id'];
					if($id != $s_id){
						return 'supplier username exists'; die;
					}else{
						$result1 = $this->db->select('*','supplier',"url = '$url'");
						if($result1->num_rows == 0){
							$this->db->update('supplier','name="'.$name.'" , url="'.$url.'"',' id='.$id);
							return 'supplier has been updated'; die;
						}else{
							$result1 = mysqli_fetch_assoc($result1);
							$ss_id = $result1['id'];

							if($id != $ss_id){
								return 'supplier URL exists'; die;
							}else{
								$this->db->update('supplier','name="'.$name.'" , url="'.$url.'"',' id='.$id);
								return 'supplier has been updated'; die;
							}
						}
					}
				}
			}
	
	}

	function upload_sup_logo($file,$filename){
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$location=$_SERVER['DOCUMENT_ROOT'].'\gp6\crawl\images\supplier\\';
    	$fileext=".png";
    	$filename=$filename.$fileext;

    	if ($_FILES['logofile']['size'] > 100000) {
      		return 'Exceeded filesize limit.';die;
   		}

		if (!isset($_FILES['logofile']['error']) || is_array($_FILES['logofile']['error'])){
			return 'Invalid parameters.';die;	
		}
		switch ($_FILES['logofile']['error']) {
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
    	if ($finfo->file($_FILES['logofile']['tmp_name']) != 'image/png'){
    		return 'invalid file format'; die;
    	}
 
   		if(move_uploaded_file($file,$location.$filename)){
   			return 'logo has been uploaded';
   		}else{
   			return 'Failed to upload logo';
   		}
	}

	function view_edit_supp($id){
		$supplier = $this->db->select('*','supplier','supplier.id = '.$id);
		foreach ($supplier as $supp) {
				extract($supp);
				echo' 
				<form method="post" action="handlers/supplier.php?supp_id='.$id.'" class="formstyle">
					<h1>Edit Supplier</h1>
					<span style="color:red;">';
					if(isset($_GET['urlerr'])){echo $_GET['urlerr'];}
					echo'</span>';
					echo'<label for="supp_url"><span>Supp_URL</span></label>
					<input type="url" value = "'.$url.'" id="supp_url" name="url">
					<span style="color:red;">';
					if(isset($_GET['nameerr'])){echo $_GET['nameerr'];}
					echo'</span>
					<label for="supp_name"><span>Supp_Name<span></label>
					<input type="text" value = "'.$name.'" id="supp_name" name="sname">
					<input type="submit" value = "Cancel" name="cancel_supp" class="button1">
					<input type="submit" value = "Edit" name="edit_supp" class="button1">
				</form>';
			}	
	}


	function view_suppliers(){
		echo"<div class=\"container\">\n<table class=\"tablestyle\" width=\"75%\">\n<tr>\n\t<th>Supplier_ID</th>\n\t<th>Supplier_Name</th>\n\t<th>Supplier_URL</th>\n\t<th>Edit</th>\n\t<th>Upload Logo</th>\n\t<th>Xpath</th><!--<th>Delete</th>--></tr>\n";
		
		$suppliers  = $this->db->select_all('supplier','order by id');

		if($suppliers->num_rows == 0){
			echo 'no suppliers to show';
		}else{
			foreach ($suppliers as $supplier) {
				extract($supplier);
				echo"<tr>\n\t
						<td>$id</td>\n\t
						<td>$name</td>\n\t
						<td>$url</td>\n\t
						<td><a href=\"supplier.php?tab=tab2&edit_supp=$id\"><button class=\"button\">Edit</button></a></td>\n\t
						<td><form action=\"handlers/supplier.php?filename=$name\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"file\" name=\"logofile\"  accept=\"image/png\"><input class=\"button\" type=\"submit\" name=\"uploadlogo\" value=\"Upload Logo\"></form></td>\n\t
						<td><a href=\"supplier.php?tab=tab2&single=$name&id=$id\"><button class=\"button\">View</button></a></td>
						<!--<td><a href=\"handlers/supplier.php?delete&id=$id\"><button class=\"button\">Delete Supplier</button></a></td>-->
					</tr>";
			}
		}

		echo "</table>
		      </div>";
	}

	function get_xpathes_by_supid($sup_id){
		$xpathes = $this->db->select('*','supplier_xpath','supplier_id='.$sup_id);
		if($xpathes->num_rows != 0){
			return $xpathes;
		}else{
			return 0;
		}
	}

	function view_single($sup_id,$name){
		echo'<div class="container"><a href="supplier.php?tab=tab2"><button class="button">Go back</button><br></a>
			 <table class="tablestyle">';
		echo"<tr><th colspan=\"7\">Supplier Name: [(< $name >)]</th></tr><tr></tr><tr></tr>";
		echo"<tr>\n\t<th>suppNavi</th>\n\t<th>proURLs</th>\n\t<th>Categories</th>\n\t<th>ProName</th>\n\t<th>ImgURL</th>\n\t<th>Price</th>\n\t<th>Action</th>\n</tr>\n<tr></tr><tr></tr>";
		$xpathes = $this->get_xpathes_by_supid($sup_id);
		if($xpathes!= false){
			foreach ($xpathes as $xpath){
				extract($xpath);
				$xpath=$this->db->select('*','xpath','id='.$xpath_id);
				$xpath=mysqli_fetch_assoc($xpath);
				$this->echo_xpath_table_row($xpath,$xpath_id,$sup_id,$name);
			}
			echo'</table>';
		}else{
			echo 'No XPath to show!<br> Please add xpath using this button->.';
		}
		echo '<form method="post" action="handlers/supplier.php?sup_id='.$sup_id.'"><input type="submit" class="button" value="Add XPath" name="update"></form></div>';
	}

	function echo_xpath_table_row($xpath,$xpath_id,$sup_id,$sup_name){
		if(isset($xpath)){
			extract($xpath);
			echo"<tr><td>$links</td><td>$product_url</td><td>$list</td><td>$pname</td><td>$img</td><td>$price</td>
		         <td><form method=\"post\" action=\"handlers/supplier.php?xpath_id=$xpath_id&sup_id=$sup_id&sup_name=$sup_name\"><input type=\"submit\" class=\"button\" value=\"Remove\" name=\"deletexpath\"></form></td></tr>";
		 }
	}

	function view_confirm_delete($id){
		echo"
			<form method=\"post\" action=\"handlers/supplier.php\">
			<input type=\"hidden\" value=\"$id\" name=\"ID\">
			<table class=\"tablestyle\" width=\"300px\">
				<tr><th colspan=\"3\"><h1>Are You Sure? </h1></th></tr>
				<tr>
					<td><input type=\"submit\" value =\"Yes!\" name=\"yes\"class=\"button\"></td>
					<td><input type=\"submit\" value =\"No!\" name=\"no\" class=\"button\"></td>
				</tr>
			</table>
			</form>";
	}

	function secure_xpath($data){
		$data = trim($data);
  		$data = str_replace('\'', '\\\'', $data);
  		$data = htmlspecialchars($data);
  		return $data;
	}
}
?>
