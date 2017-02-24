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
				function doTotalAmount(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
				if (input == "")
				{
					//alert(document.getElementById("total_amt_hiden").value);
					var input1 = document.getElementById("total_amt_hiden").value.replace(",","");
					document.getElementById("total_amt").value = input1;
					document.getElementById("remain").value = 0; 
					return;
				}
				if (parseInt(input)<=parseInt(document.getElementById("total_amt_hiden").value.replace(",",""))){
					document.getElementById("total_amt").value = (document.getElementById("total_amt_hiden").value.replace(",","")-input).toFixed(2);
					document.getElementById("remain").value = 0; 

				}
			    else if (parseInt(input)>parseInt(document.getElementById("total_amt_hiden").value.replace(",",""))){
					document.getElementById("remain").value = (input.replace(",","") - document.getElementById("total_amt_hiden").value.replace(",","")).toFixed(2); 
					document.getElementById("total_amt").value = 0;
		
					
				} 	
				

            }
			function doRepay(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation

				if (parseFloat(document.getElementById("prin").value.replace(",","")) >input)
				{
					alert('You must input principal repay bigger than original principal or equal original principal.');
					var mytext = document.getElementById("prn_repay");
					mytext.focus();
					document.getElementById("OS").value=formatCurrency(document.getElementById("OS1").value.replace(",",""));
					return;
				}
				else{
					document.getElementById("OS").value = formatCurrency((document.getElementById("OS1").value.replace(",","")-(input - document.getElementById("prin").value.replace(",",""))));	
				}
            }
			
			function doValidate() { // function that takes the text box's inputted text as an argument
           
		   		if (document.getElementById("f_repay").text>document.getElementById("s_repay").text){
					alert('Your first repay date bigger maturity date.');
					return false;
				}	   
				if (parseFloat(document.getElementById("prin").value) >parseFloat(document.getElementById("prn_repay").value))
				{
					alert('You must input principal repay bigger than original principal or equal original principal.');
					var mytext = document.getElementById("prn_repay");
					mytext.focus();
					return false;
				}
				
            }
			
				
			function doTotalPenalty(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
				if (input == "")
				{
					//alert(document.getElementById("total_amt_hiden").value);
					var input1 = document.getElementById("repay_penalty_hiden").value.replace(",","");
					document.getElementById("repay_penalty").value = input1;
					document.getElementById("repay_penalty_remain").value = 0; 
					return;
				}
				if (parseInt(input)<=parseInt(document.getElementById("repay_penalty_hiden").value.replace(",",""))){
					document.getElementById("repay_penalty").value = (document.getElementById("repay_penalty_hiden").value.replace(",","")-input).toFixed(2);
					document.getElementById("repay_penalty_remain").value = 0; 

				}
			    else if (parseInt(input)>parseInt(document.getElementById("repay_penalty_hiden").value.replace(",",""))){
					/*document.getElementById("repay_penalty_remain").value = (input - document.getElementById("repay_penalty_hiden").value).toFixed(2); 
					document.getElementById("repay_penalty").value = 0;*/
					alert("you can't input penalty > total penalty.");
						
						document.getElementById("g_pn").focus();
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
		$query = "SELECT * FROM loan_process WHERE dis='1' ORDER BY max_id ASC";
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
		//---------------------------transaction-------------------------//
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
					//check max id
				//////////////////
				$query_maxid = "SELECT max(max_id) as code FROM invoice"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['code'];
						$convert = round($max);
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
		//---check display----------------
	  	if(isset($_POST['display'])){
			$lid = $_POST['lid'];
			$dis_repay_date=date('Y-m-d',strtotime($_POST['repay_date']));
			
			$mydate=date('d-m-Y',strtotime($dis_repay_date));
			//display loan info
			$display_info="SELECT * FROM loan_process WHERE ld='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$reg_id = $row['regis_id'];
						$cid=$row['cid'];
						$reg_date= $row['reg_date'];
						$disburse_date = $row['dis_date'];
					}
			//display approval info
			$display_appinfo="SELECT * FROM customer_app WHERE cid ='$cid' and register_date='$reg_date'";
			$result_appinfo=mysql_query($display_appinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_appinfo)){
						$rate = $row['approval_rate'];
						$Num_of_rep=$row['number_of_repay'];
					}
					
			//-----start show currency
			$display_reginfo="SELECT * FROM register WHERE id='$reg_id'";
			$result_reginfo=mysql_query($display_reginfo) or die (mysql_error());
			$check_dis=mysql_num_rows($result_reginfo);
				while($row=mysql_fetch_array($result_reginfo)){
						$kh_borrower=$row['kh_borrower'];
						$l_currency=$row['cur'];
						$dis=$row['dis'];
					}
				//////end register-------------//
		
				$minInstall="SELECT MIN(repayment_date) as min_no FROM schedule WHERE ld='$lid' AND rp='0'";
				$result_mininstall=mysql_query($minInstall) or die (mysql_error());
					while($row=mysql_fetch_array($result_mininstall)){
							$min_no=$row['min_no'];
						}
				$month=date('Y-m-d',strtotime($repay_date));	
				$cur_date_sql ="SELECT repayment_date FROM schedule where ld='$lid' and repayment_date<='$dis_repay_date' and rp<>'6' order by repayment_date limit 1;";
				$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
								while($row=mysql_fetch_array($result_cur)){
									$pre_date=$row['repayment_date'];
									
									$days=dateDiff($pre_date,$month);	
								}
								
	
				$Num_of_rep1=0;
				
				if ($Num_of_rep==7 || $Num_of_rep ==14){
					$Num_of_rep1=7;
				}
				else
				{
					$Num_of_rep1=30;	
				}
								$round_khinfo="SELECT setting FROM loan_config WHERE property='rounding'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_khrinfo)){
						$round_khr=$row['setting'];
					}
					
				/////Get today penalty
				$get_remain=0; 
				$due_pn=0.00;
				$query_pn="SELECT * FROM schedule where ld='$lid' AND dis='1' AND rp='0' and repayment_date <= '$dis_repay_date' order by repayment_date desc";
						$result_pn=mysql_query($query_pn);
						echo mysql_error();
						while($row = mysql_fetch_array($result_pn))
								{
									$sch_pn=$row['total'];
									$get_remain=$row['remain_amt'];
									$date_pn=date('Y-m-d',strtotime($row['repayment_date']));
									$days_pn=round(dateDiff($date_pn,$dis_repay_date));
									
									if($days_pn>=4){
										if ($get_remain==0)
										{
											
											if ($l_currency=='KHR'){
												$due_pn=roundkhr(($sch_pn*$rate/100)*$days_pn*2/30,$round_khr);
												
											}
											else if($l_currency=='THB'){
												$due_pn=intval(($sch_pn*$rate/100)*$days_pn*2/30,2);
											}
											else{
												$due_pn=round(($sch_pn*$rate/100)*$days_pn*2/30,2);
											}
											
										}
										else
										{
											
											if ($l_currency=='KHR'){
												$due_pn=roundkhr(($get_remain*$rate/100)*$days_pn*2/30,$round_khr);
												
											}
											else if($l_currency=='THB'){
												$due_pn=intval(($get_remain*$rate/100)*$days_pn*2/30,2);
											}
											else{
												$due_pn=round(($get_remain*$rate/100)*$days_pn*2/30,2);
											}
											
											
										}
									}	
									else{
										$due_pn=0.00;
									}
								}
				
				/////end today penalty
				/////Get Amount and Count install remain $date = strtotime(date("Y-m-d", strtotime($date)) . " +2 week");
				$se_date_sql ="SELECT repayment_date FROM schedule where ld='$lid' and repayment_date>='$dis_repay_date' and rp<>'6' order by repayment_date limit 1;";
				$result_se_date=mysql_query($se_date_sql) or die(mysql_error());
								while($row=mysql_fetch_array($result_se_date)){
									
									$se_repay = strtotime ( '14 day' , strtotime ( $row['repayment_date']));
									$se_repay=date ( 'Y-m-j' , $se_repay );
								}
	
				$cf_bq=mysql_query("SELECT setting as os FROM loan_config WHERE property='rsch'");
				$cf_bq_r=mysql_fetch_array($cf_bq);
				$cf_B = $cf_bq_r['os'];
				/*if ($l_currency=='KHR'){
												$cf_B=formatMoney(roundkhr($cf_bq_r['os'],$round_khr),true);
												
											}
											else{
												$cf_B=formatMoney(round($cf_bq_r['os'],2),true);

											}*/
				/*First Repaydate*/				
				$first_rpdate=mysql_query("SELECT * from schedule where ld='$lid' and rp<>'6' order by repayment_date limit 1");
				$first_rpdate_r=mysql_fetch_array($first_rpdate);
				$f_rpdate = $first_rpdate_r['repayment_date'];
				
				$row_count_rp=mysql_query("SELECT count(rp) as rp from schedule where ld='$lid' and rp='1' order by repayment_date");
				$row_rpcount_r=mysql_fetch_array($row_count_rp);
				$rp = $row_rpcount_r['rp'];
				if($rp==0){
									$days=dateDiff($disburse_date,$dis_repay_date);	
				}
				$First_Repay=date('Y-m-d');
				$myfirst_repay=strtotime(date('Y-m-d',strtotime($dis_repay_date))."+$Num_of_rep days");
				$First_Repay = date('d-m-Y',$myfirst_repay);
				if ($f_rpdate>$dis_repay_date){
					
					$find_prin=mysql_query("SELECT (((balance+principal)-case when rp =0 then 0 else prn_paid end)*$cf_B)/100 as pr,((((balance+case when rp =1 then 0 else principal end)*$rate)/100)/$Num_of_rep1)*$days as inte FROM schedule s WHERE ld='$lid' and rp<>'6' order by repayment_date limit 1");
				$find_prin_r=mysql_fetch_array($find_prin);
				if ($l_currency=='KHR'){
												$prin=formatMoney(roundkhr($find_prin_r['pr'],$round_khr),true);
												$inter=formatMoney(roundkhr(round($find_prin_r['inte'],2),$round_khr),true);
				}
				else if($l_currency=='THB'){
					$prin=formatMoney(round($find_prin_r['pr'],2),true);
					$inter=formatMoney(intval($find_prin_r['inte'],2),true);
				}
				else{
									$prin=formatMoney(round($find_prin_r['pr'],2),true);
				$inter=formatMoney(round($find_prin_r['inte'],2),true);

											}
				
				
				$out_bq=mysql_query("SELECT balance+principal -case when rp =0 then 0 else prn_paid end as os FROM schedule WHERE ld='$lid' and rp<>'6' order by repayment_date limit 1");
				$out_bq_r=mysql_fetch_array($out_bq);
				if ($l_currency=='KHR'){
												$Out_B=formatMoney(roundkhr($out_bq_r['os'],$round_khr),true);
											}
											else if($l_currency=='THB'){
												$Out_B=formatMoney(round($out_bq_r['os'],2),true);
											}
											else{
												$Out_B=formatMoney(round($out_bq_r['os'],2),true);

											}
	
				//$Out_B= formatMoney(trim(str_replace(",","",$Out_B))-$prin,2,true);
				
				$Out_B= trim(str_replace(",","",$Out_B))-trim(str_replace(",","",$prin));


				$ins_noq=mysql_query("SELECT count(no_install) as ins FROM schedule WHERE ld='$lid' and rp=0 order by repayment_date");
				$ins_no_r=mysql_fetch_array($ins_noq);
					if ($l_currency=='KHR'){
												$ins_no=$ins_no_r['ins'];
											}
											else if($l_currency=='THB'){
												$ins_no=$ins_no_r['ins'];
											}
											else{
												$ins_no=$ins_no_r['ins'];
											}
					
				}
				else{
					$find_prin=mysql_query("SELECT (((balance+principal)-case when rp =0 then 0 else prn_paid end)*$cf_B)/100 as pr,((((balance+case when rp =1 then 0 else principal end)*$rate)/100)/$Num_of_rep1)*$days as inte FROM schedule s WHERE  ld='$lid' and repayment_date<='$dis_repay_date' and rp<>'6' order by repayment_date");
				$find_prin_r=mysql_fetch_array($find_prin);
				if ($l_currency=='KHR'){
												$prin=formatMoney(roundkhr(round($find_prin_r['pr']),$round_khr),true);
												$inter=formatMoney(roundkhr(round($find_prin_r['inte']),$round_khr),true);
												/*echo "<script>alert('$inter');</script>";*/
											}
											else if($l_currency=='THB'){
												$prin=formatMoney(round($find_prin_r['pr'],2),true);
												$inter=intval(round($find_prin_r['inte'],2));
											}
											else{
												$prin=formatMoney(round($find_prin_r['pr'],2),true);
												$inter=formatMoney(round($find_prin_r['inte'],2),true);

											}
				
				
				$out_bq=mysql_query("SELECT (balance+principal-case when rp =0 then 0 else prn_paid end) as os FROM schedule WHERE ld='$lid' and rp<>'6' and repayment_date<='$dis_repay_date' order by repayment_date limit 1");
				$out_bq_r=mysql_fetch_array($out_bq);
				if ($l_currency=='KHR'){
												$Out_B=formatMoney(roundkhr(round($out_bq_r['os']),$round_khr),true);
											}
											else if($l_currency=='THB'){
												$Out_B=formatMoney(round($out_bq_r['os'],2),true);
											}
											else{
															$Out_B=formatMoney(round($out_bq_r['os'],2),true);

											}
	
				//$Out_B= formatMoney(trim(str_replace(",","",$Out_B))-$prin,2,true);
				
				$Out_B= trim(str_replace(",","",$Out_B))-trim(str_replace(",","",$prin));


				$ins_noq=mysql_query("SELECT count(no_install)-1 as ins FROM schedule WHERE ld='$lid' and rp=0 and repayment_date>='$dis_repay_date' order by repayment_date");
				$ins_no_r=mysql_fetch_array($ins_noq);
					if ($l_currency=='KHR'){
												$ins_no=$ins_no_r['ins'];
											}
											else if($l_currency=='THB'){
												$ins_no=$ins_no_r['ins'];
											}
											else{
												$ins_no=$ins_no_r['ins'];
											}
				}
															
				/////End
				//find min installment
				$minInstall="SELECT MIN(repayment_date) as min_no FROM schedule WHERE ld='$lid' AND rp='0'";
				$result_mininstall=mysql_query($minInstall) or die (mysql_error());
					while($row=mysql_fetch_array($result_mininstall)){
							$min_no=$row['min_no'];
						}
				/*echo"<script>alert('$min_no');</script>";*/
				

				//show due information
				
				$sch_info="SELECT * FROM schedule WHERE ld='$lid' and rp='0' and dis='1' Order By repayment_date asc";
				$result_dueinfo=mysql_query($sch_info) or die (mysql_error());
				//echo $sch_info;
				/*echo"<script>alert('$dis_repay_date');</script>";*/
				while($row=mysql_fetch_array($result_dueinfo)){
						$due_date = date('d-m-Y',strtotime($row['repayment_date']));
						$due_prn=formatMoney($row['principal'],true);
						$due_amt=formatMoney($row['total'],true);
						$due_int=formatMoney($row['interest'],true);
						
						$ori_due_prn=$row['principal'];
						$ori_due_amt=$row['total'];
						$ori_due_int=$row['interest'];
						$co=$row['response_co'];
						break;
					}
					
				// calculate interest discount
						$days_dis=dateDiff(date('Y-m-d',strtotime($repay_date)),date('Y-m-d',strtotime($due_date)));
						$dis_info="SELECT * FROM int_dis";
						$result_disinfo=mysql_query($dis_info) or die (mysql_error());
						while($row=mysql_fetch_array($result_disinfo)){
							if ($days_dis<=$row['T']){
								$int_dis=$row['C_DIS'];
								if ($int_dis==0){
									$int_dis==0;
									break;
								}
									if ($l_currency=='KHR'){
												$int_dis=roundkhr((($due_int)*$int_dis)/100,$round_khr);
											}
											else if($l_currency=='THB'){
												$int_dis=round((($due_int)*$int_dis)/100,2);
											}
											else{
												$int_dis=round((($due_int)*$int_dis)/100,2);

											}
								break;
							}
							
						}
				// end
				///Over due penalty 
				$pn_int=mysql_query("SELECT SUM(penalty) as pn_tt FROM schedule WHERE ld='$lid'");
				$pn_tt=mysql_fetch_array($pn_int);
				if ($l_currency=='KHR'){
												$overdue_pn=formatMoney(roundkhr(round($pn_tt['pn_tt']),$round_khr),true);
											}
											else if($l_currency=='THB'){
												$overdue_pn=formatMoney(round($pn_tt['pn_tt'],2),true);
											}
											else{
												$overdue_pn=formatMoney(round($pn_tt['pn_tt'],2),true);
											}
				
				///Get paid penalty 
				$pn_paid=mysql_query("SELECT SUM(norpen_paid) as norpn_paid FROM schedule WHERE ld='$lid'");
				$pn_p=mysql_fetch_array($pn_paid);
				if ($l_currency=='KHR'){
												$paid_pn=roundkhr(round($pn_p['norpn_paid']),$round_khr);
												$remain_pn=roundkhr(round($overdue_pn-$paid_pn),$round_khr);
												$total_pn=formatMoney(roundkhr(round($due_pn+$remain_pn),$round_khr),true);
											}
											else if($l_currency=='THB'){
												$paid_pn=round($pn_p['norpn_paid'],2);
												$remain_pn=round($overdue_pn-$paid_pn,2);
												//total penalty
												$total_pn=formatMoney(round($due_pn+$remain_pn,2),true);
											}
											else{
				$paid_pn=round($pn_p['norpn_paid'],2);
				
				$remain_pn=round($overdue_pn-$paid_pn,2);
				
				//total penalty
				$total_pn=formatMoney(round($due_pn+$remain_pn,2),true);
											}
				
				/*echo"<script>alert('days:$days_pn,due_pn:$due_pn,remain_pn:$remain_pn,total_pn:$total_pn,OD:$overdue_pn');</script>";*/
				///show over due information
				$sum_prn=mysql_query("SELECT SUM(principal-prn_paid) as prn_tt FROM schedule WHERE repayment_date <= '$dis_repay_date' AND ld='$lid' AND rp='0'");
				$prn_tt=mysql_fetch_array($sum_prn);
				if ($l_currency=='KHR'){
												$myodprn_tt=formatMoney(roundkhr(round($prn_tt['prn_tt']),$round_khr),true);
											}
											else if($l_currency=='THB'){
												$myodprn_tt= formatMoney(round($prn_tt['prn_tt'],2),true);
											}
											else{
												$myodprn_tt= formatMoney(round($prn_tt['prn_tt'],2),true);
											}
				
				$sum_int=mysql_query("SELECT SUM(interest-int_paid-int_dis) as int_tt FROM schedule WHERE repayment_date <= '$dis_repay_date' AND ld='$lid' AND rp='0'");
				$int_tt=mysql_fetch_array($sum_int);
				if ($l_currency=='KHR'){
												$myodint_tt=formatMoney(roundkhr(round($int_tt['int_tt']),$round_khr),true);
											}
											else if($l_currency=='THB'){
												$myodint_tt= formatMoney(round($int_tt['int_tt'],2),true);
											}
											else{
												$myodint_tt= formatMoney(round($int_tt['int_tt'],2),true);
											}
				
				$total_int=mysql_query("SELECT SUM(total-(prn_paid+int_paid+int_dis)) as total_tt FROM schedule WHERE repayment_date <= '$dis_repay_date' AND ld='$lid' AND rp='0'");
				$toal_tt=mysql_fetch_array($total_int);
					if ($l_currency=='KHR'){
												$myodtotal_tt=formatMoney(roundkhr(round($toal_tt['total_tt']),$round_khr),true);
											}
											else if($l_currency=='THB'){
												$myodtotal_tt=formatMoney(round($toal_tt['total_tt'],2),true);
											}
											else{
																$myodtotal_tt=formatMoney(round($toal_tt['total_tt'],2),true);

											}
				
				/////////////
				if($min_no==''){
					echo"<script>alert('There is no this record in System! Please Check again!');</script>";	
					echo"<script>window.location.href='index.php?pages=reschedule';</script>";
					exit();
					}
				///check dis
				if($dis=='0'){
					echo"<script>alert('There Customer is not yet disbursed! Please Check again!');</script>";	
					echo"<script>window.location.href='index.php?pages=reschedule';</script>";
					}
			}///isset displaay
			
	//--check ld
	//---end diplay
	//---------start disbursement----------------//
		if(isset($_POST['repayment'])){//start schedule 
			//////////////////
				$query_maxid = "SELECT max(max_id) as code FROM loan_process"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['code'];
						$convert = round($max);
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
		$first_repay=date('Y-m-d',strtotime($_POST['f_repay']));
		$re_co=$_POST['co_name'];
		$grace_period=$_POST['grace_period'];
		$percentage=$_POST['percentage'];
		$myreg_date=date('Y-m-d',strtotime($_POST['regis_date']));
		$myapp_date=date('Y-m-d',strtotime($_POST['app_date']));
		$myloan_date=date('Y-m-d',strtotime($_POST['loan_date']));
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
		$myco_name=$_POST['co_name'];
		$myrecom_name=$_POST['recom_name'];
		$amount = $_POST['OS'];
		$amount = trim(str_replace(",","",$amount));
		$period=$_POST['period'];
		$rate=$_POST['rate'];
		$prin = $_POST['prn_repay'];
		$inter = $_POST['inter'];
		$penalty= $_POST['penalty'];
		$rep_date = date('Y-m-d',strtotime($_POST['repay_date']));
		//$amount = trim(split($amount,','));
		//--------------select customer 's adr---------//
		
		
		//---select from approval again
		$get_regis_id="SELECT * FROM register WHERE cif='$mycid' AND appr='1' AND cancel='0' AND bcif='1' AND bloan='0' AND dis='0' ORDER BY id DESC";
		$result_reg_id=mysql_query($get_regis_id) or die (mysql_error());
			while($row=mysql_fetch_array($result_reg_id)){
				$reg_id=$row['id'];
				$cur=$row['cur'];
			}
			$display_info="SELECT * FROM loan_process WHERE ld='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$reg_id = $row['regis_id'];
						$cid=$row['cid'];
					}
			//
			$sql_loan_app="SELECT * FROM customer_app WHERE cid='$cid' ORDER BY id DESC";
						$result_loan_app=mysql_query($sql_loan_app) or die (mysql_error());
							while($row = mysql_fetch_array($result_loan_app)){
								$amount=$amount;
								$rate=$rate;
								$no_r=round($row['number_of_repay']);
								$period=$period;
		}
		//---get address
			$sql_loan_adr="SELECT * FROM cif_detail WHERE cif='$cid' AND cust_kind ='borrower' ORDER BY id DESC";
						$result_loan_adr=mysql_query($sql_loan_adr) or die (mysql_error());
							while($row = mysql_fetch_array($result_loan_adr)){
								$vil=$row['village'];
								$com=$row['commune'];
								$dist=$row['district'];
								$pro=$row['province'];
							}
		
		#----------------------------start create schedule----------------------------------#
		/////////////////////////////////////////////Update Schedule//////////////////////////////////
								
								
								$update_sch="UPDATE schedule SET prn_paid ='$prin',int_paid='$inter',rp='1',paid_date ='$rep_date' 
								 ,penalty='$penalty',remain_amt='0',norpen_paid='$penalty',int_dis='0',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND rp=0 order by repayment_date limit 1";
									mysql_query($update_sch) or die (mysql_error());
									
									//Insert schedule his
									$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$rep_date','$max','$prin','$inter','$penalty',0,'0','$get_br','$user')";
									mysql_query($insert_sch) or die (mysql_error());
									
									$insert_lph="insert into  loan_process_hist select * from loan_process where ld='$lid'";
									mysql_query($insert_lph) or die (mysql_error());
									$update_lp="update loan_process set status=6 where ld='$lid'";
									mysql_query($update_lp) or die (mysql_error());
									
				$round_khinfo="SELECT setting FROM loan_config WHERE property='rounding'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_khrinfo)){
						$round_khr=$row['setting'];
					}
									$invoice_exc="INSERT INTO invoice(id,reg_id,lc,paid_date,sch_date,invioce_no,prn_paid,int_paid,pn_paid,int_dis,payoff_pnpaid,total,cashier,pay_type,pay_status,reciev_at,max_id,res_co,cur) VALUES (null,'$myreg_id', '$lid', '$rep_date', '$sch_date', '$max','$prin','$inter','$penalty','0','0', '$prin+$inter+$penalty', '$user','$dis_type', 'gm', '$get_br', '$max', '$myco', '$mycur');";
					
									$invoice_sms = mysql_query($invoice_exc) or die(mysql_error());
									/////////////End///////////////
								$sql_update="update schedule set rp='6' where ld='$lid'";
								$re_sql_update=mysql_query($sql_update) or die (mysql_error());
								
								$days = dateDiff($_POST['repay_date'],$first_repay);
								$dayset=date('d',strtotime($first_repay));
								$ba=$amount;	
								$no_installment=round($period*$no_r/$no_r);
								
									if ($cur=='KHR'){
												$pr=roundkhr(round($amount/$no_installment),$round_khr);
												$int=roundkhr(round((($ba*$rate/100)/$no_r*$days)),$round_khr);
											}
											else if($l_currency=='THB'){
												$pr=round($amount/$no_installment,2);
												$int=round((($ba*$rate/100)/$no_r*$days),2);	
											}
											else{
												$pr=round($amount/$no_installment,2);
												$int=round((($ba*$rate/100)/$no_r*$days),2);	
											}
								
								
								////////////////////////
								$period=round($period);
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
										/*echo "<script>alert('$days');</script>";*/
								//end check
		#---------------start USD-------------#
			if($cur=='USD'){
		#-----------------------------forward-----------------------------------------------
				if($setting=='forward'){//check if forward
				
						if($method=='Declining' || $method=='Negotiation'){ //start decline
									$i=1;
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));										
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ORDER BY id ASC;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list				   
													////end skip holiday and weekend
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////
														////////////
													//////////////cut and sum
															/*if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;*/
															
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																
																}
														/////////////
													/////////////loop schedule
													  ///////////start calculate
													  			
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
											echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
											mysql_close();
											echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
													//$month = strtotime("+1 day",$month);
													///////////////////
												if($no_r=='30'){//check if 30 days
												
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);	
																	}
														
														$month=$realdate;	
														$month = strtotime('+ 1 months',$month);
														$mymonth=date('d-m-y',$month);
													
												}
												else{
													
														if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
														
													} 
												/*echo"<script>alert('$mymonth');</script>";*/
												//////////////////	
												
												$i=$i+1;
											
										}//end while
									}//end if end declining
									
									if($method=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&&($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
														
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
														/*	if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$period;
																$pr=$ba;
																	
																}*/
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
													///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(round($percentage>$get_percent || $percentage=='0')){
														echo"<script>
																alert('Please check ur percentage again!');
															</script>
															";
								echo"<script>alert('Percentage you typed = $percentage AND from Setting = $get_percent!Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
													}
										///////////////////	
											
									$i=1;
									$pr=round($ba*$percentage/100,2);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
											
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															/*if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_installment;
																$pr=$ba;
																
																}*/
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=$pr;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														}  
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end percentage
									if($method=='Semi-Balloon'){ //start Semi-Balloon
										///check policy 
											if(($grace_period > $get_gp) || empty($grace_period)){
												echo"<script>
														alert('Please check your grace period again! ');
													</script>
															";
							echo"<script>alert('Grace Period you typed = $grace_period AND from Setting = $get_gp !Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
											}
										////////		
									$i=1;
									$nopr=ceil($period/$grace_period);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										$pr=round($amount/$nopr,2);
										/*echo"<script>alert('$nopr');</script>";*/
													
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												   
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																WHERE ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
													//////////////cut and sum
															/*if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_r;
																$pr=$ba;
																	
																}*/
														/////////////
														/////////////loop schedule
													  	///////////start calculate
																	
													  				if($i<$grace_period){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	if($i==1){
																		$current_gp=$grace_period;
																	}
																	if($i==$grace_period){
																		$grace_period=$grace_period+$current_gp;
																		$pr=$pr;
																	}	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date) && !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+ 1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												
												$i=$i+1;
										}//end while
									}//end if
									//////////end semi-balloon
									
									if($repayment_m=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&& ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `repayment_schedule` 
																where lc='$loan_code' and no=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															/*if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																	
																}*/
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	 if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
											echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end balloon
									
				}//--end if forward
		#-----------------------------end forward-------------------------------------------#
		#-----------------------------backward-----------------------------------------------
				if($setting=='backward'){//check if forward
				
				
						if($method=='Declining' || $method=='Negotiation'){ //start decline
									$i=1;
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));										
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list			   
													////end skip holiday and weekend
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																
																}
														/////////////
													
													/////////////loop schedule
													  ///////////start calculate
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
					if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
													//$month = strtotime("+1 day",$month);
													///////////////////
												if($no_r==(30)){//check if 30 days
												
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														
														$month=$realdate;	
														$month = strtotime('+1 months',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{

																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														}  
													}
												//////////////////	
												
												$i=$i+1;
											
										}//end while
									}//end if end declining
									
									if($method=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&&($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
														
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$period;
																$pr=$ba;
																	
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	 if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
													///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														}  
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(round($percentage>$get_percent) || ($percentage=='0')){
														echo"<script>
																alert('You are not allow to input percentage > $get_percent at all :-) ');
															</script>
															";
								echo"<script>alert('Percentage you typed = $percentage AND from Setting = $get_percent!Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
													}
										///////////////////	
											
									$i=1;
									$pr=round($ba*$percentage/100,2);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
											
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_installment;
																$pr=$ba;
																
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=$pr;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														}  
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end percentage
									if($method=='Semi-Balloon'){ //start Semi-Balloon
										///check policy 
											if(($grace_period > $get_gp) || empty($grace_period)){
												echo"<script>
														alert('Please check ur garce period again!');
													</script>
															";
							echo"<script>alert('Grace Period you typed = $grace_period AND from Setting = $get_gp !Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
											}
										////////		
									$i=1;
									$nopr=ceil($period/$grace_period);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										$pr=round($amount/$nopr,2);
										/*echo"<script>alert('$nopr');</script>";*/
													
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												   
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																WHERE ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_r;
																$pr=$ba;
																	
																}
														/////////////
														/////////////loop schedule
													  	///////////start calculate
																	
													  				if($i<$grace_period){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	if($i==1){
																		$current_gp=$grace_period;
																	}
																	if($i==$grace_period){
																		$grace_period=$grace_period+$current_gp;
																		$pr=$pr;
																	}	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+ 1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														} 
													}
												//////////////////
												
												$i=$i+1;
	
										}//end while
									}//end if
									//////////end semi-balloon
									
									if($repayment_m=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&& ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `repayment_schedule` 
																where lc='$loan_code' and no=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																	
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	 if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
				if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														} 
													}
												//////////////////
												$i=$i+1;
												echo"<script>alert('$i,$no_installment');</script>";
												
										}//end while
									}//end if			
									//////////end balloon
									
				}//--end if backward
		#-----------------------------end backward-------------------------------------------#
			}
		#----------------end USD-------------------------------------------------------------#
		#---------------start THB-------------#
			if($cur=='THB'){
		#-----------------------------forward-----------------------------------------------
				if($setting=='forward'){//check if forward
				
						if($method=='Declining' || $method=='Negotiation'){ //start decline
									$i=1;
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));										
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ORDER BY id ASC;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list				   
													////end skip holiday and weekend
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////
														////////////
													//////////////cut and sum
															/*if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;*/
															
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																
																}
														/////////////
													/////////////loop schedule
													  ///////////start calculate
													  			
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
											echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
											mysql_close();
											echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
													//$month = strtotime("+1 day",$month);
													///////////////////
												if($no_r=='30'){//check if 30 days
												
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);	
																	}
														
														$month=$realdate;	
														$month = strtotime('+ 1 months',$month);
														$mymonth=date('d-m-y',$month);
													
												}
												else{
													
														if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
														
													} 
												/*echo"<script>alert('$mymonth');</script>";*/
												//////////////////	
												
												$i=$i+1;
											
										}//end while
									}//end if end declining
									
									if($method=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&&($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
														
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
														/*	if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$period;
																$pr=$ba;
																	
																}*/
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
													///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(round($percentage>$get_percent || $percentage=='0')){
														echo"<script>
																alert('Please check ur percentage again!');
															</script>
															";
								echo"<script>alert('Percentage you typed = $percentage AND from Setting = $get_percent!Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
													}
										///////////////////	
											
									$i=1;
									$pr=round($ba*$percentage/100,2);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
											
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															/*if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_installment;
																$pr=$ba;
																
																}*/
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=$pr;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														}  
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end percentage
									if($method=='Semi-Balloon'){ //start Semi-Balloon
										///check policy 
											if(($grace_period > $get_gp) || empty($grace_period)){
												echo"<script>
														alert('Please check your grace period again! ');
													</script>
															";
							echo"<script>alert('Grace Period you typed = $grace_period AND from Setting = $get_gp !Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
											}
										////////		
									$i=1;
									$nopr=ceil($period/$grace_period);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));

										$pr=round($amount/$nopr,2);
										/*echo"<script>alert('$nopr');</script>";*/
													
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												   
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																WHERE ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
													//////////////cut and sum
															/*if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_r;
																$pr=$ba;
																	
																}*/
														/////////////
														/////////////loop schedule
													  	///////////start calculate
																	
													  				if($i<$grace_period){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	if($i==1){
																		$current_gp=$grace_period;
																	}
																	if($i==$grace_period){
																		$grace_period=$grace_period+$current_gp;
																		$pr=$pr;
																	}	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date) && !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+ 1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												
												$i=$i+1;
										}//end while
									}//end if
									//////////end semi-balloon
									
									if($repayment_m=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&& ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `repayment_schedule` 
																where lc='$loan_code' and no=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															/*if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																	
																}*/
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	 if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
											echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end balloon
									
				}//--end if forward
		#-----------------------------end forward-------------------------------------------#
		#-----------------------------backward-----------------------------------------------
				if($setting=='backward'){//check if forward
				
				
						if($method=='Declining' || $method=='Negotiation'){ //start decline
									$i=1;
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));										
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list			   
													////end skip holiday and weekend
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																
																}
														/////////////
													
													/////////////loop schedule
													  ///////////start calculate
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
					if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
													//$month = strtotime("+1 day",$month);
													///////////////////
												if($no_r==(30)){//check if 30 days
												
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														
														$month=$realdate;	
														$month = strtotime('+1 months',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														}  
													}
												//////////////////	
												
												$i=$i+1;
											
										}//end while
									}//end if end declining
									
									if($method=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&&($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
														
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$period;
																$pr=$ba;
																	
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	 if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
													///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														}  
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(round($percentage>$get_percent) || ($percentage=='0')){
														echo"<script>
																alert('You are not allow to input percentage > $get_percent at all :-) ');
															</script>
															";
								echo"<script>alert('Percentage you typed = $percentage AND from Setting = $get_percent!Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
													}
										///////////////////	
											
									$i=1;
									$pr=round($ba*$percentage/100,2);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
											
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_installment;
																$pr=$ba;
																
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=$pr;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);	
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														}  
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end percentage
									if($method=='Semi-Balloon'){ //start Semi-Balloon
										///check policy 
											if(($grace_period > $get_gp) || empty($grace_period)){
												echo"<script>
														alert('Please check ur garce period again!');
													</script>
															";
							echo"<script>alert('Grace Period you typed = $grace_period AND from Setting = $get_gp !Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
											}
										////////		
									$i=1;
									$nopr=ceil($period/$grace_period);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										$pr=round($amount/$nopr,2);
										/*echo"<script>alert('$nopr');</script>";*/
													
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												   
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																WHERE ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_r;
																$pr=$ba;
																	
																}
														/////////////
														/////////////loop schedule
													  	///////////start calculate
																	
													  				if($i<$grace_period){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	if($i==1){
																		$current_gp=$grace_period;
																	}
																	if($i==$grace_period){
																		$grace_period=$grace_period+$current_gp;
																		$pr=$pr;
																	}	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+ 1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														} 
													}
												//////////////////
												
												$i=$i+1;
	
										}//end while
									}//end if
									//////////end semi-balloon
									
									if($repayment_m=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&& ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `repayment_schedule` 
																where lc='$loan_code' and no=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																	
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=round((($ba*$rate/100)/$myno_r*$days),2);
																	$pa=round($pr+$int,2);
																	$ba=round($ba-$pr,2);
																	
															////end calculate
													 	 if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
				if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														} 
													}
												//////////////////
												$i=$i+1;
												echo"<script>alert('$i,$no_installment');</script>";
												
										}//end while
									}//end if			
									//////////end balloon
									
				}//--end if backward
		#-----------------------------end backward-------------------------------------------#
			}
		#----------------end THB-------------------------------------------------------------#
		
		#-----------start KHR----------------------------------#
		
			if($cur=='KHR'){
		#-----------------------------forward-----------------------------------------------#
				if($setting=='forward'){//check if forward
				
				
						if($method=='Declining' || $method=='Negotiation'){ //start decline
									$i=1;
									while(($month<$end) && ($i<=$no_installment))

										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));										
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ORDER BY id ASC;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list				   
													////end skip holiday and weekend
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																
																}
														/////////////
													
													/////////////loop schedule
													  ///////////start calculate
													  				$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);																																															  																	$ba=roundkhr(round($ba-$pr),$round_khr);
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
											echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
											mysql_close();
											echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
													//$month = strtotime("+1 day",$month);
													///////////////////
												if($no_r==(30)){//check if 30 days
												
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														
														$month=$realdate;	
														$month = strtotime('+1 months',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														}  
													}
												//////////////////	
												
												$i=$i+1;
											
										}//end while
									}//end if end declining
									
									if($method=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&&($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
														
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$period;
																$pr=$ba;
																	
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
															////end calculate
													 	 if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
													///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(round($percentage>$get_percent || $percentage=='0')){
														echo"<script>
																alert('Please check ur percentage again!');
															</script>
															";
								echo"<script>alert('Percentage you typed = $percentage AND from Setting = $get_percent!Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
													}
										///////////////////	
											
									$i=1;
									$pr=round($ba*$percentage/100,2);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
											
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_installment;
																$pr=$ba;
																
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=$pr;
																	}
																	$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
																																																
																	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														}  
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end percentage
									if($method=='Semi-Balloon'){ //start Semi-Balloon
										///check policy 
											if(($grace_period > $get_gp) || empty($grace_period)){
												echo"<script>
														alert('Please check your grace period again! ');
													</script>
															";
							echo"<script>alert('Grace Period you typed = $grace_period AND from Setting = $get_gp !Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
											}
										////////		
									$i=1;
									$nopr=ceil($period/$grace_period);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										$pr=round($amount/$nopr,2);
										/*echo"<script>alert('$nopr');</script>";*/
													
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												   
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																WHERE ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_r;
																$pr=$ba;
																	
																}
														/////////////
														/////////////loop schedule
													  	///////////start calculate
																	
													  				if($i<$grace_period){
																		$pr=0;
																	}
																	
																	$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
																	if($i==1){
																		$current_gp=$grace_period;
																	}
																	if($i==$grace_period){
																		$grace_period=$grace_period+$current_gp;
																		$pr=$pr;
																	}	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date) && !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
										echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+ 1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												
												$i=$i+1;
										}//end while
									}//end if
									//////////end semi-balloon
									
									if($repayment_m=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&& ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
																$countholiday=$countholiday+2;
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$countholiday=$countholiday+1;
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																/*echo "<script>alert('$ho,$countholiday,$month');</script>";	*/
																$countholiday=$countholiday+1;
																$month = strtotime("+1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("+1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `repayment_schedule` 
																where lc='$loan_code' and no=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																	
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	
																	$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														} $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
											echo"<script>alert('Could Not Catch Installment!Please input all required information');</script>";
																	mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('-1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('-2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('-3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('-4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('-5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('-6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('-7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
															
														} 
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end balloon
									
				}//--end if forward
		#-----------------------------end forward-------------------------------------------#
		#-----------------------------backward-----------------------------------------------
				if($setting=='backward'){//check if forward
				
				
						if($method=='Declining' || $method=='Negotiation'){ //start decline
									$i=1;
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));										
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list			   
													////end skip holiday and weekend
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																
																}
														/////////////
													
													/////////////loop schedule
													  ///////////start calculate
											  					    $int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
					if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
													//$month = strtotime("+1 day",$month);
													///////////////////
												if($no_r==(30)){//check if 30 days
												
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														
														$month=$realdate;	
														$month = strtotime('+1 months',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														}  
													}
												//////////////////	
												
												$i=$i+1;
											
										}//end while
									}//end if end declining
									
									if($method=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&&($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
														
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$period;
																$pr=$ba;
																	
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
													///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														}  
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(round($percentage>$get_percent) || ($percentage=='0')){
														echo"<script>
																alert('You are not allow to input percentage > $get_percent at all :-) ');
															</script>
															";
								echo"<script>alert('Percentage you typed = $percentage AND from Setting = $get_percent!Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
													}
										///////////////////	
											
									$i=1;
									$pr=round($ba*$percentage/100,2);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
											
										/*echo"<script>alert('$myholiday');</script>";*/
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_installment;
																$pr=$ba;
																
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=$pr;
																	}
																	$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														} 
													}
												//////////////////
												$i=$i+1;
												
												
										}//end while
									}//end if			
									//////////end percentage
									if($method=='Semi-Balloon'){ //start Semi-Balloon
										///check policy 
											if(($grace_period > $get_gp) || empty($grace_period)){
												echo"<script>
														alert('Please check ur garce period again!');
													</script>
															";
							echo"<script>alert('Grace Period you typed = $grace_period AND from Setting = $get_gp !Try Again!');</script>";
														mysql_close();
														echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
											}
										////////		
									$i=1;
									$nopr=ceil($period/$grace_period);
									while(($month<$end) && ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										$pr=round($amount/$nopr,2);
										/*echo"<script>alert('$nopr');</script>";*/
													
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												   
													////end skip holiday and weekend
													$mydate=$month;
													
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `schedule` 
																WHERE ld='$myld' AND no_install=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$no_r;
																$pr=$ba;
																	
																}
														/////////////
														/////////////loop schedule
													  	///////////start calculate
																	
													  				if($i<$grace_period){
																		$pr=0;
																	}
																	$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
																	if($i==1){
																		$current_gp=$grace_period;
																	}
																	if($i==$grace_period){
																		$grace_period=$grace_period+$current_gp;
																		$pr=$pr;
																	}	
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																		
																	}
														$month=$realdate;	
														$month = strtotime('+ 1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														} 
													}
												//////////////////
												
												$i=$i+1;
	
										}//end while
									}//end if
									//////////end semi-balloon
									
									if($repayment_m=='Balloon'){ //start Balloon
									$i=1;
									while(($month<$end)&& ($i<=$no_installment))
										{
										$mydate=date('D',$month);
										$myholiday=date('D',date('Y-m-d',strtotime($myholiday)));
										
										/*echo"<script>alert('$myholiday');</script>";*/
										
													//////////skip sat and sun and holiday
													//chek holiday list
													$holi_sql = "SELECT holiday FROM `holiday` ;";
													$result_holi=mysql_query($holi_sql) or die(mysql_error());
												while($row=mysql_fetch_array($result_holi)){//start holiday
															$ho=$row['holiday'];
															$holi_list=strtotime(date('Y-m-d',strtotime($ho)));
														
														// skip sat and sun										
														$mydate=date('D',$month);
														if($mydate=='Sat'){
															$countholiday=$countholiday+1;
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$countholiday=$countholiday+2;
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
																$countholiday=$countholiday+1;
																$month = strtotime("-1 day", $month);//skip holiday
																if($month==$holi_list){
																	$month = strtotime("-1 day", $month);//skip holiday
																}
														}
												   }//end holiday list	
												  
													////end skip holiday and weekend
													
													$mydate=$month;
													///////////
													//calculate num_days
															if($i>1){
																$cur_date_sql ="SELECT repayment_date FROM `repayment_schedule` 
																where lc='$loan_code' and no=($i-1);";
																$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_cur)){
																		$pre_date=$row['repayment_date'];
																		$real_date=date('Y-m-d',$month);
																		$days=dateDiff($pre_date,$real_date);	
																	}		
																}
															/////////////////	
															
														////////////
													//////////////cut and sum
															if($i==1){
																$real_pr=substr($pr,-2,2);
															}
															$pr=$sub_pr=round($pr);
															
															$str_pr=$real_pr/100;
															$final_pr=$str_pr;
															if($i==$no_installment){
																$last_pr=$final_pr*$term;
																$pr=$ba;
																	
																}
														/////////////
													/////////////loop schedule
													 /* echo"<script>alert('$mydate,$myholiday');</script>"; */	
													  ///////////start calculate
																	
													  				if($i<$no_installment){
																		$pr=0;
																	}
																	$int=roundkhr(round((($ba*$rate/100)/$myno_r*$days)),$round_khr);
																	$pa=roundkhr(round($pr+$int),$round_khr);
																	$ba=roundkhr(round($ba-$pr),$round_khr);
																	
															////end calculate
													 	if ($i==1){
															 $installment_date = date('Y-m-d',$start);	
														}
														if($i!=1){
													 	 	 $installment_date = date('Y-m-d',$month);
														}
														 $day_kh=date('D',$installment_date);	
				if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no,dis)
														VALUES
											(Null,'$today','$cid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br',1)";
																	mysql_query($insert_date) or die(mysql_error());
																	}
																	else {
																	echo"<script>alert('Could Not Catch Installment');</script>";
																}
																//$month = strtotime("+1 day",$month);
												///////////////////
												if(($no_r==30)){//check if 30 days
														//check to same day
														$same_date_sql ="SELECT repayment_date FROM `schedule` 
																where ld='$myld' and no_install=($i);";
																$result_samedat=mysql_query($same_date_sql) or die(mysql_error());
																	while($row=mysql_fetch_array($result_samedat)){
																		$pr_date=$row['repayment_date'];
																		$date_explod = date('d/m/Y',strtotime($pr_date));
																		$datepiece=explode("/",$date_explod);
																		$realdate=strtotime($dayset."-".$datepiece[1]."-".$datepiece[2]);
																	}
														$month=$realdate;	
														$month = strtotime('+1 month',$month);
													
												}
												else{
													if ($no_r==7){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+7 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==14){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+14 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==15){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+15 day',$month);
																$mydate=date('D',$month);
																if ($mydate!=$strdate){
																	echo"<script>alert('$countholiday');</script>";
																	if($countholiday==1)
																	{
																		$month = strtotime('+1 day',$month);
																	}
																	if($countholiday==2)
																	{
																		$month = strtotime('+2 day',$month);
																	}
																	if($countholiday==3)
																	{
																		$month = strtotime('+3 day',$month);
																	}
																	if($countholiday==4)
																	{
																		$month = strtotime('+4 day',$month);
																	}
																	if($countholiday==5)
																	{
																		$month = strtotime('+5 day',$month);
																	}
																	if($countholiday==6)
																	{
																		$month = strtotime('+6 day',$month);
																	}
																	if($countholiday==7)
																	{
																		$month = strtotime('+7 day',$month);
																	}
																	$countholiday=0;
																}
															
														}
														if ($no_r==1){
															if ($i==1){
																$mydate=date('D',$start);
																$strdate=$mydate;
															}
															
																$month = strtotime('+1 day',$month);
																
															
														} 
													}
												//////////////////
												$i=$i+1;
												/*echo"<script>alert('$i,$no_installment');</script>";*/
												
										}//end while
									}//end if			
									//////////end balloon
									
				}//--end if backward
		#-----------------------------end backward-------------------------------------------#
			$sql_update="update schedule set rp='6' where ld='$lid'";
			$re_sql_update=mysql_query($sql_update) or die (mysql_error());
			echo"<script>alert('Save successfully.');</script>";
			echo"<script>window.location.href='index.php?pages=reschedule&catch=repay';</script>";	
			}
		#----------------end KHR-------------------------------------------------------------#
		#-----------------------------end create schedule-----------------------------------#
		#-------------------insert to loan table--------------------------------------------#
		
			/*if(!empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
				
				$input_loan=mysql_query("INSERT INTO `loan_process` (
										`id` ,
										`regis_id` ,
										`reg_date` ,
										`app_date` ,
										`loan_date` ,
										`cid` ,
										`ld` ,
										`percentage` ,
										`grace_period` ,
										`classified_purpose` ,
										`first_repay_date` ,
										`borrower_income` ,
										`co_borrower_income` ,
										`dependant_income` ,
										`other_income` ,
										`family_expense` ,
										`remain_income` ,
										`ability` ,
										`loan_security` ,
										`depositor_name` ,
										`co_depositor_name` ,
										`ownership` ,
										`title_type` ,
										`callateral_type` ,
										`north` ,
										`south` ,
										`east` ,
										`west` ,
										`title_no` ,
										`issue_date` ,
										`issued_by` ,
										`max_id` ,
										`group_id` ,
										`post_by` ,
										`dis` ,
										`status` ,
										`loan_at` ,
										`loan_type`,
										`co` ,
										`recom_name`,
										`cur`
)
VALUES (
NULL , '$reg_id', '$myreg_date', '$myapp_date', '$myloan_date', '$mycid', '$myld', '$percentage', '$grace_period', '$myclassi_purpose', '$first_repay', '$mybor_income', '$mycobor_income', '$dependant_income', '$other_income', '$family_ex', '$remain', '$ability', '$loan_sec', '$depositor', '$co_depositor', '$ownership', '$title_type', '$collateral_type', '$north', '$south', '$east', '$west', '$titile_no', '$issued_date', '$issued_by', '$max', '', '$user', '', '', '$get_br','individual','$myco_name','$myrecom_name','$mycur'
);
");
						
				#----------------update register infor------------------#
						$update_bloan=mysql_query("UPDATE register SET bloan='1' WHERE id='$reg_id' AND cif='$mycid'");
				#--------------end update register infor----------------#
				#----------------update address for schedule------------------#
						$update_schedule=mysql_query("UPDATE schedule SET province='$s_prov',district='$s_dis',commune='$s_com',village='$s_vil'  WHERE ld='$myld'");
						echo"<script>alert('Save successfully! Please Note Loan ID: $myld');</script>";
				#--------------end update address for schedule----------------#
						echo"<script>window.location.href='index.php?pages=individual_loanForm';</script>";
				}*/
				
				else{
						echo"<script>alert('Save unsuccessfully.');</script>";	
			}//end check empty

		#-------------------insert to loan table--------------------------------------------#
		}//end isset schedule
		
	//------------end repay transaction---------------// 
	?>
<!-- start content-outer -->
<h3 class="tit">Easy Reschedule Form :</h3>
		<!-- start id-form -->
        <form name="rcsh" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'" class="nostyle">
         <tr>
		<th valign="top">LID :</th>
		<td>	
            <input type="hidden" name="reg_id" value="<?php echo $reg_id; ?>" />
            <input type="hidden" name="co" value="<?php echo $co; ?>" />
             <input type="hidden" name="cur" value="<?php echo $l_currency; ?>" />
            <input type="text" class="input-text" name="lid" id="lid" autocomplete="off" 
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
			<td>
            <a href="pages/schedule.php?r_id=<?php echo $reg_id;?>" target="_blank" title="ទៅកាន់តារាងបង់ប្រាក់">Goto Schedule</a>
            </td>
		</tr> 
		<tr>
			<th valign="top">Outstanding Balance :</th>
			<td>
            <input type="text" class="input-text" name="OS" id="OS" value="<?php echo formatMoney($Out_B,2,true); ?>" autocomplete="off"
             readonly="readonly"/>
             <input type="hidden" class="input-text" name="OS1" id="OS1" value="<?php echo $Out_B; ?>" autocomplete="off"
             readonly="readonly">
             </td>
            <th valign="top">Reschedule Date :</th>
			<td>
            <input type="text" class="input-text" name="repay_date" id="repay_date" 
            value="<?php if(!empty($mydate)){
												echo $mydate;
											}
											 else{
											 	echo date('d-m-Y'); 
											 } ?>" 
            onblur="doDate(this,'em_Date');" autocomplete="off"/></td>
		</tr>
        <tr>
			<th valign="top">Principal :</th>
			<td><input type="text" class="input-text" name="prin" id="prin" readonly value="<?php echo $prin; ?>" 
            onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
	<th valign="top">Interest :</th>
			<td><input type="text" class="input-text" name="inter" id="inter" readonly value="<?php echo $inter; ?>" 
             onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
		</tr>
             <tr>
                         <th valign="top">Penalty :</th>
			<td><input type="text" class="input-text" name="penalty" id="penalty" readonly value="<?php echo formatmoney($due_pn,true); ?>" 
             onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
        <th valign="top">First Repayment :</th>
			<td><input type="text" class="input-text" name="f_repay" id="f_repay" value="<?php if(!empty($First_Repay)){
												echo $First_Repay;
											}
											 else{
											 	echo date('d-m-Y'); 
											 } ?>" 
            onblur="doDate(this,'em_Date');" onkeypress="return handleEnter(this, event);" autocomplete="off"/>
            <input type="hidden" class="input-text" name="s_repay" id="s_repay" value="<?php if(!empty($Se_Repay)){
												echo $Se_Repay;
											}
											 else{
											 	echo date('d-m-Y'); 
											 } ?>" 
            onblur="doDate(this,'em_Date');" onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>

        </tr>
		<tr>
        	
			<th valign="top">Period :</th>
			<td><input type="text" class="input-text" name="period" id="period" value="<?php echo $ins_no; ?>" 
            onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
			<th valign="top">Rate :</th>
			<td><input type="text" class="input-text" name="rate" id="rate" readonly value="<?php echo $rate; ?>" 
             onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
		</tr>
        	
		<tr>
        	<th valign="top">Setting :</th>
		<td>	
            <select class="input-text" name="setting" id="setting" onkeypress="return handleEnter(this, event);">
                     <option value="forward" selected="selected">Forward</option>
                   	 <option value="backward">Backward</option> 
            </select>
		</td>
	
			<th valign="top">Method :</th>
			 <td align="left" valign="middle">
                	<select class="input-text" name="method" id="method" size="1" onkeypress="return handleEnter(this, event);">
                    	<option value="0">--Repayment Methods--</option>
                        <?php 
								$str_method="Select * from repay_method Group by method asc";
								$sql_method=mysql_query($str_method);
								while ($row=mysql_fetch_array($sql_method))
								{
									$method=$row['method'];
									echo '<option value="'.$method.'">' .$method. '</option>';
								}
							?>
                    </select>
                </td>
	
		</tr>
   <tr>
        	
			<th valign="top">Total :</th>
			<td><input type="text" class="input-text" name="total" id="total" readonly value="<?php echo formatMoney(round(trim(str_replace(",","",$prin))+trim(str_replace(",","",$inter))+trim(str_replace(",","",$due_pn)),2),true); ?>" 
             onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
            <th valign="top">Principal Repay :</th>
			<td><input type="text" class="input-text" name="prn_repay" id="prn_repay" value="0" 
            onkeypress="return handleEnter(this, event);" onblur="doRepay(this.value)" autocomplete="off"/></td>
		</tr>
        <tr>
			<th valign="top">Currency :</th>
			<td><input type="text" class="input-text" name="cur" id="cur" readonly value="<?php echo $l_currency; ?>" 
            onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
		</tr>
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="repayment" class="form-submit" name="repayment" id="repayment"  onclick="doValidate()"
            onclick="return confirm('Are you sure want to do repayment for <?php echo $kh_borrower; ?> ?');" />
                <input type="reset" value="reset" class="form-reset"  />

            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>