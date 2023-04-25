<?php 

$colsArr = $controller->getMM();
    
foreach($colsArr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>

<?php }; ?>