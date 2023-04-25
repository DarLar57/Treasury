<?php

class DbOperations extends DB
{
    public static $conn;

    public function report($table, $where, $instr1, $instr2, $instr3, $instr4)
    {
        // preparing, binding and executing sql statement
        $sqlPrep = DB::$conn->prepare("SELECT * FROM $table $where"); 
        if ($where) {
            $sqlPrep->bind_param("ssss", $instr1, $instr2, $instr3, $instr4);
        }

        $sqlPrep->execute();
        return $sqlPrep;
    }

    public function insertMM($null, $instrMMInst, $instrColTran, $instrColStar, $instrColEndd, $instrColBase, $instrColBank, $instrColComp, $instrColMarg, $instrColAmou, $instrColCurr, $mm, $instrColComm)
    {
        // sql statement for MM transactions
        $sql = "INSERT INTO MONEY_MARKET 
        (ID, INSTRUMENT_NAME, TRANS_DATE, START_DATE, END_DATE, BASE_INTEREST_RATE, NAME_BANK,    NAME_COMPANY, MARGIN, AMOUNT, NAME_CURRENCY, SHORT_NAME, COMMENT) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql_pr = DB::$conn->prepare($sql);
        $sql_pr->bind_param("sssssssssssss", $null, $instrMMInst, $instrColTran, $instrColStar,  $instrColEndd, $instrColBase, $instrColBank, $instrColComp, $instrColMarg, $instrColAmou, $instrColCurr, $mm, $instrColComm);
        if ($sql_pr->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertFX($null, $instrFXInst, $instrColTran, $instrColSett, $instrColBank, $instrColComp, $instrColAmou, $instrColBuyc, $instrColSell, $instrColExch, $fx, $instrColComm)
    {
        // sql statement for FX transactions
        $sql = "INSERT INTO FOREIGN_EXCHANGE
            (ID, INSTRUMENT_NAME, TRANS_DATE, SETTLEMENT_DATE, NAME_BANK, NAME_COMPANY, AMOUNT, BUY_CURRENCY, SELL_CURRENCY, EXCHANGE_RATE, SHORT_NAME, COMMENT) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql_pr = DB::$conn->prepare($sql);
        $sql_pr->bind_param("ssssssssssss", $null, $instrFXInst, $instrColTran, $instrColSett, $instrColBank, $instrColComp, $instrColAmou, $instrColBuyc, $instrColSell, $instrColExch, $fx, $instrColComm);
        if ($sql_pr->execute()) {
            return true;
        } else {
            return false;
        }
    }
}