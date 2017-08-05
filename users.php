<?php require_once 'handlers/check.php'; if(isset($_GET['tab'])) {$tab = $_GET['tab'];}else{$tab='tab1';}?>
<div class="tabs">
    <ul class="tab-links">
        <li id="atab1" class="active"><a href="users.php?tab=tab1">User</a></li>
        <li id="atab2"><a href="users.php?tab=tab2">Add User</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab active">
            <?php if($tab=='tab1')require_once 'views/users.php';?>
        </div>
        <div id="tab2" class="tab">
            <?php if($tab=='tab2')require_once 'views/adduser.php';?>
        </div>
    </div>
</div>
