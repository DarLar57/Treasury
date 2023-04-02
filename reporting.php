<?php
include('./common/head.php');
include('./included/db/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// collecting value(s) of input field
    $instr1 = $_REQUEST['instr1'] ?? ""; // MM/FX type transaction
    $instr2 = $_REQUEST['instr2'] ?? ""; // MM/FX type transaction
    $instr3 = $_REQUEST['instr3'] ?? ""; // MM/FX type transaction
    $instr4 = $_REQUEST['instr4'] ?? ""; // selected DB table (MONEY_MARKET, COMPANY etc.)
} 
// to construct relevant query dependant on passed arguments (types fo deals, banks, companies etc.)
for ($i = 1; $i <= 4; $i++) {
    switch (${'instr' . $i}) {
        case "DEPO":
        case "LOAN":
        case "CREDIT":
            $table = "MONEY_MARKET";
            $where = "WHERE INSTRUMENT_NAME IN (?,?,?,?)";  
            break;
        case "SPOT":
        case "FORWARD":
        case "FORWARD_NDF":
            $table = "FOREIGN_EXCHANGE";
            $where = "WHERE INSTRUMENT_NAME IN (?,?,?,?)";  
            break;
        case "COMPANY":
            $table = "COMPANY";
            $where ="";
            break;
        case "BANK":
            $table = "BANK";
            $where ="";
            break;
        case "CURRENCY":
            $table = "CURRENCY";
            $where ="";
            break;
        case "INSTRUMENT":
            $table = "INSTRUMENT";
            $where ="";
            break;
        case "TRANSACTION_TYPE":
            $table = "TRANSACTION_TYPE";
            $where ="";
            break;
        case "COUNTRY":
            $table = "COUNTRY";
            $where ="";  
  }
}
function customError($errno, $errstr) {
    echo "<b>Error:</b> [$errno] <br><br>$errstr<br>";
    echo "Script was ended";
    die();
}
//set error handler
set_error_handler("customError",E_USER_WARNING);
//trigger error
if (!isset($table)) {
    trigger_error("<b>Ups</b>...Something went wrong, most likely <b>selection</b> is missing.<br><br><b>Please check</b>.</br>",E_USER_WARNING);
}
$sql_pr = $conn->prepare("SELECT * FROM $table $where"); // preparing, binding and executing sql statement
if ($where) {
    $sql_pr->bind_param("ssss", $instr1, $instr2, $instr3, $instr4);
}
$sql_pr->execute();
$cols_arr = array();
$i = 0;
if ($result_mm = $sql_pr->get_result()) { // Result set from the prepared statement
    while ($fieldinfo = $result_mm->fetch_field()) { // Next field
        $d = $fieldinfo->name; // Name of col.
        array_push($cols_arr, $d); // Array with columns' names
        $i++;
    }
}
echo '<script>
$(document).ready(function(){
  $("#inputFilter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table_report tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>';
echo '<div class="sticky_top">Type to search the table ...
<input id="inputFilter" type="text" placeholder="Search...">
<br><br></div>';
echo '<table><thead><tr>';
for ($i = 0; $i < count($cols_arr); $i++) {
    echo '<th class="sticky_under">' . $cols_arr[$i] . "</th>"; // column names
}
echo '</tr></thead><tbody id="table_report">';
while ($row = $result_mm->fetch_assoc()) {
    echo "<tr>";
    for ($i = 0; $i < count($cols_arr); $i++) { // values of each record
        echo "<td>" . $row[$cols_arr[$i]] . "</td>";
        }
    echo "</tr>";
}
echo "</tbody></table>";
$conn->close();
?>