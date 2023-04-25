<?php 

$report = "<table>
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
  ?>