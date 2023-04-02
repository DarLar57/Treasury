<?php
include('./common/head.php');
include('./included/db/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// collect values of input fields
    $instrTableMMFX = $_REQUEST['instr5'];
    $instrMMInst = $_REQUEST['instr6MM'];
    $instrFXInst = $_REQUEST['instr6FX'];
    $instrColComp = $_REQUEST['COMPANY'];
    $instrColBank = $_REQUEST['BANK'];
    $instrColAmou = $_REQUEST['AMOUNT'];
    $instrColTran = $_REQUEST['TRANS_DATE'];  
    $instrColStar = $_REQUEST['START_DATE'];
    $instrColEndd = $_REQUEST['END_DATE']; 
    $instrColBase = $_REQUEST['BASE_INTEREST_RATE'];
    $instrColMarg = $_REQUEST['MARGIN'];
    $instrColCurr = $_REQUEST['NAME_CURRENCY'];   
    $instrColComm = $_REQUEST['COMMENT'];    
    $instrColSett = $_REQUEST['SETTLEMENT_DATE'];      
    $instrColBuyc = $_REQUEST['BUY_CURRENCY'];      
    $instrColSell = $_REQUEST['SELL_CURRENCY']; 
    $instrColExch = $_REQUEST['EXCHANGE_RATE'];
} 
switch ($instrTableMMFX) {
    case "MONEY_MARKET":
        $null = NULL;
        $mm = 'MM'; 
// sql statement for MM transactions
        $sql = "INSERT INTO MONEY_MARKET 
            (ID, INSTRUMENT_NAME, TRANS_DATE, START_DATE, END_DATE, BASE_INTEREST_RATE, NAME_BANK, NAME_COMPANY, MARGIN, AMOUNT, NAME_CURRENCY, SHORT_NAME, COMMENT) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql_pr = $conn->prepare($sql);
        $sql_pr->bind_param("sssssssssssss", $null, $instrMMInst, $instrColTran, $instrColStar, $instrColEndd, $instrColBase, $instrColBank, $instrColComp, $instrColMarg, $instrColAmou, $instrColCurr, $mm, $instrColComm);
// feedback after input
        $report = 
        "<table>
        <tr>
          <td>
          New <strong>MM</strong> record created successfully.<br>
          </td>
        </tr>
        <tr>
          <td>
          SQL instruction was submitted.<br>
          </td>
        </tr>
        <tr>
          <td>
          <strong>Details:</strong><br>
          </td>
        </tr>
        <tr>
          <td>
          Company: <strong>$instrColComp</strong><br>
          Bank: <strong>$instrColBank</strong><br>
          Instrument: <strong>$instrMMInst</strong><br>
          Transaction date: <strong>$instrColTran</strong><br>
          Start date: <strong>$instrColStar</strong><br>
          End date: <strong>$instrColEndd</strong><br>
          Amount: <strong>$instrColAmou</strong><br>
          Currency: <strong>$instrColCurr</strong><br>
          Interest rate: <strong>$instrColBase</strong><br>
          Margin: <strong>$instrColMarg</strong><br>
          Type of transaction: <strong>MM</strong><br>
          Comment: <strong>$instrColComm</strong><br>
          </td>
        </tr>
        </table>";
    break;
    case "FOREIGN_EXCHANGE": 
// sql statement for FX transactions
        $null = NULL;
        $fx = 'FX';
        $sql = "INSERT INTO FOREIGN_EXCHANGE
            (ID, INSTRUMENT_NAME, TRANS_DATE, SETTLEMENT_DATE, NAME_BANK, NAME_COMPANY, AMOUNT, BUY_CURRENCY, SELL_CURRENCY, EXCHANGE_RATE, SHORT_NAME, COMMENT) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql_pr = $conn->prepare($sql);
        $sql_pr->bind_param("ssssssssssss", $null, $instrFXInst, $instrColTran, $instrColSett, $instrColBank, $instrColComp, $instrColAmou, $instrColBuyc, $instrColSell, $instrColExch, $fx, $instrColComm);
// feedback after input
        $report = 
        "<table>
        <tr>
          <td>
          New <strong>FX</strong> record created successfully.<br>
          </td>
        </tr>
        <tr>
          <td>
          SQL instruction was submitted.<br>
          </td>
        </tr>
        <tr>
          <td>
          <strong>Details:</strong><br>
          </td>
        </tr>
        <tr>
          <td>
          Company: <strong>$instrColComp</strong><br>
          Bank: <strong>$instrColBank</strong><br>
          Instrument: <strong>$instrFXInst</strong><br>
          Transaction date: <strong>$instrColTran</strong><br>
          Settlement date: <strong>$instrColSett</strong><br>
          Amount: <strong>$instrColAmou</strong><br>
          Currency bought: <strong>$instrColBuyc</strong><br>
          Currency sold: <strong>$instrColSell</strong><br>
          Exchange rate: <strong>$instrColExch</strong><br>
          Type of transaction: <strong>FX</strong><br>
          <br>Comment: <strong>$instrColComm</strong><br>
          </td>
        </tr>
        </table>";
    break;
}
if ($sql_pr->execute()) {
    echo $report;
} 
else echo "Error: <br>";
$conn->close();
?>