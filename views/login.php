</head>
<body>
<form action="handlers/login.php" method="post" class="formstyle">
<h1>Login</h1>
<span style="color:red"><?php if(isset($_GET['logerr'])){echo $_GET['logerr'];}?></span>
<label for="user">
	<span>Username:</span>
</label>
<input type="text" name="username" id="user" required/>

<label for="pass">
	<span>Password:</span>
</label>
<input type="password" name="password" id="pass" required/>

<input type="submit" value="login" class="button" required/>
</form>
