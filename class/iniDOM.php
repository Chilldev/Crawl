<?php

class iniDOM{

	public    $curl_handler;
	public    $url;
	public    $DOM;
	public    $Xpath;
	public    $result;
	public    $state;
	public    $site_session;
	public    $arr;
	protected $db;


	function __construct($state,$db){
		$this->state = $state;
		$this->db    = $db;
	}

	function initiate_cURL($url){
		$this->url=$url;
		$this->curl_handler=curl_init($url);
		iniDOM::set_options();
		$this->site_session= curl_exec($this->curl_handler);
		curl_close($this->curl_handler);
	}

	function set_options(){
		set_time_limit(0);
        curl_setopt($this->curl_handler, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0');
        curl_setopt($this->curl_handler, CURLOPT_SSL_VERIFYPEER , false        );
		curl_setopt($this->curl_handler, CURLOPT_SSL_VERIFYHOST , false        );
		curl_setopt($this->curl_handler, CURLOPT_BINARYTRANSFER , true         );
		curl_setopt($this->curl_handler, CURLOPT_RETURNTRANSFER , $this->state );
	}

	function load_xpath(){
		$this->DOM = new DOMDocument();
		@$this->DOM->loadHTML($this->site_session);
		$this->Xpath = new DOMXpath($this->DOM);
	}

	function xquery($path){
		iniDOM::load_xpath();
		return @$this->Xpath->query($path);
	}

	function write_file($sitename){
		$file_handler   = fopen($sitename.'.php', 'w');
		//$file_conetnets = $this->site_session;//iniDOM::initiate_cURL($url);
		fwrite($file_handler, $this->site_session);
		fclose($file_handler);
	}

	function get_links($linkXpath){
		$links = iniDOM::xquery($linkXpath);
		if(!empty($links)){
			$counter = 1;
			foreach($links as $link){
				if(@!filter_var($link->nodeValue,FILTER_VALIDATE_URL)){
					$this->arr['links'][$counter] = $this->url.$link->nodeValue;
				}else{
					$this->arr['links'][$counter] = $link->nodeValue;
				}
				$counter++;
			}
			$this->arr['links'];
		}
	}

	function get_categories($catXpath){
		$categories = iniDOM::xquery($catXpath);
		if(!empty($categories)){
			$counter = 1;
			foreach($categories as $category){
				$this->arr['categories'][$counter] = $category->nodeValue;
				$counter++;
			}
			$this->arr['categories'];
		}
	}

	function get_names($proXpath){
		$pro_names = iniDOM::xquery($proXpath);
		if(!empty($pro_names)){
			$counter = 1;
			foreach($pro_names as $pro_name){
				$this->arr['pro_names'][$counter] = $pro_name->nodeValue;
				$counter++;
			}
			$this->arr['pro_names'];
		}

	}

	function product_url($productXpath){
		$urls = iniDOM::xquery($productXpath);
		if(!empty($urls)){
			$counter = 1;
			foreach($urls as $url){
				$this->arr['urls'][$counter] = $url->nodeValue;
				$counter++;
			}
			$this->arr['urls'];
		}
	}

	function get_images($imageXpath){
		$images = iniDOM::xquery($imageXpath);
		if(!empty($images)){
			$counter = 1;
			foreach($images as $image){
				$this->arr['images'][$counter] = $image->nodeValue;
				$counter++;
			}
			$this->arr['images'];
		}
	}

	function get_prices($priceXpath){
		$prices = iniDOM::xquery($priceXpath);
		if(!empty($prices)){	
			$counter = 1;
			foreach($prices as $price){
				$price=preg_replace('/[^0-9\.]/', '', $price->nodeValue);
				$this->arr['prices'][$counter]=$price;
				$counter++;
			}
			$this->arr['prices'];
		}
	}
	function img($name,$img_url,$id){
		$url       = str_replace(' ','%20',$img_url);
		$path      = $_SERVER['DOCUMENT_ROOT']."/gp6/crawl/images/".$name."/";
		$ext       = "$id".'-'."$name".'.jpg';
		$root      = $path.$ext;

		if(!file_exists($path)){
    		        mkdir($path,true);
		}

             copy($url,$root);
               // echo $file= file_get_contents($url);
               // if(!file_put_contents($root,$file)) die('horror');
		//if(!copy($url,$root)) die($url.$root);
	}

	function curl_phaseOne($site_id,$linkXpath,$catXpath){
		iniDOM::get_links($linkXpath);
		iniDOM::get_categories($catXpath);

		$counter=1;
		foreach ($this->arr['links'] as $link){

			$link     = trim($this->arr['links'][$counter]);
			$category = trim($this->arr['categories'][$counter]);
			if(!empty($link)&&!empty($category)){
				$result = $this->db->select('*','sub_category',"sub_cat_name =\"$category\"");
				if($result->num_rows == 0){
					$this->db->insert('sub_category',"'',\"$category\"");
					$result=$this->db->select('sub_cat_id','sub_category',"sub_cat_name =\"$category\"");
					$result = mysqli_fetch_assoc($result);	
					$cat_id= $result['sub_cat_id'];

				}else{

					$result = mysqli_fetch_assoc($result);	
					$cat_id = $result['sub_cat_id'];
				}

				$result=$this->db->select('*','url',"supplier_url = '$link'");
				if($result->num_rows == 0){
					$this->db->insert('url',"'','$link','$cat_id','$site_id'");
				}
			}
			$counter++;
		}

	}

	function curl_phaseTwo($pname,$urls,$price,$img,$site_id,$cat_id){
		iniDOM::get_names($pname);
		iniDOM::product_url($urls);
		iniDOM::get_prices($price);
		iniDOM::get_images($img);
		$counter=1;
		foreach ($this->arr['pro_names'] as $nameo){
			$name  = @trim($this->arr['pro_names'][$counter]);
			$price = @trim($this->arr['prices'][$counter]);
			$image = @trim($this->arr['images'][$counter]);
			$url   = @trim($this->arr['urls'][$counter]);
			$result=$this->db->select('*','product',"name = \"$name\"");
				if($result->num_rows == 0){
					$this->db->insert('product(name,sub_cat_id)',"\"$name\",\"$cat_id\"");
					$result=$this->db->select('*','product',"name = \"$name\"");
					$result=mysqli_fetch_assoc($result);
					$pro_id=$result['id'];
					$this->db->insert('pro_location(price,supp_id,pro_id,product_url,img_url)',"'$price','$site_id','$pro_id','$url','$image'");
				}else{
					$result=mysqli_fetch_assoc($result);
					$pro_id=$result['id'];
					$this->db->insert('pro_location(price,supp_id,pro_id,product_url,img_url)',"'$price','$site_id','$pro_id','$url','$image'");
				}
			$counter++;
		}

		return 1;
	}
}
?>
