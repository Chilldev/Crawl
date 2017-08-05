<?php
class crawl{

	protected $db;
	protected $cURL;

	function __construct($db,$cURL){
		$this->db    = $db;
		$this->cURL  = $cURL;
	}

	function get_data($id){
		$suppliers_xpath = $this->db->select('*','supplier_xpath',"supplier_id = '$id'");
		foreach ($suppliers_xpath as $supplier_xpath) {
			$supplier =  $this->db->select('*','supplier',"id =".$supplier_xpath['supplier_id']);
			$xpath    =  $this->db->select('*','xpath',"id =". $supplier_xpath['xpath_id']);
			$this->crawl_data($supplier,$xpath);
		}
		return 1;
	}

	function get_images($id){
		$products=$this->db->select('*','pro_location','supp_id='.$id.' and status = 3');
		$supplier= $this->db->select('name','supplier','id='.$id);
		$supplier=mysqli_fetch_assoc($supplier);
		$name = $supplier['name'];
		return $this->crawl_images($products,$name);
	}

	function get_all_data(){
		$suppliers_xpath = $this->db->select_all('supplier_xpath');
		foreach ($suppliers_xpath as $supplier_xpath){
			$supplier =  $this->db->select('*','supplier',"id =".$supplier_xpath['supplier_id']);
			$xpath    =  $this->db->select('*','xpath',"id =". $supplier_xpath['xpath_id']);
			$this->crawl_data($supplier,$xpath);
		}
		return 1;
	}

	function get_all_images(){
		$products=$this->db->select_all('pro_location');
		$suppliers=$this->db->select_all('supplier');
		foreach ($suppliers as $supplier) {
			extract($supplier);
			$supplier= $this->db->select('name','supplier','id='.$id.' and status = 3');
			$supplier=mysqli_fetch_assoc($supplier);
			$name = $supplier['name'];
			return $this->crawl_images($products,$name);
		}
	}

	function crawl_data($supplier,$xpath){
			$supplier=mysqli_fetch_assoc($supplier);
			$xpath   =mysqli_fetch_assoc($xpath);
			$this->cURL->initiate_cURL($supplier['url']);
			$this->cURL->curl_phaseOne($supplier['id'],$xpath['links'],$xpath['list']);
			$curl_urls = $this->db->select('*','url',"url.supplier_id =".$supplier['id']);
			foreach($curl_urls as $url){
				extract($url);
				$this->cURL->initiate_cURL($url['supplier_url']);
				$this->cURL->curl_phaseTwo($xpath['pname'],$xpath['product_url'],$xpath['price'],$xpath['img'],$url['supplier_id'],$url['cat_id']);
			}
		return 1;
	}

	function crawl_images($products,$name){
		foreach ($products as $product) {
			extract($product);
			$this->cURL->img($name,$img_url,$pro_id);
		}
		return 1;
	}

	function data_view(){
		$all_sites= $this->db->select('distinct supplier.id,supplier.name,supplier.url','supplier,supplier_xpath','supplier.id=supplier_xpath.supplier_id');
		$this->view($all_sites,'data');
	}

	function images_view(){
		$all_sites= $this->db->select('*','supplier,xpath','supplier.id=xpath.supplier_id');
		$this->view($all_sites,'images');
	}

	function view($all_sites,$buttonname){
		 print("<div class=\"container\"><table class=\"tablestyle\" width=\"900px\"/>
			 	   <tr>
						<th>supplier_id</th>
						<th>supplier_url</th>
						<th>Sitename</th>
						<th colspan=\"2\">Action</th>
					</tr>
		");

		foreach ($all_sites as $site => $value) {
			 extract($value);
			print("<form action=\"handlers/crawl.php\" method=\"post\"/>
					<tr>
					<input type=\"hidden\"name=\"id\" value=\"$id\"/>
						<td>$id</td>
						<td>$url</td>
						<td>$name</td>
						<td><input type=\"submit\" value=\"Products\" name=\"data\" class=\"button\"></td>
						<td><input type=\"submit\" value=\"Images\" name=\"images\" class=\"button\"></td>
					</tr>
				  </form>");
 }
 print('</table></form>
 	<h4 style="color:gray">Note: this process might take several minutes.<h4></div>');

	}
}
?>
