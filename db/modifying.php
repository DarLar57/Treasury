<?php

include('../common/head_operations.php');
include('../initializing.php');

$instrColComp = "";
$instrColBank = "";
$instrMMInst = "";
$instrColCurr = "";
$instrFXInst = "";
$instrColSell = "";
$instrColBuyc = "";

// collect values of input fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mm = []; // catch POST MM Requests in arr
    $fx = []; // catch POST FX Requests in arr
    $instrTableMMFX = $_REQUEST['instr5'];    
    $instrColId = $_REQUEST['ID'];
    isset($_REQUEST['instr6MM']) ? (($instrMMInst = $_REQUEST['instr6MM']) && $mm[] = $instrMMInst):'';
    isset($_REQUEST['TRANS_DATE']) ? (($instrColTran = $_REQUEST['TRANS_DATE']) && ($mm[] = $instrColTran) && ($fx[] = $instrColTran)):'';
    isset($_REQUEST['START_DATE']) ? (($instrColStar = $_REQUEST['START_DATE']) && $mm[] = $instrColStar):'';
    isset($_REQUEST['END_DATE']) ? (($instrColEndd = $_REQUEST['END_DATE']) && $mm[] = $instrColEndd):'';
    // catch and process '0' as value to modify DB
    if ($_REQUEST['BASE_INTEREST_RATE'] === '0') {
        $instrColBase = '0';
        $mm[] = $instrColBase;
    }
    else if (isset($_REQUEST['BASE_INTEREST_RATE'])) {
        (($instrColBase = $_REQUEST['BASE_INTEREST_RATE']) && $mm[] = $instrColBase);
    }
    isset($_REQUEST['BANK']) ? (($instrColBank = $_REQUEST['BANK']) && ($mm[] = $instrColBank) && ($fx[] = $instrColBank)):'';
    isset($_REQUEST['COMPANY']) ? (($instrColComp = $_REQUEST['COMPANY']) && ($mm[] = $instrColComp) && ($fx[] = $instrColComp)):'';
    // catch and process '0' as value to modify DB
    if ($_REQUEST['MARGIN'] === '0') {
        $instrColMarg = '0';
        $mm[] = $instrColBase;
    }
    else if (isset($_REQUEST['MARGIN'])) {
        (($instrColMarg = $_REQUEST['MARGIN']) && $mm[] = $instrColMarg);
    }
    // catch and process '0' as value to modify DB
    if ($_REQUEST['AMOUNT'] === '0') {
        $instrColAmou = '0';
        $mm[] = $instrColAmou;
        $fx[] = $instrColAmou;
    }
    else if (isset($_REQUEST['AMOUNT'])) {
        (($instrColAmou = $_REQUEST['AMOUNT']) && ($mm[] = $instrColAmou) && ($fx[] = $instrColAmou));
    }
    isset($_REQUEST['NAME_CURRENCY']) ? (($instrColCurr = $_REQUEST['NAME_CURRENCY']) && $mm[] = $instrColCurr):'';
    isset($_REQUEST['COMMENT']) ? (($instrColComm = $_REQUEST['COMMENT']) && ($mm[] = $instrColComm) && ($fx[] = $instrColComm)):'';

    // FX
    isset($_REQUEST['instr6FX']) ? (($instrFXInst = $_REQUEST['instr6FX']) && $fx[] = $instrFXInst):'';
    isset($_REQUEST['SETTLEMENT_DATE']) ? (($instrColSett = $_REQUEST['SETTLEMENT_DATE']) && $fx[] = $instrColSett):'';
    isset($_REQUEST['BUY_CURRENCY']) ? (($instrColBuyc = $_REQUEST['BUY_CURRENCY']) && $fx[] = $instrColBuyc):'';  
    isset($_REQUEST['SELL_CURRENCY']) ? (($instrColSell = $_REQUEST['SELL_CURRENCY']) && $fx[] = $instrColSell):'';
    isset($_REQUEST['EXCHANGE_RATE']) ? (($instrColExch = $_REQUEST['EXCHANGE_RATE']) && $fx[] = $instrColExch):'';

    // number of changes for MM and FX
    $count_modif_col_mm = count($mm);
    $s_number_mm = str_repeat("s", $count_modif_col_mm);
    $count_modif_col_fx = count($fx);
    $s_number_fx = str_repeat("s", $count_modif_col_fx);

    // checking by ID if Transaction to be changed exists in DB
    $err_no_id = "<table>
        <tr>
        <td><strong>Transaction</strong> with such <strong>ID</strong> does <strong>not</strong> exist in database !<br><br>
        Please check proper <strong>ID</strong> through Reporting option!
        </td>
        </tr>
        </table>";
    
    if ($instrTableMMFX == "MONEY_MARKET") {
        $sql = "SELECT COUNT(*) FROM MONEY_MARKET WHERE ID = ?";
        $sql_pr = DB::$conn->prepare($sql);
        $sql_pr->bind_param("s", $instrColId);
        $sql_pr->execute();
        $result_mm = $sql_pr->get_result();
        $fieldinfo = $result_mm->fetch_row();
        
        if ($fieldinfo[0] == 0) {
            echo $err_no_id;
            die ();
        }

    } else {
        $sql = "SELECT COUNT(*) FROM FOREIGN_EXCHANGE WHERE ID = ?";
        $sql_pr = DB::$conn->prepare($sql);
        $sql_pr->bind_param("s", $instrColId);
        $sql_pr->execute();
        $result_mm = $sql_pr->get_result();
        $fieldinfo = $result_mm->fetch_row();

        if ($fieldinfo[0] == 0) {
            echo $err_no_id;
            die ();
        }
    }
}

switch ($instrTableMMFX) {
    case "MONEY_MARKET":
        // sql statement for MM transactions
        $sql = "UPDATE MONEY_MARKET SET " . 
        substr(trim(
        (!empty($instrMMInst) ? "INSTRUMENT_NAME = ?, " : "") . 
        (!empty($instrColTran) ? "TRANS_DATE = ?, " : "") . 
        (!empty($instrColStar) ? "START_DATE = ?, " : "") .
        (!empty($instrColEndd) ? "END_DATE = ?, " : "") .
        (!empty($instrColBase) ? "BASE_INTEREST_RATE = ?, " : (($instrColBase == '0') ? "BASE_INTEREST_RATE = ?, " : "")) .
        (!empty($instrColBank) ? "NAME_BANK = ?, " : "") .
        (!empty($instrColComp) ? "NAME_COMPANY = ?, " : "") .
        (!empty($instrColMarg) ? "MARGIN = ?, " : (($instrColMarg == '0') ? "MARGIN = ?, " : "")) .
        (!empty($instrColAmou) ? "AMOUNT = ?, " : (($instrColAmou == '0') ? "AMOUNT = ?, " : "")) .
        (!empty($instrColCurr) ? "NAME_CURRENCY = ?, " : "") .
        (!empty($instrColComm) ? "COMMENT = ?, " : "")), 0, -1) .
        " WHERE ID = $instrColId";

        $sql_pr = DB::$conn->prepare($sql);
        $sql_pr->bind_param("$s_number_mm", ...$mm);
        // feedback after input
       
        include('../included/text/modyfying_mm-report.php');
        
    break;
    case "FOREIGN_EXCHANGE": 

// sql statement for FX transactions      
$sql = "UPDATE FOREIGN_EXCHANGE SET " . 
        substr(trim(
        (!empty($instrColTran) ? "TRANS_DATE = ?, " : "") . 
        (!empty($instrColBank) ? "NAME_BANK = ?, " : "") .
        (!empty($instrColComp) ? "NAME_COMPANY = ?, " : "") .
        (!empty($instrColAmou) ? "AMOUNT = ?, " : (($instrColAmou == '0') ? "AMOUNT = ?, " : "")) .
        (!empty($instrColComm) ? "COMMENT = ?, " : "") .
        (!empty($instrFXInst) ? "INSTRUMENT_NAME = ?, " : "") . 
        (!empty($instrColSett) ? "SETTLEMENT_DATE = ?, " : "") .
        (!empty($instrColBuyc) ? "BUY_CURRENCY = ?, " : "") .
        (!empty($instrColSell) ? "SELL_CURRENCY = ?, " : "") .
        (!empty($instrColExch) ? "EXCHANGE_RATE = ?, " : "")), 0, -1) .
        " WHERE ID = $instrColId";
       
        $sql_pr = DB::$conn->prepare($sql);
        $sql_pr->bind_param("$s_number_fx", ...$fx);
        // feedback after input
        
        include('../included/text/modyfying_fx-report.php');
        
    break;
}
if ($sql_pr->execute()) {
    echo $report;
} else {echo "Error: <br>";
  }

  DB::$conn->close();
?>