<?php require_once 'handlers/check.php'; if(isset($_GET['tab'])) {$tab = $_GET['tab'];}else{$tab='tab1';}?>
<div class="tabs">
    <ul class="tab-links">
        <li id="atab1" class="active"><a href="supplier.php?tab=tab1">Add Supplier</a></li>
        <li id="atab2"><a href="supplier.php?tab=tab2">Edit Supplier</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab active">
            <?php if($tab=='tab1')include'views/add_site.php';?>
        </div>
        <div id="tab2" class="tab">
            <?php if($tab=='tab2')include'views/update_site.php';?>
        </div>
    </div>
</div>
