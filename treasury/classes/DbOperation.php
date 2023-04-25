<?php

class DbOperations extends Db
{
    public static $conn;

    public function report(
        $table, 
        $where, 
        $instr1, 
        $instr2, 
        $instr3, 
        $instr4)
    {
        // preparing, binding and executing sql statement
        $sqlPrep = Db::$conn->prepare("SELECT * FROM $table $where"); 
        if ($where) {
            $sqlPrep->bind_param("ssss", $instr1, $instr2, $instr3, $instr4);
        }

        $sqlPrep->execute();
        return $sqlPrep;
    }

    public function insertMM(
        $null, 
        $instrMMInst, 
        $instrColTran, 
        $instrColStar, 
        $instrColEndd, 
        $instrColBase, 
        $instrColBank, 
        $instrColComp, 
        $instrColMarg, 
        $instrColAmou, 
        $instrColCurr, 
        $mm, 
        $instrColComm): bool
    {
        // sql statement for MM transactions
        $sql = "INSERT INTO MONEY_MARKET 
        (ID, INSTRUMENT_NAME, TRANS_DATE, START_DATE, END_DATE, BASE_INTEREST_RATE, NAME_BANK,    NAME_COMPANY, MARGIN, AMOUNT, NAME_CURRENCY, SHORT_NAME, COMMENT) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sqlPrep = Db::$conn->prepare($sql);
        $sqlPrep->bind_param("sssssssssssss", $null, $instrMMInst, $instrColTran, $instrColStar,  $instrColEndd, $instrColBase, $instrColBank, $instrColComp, $instrColMarg, $instrColAmou, $instrColCurr, $mm, $instrColComm);
        if ($sqlPrep->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertFX(
        $null, 
        $instrFXInst, 
        $instrColTran, 
        $instrColSett, 
        $instrColBank, 
        $instrColComp, 
        $instrColAmou, 
        $instrColBuyc, 
        $instrColSell, 
        $instrColExch, 
        $fx, 
        $instrColComm): bool
    {
        // sql statement for FX transactions
        $sql = "INSERT INTO FOREIGN_EXCHANGE
            (ID, INSTRUMENT_NAME, TRANS_DATE, SETTLEMENT_DATE, NAME_BANK, NAME_COMPANY, AMOUNT, BUY_CURRENCY, SELL_CURRENCY, EXCHANGE_RATE, SHORT_NAME, COMMENT) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sqlPrep = Db::$conn->prepare($sql);
        $sqlPrep->bind_param("ssssssssssss", $null, $instrFXInst, $instrColTran, $instrColSett, $instrColBank, $instrColComp, $instrColAmou, $instrColBuyc, $instrColSell, $instrColExch, $fx, $instrColComm);
        if ($sqlPrep->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkID($instrument, $instrColId): bool
    {
        $sql = "SELECT COUNT(*) FROM $instrument WHERE ID = ?";
        $sqlPrep = Db::$conn->prepare($sql);
        $sqlPrep->bind_param("s", $instrColId);
        $sqlPrep->execute();
        $resultMM = $sqlPrep->get_result();
        $fieldinfo = $resultMM->fetch_row();
        
        if ($fieldinfo[0] == 0) {
            return false;
        } else return true;
    }

    public function updateMM(
        $sNumberMM, 
        $mm, 
        $instrMMInst, 
        $instrColTran, 
        $instrColStar, 
        $instrColEndd, 
        $instrColBase, 
        $instrColBank, 
        $instrColComp, 
        $instrColMarg, 
        $instrColAmou, 
        $instrColCurr, 
        $instrColComm, 
        $instrColId): bool
    {
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
        
        $sqlPrep = Db::$conn->prepare($sql);
        $sqlPrep->bind_param("$sNumberMM", ...$mm);
        
        if ($sqlPrep->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateFX(
        $sNumberFX, 
        $fx,
        $instrColTran,
        $instrColBank,
        $instrColComp,
        $instrColAmou,
        $instrColComm,
        $instrFXInst,
        $instrColSett,
        $instrColBuyc,
        $instrColSell,
        $instrColExch,
        $instrColId): bool
    {
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
               
        $sqlPrep = Db::$conn->prepare($sql);
        $sqlPrep->bind_param("$sNumberFX", ...$fx);

        if ($sqlPrep->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getBanks(): array
    {
        $sqlPrep = Db::$conn->query("SELECT * FROM BANK"); // preparing, binding and executing sql statement
        $colsArr = array();
            while ($row = $sqlPrep->fetch_assoc()) { // Next field
                array_push($colsArr, $row['NAME_BANK']); // Array with columns' names
            }
        return $colsArr;
    }
    
    public function getCompanies(): array
    {
        $sqlPrep = Db::$conn->query("SELECT * FROM COMPANY"); // preparing, binding and executing sql statement
        $colsArr = array();
            while ($row = $sqlPrep->fetch_assoc()) { // Next field
                array_push($colsArr, $row['NAME_COMPANY']); // Array with columns' names
            }
        return $colsArr;
    }

    public function getCurrencies(): array
    {
        $sqlPrep = Db::$conn->query("SELECT * FROM CURRENCY"); // preparing, binding and executing sql statement
        $colsArr = array();
            while ($row = $sqlPrep->fetch_assoc()) { // Next field
                array_push($colsArr, $row['NAME_CURRENCY']); // Array with columns' names
            }
        return $colsArr;
    }

    public function getFX(): array
    {
        $sqlPrep = Db::$conn->query("SELECT * FROM INSTRUMENT WHERE SHORT_NAME = 'FX'"); // preparing, binding and executing sql statement
        $colsArr = array();
            while ($row = $sqlPrep->fetch_assoc()) { // Next field
                array_push($colsArr, $row['INSTRUMENT_NAME']); // Array with columns' names
            }
        return $colsArr;
    }
    public function getMM(): array
    {
        $sqlPrep = Db::$conn->query("SELECT * FROM INSTRUMENT WHERE SHORT_NAME = 'MM'"); // preparing, binding and executing sql statement
        $colsArr = array();
            while ($row = $sqlPrep->fetch_assoc()) { // Next field
                array_push($colsArr, $row['INSTRUMENT_NAME']); // Array with columns' names
            }
        return $colsArr;
    }
}