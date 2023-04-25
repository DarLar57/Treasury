<?php 

$colsArr = $controller->getCurrencies();
    
foreach($colsArr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>

<?php }; ?>