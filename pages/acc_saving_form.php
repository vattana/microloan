<script type="text/javascript">
	function focusit() {			
		document.getElementById("cid").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<!-- suggestion cif -->
	<script type="text/javascript">
				var nameArray = null;
	</script>
	 <script type="text/javascript">
		///////////
            function doSuggestionBox(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestions').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestions').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestions(text);
                }
            }
            function outClick() {
                document.getElementById('divSuggestions').style.visibility = 'hidden';
            }
            function doSelection(text) {
                var selection = text;
                document.getElementById('divSuggestions').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("cid").value = selection;
            }
            function changeBG(obj) {
                element = document.getElementById(obj);
                oldColor = element.style.backgroundColor;
                if (oldColor == "white" || oldColor == "") {
                    element.style.background = "blue";
                    element.style.color = "white";
                    element.style.cursor = "pointer";
                } else {
                    element.style.background = "white";
                    element.style.color = "#333333";
                    element.style.cursor = "pointer";
                }
            }
            function doSuggestions(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBG(this.id);' onMouseOut='changeBG(this.id);' onclick='doSelection(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClick();
                }
                document.getElementById('divSuggestions').innerHTML = code;
                document.getElementById('divSuggestions').style.overflow='auto';
            }
        </script>

<style type="text/css">
            <!--
            div.suggestions {
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                border: 1px solid #999999;
                text-align: left;
				z-index:0;
            }
            -->
</style>
<!-- end suggestion cif -->
<?php
		$query = "SELECT cif FROM register where appr='1' and bcif='1' and bloan='0' and type_loan <> 'group' GROUP BY cif DESC";
			$result = mysql_query($query);
			$counter = 0;
			echo("<script type='text/javascript'>");
			echo("this.nameArray = new Array();");
			if($result) {
				while($row = mysql_fetch_array($result)) {
					echo("this.nameArray[" . $counter . "] = '" . trim($row['cif']) . " ';");
					$counter += 1;
				}
			}
			echo("</script>");
?>
<?php
		//----------------------------------------------transaction-------------------------//
		include('pages/module.php');
		$user = $_SESSION['usr'];
		//get ability from config-----------
			$sql_ab = "SELECT setting FROM loan_config WHERE property ='ability' ORDER BY id"; 
						$result_ab = mysql_query($sql_ab) or die(mysql_error());
						// Print out result
							while($row = mysql_fetch_array($result_ab)){
								$get_ab=$row['setting'];
								
							}
						//-------
			//get percentage from config-----------
			$sql_ab = "SELECT setting FROM loan_config WHERE property ='Percentage' ORDER BY id"; 
						$result_ab = mysql_query($sql_ab) or die(mysql_error());
						// Print out result
							while($row = mysql_fetch_array($result_ab)){
								$get_percent=$row['setting'];
								
							}
						//-------
			//get grace period from config-----------
			$sql_ab = "SELECT setting FROM loan_config WHERE property ='Semi-Balloon' ORDER BY id"; 
						$result_ab = mysql_query($sql_ab) or die(mysql_error());
						// Print out result
							while($row = mysql_fetch_array($result_ab)){
								$get_gp=$row['setting'];
								
							}
						//-------
					///check branch no------------
					$br_ip = $_SERVER['REMOTE_ADDR'];
					$br_sql="Select * from br_ip_mgr where set_ip ='$br_ip'";
					$result_br=mysql_query($br_sql) or die (mysql_error());
						while($row = mysql_fetch_array($result_br))
								{
									$get_ip=$row['set_ip'];
									$get_br=$row['br_no'];	 
								}
					//end check branch no------
	//---check display----------------
	if(isset($_POST['display']) && ($getglcode!='0')){
		$dis_app_date=date('Y-m-d',strtotime($_POST['app_date']));
		$mydate=date('d-m-Y',strtotime($dis_app_date));
		//display register info
		$cid_display=$_POST['cid'];
		$display_info="SELECT * FROM register WHERE cif='$cid_display' AND appr='1' AND bcif='1' and bloan='0' ORDER BY id DESC";
		
		$result_info=mysql_query($display_info) or die (mysql_error());
			while($row=mysql_fetch_array($result_info)){
					$regis_id=$row['id'];
					$reg_date=date('d-m-Y',strtotime($row['register_date']));
					$kh_borrower=$row['kh_borrower'];
					$borrower=$row['borrower'];
					$kh_co_borrower=$row['kh_co_borrower'];
					$co_borrower=$row['co_borrower'];
					$recommender=$row['recomend_name'];
					$co_name=$row['co'];
					$purpose=$row['purpose'];
					$l_type=$row['type_loan'];
					$l_period=$row['period'];
					$l_currency=$row['cur'];
					$type_cust=$row['type_cust'];
				}
				//approval info----------------
						$sql_app_info="SELECT * FROM customer_app WHERE cid='$cid_display' ORDER BY id";
						$result_app_info=mysql_query($sql_app_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_app_info)){
								$approval_date=date('d-m-Y',strtotime($row['approval_date']));
								if($row['approval_date']=='0000-00-00'){
									$approval_date=date('d-m-Y');
									}
								$approval_amt=formatMoney($row['approval_amt'],true);
								$myapproval_amt=$row['approval_amt'];
								$approval_rate=$row['approval_rate'];
								$approval_period=$row['approval_period'];
								$repay_method=$row['method'];
								$nor=$row['number_of_repay'];
							}
					//display frequency
						if($nor=='30'){
							$show_fr='Monthly';
							$freq='4';
							}
						else if($nor=='14'){
							$show_fr='Two Weeks';
							$freq='3';
							}
						else if($nor=='7'){
							$show_fr='Weekly';
							$freq='2';
							}
						else if($nor=='1'){
							$show_fr='Daily';
							$freq='1';
							}
						else if($nor=='15'){
							$show_fr='Half-Monthly';
							$freq='5';
							}
						else{
							$show_fr='Half-Monthly';
							$freq='5';
							}
							
					///---------
					$first_repay_date=date('Y-m-d');
					$myfirst_repay=strtotime(date('Y-m-d',strtotime($first_repay_date))."+$nor days");
					$real_first_repay=date('d-m-Y',$myfirst_repay);
					
				// show business type------------
					$sql_biz_type = "SELECT business_type FROM cif_detail WHERE cif='$cid_display'"; 
					$result_biz_type = mysql_query($sql_biz_type) or die(mysql_error());
						while($row = mysql_fetch_array($result_biz_type)){
							$biz_type=$row['business_type'];
						}
				//get code of business type
					$sql_code_type = "SELECT code FROM business_type WHERE business='$biz_type'"; 
					$result_code_type = mysql_query($sql_code_type) or die(mysql_error());
						while($row = mysql_fetch_array($result_code_type)){
							$code_biz_type=$row['code'];
						}
				//get code of currency type
					$sql_cur_type = "SELECT code FROM currency_type WHERE types='$l_currency'"; 
					$result_cur_type = mysql_query($sql_cur_type) or die(mysql_error());
						while($row = mysql_fetch_array($result_cur_type)){
							$code_cur_type=$row['code'];
						}
				//get code of loan type
					$sql_l_type = "SELECT code FROM loan_type WHERE en_ltype='$l_type'"; 
					$result_l_type = mysql_query($sql_l_type) or die(mysql_error());
						while($row = mysql_fetch_array($result_l_type)){
							$code_l_type=$row['code'];
						}
				//check max id
				//////////////////
				$query_maxid = "SELECT max(id) as code FROM saving_process"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['code'];
						$convert = intval($max);
						$max += 1;
						/*if (strlen($max)==1){ 
							$max='0000'.$max;
						}
						else if((strlen($max)==2)){
							$max='000'.$max;
						}
						else if((strlen($max)==3)){
							$max='00'.$max;
						}
						else if((strlen($max)==4)){
							$max='0'.$max;
						}
						else {
							$max = $max ;
						}*/
					}
					///end check max id-----	
					
					$myget_monthyear =$_POST['loan_date'];
					$get_loan_month = date('m',strtotime($myget_monthyear));
					$get_loan_year = date('y',strtotime($myget_monthyear));
					$get_loan_day = date('d',strtotime($myget_monthyear));
				//-------------------------------
				//generate amount
				if($l_currency=='USD'){//-- check currnecy type
					intval($myapproval_amt);
						if(($myapproval_amt) <= 200){
							
							$code_amt ='1';
						}
						else if(($myapproval_amt) > 200 && ($myapproval_amt) <= 500){					
							$code_amt ='2';
						}
						else if(($myapproval_amt) > 500 && ($myapproval_amt) <= 1000){
							$code_amt ='3';
						}
						else if(($myapproval_amt) > 1000 && ($myapproval_amt) <= 2000){
							$code_amt ='4';
						}
						else if(($myapproval_amt) > 2000 ) {
							$code_amt ='5';
						}
				}//---
				else{
					$code_amt='9';
					}
				//--generate period
					if($l_period<=12){
						$code_period='1';
						}
						else{
						$code_period='2';
							}
				//------
				//--loan cycle
					$result_loancycle = mysql_query("SELECT * FROM loan_process WHERE cid ='$cid_display'");
					$num_rows_lcycle = mysql_num_rows($result_loancycle);
					$code_lcycle=$num_rows_lcycle+1;
				//----
				//-----------------
					$ld='6'.$code_cur_type.'-'.$get_loan_day.$get_loan_month.$get_loan_year.'-'.$code_lcycle.$code_cur_type.$max;
							
			}///isset
	//--check ld
		if($ld==''){
				$ld='Auto-Generate';
			}
			else{
				$ld=$ld;
			}
	//----
	//---end diplay
	//---start save loan info
	if(isset($_POST['save']) && ($getglcode!='0')){
		//////////////////
				$query_maxid = "SELECT max(max_id) as code FROM loan_process"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['code'];
						$convert = intval($max);
						$max += 1;
						if (strlen($max)==1){ 
							$max='0000'.$max;
						}
						else if((strlen($max)==2)){
							$max='000'.$max;
						}
						else if((strlen($max)==3)){
							$max='00'.$max;
						}
						else if((strlen($max)==4)){
							$max='0'.$max;
						}
						else {
							$max = $max ;
						}
					}
					///end check max id-----	
		$myld=$_POST['lid'];
		$mycid=$_POST['cid'];
		$setting=$_POST['setting'];
		$method=$_POST['method'];
		$first_repay=date('Y-m-d',strtotime($_POST['frp']));
		$re_co=$_POST['co_name'];
		$grace_period=$_POST['grace_period'];
		$percentage=$_POST['percentage'];
		$myreg_date=date('Y-m-d',strtotime($_POST['regis_date']));
		$myapp_date=date('Y-m-d',strtotime($_POST['app_date']));
		$myloan_date=date('Y-m-d',strtotime($_POST['loan_date']));
		$myfrp_date=date('Y-m-d',strtotime($_POST['frp']));
		$myclassi_purpose=$_POST['classify_pur'];
		$mybor_income=$_POST['bor_income'];
		$mycobor_income=$_POST['cobor_income'];
		$dependant_income=$_POST['dependant_income'];
		$other_income=$_POST['other_income'];
		$family_ex=$_POST['family_ex'];
		$remain=$_POST['remain'];
		$ability=$_POST['ability'];
		$loan_sec=$_POST['loan_security'];
		$titile_no=$_POST['title_no'];
		$check_issued_date=$_POST['issued_date'];
		$myco_name=trim($_POST['co_name']);
		$myrecom_name=$_POST['recom_name'];
		$myLtype=$_POST['ltype'];
		if(!empty($check_issued_date)){
			$issued_date=date('Y-m-d',strtotime($_POST['issued_date']));
			}
			else{
			$issued_date=$_POST['issued_date'];	
			}
		$issued_by=$_POST['issued_by'];
		$west=$_POST['west'];
		$east=$_POST['east'];
		$north=$_POST['north'];
		$south=$_POST['south'];
		$ownership=$_POST['ownership'];
		$depositor=$_POST['depositor'];
		$co_depositor=$_POST['co_depositor'];
		$title_type=$_POST['title_type'];
		$collateral_type=$_POST['collateral_type'];
		$mycur=trim($_POST['cur']);
		$mytypeCust=$_POST['type_cust'];
		$getglcode=$_POST['gllink'];
		//---select from approval again
		$get_regis_id="SELECT * FROM register WHERE cif='$mycid' AND appr='1' AND cancel='0' AND bcif='1' AND bloan='0' AND dis='0' ORDER BY id DESC";
		$result_reg_id=mysql_query($get_regis_id) or die (mysql_error());
			while($row=mysql_fetch_array($result_reg_id)){
				$reg_id=$row['id'];
				$cur=$row['cur'];
				break;
			}

		
		#----------------------------start create schedule----------------------------------#
								/*$dayset=date('d',strtotime($first_repay));
								$ba=$amount;	
								$no_installment=intval($period*$no_r/$no_r);
								$pr=round($amount/$no_installment,2);
								$int=round((($ba*$rate/100)/30*0),2);	
								
								////////////////////////
								$period=intval($period);
								$start = $month =strtotime(date('Y-m-d',strtotime($first_repay)));
								if($no_r=='30'){
									$naturity_date= strtotime(date('Y-m-d',strtotime($first_repay))."+$period month");
								}
								else if($no_r=='7'){
									$naturity_date= strtotime(date('Y-m-d',strtotime($first_repay))."+$period week");
									}
								else {
									$naturity_date= strtotime(date('Y-m-d',strtotime($first_repay))."+$period month");
									}
								$end = strtotime(date('Y-m-d',$naturity_date));	
								//check No_r
									if(($no_r=='7')||($no_r=='14')){
										$myno_r='7';
										}
									else if(($no_r=='15')||($no_r=='30')){
										$myno_r=$no_r;
										}
									else{
										$myno_r=$no_r;
										}
								/*///end check

		#----------------end KHR-------------------------------------------------------------#
		#-----------------------------end create schedule-----------------------------------#
		#-------------------insert to loan table--------------------------------------------#
		$getdate = getdate();
			if(!empty($myld) && ($getglcode!='0')){
				
				$input_loan=mysql_query("
				INSERT INTO `saving_process` (
`id` ,
`cid` ,
`sid` ,
`open_date` ,
`cur` ,
`gllink` ,
`user` ,
`date_create`
)
VALUES (
NULL , '$mycid', '$myld', '$myloan_date','$mycur','$getglcode','$user','$getdate'
);
") or die(mysql_error()); 
						
				#----------------update register infor------------------#
		
				#--------------end update register infor----------------#
				#----------------update address for schedule------------------#
						echo"<script>alert('Save successfully! Please Note Saving ID: $myld');</script>";
				#--------------end update address for schedule----------------#
					/*	echo"<script>window.location.href='index.php?pages=loanEntryForm';</script>";*/
				}
					else{
						echo"<script>alert('Save Unsuccessfully! Try to Check again! GLLinnk Is Important');</script>";	
						echo"<script>window.location.href='index.php?pages=acc_saving_form&catch';</script>";
			}//end check empty

		#-------------------insert to loan table--------------------------------------------#
	}//end isset insert
	//--end save loan info
	
?>
<script language="javascript">
	// Cash Flow
		function remaining(){
			var ab='<?php echo $get_ab;?>';
			var ifb = parseFloat(document.getElementById("bor_income").value);
			var ifc = parseFloat(document.getElementById("cobor_income").value);
			var ifd = parseFloat(document.getElementById("dependant_income").value);
			var ifo = parseFloat(document.getElementById("other_income").value);
			var fex = parseFloat(document.getElementById("family_ex").value);
			
			var remain = parseFloat((ifb+ifc+ifd+ifo)-(fex));
			var abl= parseFloat(remain*ab/100);
			
				document.getElementById("remain").value=remain;
				document.getElementById("ability").value=abl;
				
		}
		//end cash flow	
	</script>
<!-- start content-outer -->
<h3 class="tit">Easy Open new account saving Form :</h3>

		<!-- start id-form -->
        <form name="ind_loan" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'" class="nostyle">
         <tr>
		<th valign="top">CID :</th>
		<td>	
		<input type="text" class="input-text" name="cid" id="cid" autocomplete="off" 
        onKeyPress="return handleEnter(this, event);" value="<?php echo $cid_display; ?>" onKeyUp="doSuggestionBox(this.value);"/>
        <input type="submit" name="display" value="+"/>
		</td>
        <th valign="top">GL LINK :</th>
		<td>	
            <select class="input-text" name="gllink" id="gllink" onkeypress="return handleEnter(this, event);">
                    <option value="0">--Select--</option>
                     <?php 
								$str_glname="Select * from glp_caption where cType='S' order by id ASC;";   
                                      $sql_glname=mysql_query($str_glname);
                                      while ($row=mysql_fetch_array($sql_glname))
                                        {
                                        $glcode=$row['glcode'];
                                        $glname=$row['glname'];
                                        echo '<option value="'.$glcode.'">'.$glname.'</option>';
                                        }
							?>
            </select>
            <font color="#FF0000">( * )</font>
		</td>
        </tr>
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
				<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 13%;
						 	margin-top:-4px; background-color: #FFFFFF;float:right; color: #666666; 
                            height: 100px; padding-left: 5px;position:absolute;">
                </div>
		</td>
			
		</tr> 
		<tr>
			<th valign="top">Register Date :</th>
			<td>
            <input type="text" class="input-text" name="regis_date" id="regis_date" value="<?php echo $reg_date; ?>" autocomplete="off"
             readonly="readonly"/></td>
             <th valign="top">Currency :</th>
			<td>
             <select class="input-text" name="cur" id="cur" onkeypress="return handleEnter(this, event);">
        
                     <?php 
								$str_glname="Select types from currency_type";   
                                      $sql_glname=mysql_query($str_glname);
                                      while ($row=mysql_fetch_array($sql_glname))
                                        {
                                        $glname=$row['types'];
                                        echo '<option value="'.$glname.'">'.$glname.'</option>';
                                        }
							?>
            </select>
           
		</tr>
		<tr>
			<th valign="top">Open Date :</th>
			<td><input type="text" class="input-text" name="loan_date" id="loan_date" value="<?php $myloanDate=date('d-m-Y',strtotime($_POST['loan_date']));if(($myloanDate=='01-01-1970')){
												
												echo date('d-m-Y');
											}
											 else{
											 	 echo $myloanDate;
											 } ?>" 
            onblur="doDate(this,'em_Date');" onkeypress="return handleEnter(this, event);" autocomplete="off"/>
            <font color="#FF0000">( * )</font></td>
            <th valign="top">SID :</th>
			<td><input type="text" class="input-text" name="lid" id="lid" value="<?php echo $ld; ?>" autocomplete="off" readonly="readonly"/></td>
		</tr>
		<tr>
			<th valign="top">អ្នកដាក់ :</th>
			<td>
            <input type="text" class="input-text" name="kh_bor" id="kh_bor" value="<?php echo $kh_borrower; ?>" readonly="readonly" 
            style="font-family:khmer OS; size:10pt" size="16"/>
            </td>
            <th valign="top">Deposit :</th>
			<td>
            <input type="text" class="input-text" name="en_bor" id="en_bor" value="<?php echo $borrower; ?>" readonly="readonly"/>
            </td>
		</tr>
   
        
         
		
       
       <!--  <tr>
			<th valign="top">Bor's Income :</th>
			<td>
            <input type="text" class="input-text" name="bor_income" id="bor_income" value="0" onkeypress="return handleEnter(this, event);" 
            onkeyup="remaining()"/>
            </td>
            <th valign="top">Co-Bor's Income :</th>
			<td>
            <input type="text" class="input-text" name="cobor_income" id="cobor_income" value="0" onkeypress="return handleEnter(this, event);" 
            onkeyup="remaining()"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Dependant's Income :</th>
			<td>
            <input type="text" class="input-text" name="dependant_income" id="dependant_income" value="0" 
            onkeypress="return handleEnter(this, event);" onkeyup="remaining()"/>
            </td>
            <th valign="top">Other's Income :</th>
			<td>
            <input type="text" class="input-text" name="other_income" id="other_income" value="0" onkeypress="return handleEnter(this, event);" 
            onkeyup="remaining()"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Family Expense :</th>
			<td>
            <input type="text" class="input-text" name="family_ex" id="family_ex" value="0" onkeypress="return handleEnter(this, event);" 
            onkeyup="remaining()"/>
            </td>
            <th valign="top">Remain :</th>
			<td>
            <input type="text" class="input-text" name="remain" id="remain" value="0" onkeypress="return handleEnter(this, event);" 
            readonly="readonly"/>
            </td>
		</tr> -->
        
       <!-- <tr>
			<th valign="top">&nbsp;</th>
			<td>
           		<h3>Boundary</h3>
            </td>
            <th valign="top">Issued By :</th>
			<td>
            <input type="text" class="input-text" name="issued_by" id="issued_by" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
		</tr>
        <tr>
			<th valign="top">West :</th>
			<td>
            <input type="text" class="input-text" name="west" id="west" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">East :</th>
			<td>
            <input type="text" class="input-text" name="east" id="east" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
		</tr>
        <tr>
			<th valign="top">North :</th>
			<td>
            <input type="text" class="input-text" name="north" id="north" value="" 
            onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">South :</th>
			<td>
            <input type="text" class="input-text" name="south" id="south" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
		</tr> -->
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="submit" class="form-submit" name="save" id="save" 
          onclick="return confirm('Are you sure wanna save?');"/>
                <input type="reset" value="reset" class="form-reset"  />
            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>