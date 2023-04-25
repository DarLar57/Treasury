<?php 

$sql_pr = DB::$conn->query("SELECT * FROM BANK"); // preparing, binding and executing sql statement
$cols_arr = array();
    while ($row = $sql_pr->fetch_assoc()) { // Next field
        array_push($cols_arr, $row['NAME_BANK']); // Array with columns' names
    }

foreach($cols_arr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>

<?php }; ?>