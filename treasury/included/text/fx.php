<?php 

$colsArr = $controller->getFX();
    
foreach($colsArr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>

<?php }; ?>