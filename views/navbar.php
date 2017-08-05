<?php 
$isadmin = 0;
if($_SESSION['user_type'] == 'admin'){
	$isadmin =1;
}
?>
<div class="navbar">
	<div class="navcontainer">
		<div class="leftnav">
			<ul>
				<a href="index.php"><li>Suppliers</li></a>
							<li>|</li>
				<a href="products.php?tab=tab1"><li>Products</li></a>
							<li>|</li>
				<a href="crawl.php?tab=tab1"><li>Crawl</li></a>
				<?php if($isadmin == 1)echo'<li>|</li><a href="users.php?tab=tab1"><li>Users</li></a></ul>';?>	
		</div>
		<div class="rightnav">
			<ul>					
				<a href="handlers/login.php?logout=true"><li>Log Out</li></a>
			</ul>
		</div>
	</div>
</div>
