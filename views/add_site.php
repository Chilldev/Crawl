<div class="container">
	<span style="color:green;"><?php if(isset($_GET['optrue'])){echo $_GET['optrue'];}?></span>
	<form method="POST" action="handlers/supplier.php" class="formstyle">
		<h1>Site Data</h1>
			<span style="color:red;"><?php if(isset($_GET['urlerr'])){echo $_GET['urlerr'];}?></span>
			<label for="siteurl">
				<span>SiteURL</span>
			</label>
			<input type="url" name="url" id="siteurl" required/>
			<span style="color:red;"><?php if(isset($_GET['nameerr'])){echo $_GET['nameerr'];}?></span>
			<label for="sitename">
				<span>SiteName</span>
			</label>
			<input type="text" name="sname" id="sitename" required/>

			<input type="submit" value="Add" name="sub" class="button">
	</form>
</div>
