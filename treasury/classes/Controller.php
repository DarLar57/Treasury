<?php

class Controller
{
    public function getReport(): void
    {
        global $instr1;
        global $instr2; 
        global $instr3; 
        global $instr4;
        $j = 1;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // collecting value(s) of input field
            for ($j; $j <= 4; $j++) {
                ${'instr' . $j} = $_REQUEST['instr' . $j] ?? ""; // MM/FX type transaction
            }
            // to construct relevant query dependant on passed arguments (types fo deals, banks,         companies etc.)
        
            $i = 1;
            for ($i; $i < $j; $i++) {
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
            $this->checkErr($table);
            // preparing, binding and executing sql statement
            $sqlPrep = (new DbOperations)->report($table, $where, $instr1, $instr2,$instr3,     $instr4);
            $colsArr = [];
            $i = 0;
            if ($result = $sqlPrep->get_result()) { // Result set from the prepared statement
                while ($fieldinfo = $result->fetch_field()) { // Next field
                    $col = $fieldinfo->name; // Name of col.
                    array_push($colsArr, $col); // Array with columns' names
                    $i++;
                }
            }
            
            $this->buildReportTable($result, $colsArr);
            Db::$conn->close();
        }
    }

    function buildReportTable($result, $colsArr): void
    {
        echo '<script>filerTable();</script>';
        echo '<div class="sticky_top">Type to search the table ...
        <input id="inputFilter" type="text" placeholder="Search...">
        <br><br></div>';
        echo '<table><thead><tr>';
        
        for ($i = 0; $i < count($colsArr); $i++) {
            echo '<th class="sticky_under">' . $colsArr[$i] . "</th>"; // column names
        }
        
        echo '</tr></thead><tbody id="table_report">';
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            for ($i = 0; $i < count($colsArr); $i++) { // values of each record
                echo "<td>" . $row[$colsArr[$i]] . "</td>";
            }
            echo "</tr>";
        }
        
        echo "</tbody></table>";
    }

    function checkErr($table): void
    {
        function customError($errno, $errstr): void
        {
            echo "<b>Error:</b> [$errno] <br><br>$errstr<br>";
            echo "Script was ended";
            die();
        }
        
        //set error handler
        set_error_handler("customError", E_USER_WARNING);
        //trigger error
        if (!isset($table)) {
            trigger_error("<b>Ups</b>...Something went wrong, most likely <b>selection<b> is missing.<br><br><b>Please check</b>.</br>",E_USER_WARNING);
        }
    }
    public function insertDeal()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect values of input fields
            $instrTableMMFX = $_REQUEST['instr5'];
            $instrMMInst = $_REQUEST['instr6MM'] ?? "";
            $instrFXInst = $_REQUEST['instr6FX'] ?? "";
            $instrColComp = $_REQUEST['COMPANY'];
            $instrColBank = $_REQUEST['BANK'];
            $instrColAmou = $_REQUEST['AMOUNT'];
            $instrColTran = $_REQUEST['TRANS_DATE'];  
            $instrColStar = $_REQUEST['START_DATE'];
            $instrColEndd = $_REQUEST['END_DATE']; 
            $instrColBase = $_REQUEST['BASE_INTEREST_RATE'];
            $instrColMarg = $_REQUEST['MARGIN'];
            $instrColCurr = $_REQUEST['NAME_CURRENCY'] ?? "";   
            $instrColComm = $_REQUEST['COMMENT'];    
            $instrColSett = $_REQUEST['SETTLEMENT_DATE'];      
            $instrColBuyc = $_REQUEST['BUY_CURRENCY'] ?? "";      
            $instrColSell = $_REQUEST['SELL_CURRENCY'] ?? ""; 
            $instrColExch = $_REQUEST['EXCHANGE_RATE'];
        }
        
        switch ($instrTableMMFX) {
            case "MONEY_MARKET":
                $null = NULL;
                $mm = 'MM'; 
                
                $insert = (new DbOperations)->insertMM($null, $instrMMInst, $instrColTran, $instrColStar, $instrColEndd, $instrColBase, $instrColBank, $instrColComp, $instrColMarg, $instrColAmou, $instrColCurr, $mm, $instrColComm);
                // feedback after input
                include('../included/text/inserting_mm-report.php');
                
            break;
            case "FOREIGN_EXCHANGE": 
                $null = NULL;
                $fx = 'FX';

                $insert = (new DbOperations)->insertFX($null, $instrFXInst, $instrColTran, $instrColSett, $instrColBank, $instrColComp, $instrColAmou, $instrColBuyc, $instrColSell, $instrColExch, $fx, $instrColComm);
                // feedback after input
                include('../included/text/inserting_fx-report.php');
                
            break;
        }

        if ($insert == true) {
            echo $report;
        } else {
            echo "error <br>";
        } 

        Db::$conn->close();
    }

    public function modifyDeal() 
    {
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

            // catch and process '0' as value to modify Db
            if ($_REQUEST['BASE_INTEREST_RATE'] === '0') {
                $instrColBase = '0';
                $mm[] = $instrColBase;
            } else if (isset($_REQUEST['BASE_INTEREST_RATE'])) {
                (($instrColBase = $_REQUEST['BASE_INTEREST_RATE']) && $mm[] = $instrColBase);
            }

            isset($_REQUEST['BANK']) ? (($instrColBank = $_REQUEST['BANK']) && ($mm[] = $instrColBank) && ($fx[] = $instrColBank)):'';
            isset($_REQUEST['COMPANY']) ? (($instrColComp = $_REQUEST['COMPANY']) && ($mm[] = $instrColComp) && ($fx[] = $instrColComp)):'';

            // catch and process '0' as value to modify Db
            if ($_REQUEST['MARGIN'] === '0') {
                $instrColMarg = '0';
                $mm[] = $instrColBase;
            } else if (isset($_REQUEST['MARGIN'])) {
                (($instrColMarg = $_REQUEST['MARGIN']) && $mm[] = $instrColMarg);
            }

            // catch and process '0' as value to modify Db
            if ($_REQUEST['AMOUNT'] === '0') {
                $instrColAmou = '0';
                $mm[] = $instrColAmou;
                $fx[] = $instrColAmou;
            } else if (isset($_REQUEST['AMOUNT'])) {
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
            $countModifColMM = count($mm);
            $sNumberMM = str_repeat("s", $countModifColMM);
            $countModifColFX = count($fx);
            $sNumberFX = str_repeat("s", $countModifColFX);
        
            // checking by ID if Transaction to be changed exists in Db
            $errNoId = "<table><tr>
                <td><strong>Transaction</strong> with such <strong>ID</strong> does <strong>not</strong>exist in database !<br><br>
                Please check proper <strong>ID</strong> through Reporting option!
                </td></tr>
                </table>";
            
            if ($instrTableMMFX == "MONEY_MARKET") {
                $sql = (new DbOperations)->checkID("MONEY_MARKET", $instrColId);
                if ($sql == false) {
                    echo $errNoId;
                    die ();
                }
            } else {
                $sql = (new DbOperations)->checkID("FOREIGN_EXCHANGE", $instrColId);
                if ($sql == false) {
                    echo $errNoId;
                    die ();
                }
            }
        }
        
        switch ($instrTableMMFX) {
            case "MONEY_MARKET":
                // sql statement for MM transactions
                $insert = (new DbOperations)->updateMM($sNumberMM, $mm, $instrMMInst, $instrColTran, $instrColStar, $instrColEndd, $instrColBase, $instrColBank, $instrColComp, $instrColMarg, $instrColAmou, $instrColCurr, $instrColComm, $instrColId);
                
                // feedback after input
                include('../included/text/modyfying_mm-report.php');
                
            break;
            case "FOREIGN_EXCHANGE": 
        
            // sql statement for FX transactions      
            $insert = (new DbOperations)->updateFX($sNumberFX, $fx, $instrColTran, $instrColBank, $instrColComp, $instrColAmou, $instrColComm, $instrFXInst, $instrColSett, $instrColBuyc, $instrColSell, $instrColExch, $instrColId);

                // feedback after input
                include('../included/text/modyfying_fx-report.php');
                
            break;
        }
        if ($insert == true) {
            echo $report;
        } else {
            echo "error <br>";
        } 

        Db::$conn->close();
    }

    public function getBanks(): array
    {
        $colsArr = (new DbOperations)->getBanks();
        return $colsArr;
    }

    public function getCompanies(): array
    {
        $colsArr = (new DbOperations)->getCompanies();
        return $colsArr;
    }

    public function getCurrencies(): array
    {
        $colsArr = (new DbOperations)->getCurrencies();
        return $colsArr;
    }

    public function getFX(): array
    {
        $colsArr = (new DbOperations)->getFX();
        return $colsArr;
    }

    public function getMM(): array
    {
        $colsArr = (new DbOperations)->getMM();
        return $colsArr;
    }
}