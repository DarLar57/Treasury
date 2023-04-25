<?php 

$sql_pr = DB::$conn->query("SELECT * FROM INSTRUMENT WHERE SHORT_NAME = 'FX'"); // preparing, binding and executing sql statement
$cols_arr = array();
    while ($row = $sql_pr->fetch_assoc()) { // Next field
        array_push($cols_arr, $row['INSTRUMENT_NAME']); // Array with columns' names
    }
    
foreach($cols_arr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>

<?php }; ?>