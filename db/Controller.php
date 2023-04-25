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
            
            DB::$conn->close();
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
        if ($insert == true) 
            echo $report;
        else {
            echo "error <br>";
            } 
            DB::$conn->close();
    }
}