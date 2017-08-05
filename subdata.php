<?php
require_once 'init.php';
ini_set('max_execution_time', 3600);
session_start();
$where  ='';
$submit ='';

if(isset($_GET)){extract($_GET);}

if(isset($_GET['sitename'])){

	$supplier_name = $_GET['sitename'];
	$where = "name = '$supplier_name'";
	$submit = "addpathes";
	
}elseif(isset($_GET['id'])){

	$where = "id = ".$_GET['id'];
	$submit ="updatepathes";

}

$db = new dbc($config);
$data = $db->select('*','supplier',"$where");

	foreach ($data as $key){
		$siteid             = $key['id'];
		$sitename           = $key['name'];
		$siteurl            = $key['url'];
		$_SESSION['siteid'] = $siteid;
	}


//$curl = new iniDOM(1);
//$curl->initiate_cURL($siteurl);
//$curl->write_file($sitename);

//include 'views/header.php';
echo '<!DOCTYPE html>
<html>
<head>
	<title>
	Collect | Xpath
	</title>
	<meta charset="utf-8">	
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
   	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	  <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <script type="text/javascript" src="js/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="js/parser.js"></script>
</head>
<body>';
?>
<div class="wrap-sub-second">
	<div class="sub-second">
		<?php
		// $curl->initiate_cURL($siteurl);
			$file='cache/'.$sitename.'.html';
				//echo fread('cache/'.$sitename.'.html',filesize('cache/'.$sitename.'.html'));
				//apc_load_constants('cache/'.$sitename.'.html');

				copy($siteurl,$_SERVER['DOCUMENT_ROOT'].'/gp6/crawl/'.$file);
				
				include($file);
				//apc_load_constants('cache/'.$sitename.'.html');
		?>
		<!--<iframe id="iFrame" src="curr_curl.php" width="1000px" height="1000px;" sandbox="allow-scripts allow-pointer-lock allow-same-origin">
			
		</iframe>-->
	</div>
</div>
<div class="wrap-sub-first" style="width:100%; margin-top:0px; position:fixed; background: #EBF0F6;"/>
	<div class="sub-first">

		<form action="http://localhost/gp6/crawl/handlers/supplier.php?id=<?php echo $siteid.'&sup_name='.$sitename;?>" method="POST" style="margin-top: 0em; margin-left:auto; margin-right:auto; width:100%; background: #EBF0F6; padding: 3em 15px 25px 10px; font: 12px Georgia, "Times New Roman", Times, serif; color: #888; text-shadow: 1px 1px 1px #FFF; border:1px solid #E4E4E4;">
			
            <h1 style="font-size: 2.3em; padding: 0px 0px 10px 40px; display: block; border-bottom:1px solid #E4E4E4; margin: -10px -15px 30px -10px; color: #222222;">
                Site Data
			</h1>
			<label for="thesiteurl" style="display: block; margin: 0px;">
			<!--	<span>SiteURL</span>-->
			</label>
			<input type="hidden"  name="url" value="<?php echo $siteurl;?>" id="thesiteurl"/>

			<label for="sitename" style="display: block; margin: 0px;">

			<!--	<span>SiteName</span>-->
			</label>
			<input type="hidden" name="siten" value="<?php echo $sitename;?>" id="sitename"/>

			<label for="Links" style="display: block; margin: 0px;">
			<span style="color:green"><?php if(!empty($suc)){echo $suc;}?></span>
        	<span style="color:red"> <?php if(!empty($err)){echo $err;}?></span>
    			<span id="linksz" style="float: left; width: 20%; font-size: 1.5em; text-align: right; padding-right: 10px; margin-top: 10px; color: #222222;">
                    Links
                </span>
			</label>
			<input type="text" name="links" id="Links" style="border: 1px solid #DADADA; color: #222222; height: 30px; margin-bottom: 16px;margin-right: 6px; margin-top: 2px; outline: 0 none; padding: 3px 3px 3px 5px; width: 70%; font-size: 1.5em; line-height:15px; box-shadow: inset 0px 1px 4px #ECECEC; -moz-box-shadow: inset 0px 1px 4px #ECECEC; -webkit-box-shadow: inset 0px 1px 4px #ECECEC;"/>

			<label for="Category" style="display: block; margin: 0px;">
				<span style="color:red"> <?php if(!empty($err1)){echo $err1;}?></span>
				<span id="sublistz" style="float: left; width: 20%; font-size: 1.5em; text-align: right; padding-right: 10px; margin-top: 10px; color: #222222;">
                    Category
                </span>
			</label>
			<input type="text" name="list" id="Category" style="border: 1px solid #DADADA; color: #222222; height: 30px; margin-bottom: 16px; margin-right: 6px; margin-top: 2px; outline: 0 none; padding: 3px 3px 3px 5px; width: 70%; font-size: 1.5em; line-height:15px; box-shadow: inset 0px 1px 4px #ECECEC; -moz-box-shadow: inset 0px 1px 4px #ECECEC; -webkit-box-shadow: inset 0px 1px 4px #ECECEC;"/>
			
			<label for="url" style="display: block; margin: 0px;">
				<span style="color:red"> <?php if(!empty($err2)){echo $err2;}?></span>
				<span id="urlsz" style="float: left; width: 20%; font-size: 1.5em; text-align: right; padding-right: 10px; margin-top: 10px; color: #222222;">
                    ProURLs
                </span>
			</label>
			<input type="text" name="urls" id="ProURLs" style="border: 1px solid #DADADA; color: #222222; height: 30px; margin-bottom: 16px; margin-right: 6px; margin-top: 2px; outline: 0 none; padding: 3px 3px 3px 5px; width: 70%; font-size: 1.5em; line-height:15px; box-shadow: inset 0px 1px 4px #ECECEC; -moz-box-shadow: inset 0px 1px 4px #ECECEC; -webkit-box-shadow: inset 0px 1px 4px #ECECEC;"/>

			<label for="ProductName" style="display: block; margin: 0px;">
				<span style="color:red"> <?php if(!empty($err3)){echo $err3;}?></span>
            	<span id="pro_namesz" style="float: left; width: 20%; font-size: 1.5em; text-align: right; padding-right: 10px; margin-top: 10px; color: #222222;">
                    ProductName
                </span>
			</label>
			<input type="text" name="pname" id="ProductName" style="border: 1px solid #DADADA; color: #222222; height: 30px; margin-bottom: 16px; margin-right: 6px; margin-top: 2px; outline: 0 none; padding: 3px 3px 3px 5px; width: 70%; font-size: 1.5em; line-height:15px; box-shadow: inset 0px 1px 4px #ECECEC; -moz-box-shadow: inset 0px 1px 4px #ECECEC; -webkit-box-shadow: inset 0px 1px 4px #ECECEC;"/>
 
			<label for="Image" style="display: block; margin: 0px;">
			    <span style="color:red"> <?php if(!empty($err4)){echo $err4;}?></span>                 
            	<span id="imagesz" style="float: left; width: 20%; font-size: 1.5em; text-align: right; padding-right: 10px; margin-top: 10px; color: #222222;">
                    Image
                </span>
			</label>
			<input type="text" name="img" id="Image" style="border: 1px solid #DADADA; color: #222222; height: 30px; margin-bottom: 16px; margin-right: 6px; margin-top: 2px; outline: 0 none; padding: 3px 3px 3px 5px; width: 70%; font-size: 1.5em; line-height:15px; box-shadow: inset 0px 1px 4px #ECECEC; -moz-box-shadow: inset 0px 1px 4px #ECECEC;-webkit-box-shadow: inset 0px 1px 4px #ECECEC;"/>
			<label for="Price" style="display: block; margin: 0px;">
	        	<span style="color:red"> <?php if(!empty($err5)){echo $err5;}?></span>
				<span id="pricez" style="float: left; width: 20%; font-size: 1.5em; text-align: right; padding-right: 10px;margin-top: 10px; color: #222222;">
                    Price
                </span>
			</label>
		
        	<input type="text" name="price" id="Price" style="border: 1px solid #DADADA; color: #222222; height: 30px; margin-bottom: 16px; margin-right: 6px; margin-top: 2px; outline: 0 none; padding: 3px 3px 3px 5px; width: 70%; font-size: 1.5em; line-height:15px; box-shadow: inset 0px 1px 4px #ECECEC; -moz-box-shadow: inset 0px 1px 4px #ECECEC; -webkit-box-shadow: inset 0px 1px 4px #ECECEC;"/>
         
            <input type="submit" value="Go Back" name="goback" style="background: #E27575; border: none; margin-left:22%; width:9%; padding: 10px 25px 10px 25px; color: #fff; box-shadow: 1px 1px 5px #B6B6B6; border-radius: 3px; text-shadow: 1px 1px 1px #9E3F3F; cursor: pointer;"/>
			
            <input type="submit" value="Add" name="<?php echo $submit?>" class="myhappysubmit" style="background: #E27575; border: none; margin-left:53%; width:7%; padding: 10px 25px 10px 25px;  color: #fff; box-shadow: 1px 1px 5px #B6B6B6; border-radius: 3px; text-shadow: 1px 1px 1px #9E3F3F; cursor: pointer;"/>
		</form>
	</div>
</div>
    <script type="text/javascript" src="js/parser.js"></script>
</body>
</html>

