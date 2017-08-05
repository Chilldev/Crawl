<div>
<?php if(isset($_GET['message'])){echo $_GET['message'];}?>
</div>	
	<form action="handlers/crawl.php" method="post" class="push">
		<input id="round" type="submit" value="All Data" name="alldata" />
		<input id="round" type="submit" value="All Images" name="allimages" />
	</form>
<?php
	require_once 'init.php';
	$crawl = new crawl(new dbc($config),new iniDOM(1,new dbc($config)));
	$crawl->data_view();
?>
