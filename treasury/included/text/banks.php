<?php 

$colsArr = $controller->getBanks();

foreach($colsArr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>

<?php }; ?>