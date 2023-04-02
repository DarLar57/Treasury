// to scroll screen to center a clicked element
function hyperlink(e) {
  document
    .getElementById(e)
    .scrollIntoView({ behavior: "smooth", block: "center" });
}
// Reporting display
function add_reporting() {
  hideReportDisplay();
  $("#Reporting_1").css("display", "block");
  $("#Treasury-container").css("display", "block");
  $("#Report_insert2").css("display", "none");
  unhideOther();
  $("#Reporting_2").css("display", "none");
  $("#Reporting_submit").css("display", "none");
  $("#inserting_deals").css("display", "none");
  $("#Reporting").html("Reporting:");
  $("#mmfx_instr").html("<h5>Choose Type of Table to report</h5>");
  $("#lMM").html("Money Market (MM)");
  $("#lFX").html("Foreign Exchange (FX)");
  $("#lCOMPANY").html("Companies");
  $("#lBANK").html("Banks");
  $("#lCURRENCY").html("Currencies");
  $("#lINSTRUMENT").html("All Financial Instruments");
  $("#lTRANSACTION_TYPE").html("All Types of Transactions");
  $("#lCOUNTRY").html("Countries of Counterparties");
  hyperlink("Treasury-container");
}
// Reporting (MM) display
function add_mm() {
  //hideReportDisplay();
  $("#Reporting_2").css("display", "block");
  $("#Reporting_submit").css("display", "none");
  $("#instrument").html("Choose MM Instrument:");
  $("#linstr1").html("Deposit");
  $("#linstr2").html("Loan");
  $("#linstr3").html("Bank Credit");
  $("#instr1").val("DEPO");
  $("#instr2").val("LOAN");
  $("#instr3").val("CREDIT");
  uncheck();
}
// Reporting (FX) display
function add_fx() {
  hideReportDisplay();
  $("#Reporting_2").css("display", "block");
  $("#Reporting_submit").css("display", "none");
  $("#instrument").html("Choose FX Instrument:");
  $("#linstr1").html("FX Spot");
  $("#linstr2").html("FX Forward");
  $("#linstr3").html("FX Forward (NDF)");
  $("#instr1").val("SPOT");
  $("#instr2").val("FORWARD");
  $("#instr3").val("FORWARD_NDF");
  uncheck();
}
// Reporting (Other) display
function add_other() {
  hideReportDisplay();
  $("#instr1").val("");
  $("#instr2").val("");
  $("#instr3").val("");
  $("#Reporting_submit").css("display", "block");
  $("#Reporting_2").css("display", "none");
  $("#linstr1").html("");
  $("#linstr2").html("");
  $("#linstr3").html("");
}
// Uncheck MM/FX Instruments
function uncheck() {
  $("#instr1").prop("checked", false);
  $("#instr2").prop("checked", false);
  $("#instr3").prop("checked", false);
}
function showSubmitButton() {
  $("#Reporting_submit").css("display", "block");
  $("#Report_display").css("display", "none");
}
function showReportDisplay() {
  $("#Report_display").css("display", "block");
}
function hideReportDisplay() {
  clearReportDisplay();
  $("#Report_display").css("display", "none");
}
function clearReportDisplay() {
  $("#display").contents().find("body").html('');
}
function commonAddInputModify() {
  $("#Reporting_1").css("display", "none");
  $("#Reporting_2").css("display", "none");
  $("#Reporting_submit").css("display", "none");
  $("#Treasury-container").css("display", "block");
  $("#inserting_deals").css("display", "block");
  $("#inserting_deals_h5").html("Select Type of Transaction");
  $("#Report_insert2").css("display", "block");
  $("#Reporting_submit_2").css("display", "none");
  $("#myForm2_2").css("display", "none");
  $("#lMM2").html("Money Market (MM)");
  $("#lFX2").html("Foreign Exchange (FX)");
  hideOther();
  todays();
  check_date();
  hyperlink("Treasury-container");
}
// Input Deals display
function add_input() {
  hideReportDisplay();
  $("#Report_insert2_h2").html("Deal's Input:");
  commonAddInputModify();
  $("#myForm2").attr("action", "inserting.php");
  $("#MM2").attr("onclick", "add_mm_2()");
  $("#FX2").attr("onclick", "add_fx_2()");
}
// Modify Deals display
function add_modify() {
  hideReportDisplay();
  $("#Report_insert2_h2").html("Deal's Modification:");
  commonAddInputModify();
  $("#myForm2").attr("action", "modifying.php");
  $("#MM2").attr("onclick", "add_modify_mm_2()");
  $("#FX2").attr("onclick", "add_modify_fx_2()");
  unhideID();
  $("#INS_O_MM").prop("required", false);
  $("#S_Date").prop("required", false);
  $("#E_Date").prop("required", false);
  $("#Int_r").prop("required", false);
  $("#Curr").prop("required", false);
  $("#INS_O_FX").prop("required", false);
  $("#Setl_Date").prop("required", false);
  $("#Buy").prop("required", false);
  $("#Sell").prop("required", false);
  $("#Exchange").prop("required", false);
  clearInputs();
}
// Modify Deals (MM) display
function add_modify_mm_2() {
  hideReportDisplay();
  hyperlink("T_Date");
  $("#myForm2_2").css("display", "block");
  $("#myForm2").css("display", "block");
  $("#INS_O_FX").css("display", "none");
  $("#lINS_O_FX").css("display", "none");
  $("#INS_O_MM").css("display", "inline");
  $("#lINS_O_MM").css("display", "inline");
  $("#instrument2").css("display", "block");
  $("#instrument2").html("Choose ID of Instrument to be modified:");
  $("#Reporting_submit_2").css("display", "block");
  $("#mm_addintional_data").css("display", "block");
  $("#fx_addintional_data").css("display", "none");
  $("#MM2").val("MONEY_MARKET");
  $("#COM_O").prop("required", false);
  $("#BAN_O").prop("required", false);
  $("#Amount").prop("required", false);
  $("#T_Date").prop("required", false);
  $("#S_Date").prop("required", false);
  $("#E_Date").prop("required", false);
  $("#Int_r").prop("required", false);
  $("#Curr").prop("required", false);
  $("#INS_O_MM").prop("required", false);
  $("#Margin").prop("required", false);
  $("#Curr").prop("required", false);
  clearFXInputs();
}
// Modify Deals (FX) display
function add_modify_fx_2() {
  hideReportDisplay();
  hyperlink("T_Date");
  $("#myForm2_2").css("display", "block");
  $("#myForm2").css("display", "block");
  $("#INS_O_FX").css("display", "inline");
  $("#lINS_O_FX").css("display", "inline");
  $("#INS_O_MM").css("display", "none");
  $("#lINS_O_MM").css("display", "none");
  $("#instrument2").css("display", "block");
  $("#instrument2").html("Choose ID of Instrument to be modified:");
  $("#Reporting_submit_2").css("display", "block");
  $("#mm_addintional_data").css("display", "none");
  $("#fx_addintional_data").css("display", "block");
  $("#FX2").val("FOREIGN_EXCHANGE");
  $("#COM_O").prop("required", false);
  $("#BAN_O").prop("required", false);
  $("#Amount").prop("required", false);
  $("#T_Date").prop("required", false);
  $("#S_Date").prop("required", false);
  $("#E_Date").prop("required", false);
  $("#Int_r").prop("required", false);
  $("#Curr").prop("required", false);
  $("#INS_O_MM").prop("required", false);
  $("#Margin").prop("required", false);
  $("#Curr").prop("required", false);
}
function hideOther() {
  $("#lCOUNTRY").css("display", "none");
  $("#lCOMPANY").css("display", "none");
  $("#lBANK").css("display", "none");
  $("#lCURRENCY").css("display", "none");
  $("#lINSTRUMENT").css("display", "none");
  $("#lTRANSACTION_TYPE").css("display", "none");
  $("#COU").css("display", "none");
  $("#COM").css("display", "none");
  $("#BAN").css("display", "none");
  $("#CUR").css("display", "none");
  $("#INS").css("display", "none");
  $("#TRA").css("display", "none");
}
function unhideOther() {
  $("#lCOUNTRY").css("display", "inline");
  $("#lCOMPANY").css("display", "inline");
  $("#lBANK").css("display", "inline");
  $("#lCURRENCY").css("display", "inline");
  $("#lINSTRUMENT").css("display", "inline");
  $("#lTRANSACTION_TYPE").css("display", "inline");
  $("#COU").css("display", "inline");
  $("#COM").css("display", "inline");
  $("#BAN").css("display", "inline");
  $("#CUR").css("display", "inline");
  $("#INS").css("display", "inline");
  $("#TRA").css("display", "inline");
}
// Input Deals (MM) display
function add_mm_2() {
  hideReportDisplay();
  hyperlink("T_Date");
  clearInputs();
  clear_hideID();
  $("#myForm2_2").css("display", "block");
  $("#myForm2").css("display", "block");
  $("#INS_O_FX").css("display", "none");
  $("#lINS_O_FX").css("display", "none");
  $("#INS_O_MM").css("display", "inline");
  $("#lINS_O_MM").css("display", "inline");
  $("#instrument2").css("display", "block");
  $("#instrument2").html("Choose MM Instrument:");
  $("#Reporting_submit_2").css("display", "block");
  $("#mm_addintional_data").css("display", "block");
  $("#fx_addintional_data").css("display", "none");
  $("#MM2").val("MONEY_MARKET");
  $("#INS_O_MM").prop("required", true);
  $("#S_Date").prop("required", true);
  $("#E_Date").prop("required", true);
  $("#Int_r").prop("required", true);
  $("#Curr").prop("required", true);
  $("#COM_O").prop("required", true);
  $("#BAN_O").prop("required", true);
  $("#Amount").prop("required", true);
  $("#INS_O_FX").prop("required", false);
  $("#Setl_Date").prop("required", false);
  $("#Buy").prop("required", false);
  $("#Sell").prop("required", false);
  $("#Exchange").prop("required", false);
}
// Input Deals (FX) display
function add_fx_2() {
  hideReportDisplay();
  hyperlink("T_Date");
  clearInputs();
  clear_hideID();
  $("#myForm2_2").css("display", "block");
  $("#myForm2").css("display", "block");
  $("#INS_O_MM").css("display", "none");
  $("#lINS_O_MM").css("display", "none");
  $("#INS_O_FX").css("display", "inline");
  $("#lINS_O_FX").css("display", "inline");
  $("#instrument2").css("display", "block");
  $("#instrument2").html("Choose FX Instrument:");
  $("#Reporting_submit_2").css("display", "block");
  $("#fx_addintional_data").css("display", "block");
  $("#mm_addintional_data").css("display", "none");
  $("#FX2").val("FOREIGN_EXCHANGE");
  $("#INS_O_FX").prop("required", true);
  $("#Setl_Date").prop("required", true);
  $("#Buy").prop("required", true);
  $("#Sell").prop("required", true);
  $("#Exchange").prop("required", true);
  $("#INS_O_MM").prop("required", false);
  $("#S_Date").prop("required", false);
  $("#E_Date").prop("required", false);
  $("#Int_r").prop("required", false);
  $("#Curr").prop("required", false);
}
function clear_hideID() {
  $("#lINS_O_MM_ID").css("display", "none");
  $("#ID").val("");
  $("#ID").prop("required", false);
  $("#ID").css("display", "none");
}
function unhideID() {
  $("#lINS_O_MM_ID").css("display", "inline");
  $("#ID").val("");
  $("#ID").prop("required", true);
  $("#ID").css("display", "inline");
}
function clearMMInputs() {
  //$("#MM2").val("");
  $("#INS_O_MM").val("");
  $("#S_Date").val("");
  $("#E_Date").val("");
  $("#Int_r").val("");
  $("#Margin").val("");
  $("#Curr").val("");
}
function clearFXInputs() {
  //$("#FX2").val("");
  $("#INS_O_FX").val("");
  $("#Setl_Date").val("");
  $("#Buy").val("");
  $("#Sell").val("");
  $("#Exchange").val("");
}
// Reset values (MM/FX)
function clearInputs() {
  clearMMInputs();
  clearFXInputs();
  $("#ID").val("");
  $("#COM_O").val("");
  $("#BAN_O").val("");
  $("#Amount").val("");
  $("#Comm").val("");
}
// Dynamically adding Market Data (containers, could be more than 1) and a button to delete the iframe
var i = 0;
function market() {
  hyperlink("divMarket");
  var e_h2 = document.createElement("h2");
  e_h2.value = i;
  i++;
  e_h2.innerText = "Market Data - frame #" + i;
  var divMarket = document.getElementById("divMarket");
  divMarket.appendChild(e_h2);
  const e_iframe = document.createElement("iframe");
  e_iframe.id = "market " + i;
  e_iframe.src =
    "https://www.wsj.com/market-data/quotes/fx/EURUSD?mod=md_home_overview_quote";
  divMarket.appendChild(e_iframe);
  var e_button = document.createElement("button");
  e_button.id = "e_button " + i;
  e_button.innerText = "Delete";
  e_button.addEventListener("click", function () {
    e_h2.remove();
    e_iframe.remove();
  });
  e_h2.appendChild(e_button);
}
// setting Transaction Date as today (default) for MM and FX
function todays() {
  var date = new Date();
  var day = date.getDate();
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  if (month < 10) month = "0" + month;
  if (day < 10) day = "0" + day;
  var today = year + "-" + month + "-" + day;
  document.getElementById("T_Date").value = today;
}
// setting algorythm to disable End Date = or < Start Date for MM and FX
function check_date() {
  S_Date = document.getElementById("S_Date");
  E_Date = document.getElementById("E_Date");
  S_Date = S_Date.onchange = function () {
    const date = this.valueAsDate;
    date.setDate(date.getDate() + 1);
    document.getElementById("E_Date").min =
      date.getFullYear().toString() +
      "-" +
      (date.getMonth() + 1).toString().padStart(2, 0) +
      "-" +
      date.getDate().toString().padStart(2, 0);
  };
}
// not to allow improper inserting of Currency Pairs
function check_currency() {
  if (
    document.getElementById("Sell").value ==
    document.getElementById("Buy").value
  ) {
    document.getElementById("Sell").style.backgroundColor = "red";
    document.getElementById("Buy").style.backgroundColor = "red";
    if (document.getElementById("Sell").value != (null || ""))
      alert("Currency pair cannot have the same values !");
  } else {
    if (document.getElementById("Sell").value != (null || ""))
      document.getElementById("Sell").style.backgroundColor = "aquamarine";
    if (document.getElementById("Buy").value != (null || ""))
      document.getElementById("Buy").style.backgroundColor = "aquamarine";
  }
  if (document.getElementById("Sell").value == (null || "")) {
    document.getElementById("Sell").style.backgroundColor = "aquamarine";
  }
  if (document.getElementById("Buy").value == (null || "")) {
    document.getElementById("Buy").style.backgroundColor = "aquamarine";
  }
}
// time display since last reload of page

(function reloadTime() {
  var sec = 0,
    min = 0,
    hour = 0;
  function sessionTime() {
    sec++;
    if (sec == 60) {
      sec = 0;
      min++;
    }
    if (min == 60) {
      min = 0;
      hour++;
    }
    document.getElementById("sessionTiming").innerText =
      "Since app reload: " +
      String(hour).padStart(2, "0") +
      ":" +
      String(min).padStart(2, "0") +
      ":" +
      String(sec).padStart(2, "0");
  }
  setInterval(sessionTime, 1000);
})();
