<?php

include('../common/head_operations.php');
include('../../treasury/initializing.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_REQUEST['instr4'])) {
    $controller->getReport();
} else if ($_SERVER["REQUEST_METHOD"] == "POST" & ($_REQUEST['ModifyOrInsert'] == "Insert")) {
    $controller->insertDeal();
}
  else if ($_SERVER["REQUEST_METHOD"] == "POST" & ($_REQUEST['ModifyOrInsert'] == "Modify")) {
$controller->modifyDeal();
}