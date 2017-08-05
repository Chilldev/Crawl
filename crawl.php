<?php require_once 'handlers/check.php'; if(isset($_GET['tab'])) {$tab = $_GET['tab'];}else{$tab='tab1';}?>
<div class="tabs">
    <ul class="tab-links">
        <li id="atab1" class="active"><a href="crawl.php?tab=tab1">Crawler</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab active">
            <?php if($tab=='tab1')require_once 'views/crawldata.php';?>
        </div>
    </div>
</div>
