<script type="text/javascript">
	function focusit() {			
		document.getElementById("lid").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<!-- suggestion cif -->
	<script type="text/javascript">
				var nameArray = null;
	</script>
	 <script type="text/javascript">
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
                document.getElementById("lid").value = selection;
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
		$query = "SELECT * FROM loan_process WHERE loan_type='individual' AND dis='0' ORDER BY max_id ASC";
			$result = mysql_query($query);
			$counter = 0;
			echo("<script type='text/javascript'>");
			echo("this.nameArray = new Array();");
			if($result) {
				while($row = mysql_fetch_array($result)) {
					echo("this.nameArray[" . $counter . "] = '" . trim($row['ld']) . " ';");
					$counter += 1;
				}
			}
			echo("</script>");
?>
<?php
		//----------------------------------------------transaction-------------------------//
		include('pages/module.php');
		$user = $_SESSION['usr'];
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
	  
	  	if(isset($_POST['display'])){
			 $lid = $_POST['lid'];
			//display loan info
			$display_info="SELECT * FROM loan_process WHERE ld='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$reg_id = $row['regis_id'];
						$cid = $row['cid'];
						$reg_date=date('d-m-Y',strtotime($row['reg_date']));
						$app_date=date('d-m-Y',strtotime($row['app_date']));
						$loan_date=date('d-m-Y',strtotime($row['loan_date']));
						$first_repay=date('d-m-Y',strtotime($row['first_repay_date']));
						$classify_pur=$row['classified_purpose'];
					}
			//-------start get info from approval
			$display_appinfo="SELECT * FROM customer_app WHERE reg_id='$reg_id'";
			$result_appinfo=mysql_query($display_appinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_appinfo)){
						
						$app_amt = formatMoney($row['approval_amt'],true);
						$app_rate=$row['approval_rate'];
						$app_period=$row['approval_period'];
						$app_method=$row['method'];
						$nor=$row['number_of_repay'];
						
					}
			///////////ens get infor from approval	
				//display frequency
						if($nor=='30'){
							$show_fr='Monthly';
							}
						if($nor=='7'){
							$show_fr='Weekly';
							}
						if($nor=='14'){
							$show_fr='Two-Weeks';
							}
						if($nor=='15'){
							$show_fr='Half-Month';
							}
						if($nor=='1'){
							$show_fr='Daily';
							}
						
				//---end frequency----//		
				//-----start show more info from register
				$display_reginfo="SELECT * FROM register WHERE id='$reg_id' AND appr='1' AND cancel='0' AND bcif='1' AND bloan='1' AND dis='0' ORDER BY id DESC";
		$result_reginfo=mysql_query($display_reginfo) or die (mysql_error());
		$check_dis=mysql_num_rows($result_reginfo);
			while($row=mysql_fetch_array($result_reginfo)){
					$kh_borrower=$row['kh_borrower'];
					$borrower=$row['borrower'];
					$kh_co_borrower=$row['kh_co_borrower'];
					$co_borrower=$row['co_borrower'];
					$recommender=$row['recomend_name'];
					$co_name=$row['co'];
					$purpose=$row['purpose'];
					$l_type=$row['type_loan'];
					$l_currency=$row['cur'];
					
				}
				//////end register-------------//
				//check if already disburse
					if($check_dis=='0'){
						echo"<script>alert(' សូមត្រួតពិនិត្យម្តងទៀតអោយបានច្បាស់លាស់! Please check again!');</script>";
						echo"<script>window.location.href='index.php?pages=individual_disForm';</script>";
						}
				//////end check disburse
			}///isset displaay
		
	//--check ld
	//---end diplay
	//---------start disbursement----------------//
		if(isset($_POST['disburse'])){//start schedule 
			$myreg_id=$_POST['reg_id'];
			$dis_date=date('Y-m-d',strtotime($_POST['ddate']));
			///--------update disbursement date------------------
			if(!empty($myreg_id)){
				$update_dis="UPDATE loan_process SET dis_date ='$dis_date',dis='1' WHERE regis_id='$myreg_id'";
					mysql_query($update_dis) or die (mysql_error());
					
				$update_dis="UPDATE register SET dis ='1',dis_by='$user',dis_at='$get_br' WHERE id='$myreg_id'";
					mysql_query($update_dis) or die (mysql_error());
					
				$update_disapp="UPDATE customer_app SET dis ='1' WHERE reg_id='$myreg_id'";
					mysql_query($update_disapp) or die (mysql_error());
			}
			/*echo"<script>alert('$myreg_id,$dis_date');</script>";	*/
			//---------------end update disbursement date--------------------------
			echo"
				<script> 
					var print =window.open('','print','status=1,width=1100,height=700,scrollbars=yes,menubar=yes,addressbar=no,resizable=no');
					print.location.href='pages/schedule.php?r_id=$myreg_id';
				</script>";
			echo"<script>window.location.href='index.php?pages=individual_disForm';</script>";
			
		}//end isset schedule
		
	//------------end disbursment---------------// 
	?>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">
<div id="page-heading"><h1>Easy Individual Disbursement Form :</h1></div>

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>	
		<!--  start step-holder -->
		<div id="step-holder">
			<div class="step-no">4</div>
			<div class="step-dark-left">Disbursement</div>
			<div class="step-dark-right">&nbsp;</div>
            <div class="step-no">5</div>
			<div class="step-dark-left">Repayment</div>
			<div class="step-dark-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
		<!-- start id-form -->
        <form name="ind_loan" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'">
         <tr>
		<th valign="top">LID :</th>
		<td>	
		<input type="text" class="inp-form" name="lid" id="lid" autocomplete="off" 
        onKeyPress="return handleEnter(this, event);" value="<?php echo $lid; ?>" onKeyUp="doSuggestionBox(this.value);"/>
        <input type="submit" name="display" value="+"/>
		</td>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
        </tr>
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
				<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 15%;
						 	margin-top:-24px; background-color: #FFFFFF;float:right; color: #666666; 
                            height: 100px; padding-left: 5px;position:absolute;">
                </div>
		</td>
			<th>&nbsp;</th>
			<td>&nbsp;
            </td>
		</tr> 
		<tr>
			<th valign="top">Register Date :</th>
			<td>
            <input type="text" class="inp-form" name="regis_date" id="regis_date" value="<?php echo $reg_date; ?>" autocomplete="off"
             readonly="readonly"/></td>
            <th valign="top">Approval Date :</th>
			<td><input type="hidden" name="reg_id" id="reg_id" size="2" value="<?php echo $reg_id; ?>" />
            <input type="text" class="inp-form" name="app_date" id="app_date" value="<?php echo $app_date; ?>" autocomplete="off"
             readonly="readonly"/></td>
		</tr>
		<tr>
			<th valign="top">Loan Entry Date :</th>
			<td><input type="text" class="inp-form" name="loan_date" id="loan_date" value="<?php echo $loan_date; ?>" 
            onblur="doDate(this,'em_Date');" onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
            <th valign="top">CID :</th>
			<td><input type="text" class="inp-form" name="cid" id="cid" value="<?php echo $cid; ?>" autocomplete="off" readonly="readonly"/></td>
		</tr>
		<tr>
			<th valign="top">អ្នកខ្ចី :</th>
			<td>
            <input type="text" class="inp-form" name="kh_bor" id="kh_bor" value="<?php echo $kh_borrower; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Borrower :</th>
			<td>
            <input type="text" class="inp-form" name="en_bor" id="en_bor" value="<?php echo $borrower; ?>" readonly="readonly"/>
            </td>
		</tr>
        <tr>
			<th valign="top">អ្នករួមខ្ចី :</th>
			<td>
            <input type="text" class="inp-form" name="kh_cobor" id="kh_cobor" value="<?php echo $kh_co_borrower; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Co-Borrower :</th>
			<td>
            <input type="text" class="inp-form" name="en_cobor" id="en_cobor" value="<?php echo $co_borrower; ?>" readonly="readonly"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Recommender :</th>
			<td>
            <input type="text" class="inp-form" name="recom_name" id="recom_name" value="<?php echo $recommender; ?>" readonly="readonly"/>
            </td>
            <th valign="top">CO's Name :</th>
			<td>
            <input type="text" class="inp-form" name="co_name" id="co_name" value="<?php echo $co_name; ?>" readonly="readonly"/>
            </td>
		</tr>
         <tr>
			<th valign="top">Loan Amount :</th>
			<td>
            <input type="text" class="inp-form" name="loan_amt" id="loan_amt" value="<?php echo $app_amt; ?>" readonly="readonly"/>
            <?php echo $l_currency; ?>
            </td>
            <th valign="top">First Repay Date :</th>
		<td>	
		<input type="text" class="inp-form" name="frp" id="frp" autocomplete="off"  
        onkeypress="return handleEnter(this, event);" value="<?php echo $first_repay; ?>" readonly="readonly"/>
		</td>
		</tr>
         <tr>
			 <th valign="top">Rate :</th>
			<td>
            <input type="text" class="inp-form" name="rate" id="rate" value="<?php echo $app_rate; ?>" readonly="readonly"/> %
            </td>
            <th valign="top">Method :</th>
			<td>
            <input type="text" class="inp-form" name="method" id="method" value="<?php echo $app_method; ?>" readonly="readonly"/>
            </td>
		</tr>
		
        <tr>
        <th valign="top">Period :</th>
			<td>
            <input type="text" class="inp-form" name="period" id="period" value="<?php echo $app_period; ?>" readonly="readonly"/>
            <?php echo $show_fr; ?>
            </td>
       
		
			<th valign="top">Loan Type :</th>
		<td>	
		<input type="text" class="inp-form" name="l_type" id="l_type" autocomplete="off"  
        onkeypress="return handleEnter(this, event);" value="<?php echo $l_type; ?>" readonly="readonly"/>
		</td>
		</tr> 
         <tr>
		<th valign="top">Disbursement Date :</th>
		<td>	
		<input type="text" class="inp-form" name="ddate" id="ddate" autocomplete="off" onblur="doDate(this,'em_Date');" 
        onkeypress="return handleEnter(this, event);" value="<?php echo date('d-m-Y'); ?>"/>
		</td>
			<td align="left"><div class="error-left"></div>
			<div class="error-inner">dd-mm-yyyy</div></td>
		</tr> 
		 <tr>
		<th valign="top">Classified Purpose :</th>
            <td><textarea rows="" cols="" class="form-textarea" name="loan_purpose" id="loan_purpose"><?php echo trim($classify_pur); ?></textarea></td>
            <td>&nbsp;</td>
		</tr>
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="Disburse" class="form-submit" name="disburse" id="disburse" 
            onclick="return confirm('Are you sure wanna disburse <?php echo $kh_borrower; ?> ?');"/>
                <input type="reset" value="reset" class="form-reset"  />
            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>
	<!-- end id-form  -->
	</td>
	<td>
	<!--  start related-activities -->
	<?php
		include("pages/right_menu.php");
	?>
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>
<div class="clear">&nbsp;</div>
</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->