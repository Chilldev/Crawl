<?php
if(isset($_GET['error'])){
echo $_GET['error'];
}else{
	header('HTTP/1.1 404 Not Found');
    echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n<html><head>\n<title>404 Not Found</title>\n</head>";
    echo "<body>\n<h1>Not Found</h1>\n<p>The requested URL ".$_SERVER['REQUEST_URI']." was not found on this server.</p>\n";
    echo "<hr>\n".$_SERVER['SERVER_SIGNATURE']."\n</body></html>\n";
    exit;
}
?>
