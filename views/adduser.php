<?php 
$name;
if(isset($_GET)){extract($_GET);}
if(!isset($_SESSION)){session_start();}

if(isset($_SESSION['edituser'])){
    extract($_SESSION['edituser']);
    unset($_SESSION['edituser']);
    $name='edituser';
}else{
    $name='adduser';
}

?>

<div>
    <form action="handlers/user.php<?php if(isset($id)){echo'?id='.$id;} ?>" method="post" class="formstyle">
        <h1>Add User</h1>
        <label for="username">
            <span>
                Username
            </span>
        </label>
        <span style="color:green"><?php if(!empty($suc)){echo $suc;}?></span>
        <span style="color:red"> <?php if(!empty($usernamerr)){echo $usernamerr;}?></span>
        <input type="text" name="username" placeholder="Username" id="username" <?php if(!empty($username)){echo "value=\"$username\"";}?>/>

        <label for="email">
            <span>
                Email
            </span>
        </label>
        <span style="color:red"><?php if(!empty($emailerr)){echo $emailerr;}?></span>
        <input type="email" name="email" placeholder="User email" id="email"<?php if(!empty($email)){echo "value=\"$email\"";}?>/>

        <label for="password">
            <span>
                Password
            </span>
        </label>
        <span style="color:red"><?php if(!empty($passerr)){echo $passerr;}?></span>
        <input type="password" name="password" placeholder="User passwrod" id="password"/>
        
        <label for="user_type">
            <span>
                User type:
            </span>
        </label>

        <select id="user_type" name="usertype">
            <option>Editor</option>
            <option>Admin</option>
        </select>

        <input type="reset" value="Reset" class="button1"/>
        <input type="submit" value="add" name="<?php echo $name;?>" class="button1"/>       
    </form>
</div>
