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
					document.getElementById("total_amt").value = formatCurrency(input1);
					document.getElementById("remain").value = 0; 
					return;
				}
				if (parseInt(input)<=parseInt(document.getElementById("total_amt_hiden").value.replace(",",""))){
					document.getElementById("total_amt").value = formatCurrency((document.getElementById("total_amt_hiden").value.replace(",","")-input).toFixed(2));
					document.getElementById("remain").value = 0; 

				}
			    else if (parseInt(input)>parseInt(document.getElementById("total_amt_hiden").value.replace(",",""))){
					document.getElementById("remain").value = formatCurrency((input.replace(",","") - document.getElementById("total_amt_hiden").value.replace(",","")).toFixed(2)); 
					document.getElementById("total_amt").value = 0;
		
					
				} 	
				

            }
			function doTotalPenalty(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
				if (input == "")
				{
					//alert(document.getElementById("total_amt_hiden").value);
					var input1 = document.getElementById("repay_penalty_hiden").value.replace(",","");
					document.getElementById("repay_penalty").value = formatCurrency(input1);
					document.getElementById("repay_penalty_remain").value = 0; 
					return;
				}
				if (parseInt(input)<=parseInt(document.getElementById("repay_penalty_hiden").value.replace(",",""))){
					document.getElementById("repay_penalty").value = formatCurrency((document.getElementById("repay_penalty_hiden").value.replace(",","")-input).toFixed(2));
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
			// wave penalty
			
				if(isset($_POST['wavePn'])){
					$lid = $_POST['lid'];
					$waveDate=date('Y-m-d',strtotime($_POST['repay_date']));
						$sumPn=mysql_query("Select sum(penalty) as totalPn from schedule where ld='$lid'");
						$getPn=mysql_fetch_array($sumPn);
						$myTotalPn=$getPn['totalPn'];
						$myPnDis=formatMoney($myTotalPn,true);
						///insert to wave 
						$insertPnWave=mysql_query("INSERT INTO `waves` (
														`id` ,
														`wave_date` ,
														`wave_prn` ,
														`wave_int` ,
														`wave_pn` ,
														`ld` ,
														`br` ,
														`wave_by`
														)
														VALUES (
														NULL , '$waveDate', '0', '0', '$myTotalPn', '$lid', '$get_br', '$user'
														);");
						// clear penalty
						$clearPn =mysql_query("Update schedule set penalty='0' where ld ='$lid'");
						echo"<script>alert('$myPnDis has been waved by $user for $lid! you can not undo it! thanks ');</script>";
				}
				
		//---check display----------------
	  	if(isset($_POST['display'])){
			$lid = $_POST['lid'];
			$dis_repay_date=date('Y-m-d',strtotime($_POST['repay_date']));
			
			$mydate=date('d-m-Y',strtotime($dis_repay_date));
			$due_dates=date('Y-m-d',strtotime($_POST['due_date']));
			//display loan info
			$display_info="SELECT * FROM loan_process WHERE ld='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$reg_id = $row['regis_id'];
						$cid = $row['cid'];
					}
			//display approval info
			$display_appinfo="SELECT * FROM customer_app WHERE cid='$cid'";
			$result_appinfo=mysql_query($display_appinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_appinfo)){
						$rate = $row['approval_rate'];
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
					$round_khinfo="SELECT setting FROM loan_config WHERE property='rounding'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_khrinfo)){
						$round_khr=$row['setting'];
					}
				//////end register-------------//
				/////Get today penalty
				$get_remain=0;
			
				$query_pn=" SELECT * FROM schedule where ld='$lid' AND dis='1' AND rp='0' and repayment_date <= '$dis_repay_date' order by repayment_date desc";
						$result_pn=mysql_query($query_pn);
						echo mysql_error();
						while($row = mysql_fetch_array($result_pn))
								{
									$sch_pn=$row['total'];
									$get_remain=$row['remain_amt'];
									$date_pn=date('Y-m-d',strtotime($row['repayment_date']));
									$days_pn=intval(dateDiff($date_pn,$dis_repay_date));
									
									if($days_pn>=4){
										if ($get_remain==0)
										{
											if ($l_currency=='KHR'){
												$due_pn=roundkhr(round(($sch_pn*$rate/100)*$days_pn*2/30,2),$round_khr);
											}
											else{
												$due_pn=round(($sch_pn*$rate/100)*$days_pn*2/30,2);
											}
										}
										else
										{
											if ($l_currency=='KHR'){
												$due_pn=roundkhr(round(($get_remain*$rate/100)*$days_pn*2/30,2),$round_khr);
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
								$int_dis=round((($due_int)*$int_dis)/100,2);
								break;
							}
							
						}
				// end
				///Over due penalty 
				$pn_int=mysql_query("SELECT SUM(penalty) as pn_tt FROM schedule WHERE ld='$lid'");
				$pn_tt=mysql_fetch_array($pn_int);
				if ($l_currency=='KHR'){
												$overdue_pn=formatMoney(roundkhr($pn_tt['pn_tt'],$round_khr),true);
											}
											else{
												$overdue_pn=formatMoney(round($pn_tt['pn_tt'],2),true);
											}
				
				///Get paid penalty 
				$pn_paid=mysql_query("SELECT SUM(norpen_paid) as norpn_paid FROM schedule WHERE ld='$lid'");
				$pn_p=mysql_fetch_array($pn_paid);
				
				if ($l_currency=='KHR'){
												$paid_pn=roundkhr($pn_p['norpn_paid'],$round_khr);
												$remain_pn=roundkhr(trim(str_replace(",","",$overdue_pn))-trim(str_replace(",","",$paid_pn)),$round_khr);
												
											}
											else{
												$paid_pn=round($pn_p['norpn_paid'],2);
												$remain_pn=round(trim(str_replace(",","",$overdue_pn))-trim(str_replace(",","",$paid_pn)),2);
											}
				
				
				//total penalty
			
				if ($l_currency=='KHR'){
												
												$total_pn=formatMoney(roundkhr(trim(str_replace(",","",$due_pn))+trim(str_replace(",","",$remain_pn)),$round_khr),true);
												
											}
											else{
												
												$total_pn=formatMoney(round($due_pn+$remain_pn,2),true);
											}
				
				
				/*echo"<script>alert('days:$days_pn,due_pn:$due_pn,remain_pn:$remain_pn,total_pn:$total_pn,OD:$overdue_pn');</script>";*/
				///show over due information
				$sum_prn=mysql_query("SELECT SUM(principal-prn_paid) as prn_tt FROM schedule WHERE repayment_date <= '$dis_repay_date' AND ld='$lid' AND rp='0'");
				$prn_tt=mysql_fetch_array($sum_prn);
							if ($l_currency=='KHR'){
											
												$myodprn_tt=formatMoney(roundkhr($prn_tt['prn_tt'],$round_khr),true);
												
											}
											else{
												$myodprn_tt= formatMoney(round($prn_tt['prn_tt'],2),true);
											}
				
				
				$sum_int=mysql_query("SELECT SUM(interest-int_paid-int_dis) as int_tt FROM schedule WHERE repayment_date <= '$dis_repay_date' AND ld='$lid' AND rp='0'");
				$int_tt=mysql_fetch_array($sum_int);
									if ($l_currency=='KHR'){
											
												$myodint_tt=formatMoney(roundkhr($int_tt['int_tt'],$round_khr),true);
												
											}
											else{
												$myodint_tt= formatMoney(round($int_tt['int_tt'],2),true);
											}
				
				$total_int=mysql_query("SELECT SUM(total-(prn_paid+int_paid+int_dis)) as total_tt FROM schedule WHERE repayment_date <= '$dis_repay_date' AND ld='$lid' AND rp='0'");
				$toal_tt=mysql_fetch_array($total_int);
				if ($l_currency=='KHR'){
											
												$myodtotal_tt=formatMoney(roundkhr($toal_tt['total_tt'],$round_khr),true);
												
											}
											else{
												$myodtotal_tt=formatMoney(round($toal_tt['total_tt'],2),true);
											}
				
					if ($due_dates>$dis_repay_date){
						if ($l_currency=='KHR'){
												$myodint_tt=formatMoney(roundkhr(trim(str_replace(",","",$due_int)),$round_khr),true);
												$myodprn_tt=formatMoney(roundkhr(trim(str_replace(",","",$due_prn)),$round_khr),true);
												$myodtotal_tt=formatMoney(roundkhr(trim(str_replace(",","",$due_amt)),$round_khr),true);
												
											}
											else{
												$myodint_tt=formatMoney(round(trim(str_replace(",","",$due_int)),2),true);
												$myodprn_tt=formatMoney(round(trim(str_replace(",","",$due_prn)),2),true);
												$myodtotal_tt=formatMoney(round(trim(str_replace(",","",$due_amt)),2),true);
											}
											$due_pn=0.00;
				}
				
				
				/////////////
				if($min_no==''){
					echo"<script>alert('There is no this record in System! Please Check again!');</script>";	
					echo"<script>window.location.href='index.php?pages=general_repayForm';</script>";
					exit();
					}
				///check dis
				if($dis=='0'){
					echo"<script>alert('There Customer is not yet disbursed! Please Check again!');</script>";	
					echo"<script>window.location.href='index.php?pages=general_repayForm';</script>";
					}
			}///isset displaay
			
	//--check ld
	//---end diplay
	//---------start disbursement----------------//
		if(isset($_POST['repayment'])){//start schedule 
			$display_appinfo="SELECT * FROM customer_app WHERE reg_id='$reg_id'";
			$result_appinfo=mysql_query($display_appinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_appinfo)){
						$rate = $row['approval_rate'];
					}
			$lid = trim($_POST['lid']);
			$myreg_id=$_POST['reg_id'];
			$prn=$_POST['repay_prn'];
			$int=$_POST['repay_int'];
			$total=$_POST['total_amt'];
			$myco=$_POST['co']; 
			$mycur=$_POST['cur'];
			$int_dis=$_POST['int_dis'];
			$repay_date=date('Y-m-d',strtotime($_POST['repay_date']));
			$sch_date=date('Y-m-d',strtotime($_POST['due_date']));
			$total_pn=$_POST['due_pn'];
			$repay_pn=$_POST['repay_penalty'];
		//	$total_pn_org=$_POST['repay_penalty'];
			//
			$spit = array(",", "'");
			$my_prn = str_replace($spit, "",$prn);
			$my_int = str_replace($spit, "",$int);
			$my_total =str_replace($spit, "",$total);
			$amount = $_POST['g_amt'];
			$penalty = $_POST['g_pn'];
			//
			//--check days--//
			$days=dateDiff(date('Y-m-d',strtotime($repay_date)),$sch_date);
			//find min installment
				/*$minInstall="SELECT MIN(repayment_date) as min_no FROM schedule WHERE ld='$lid' AND rp='0'";
				$result_mininstall=mysql_query($minInstall) or die (mysql_error());
				
					while($row=mysql_fetch_array($result_mininstall)){
							$min_no=$row['min_no'];
						}	*/
			///--------update schedule------------------
				$normaltotalpenalty =0;
				$Prin = 0;
				$total_from_db= 0;
				$remain_from_db=0;
				$due_remain=0;
				$int_paid=0;
				$prin_pain=0;
				$j=0;
				$prn_pain_total=0;
				$int_pain_total=0;
				$pn_pain_total=0;
				$int_dis_total=0;
				
			//Check amount >= balance
				$balace = "Select sum(total-prn_paid-int_paid-int_dis) as total from schedule where ld='$lid' and rp='0' order by repayment_date asc"; 
				$result_balance= mysql_query($balace) or die(mysql_error());
				while($row = mysql_fetch_array($result_balance)){
					$balace=$row['total'];
				}
	
				while ($amount>0){
						$rp=0;
						//Get some data for calculator
						$total_from_db = "Select total,(principal-prn_paid) as principal,(interest-int_paid) as interest,int_paid,prn_paid,no_install,remain_amt,repayment_date, int_dis,pay_status,cid from schedule where ld='$lid' and rp='0' order by repayment_date asc";
						$total_from = mysql_query($total_from_db) or die(mysql_error());
					
						while($row=mysql_fetch_array($total_from)){
								$total_from=$row['total'];
								$int_from=$row['interest'];
								$prin_from=$row['principal'];
								$result_mininstall=$row['no_install'];
								$remain_from_db=$row['remain_amt'];
								$int_paid=$row['int_paid'];
								$prin_pain=$row['prn_paid'];
								$repay_date_from = $row['repayment_date'];
								$int_dis = $row['int_dis'];
								$dis_type=$row['pay_status'];
								$cid = $row['cid'];
								break;
						}
						// End
						//Count installment for Reschedule
						$countInstall = " SELECT approval_period - (SELECT count( no_install ) FROM schedule WHERE schedule.ld = L.ld AND STATUS =1 AND rp =1) as no_install FROM customer_app C INNER JOIN loan_process L ON C.reg_id = L.regis_id  where L.ld='$lid'";
						$countInstallR = mysql_query($countInstall) or die(mysql_error());
						
						$countInstall_1=mysql_fetch_array($countInstallR);
				
						//End
						$conu =$countInstall_1[no_install];

						if ($amount>$balace and $result_mininstall != $conu)
						{
							print("<script>alert('amount bigger than balance, so u should payoff this loan.$amount,$balace,$result_mininstall,$conu');</script>");
							echo"<script>window.location.href='index.php?pages=payOff_Form';</script>";
							break;
						}
						$amount_bal=$amount-$total_from;			
						// calculate interest discount
						if ($int_dis==0)
						{
							$days_dis=dateDiff(date('Y-m-d',strtotime($repay_date)),date('Y-m-d',strtotime($repay_date_from)));
							$dis_info="SELECT * FROM int_dis";
							$result_disinfo=mysql_query($dis_info) or die (mysql_error());
							while($row=mysql_fetch_array($result_disinfo)){
								if ($days_dis==0){ // if day = 0
									$dis_type = "NR";
									$int_dis=0;	
									break;
								}
								if ($days_dis<=$row['T']){
									$int_dis=$row['C_DIS']; //Number of int_dis // if day > 0
									if ($int_dis==0){
										$int_dis=0;
										$dis_type="ENR";
										break;
									}
									if (($amount-($int_from+$prin_from))>=0)
									{
										$int_dis=round((($int_from)*$int_dis)/100,2);
										$dis_type="ER";
										break;
									}
									else
									{
										$int_dis=0;
										$dis_type='';
										break;
									}
								}
								
							}
						}
						// end
						if ($amount_bal>=0){
							$j+=1;
							$int_end= $int_from+$int_paid-$int_dis;
							$prin_end=$prin_from+$prin_pain;
							if ($j==1){ //have penalty
									$update_sch="UPDATE schedule SET prn_paid ='$prin_end',int_paid='$int_end',rp='1',paid_date ='$repay_date' 
								 ,penalty='$total_pn',remain_amt='0',norpen_paid='$penalty',int_dis='$int_dis',pay_status='$dis_type', pay_type = 'gm',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
									mysql_query($update_sch) or die (mysql_error());
									
									//Insert schedule his
									$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$repay_date','$max','$prin_end','$int_end','$normaltotalpenalty',0,'$int_dis','$dis_type','gm','$get_br','$user')";
									mysql_query($insert_sch) or die (mysql_error());
									$total_pn=0;
									$penalty=0;
									
							}
							else{// Non penalty
								$update_sch="UPDATE schedule SET prn_paid ='$prin_end',int_paid='$int_end',rp='1',paid_date ='$repay_date' 
								 ,remain_amt='0',int_dis='$int_dis',pay_status='$dis_type', pay_type = 'gm',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
									mysql_query($update_sch) or die (mysql_error());
									
										//Insert schedule his
									$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$repay_date','$max','$prin_end','$int_end','0',0,'$int_dis','$dis_type','gm','$get_br','$user')";
									mysql_query($insert_sch) or die (mysql_error());
							}
							
							if ($remain_from_db>0){
								$amount=$amount-$remain_from_db;
							}
							else
							{
								$amount=$amount-$total_from+$int_dis;
							}
							//Total prn,int,pn,int_dis
							$prn_pain_total = $prn_pain_total + $prin_end;
							$int_pain_total = $int_pain_total + $int_end;
							$int_dis_total = $int_dis_total + $int_dis;
							//$pn_pain_total = $pn_pain_total + $total_pn;
							$prin_from=0;
							$int_dis=0;
							$int_from=0;
							//$total_pn=0;
						}
						else{
							//Saving
							if ($j!=0){
								$saving = round($amount,2);
								$insert_saving="insert into deposit(ld,cid,amount,date,user,cur,status) values('$lid','$cid','$saving','$repay_date','$user','$mycur','rp')";
										mysql_query($insert_saving) or die (mysql_error());
										$amount=0;
										break;
							}
							$j+=1;
							//End Saving
							if ($penalty>0){
								$normaltotalpenalty=$penalty;	
							}
							
								if ($total!=0 && $rp=='0'){
									/*echo "<script>alert('$amount,$rate,$days');</script>";*/
									$total_pn=round(((($amount*$rate)/100)*2*(-($days)))/30,2);
								}
							if ($amount-($int_from-$int_dis)>=0){
								$amount=$amount-($int_from-$int_dis);
								
								if (($int_from-$int_dis)==0){
									if ($amount-$prin_from>=0){
											$total_pn=$repay_pn;
										$remain= 0; 
										$prin_from=$prin_from+$prin_pain;
										$int_from = $int_from+$int_paid-$int_dis;
										$amount=$amount-$remain_from_db;
										
										$update_sch="UPDATE schedule SET prn_paid ='$prin_from',int_paid='$int_from',rp='1',paid_date ='$repay_date',remain_amt='$remain',norpen_paid='$normaltotalpenalty',penalty='$total_pn',int_dis='$int_dis',pay_status='$dis_type', pay_type = 'gm',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
										mysql_query($update_sch) or die (mysql_error());
												
										//History varaible not use other
										$prin_hist = $prin_from-$prin_pain;
										$int_hist = $int_from-$int_paid;
											//Insert schedule his
									$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$repay_date','$max','$prin_hist','$int_hist','$normaltotalpenalty',0,'$int_dis','$dis_type','gm','$get_br','$user')";
									mysql_query($insert_sch) or die (mysql_error());
										$total_pn=0;
										$penalty= 0;
										$normaltotalpenalty=0;
										//Total prn,int,pn,int_dis
										$prn_pain_total = $prn_pain_total + ($prin_from-$prin_pain);
										$int_pain_total = $int_pain_total + ($int_from-$int_paid);
										$int_dis_total = $int_dis_total + $int_dis;
										//$pn_pain_total = $pn_pain_total + $total_pn;
										$prin_from=0;
										$int_dis=0;
										$int_from=0;
										//$total_pn=0;
										continue;
									}
									else{
										
										$prin_from= $amount+$prin_pain;
										$int_from=$int_paid-$int_dis;
										$remain=$total_from-($amount+$int_paid+$prin_pain);
										$amount=0;
									}
								}
								else
								{	
									if($prin_from!=0){
										$remain= $prin_from-$amount; 
										$prin_from= $prin_pain+$amount;
										$int_from = $int_from+$int_paid-$int_dis;	
										$amount=0;
										if ($remain==0){
											$rp=1;
										}
										//History varaible not use other
										$prin_hist = $prin_from-$prin_pain;
										$int_hist = $int_from-$int_paid;
									}
									else
									{
										
										/*if ($amount_bal<0){
											$total_pn=round(((($amount*$rate)/100)*2*(-($days))/30),2);
												
										}*/
										$remain= 0; 
										$int_from = $int_from+$int_paid-$int_dis;	
										$update_sch="UPDATE schedule SET prn_paid ='$prin_from',int_paid='$int_from',rp='0',paid_date ='$repay_date',remain_amt='$remain',penalty='$total_pn' 
						 ,norpen_paid='$normaltotalpenalty',int_dis='$int_dis',pay_status='$dis_type', pay_type = 'gm',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
										mysql_query($update_sch) or die (mysql_error());
											//Insert schedule his
									$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$repay_date','$max','$prin_from','$int_from','$normaltotalpenalty',0,'$int_dis','$dis_type','gm','$get_br','$user')";
									mysql_query($insert_sch) or die (mysql_error());
										//Total prn,int,pn,int_dis
										$prn_pain_total = $prn_pain_total + $prin_from;
										$int_pain_total = $int_pain_total + $int_from;
										$int_dis_total = $int_dis_total + $int_dis;
										//$pn_pain_total = $pn_pain_total + $total_pn;
										$prin_from=0;
										$int_dis=0;
										$int_from=0;
										$normaltotalpenalty=0;
										$total_pn=0;
										//$total_pn=0;
										continue;
									}
								}
							}
							else{					
								$int_from=$amount+($int_paid-$int_dis);
								$remain= $total_from-($amount+$int_paid); 
								$prin_from=0;
								$amount=0;
								//History varaible not use other
								$prin_hist = 0;
								$int_hist = $int_from-$int_paid;
							}

							$update_sch="UPDATE schedule SET prn_paid ='$prin_from',int_paid='$int_from',rp='$rp',paid_date ='$repay_date',remain_amt='$remain' ,penalty='$total_pn'
						 ,norpen_paid='$normaltotalpenalty',int_dis='$int_dis',pay_status='$dis_type', pay_type = 'gm',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
							mysql_query($update_sch) or die (mysql_error());
										//Insert schedule his
									$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$repay_date','$max','$prin_hist','$int_hist','$normaltotalpenalty',0,'$int_dis','$dis_type','gm','$get_br','$user')";
									mysql_query($insert_sch) or die (mysql_error());
							//Total prn,int,pn,int_dis
							$prn_pain_total = $prn_pain_total + ($prin_from-$prin_pain);
							$int_pain_total = $int_pain_total + ($int_from-$int_paid);
							$int_dis_total = $int_dis_total + $int_dis;
							//$pn_pain_total = $pn_pain_total + $total_pn;
							$prin_from=0;
							$int_dis=0;
							$int_from=0;
							$total_pn=0;
							$normaltotalpenalty=0;
							//$total_pn=0;
						}
	
			
					}
				
				$total = $prn_pain_total+ $int_pain_total +$penalty;
				//insert invoice
			   // $amount = $_POST['g_amt'];

					/* ('id' ,'reg_id' ,'lc' ,'paid_date' ,'sch_date' ,'invioce_no','prn_paid' ,'int_paid' ,'pn_paid','int_dis','payoff_pnpaid','total' ,'cashier' ,'pay_type','pay_status','reciev_at','max_id','res_co','cur')
							,'$myreg_id', '$lid', '$repay_date', '$sch_date', '$max','$prn_pain_total','$int_pain_total','$pn_pain_total','$int_dis_total','0', '$amount', '$user', 'gm', '$get_br', '$max', '$myco', '$mycur');*/
				$invoice_exc="INSERT INTO invoice(id,reg_id,lc,paid_date,sch_date,invioce_no,prn_paid,int_paid,pn_paid,int_dis,payoff_pnpaid,total,cashier,pay_type,pay_status,reciev_at,max_id,res_co,cur) VALUES (null,'$myreg_id', '$lid', '$repay_date', '$sch_date', '$max','$prn_pain_total','$int_pain_total','$penalty','$int_dis_total','0', '$total', '$user','$dis_type', 'gm', '$get_br', '$max', '$myco', '$mycur');";
					///
					$mycur=$_POST['cur'];
					echo"
					<script> 
						var print =window.open('','print','status=1,width=1100,height=700,scrollbars=yes,menubar=yes,addressbar=no,resizable=no');
						print.location.href='pages/transactionSlip.php?lid=$lid&inNo=$max&t=rp&cur=$mycur';
					</script>";
					
					echo "<script>alert('Repayment Successful,This is Invoice No : $max');</script>";
					$invoice_sms = mysql_query($invoice_exc) or die(mysql_error());
	
			//---------------end update schedule--------------------------
			/*echo"
				<script> 
					alert('$myreg_id');
				</script>";*/
			echo"<script>window.location.href='index.php?pages=general_repayForm';</script>";
		}//end isset schedule
		
	//------------end repay transaction---------------// 
	?>
<!-- start content-outer -->
<h3 class="tit">Easy General Repayment Form :</h3>
		<!-- start id-form -->
        <form name="ind_loan" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'" class="nostyle">
         <tr>
		<th valign="top">LID :</th>
		<td>	
            <input type="hidden" name="reg_id" value="<?php echo $reg_id; ?>" />
            <input type="hidden" name="co" value="<?php echo $co; ?>" />
             <input type="hidden" name="cur" value="<?php echo $l_currency; ?>" />
             <input type="hidden" name="inNo" value="<?php echo $max; ?>" />
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
			<th valign="top">Due Date :</th>
			<td>
            <input type="text" class="input-text" name="due_date" id="due_date" value="<?php echo $due_date; ?>" autocomplete="off"
             readonly="readonly"/></td>
            <th valign="top">Repay Date :</th>
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
			<th valign="top">Customer Name :</th>
			<td><input type="text" class="input-text" name="cust_name" id="cust_name" value="<?php echo $kh_borrower; ?>" 
            onblur="doDate(this,'em_Date');" onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
            <th valign="top">Total Amount :</th>
			<td><input type="text" class="input-text" name="total_amt" id="total_amt" value="<?php echo $myodtotal_tt; ?>" autocomplete="off"/></td>
            <td><input type="hidden" class="input-text" name="total_amt_hiden" id="total_amt_hiden" value="<?php echo $myodtotal_tt; ?>" autocomplete="off"/></td>
		</tr>
		<tr>
			<th valign="top">Due Amount :</th>
			<td>
            <input type="text" class="input-text" name="due_amt" id="due_amt" value="<?php echo $due_amt; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Repay Principal :</th>
			<td>
            <input type="text" class="input-text" name="repay_prn" id="repay_prn" value="<?php echo $myodprn_tt; ?>" autocomplete="off"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Due Principal :</th>
			<td>
            <input type="text" class="input-text" name="due_prn" id="due_prn" value="<?php echo $due_prn; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Repay Interest:</th>
			<td>
            <input type="text" class="input-text" name="repay_int" id="repay_int" autocomplete="off" value="<?php echo $myodint_tt; ?>"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Due Interest :</th>
			<td>
            <input type="text" class="input-text" name="due_int" id="due_int" value="<?php echo $due_int; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Total Penalty :</th>
		<td>	
		<input type="text" class="input-text" name="repay_penalty" id="repay_penalty" autocomplete="off" value="<?php echo $total_pn; ?>"/>
        <input type="hidden" class="input-text" name="repay_penalty_hiden" id="repay_penalty_hiden" autocomplete="off" value="<?php echo $total_pn; ?>"/>
        <input type="hidden" class="input-text" name="repay_penalty_remain" id="repay_penalty_remain" autocomplete="off" value="<?php echo "00"; ?>"/>
		</td>
		</tr>
         <tr>
         	<th valign="top">Due Penalty :</th>
			<td>
            <input type="text" class="input-text" name="due_pn" id="due_pn" value="<?php 
			
				if ($l_currency=='KHR'){
					echo formatmoney(roundkhr($due_pn,$set),true);
				}
				else
				{
					echo formatmoney($due_pn,true);
				}
			 
			 ?>" readonly="readonly"/> 
            </td>
			 <th valign="top">Remain :</th>
			<td>
            <input type="text" class="input-text" name="remain" id="remain" readonly="readonly" value="00"/>
            </td>
		</tr>
         <tr>
			<th valign="top">Interest Discount :</th>
			<td>
            <input type="text" class="input-text" name="int_dis" id="int_dis" value="<?php echo $int_dis; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Currency :</th>
			<td>
            <input type="text" class="input-text" name="cur" id="cur" value="<?php echo $l_currency; ?>" readonly="readonly"/>
            </td>
		</tr>
         <tr>	
        	<td>&nbsp;
            	
            </td>
            <td>
            	<h3><u>Repayment Area:</u></h3> 
            </td>
        </tr>
         <tr>	
        	<td colspan="2">&nbsp;
            	
            </td>
        </tr>
        <tr>
			<th valign="top">Amount :</th>
			<td><input type="text" class="input-text" name="g_amt" id="g_amt" value="<?php echo '00'; ?>" onkeyup="doTotalAmount(this.value)" 
            onkeypress="return isNumberKe(event);" autocomplete="off"/></td>
            <th valign="top">Penalty :</th>
			<td>
            <input type="text" class="input-text" name="g_pn" id="g_pn" value="<?php echo '00'; ?>" onkeyup="doTotalPenalty(this.value)" autocomplete="off"/>
            </td>
		</tr>
       
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="Pay" class="form-submit" name="repayment" id="repayment" 
            onclick="return confirm('Are you sure want to do repayment for <?php echo $kh_borrower; ?> ?');"/>
                <input type="reset" value="reset" class="form-reset"  />
                 <input type="submit" value="Wave Penalty" class="form-submit" name="wavePn" id="wavePn" 
            onclick="return confirm('Are you sure want to wave penalty <?php echo $kh_borrower; ?> ? Once you wave, you can not undo it!');"/>

            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>