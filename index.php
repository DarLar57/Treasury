<?php 
include('./treasury/common/head.php'); 
include('treasury/initializing.php');
?>

    <div class="header">
      <!-- Navigation bar -->      
      <ul class="header-ul">
        <li><a href=#home>Home</a></li>
        <li class="dropdown">
          <a href="#home" class="dropbtn">Database</a>
          <div class="dropdown-content">
            <a onclick="add_input()">Deal Input</a>
            <a onclick="add_modify()">Modify Deal</a>
            <a onclick="add_reporting()">Reporting</a>
          </div>
        </li>
        <li><a onclick=market()>Market</a></li>
        <li><a href=#glossary>Glossary</a></li>
        <li><a href=#contact>Contact</a></li>
        <p id="sessionTiming"></p>
      </ul>
    </div>
    <!-- Headline with App name -->  
    <div class="sub-header">
      <h1 id="TL">D ARLAR Treasury Tool</h1>
    </div>
    <div class="main">
      <!-- 3 (will be 4) clicables to Insert, Modify (not ready), Report deals and open Market data -->  
      <div class="col-1 col-s-1 menu">
        <ul class="main-ul">
          <li class="click" onclick="add_input()">Deal input</li>
          <li class="click" onclick="add_modify()">Modify Deal</li> 
          <li class="click" onclick=add_reporting()>Reporting</li>
          <li class="click" onclick=market()>Market</li>
        </ul>
      </div>
      <div class="col-2 col-s-2">
          <!-- Welcome / short description -->  
          <?php include('./treasury/included/text/welcome.php'); ?> 

      </div>
      <div class="col-1 col-s-4">
        <div class="aside">
          <img src="treasury/photos/currencies.jpg" /> 
        </div>
      </div>
    </div>
    <div class="after-main">
    <!-- Main Container for user's interactions with DB that includes other containers -->    
    <div class="col-4 col-s-4" id="Treasury-container">
      <div class="col-4 col-s-4" style="display: flex; flex-wrap: wrap;">
        <!-- Container #1 part to both Report and Insert  MM and FX to / from  DB -->  
          <div class="col-1 .col-s-1" id="Report_insert">
            <div id="Reporting_1">
              <h2 id="Reporting"></h2>
              <div id="mmfx_instr">
              </div>
                <h5 id="type_of_tr"></h5>
                  <!-- Form (main category selection MM? / FX?) to report from DB -->                     
                  <form name="myForm" id="myForm" action="/treasury/common/display.php" method="POST" target="display">
                    <ul>
                        <?php include('./treasury/included/text/reporting_options.php'); ?>

                    </ul>
            </div>
            <!-- Form (exact transation category selection e.g. depo, loan, FX spot etc.) to report MM / FX from DB -->  
            <div id="Reporting_2">
              <h5 id="instrument"></h5>
                <ul> 
                <li><input type="checkbox" id="instr1" name="instr1" value="" onclick="showSubmitButton()">
                    <label for="instr1" id="linstr1"></label></li>
                <li><input type="checkbox" id="instr2" name="instr2" value="" onclick="showSubmitButton()">
                    <label for="instr2" id="linstr2" ></label></li>
                <li><input type="checkbox" id="instr3" name="instr3" value="" onclick="showSubmitButton()">
                    <label for="instr3" id="linstr3" ></label></li><br>
                </ul>  
            </div>
            <!-- Submission to DB --> 
            <div id="Reporting_submit">
              <button class="click" type="submit" id="submit" onclick="showReportDisplay()">Submit</button>
                  </form>
            </div>
            <!-- Container #2 part to Insert  MM and FX into DB -->   
            <div class="col-4 col-s-4" id="Report_insert2">
              <h2 id="Report_insert2_h2">Deal's Input: </h2>
              <div id="inserting_deals"><h5 id="inserting_deals_h5"></h5>
              <!-- Form (main category selection MM? / FX?) to insert into DB -->        
                <form name="myForm2" id="myForm2" action="treasury/common/display.php" method="POST" target="display">
                <input type="hidden" id="ModifyOrInsert" name="ModifyOrInsert" value="">
                
                    <ul>
                      <li><input type="radio" id="MM2" name="instr5" value="MONEY_MARKET" onclick="add_mm_2()">
                        <label for="MM2" id="lMM2"></label></li>
                      <li><input type="radio" id="FX2" name="instr5" value="FOREIGN_EXCHANGE" onclick="add_fx_2()">
                        <label for="FX2" id="lFX2"></label></li><br>
                <div id="myForm2_2"> 
                  <div id="Reporting_2_2">  
                    <h5 id="instrument2"></h5>
                  </div>
                  <!-- Form (exact transation category selection e.g. depo, loan, FX spot etc.) to insert MM / FX into DB -->  
                    <div class="grid_input_selection">
                      <div>
                        <label for="INS_O_MM_ID" id="lINS_O_MM_ID" >ID of Instrument:</label>
                      </div>
                      <div>
                        <input type="text" id="ID" name="ID" value="" onclick="" pattern="([0-9]+)|([0-9]+[\.]{1}[0-9]{1,2})">
                      </div>
                      <div>
                        <label for="INS_O_MM" id="lINS_O_MM" >MM Instrument:</label>
                      </div>
                      <div>
                        <select id="INS_O_MM" name="instr6MM">
                            <?php include('./treasury/included/text/mm.php'); ?>

                        </select>
                      </div> 
                      <div>
                        <label for="INS_O_FX" id="lINS_O_FX" >FX Instrument:</label>
                      </div>
                      <div>
                        <select id="INS_O_FX" name="instr6FX">
                            <?php include('./treasury/included/text/fx.php'); ?>

                        </select>
                      </div>
                      <div>
                        <label for="COM_O" id="lCOM_O" >Company:</label>
                      </div>
                      <div>  
                        <select id="COM_O" name="COMPANY" required>
                            <?php include('./treasury/included/text/companies.php'); ?>

                        </select>
                      </div>
                      <div>
                        <label for="BAN_O" id="lBAN_O" >Bank:</label>
                      </div>
                      <div>  
                        <select id="BAN_O" name="BANK" required>
                            <?php include('./treasury/included/text/banks.php'); ?>

                        </select>
                      </div>
                      <div>
                        <label for="Amount" id="lAmount" >Amount:</label>
                      </div>
                      <div>
                        <input type="text" id="Amount" name="AMOUNT" value="" onclick="" pattern="([1-9]+)|([1-9][0-9]+)|([0-9]+[\.]{1}[0-9]{1,2})|([\.]{1}[0-9]{1,})"  required>
                      </div>
                      <div>
                        <label for="T_Date" id="lTdate">Transaction date:</label>
                      </div>
                      <div>
                        <input type="date" id="T_Date" name="TRANS_DATE" onclick="">
                      </div>
                    </div>
                    <!-- Form continued (specific just for MM transactions -->
                    <div id="mm_addintional_data">
                      <div class="grid_input_selection">  
                        <div>
                          <label for="S_Date" id="lSdate">Start date:</label>
                        </div>
                        <div>
                          <input type="date" id="S_Date" name="START_DATE" value="" onclick="">
                        </div>
                        <div>
                          <label for="E_Date" id="lSdate">End date:</label>
                        </div>
                        <div>
                          <input type="date" id="E_Date" name="END_DATE" value="" onclick="">
                        </div>
                        <div>
                          <label for="Int_r" id="lInt_r" >Base Rate (not %):</label>
                        </div>
                          <input type="text" id="Int_r" name="BASE_INTEREST_RATE" onclick="" pattern="([-]?[1-9][0-9]+)|[-]?([0-9]+[\.]{1}[0-9]{1,})|[-]?([\.]{1}[0-9]{1,})">
                        <div>
                          <label for="Margin" id="lMargin" >Margin (not %):</label>
                        </div>
                        <div>
                          <input type="text" id="Margin" name="MARGIN" value="" onclick="" pattern="([0-9]+)|([0-9]+[\.]{1}[0-9]{1,}|([\.]{1}[0-9]{1,})">
                        </div>
                        <div>
                          <label for="Curr" id="lCurr" >Currency:</label>
                        </div>
                        <div>
                          <select id="Curr" name="NAME_CURRENCY" value="" onclick="">
                              <?php include('./treasury/included/text/currencies.php'); ?>

                          </select> 
                        </div>
                      </div>
                    </div>
                    <!-- Form continued (specific just for FX transactions -->
                    <div id="fx_addintional_data">
                      <div class="grid_input_selection">
                        <div>
                          <label for="Setl_Date" id="lSetldate">Settlement date:</label>
                        </div>
                          <input type="date" id="Setl_Date" name="SETTLEMENT_DATE" value="" onclick="">
                        <div>
                          <label for="Buy" id="lBuy" >Currency Buy:</label>
                        </div>
                        <div>  
                          <select id="Buy" name="BUY_CURRENCY" value="" onclick="" onchange="check_currency()">
                              <?php include('./treasury/included/text/currencies.php'); ?>

                          </select>
                        </div>
                        <div>
                          <label for="Sell" id="lSell" >Currency Sell:</label>
                        </div>
                        <div>
                          <select id="Sell" name="SELL_CURRENCY" value="" onclick="" onchange="check_currency()">
                              <?php include('./treasury/included/text/currencies.php'); ?>

                          </select>
                        </div>
                        <div>
                          <label for="Exchange" id="lExchange" >Exchange Rate:</label>
                        </div>
                        <div>  
                          <input type="text" id="Exchange" name="EXCHANGE_RATE" value="" onclick="" pattern="([1-9][0-9]+)|([0-9]+[\.]{1}[0-9]{1,})">
                        </div>
                        <div>
                          <label for="Comm" id="lComm" ></label>
                        </div>
                      </div>
                    </div>
                      <textarea rows="5" cols="30" type="text" id="Comm" name="COMMENT" value="" onclick="" placeholder="Comments, if any..."></textarea>
                  </div>
                  <!-- Submission to DB or reseting fields --> 
                  <div id="Reporting_submit_2">
                    <button class="click" type="submit" id="submit_2" onclick="showReportDisplay()">Submit</button>
                    <button class="click" type="button" id="submit_reset" onclick="clearInputs()">Reset</button>
                  </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Display of Treasury data from DB -->
            <div  class="col-3" id="Report_display">
            <iframe id="display" name="display"></iframe>
          </div>
        </div>
      </div>   
      <div class="col-4 col-s-4">
      <!-- Description of the tool -->
          <?php include('./treasury/included/text/description.php'); ?>

      </div>
      <!-- Place for Market Data to be displaid -->    
      <div id="divMarket" class="col-4 col-s-4">   
      </div>
      <div class="col-4 col-s-4">
          <!-- Glossary related to the tool -->
          <?php include('./treasury/included/text/glossary.php'); ?>

      </div>
      <div class="col-4 col-s-4">  
          <!-- About the author -->
          <?php include('./treasury/included/text/about_me.php'); ?>

      </div>
    </div>
<?php include('./treasury/common/footer.php'); ?>    
    