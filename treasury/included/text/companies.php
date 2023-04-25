<?php 

$colsArr = $controller->getCompanies();
    
foreach($colsArr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>
$item
<?php }; ?>