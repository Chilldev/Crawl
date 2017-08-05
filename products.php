<?php require_once 'handlers/check.php'; if(isset($_GET['tab'])) {$tab = $_GET['tab'];}else{$tab='tab1';}?>
<div class="tabs">
    <ul class="tab-links">
        <li id="atab1" class="active"><a href="products.php?tab=tab1&amp;p=1">New</a></li>
        <li id="atab2"><a href="products.php?tab=tab2&amp;p=1">Active</a></li>
        <li id="atab3"><a href="products.php?tab=tab3&amp;p=1">Archived</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab active">
            <?php if($tab=='tab1')require_once 'views/new.php';?>     
        </div>
        <div id="tab2" class="tab">
            <?php if($tab=='tab2')require_once 'views/active.php';?>     
        </div>
        <div id="tab3" class="tab">  
            <?php if($tab=='tab3') require_once 'views/archived.php';?>     
        </div>
    </div>
</div>
