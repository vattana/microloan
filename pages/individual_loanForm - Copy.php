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
		$query = "SELECT cif FROM register where appr='1' and cancel ='0' and bcif='1' and bloan='0' and dis='0' and type_loan='individual' 
		GROUP BY cif DESC";
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
	if(isset($_POST['display'])){
		
		//display register info
		$cid_display=$_POST['cid'];
		$display_info="SELECT * FROM register WHERE cif='$cid_display' AND appr='1' AND cancel='0' AND bcif='1' AND bloan='0' AND dis='0' ORDER BY id DESC";
		
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
				}
				//approval info----------------
						$sql_app_info="SELECT * FROM customer_app WHERE reg_id='$regis_id' ORDER BY id";
						$result_app_info=mysql_query($sql_app_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_app_info)){
								$approval_date=date('d-m-Y',strtotime($row['approval_date']));
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
						else{
							$show_fr='Monthly';
							$freq='4';
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
				$query_maxid = "SELECT max(max_id) as code FROM loan_process"; 
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
				//--generate period
					if($l_period<=12){
						$code_period='1';
						}
						else{
						$code_period='2';
							}
				//------
				//--loan cycle
					$result_loancycle = mysql_query("SELECT * FROM cycle_loan WHERE cid ='$cid_display'");
					$num_rows_lcycle = mysql_num_rows($result_loancycle);
					$code_lcycle=$num_rows_lcycle+1;
				//----
				//-----------------
					$ld=$code_l_type.$freq.'-'.$get_loan_month.$get_loan_year.'-'.$code_lcycle.$code_cur_type.$max;
							
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
	if(isset($_POST['save'])){
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
		//--------------select customer 's adr---------//
			$sql_cust_adr="SELECT * FROM cif_detail WHERE cif='$mycid' AND cust_kind='borrower' ORDER BY id";
						$result_cust_adr=mysql_query($sql_cust_adr) or die (mysql_error());
							while($row = mysql_fetch_array($result_cust_adr)){
								$s_vil=$row['village'];
								$s_com=$row['commune'];
								$s_dis=$row['district'];
								$s_prov=$row['province'];
							}
		//-----------------end select customer adr-----//
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
		$mycur=$_POST['cur'];
		//---select from approval again
		$get_regis_id="SELECT * FROM register WHERE cif='$mycid' AND appr='1' AND cancel='0' AND bcif='1' AND bloan='0' AND dis='0' ORDER BY id DESC";
		$result_reg_id=mysql_query($get_regis_id) or die (mysql_error());
			while($row=mysql_fetch_array($result_reg_id)){
				$reg_id=$row['id'];
				$cur=$row['cur'];
			}
			//
			$sql_loan_app="SELECT * FROM customer_app WHERE reg_id='$reg_id' ORDER BY id DESC";
						$result_loan_app=mysql_query($sql_loan_app) or die (mysql_error());
							while($row = mysql_fetch_array($result_loan_app)){
								$amount=$row['approval_amt'];
								$rate=$row['approval_rate'];
								$no_r=intval($row['number_of_repay']);
								$period=$row['approval_period'];
							}
		//---get address
			$sql_loan_adr="SELECT * FROM cif_detail WHERE cif='$mycid' AND cust_kind ='borrower' ORDER BY id DESC";
						$result_loan_adr=mysql_query($sql_loan_adr) or die (mysql_error());
							while($row = mysql_fetch_array($result_loan_adr)){
								$vil=$row['village'];
								$com=$row['commune'];
								$dist=$row['district'];
								$pro=$row['province'];
							}
		
		#----------------------------start create schedule----------------------------------#
								$dayset=date('d',strtotime($first_repay));
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
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	$installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													
														$month = strtotime("+ $no_r days",$month); 
														
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
															$month = strtotime("+2 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	 $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(intval($percentage>$get_percent || $percentage=='0')){
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
															$month = strtotime("+2 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
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
													 	$installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("+2 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
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
													 	$installment_date = date('Y-m-d',$month);
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date) && !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+ $no_r days",$month); 
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
															$month = strtotime("+2 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	 $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	$installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
					if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	 $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(intval($percentage>$get_percent) || ($percentage=='0')){
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
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
													 	$installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
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
													 	$installment_date = date('Y-m-d',$month);
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+ $no_r days",$month); 
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	 $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
				if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
																$month = strtotime("+2 day", $month);//skip to mon
														}
														//////
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	$installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("+2 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	 $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(intval($percentage>$get_percent || $percentage=='0')){
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
															$month = strtotime("+2 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
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
													 	$installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("+2 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
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
													 	$installment_date = date('Y-m-d',$month);
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date) && !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+ $no_r days",$month); 
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
															$month = strtotime("+2 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("+1 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	 $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	$installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
					if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
									$today=date('Y-m-d');
									$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	 $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);
													
												////////////	
						if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
										$today=date('Y-m-d');
										$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
													}
												//////////////////
												
												$i=$i+1;
												
										}//end while
									}//end if			
									//////////end balloon
									
									if($method=='Percentage'){ //start percentage
										
										/////check policy and text input
													if(intval($percentage>$get_percent) || ($percentage=='0')){
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
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
													 	$installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
							if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
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
													 	$installment_date = date('Y-m-d',$month);
														 //$day_kh=date('D',$installment_date);	
								if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
											$today=date('Y-m-d');
											$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+ $no_r days",$month); 
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
															$month = strtotime("-1 day", $month);//skip to mon
														}
														else if($mydate=='Sun'){
															$month = strtotime("-2 day", $month);//skip to mon
														}
														// end skip sat and sun
														else if($month==$holi_list){
															
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
															$pr=$sub_pr=intval($pr);
															
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
													 	 $installment_date = date('Y-m-d',$month);
														 $day_kh=date('D',$installment_date);	
				if(!empty($installment_date) && !empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
								$today=date('Y-m-d');
								$insert_date="INSERT INTO schedule(id,record_date,cid,ld,no_install,repayment_date,principal,interest,total,balance,response_co,currency,br_no)
														VALUES
											(Null,'$today','$mycid','$myld','$i','$installment_date','$pr','$int','$pa','$ba','$re_co','$cur','$get_br')";
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
													$month = strtotime("+$no_r days",$month); 
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
		#----------------end KHR-------------------------------------------------------------#
		#-----------------------------end create schedule-----------------------------------#
		#-------------------insert to loan table--------------------------------------------#
		
			if(!empty($myreg_date)&& !empty($reg_id) && ($myclassi_purpose!='0')){
				
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
				}
					else{
						echo"<script>alert('Save Unsuccessfully! Try to Check again!');</script>";	
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
<div id="content-outer">
<!-- start content -->
<div id="content">
<div id="page-heading"><h1>Easy Individual Loan Form :</h1></div>

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
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no">3</div>
			<div class="step-dark-left">Loan Detail</div>
			<div class="step-dark-right">&nbsp;</div>
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
		<th valign="top">CID :</th>
		<td>	
		<input type="text" class="inp-form" name="cid" id="cid" autocomplete="off" 
        onKeyPress="return handleEnter(this, event);" value="<?php echo $cid_display; ?>" onKeyUp="doSuggestionBox(this.value);"/>
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
			<td><input type="text" class="inp-form" name="app_date" id="app_date" value="<?php echo $approval_date; ?>" autocomplete="off"
             readonly="readonly"/></td>
		</tr>
		<tr>
			<th valign="top">Loan Entry Date :</th>
			<td><input type="text" class="inp-form" name="loan_date" id="loan_date" value="<?php echo date('d-m-Y'); ?>" 
            onblur="doDate(this,'em_Date');" onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
            <th valign="top">LID :</th>
			<td><input type="text" class="inp-form" name="lid" id="lid" value="<?php echo $ld; ?>" autocomplete="off" readonly="readonly"/></td>
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
            <input type="text" class="inp-form" name="loan_amt" id="loan_amt" value="<?php echo $approval_amt; ?>" readonly="readonly"/>
            <?php echo $l_currency; ?>
             <input type="hidden" name="cur" value=" <?php echo $l_currency; ?>" />
            </td>
            <th valign="top">Rate :</th>
			<td>
            <input type="text" class="inp-form" name="rate" id="rate" value="<?php echo $approval_rate; ?>" readonly="readonly"/>
            </td>
		</tr>
         <tr>
			<th valign="top">Period :</th>
			<td>
            <input type="text" class="inp-form" name="period" id="period" value="<?php echo $approval_period; ?>" readonly="readonly"/>
            <?php echo $show_fr; ?>
            </td>
            <th valign="top">Method :</th>
			<td>
            <input type="text" class="inp-form" name="method" id="method" value="<?php echo $repay_method; ?>" readonly="readonly"/>
            </td>
		</tr>
		
        <tr>
		<th valign="top">First Repay Date :</th>
		<td>	
		<input type="text" class="inp-form" name="frp" id="frp" autocomplete="off" onblur="doDate(this,'em_Date');" 
        onkeypress="return handleEnter(this, event);" value="<?php echo $real_first_repay; ?>"/>
		</td>
			<td align="left"><div class="error-left"></div>
			<div class="error-inner">dd-mm-yyyy</div></td>
		</tr> 
		<tr>
		<th valign="top">Setting :</th>
		<td>	
            <select class="styledselect_form_1" name="setting" id="setting" onkeypress="return handleEnter(this, event);">
                     <option value="forward" selected="selected">Forward</option>
                   	 <option value="backward">Backward</option> 
            </select>
		</td>
		 <th valign="top">Classify Purpose :</th>
		<td>	
            <select class="styledselect_form_1" name="classify_pur" id="classify_pur" onkeypress="return handleEnter(this, event);">
                    <option value="0">--Select--</option>
                     <?php 
								$str_classi_pur="Select * from purpose_cat order by id ASC;";   
                                      $sql_classi_pur=mysql_query($str_classi_pur);
                                      while ($row=mysql_fetch_array($sql_classi_pur))
                                        {
                                        $id=$row['id'];
                                        $classi_pur=$row['clas_purpose'];
                                        echo '<option value="'.$classi_pur.'">'.$classi_pur.'</option>';
                                        }
							?>
            </select>
            <font color="#FF0000">( Required )</font>
		</td>
		</tr> 
         <tr>
		<th valign="top">Loan Purpose :</th>
            <td><textarea rows="" cols="" class="form-textarea" name="loan_purpose" id="loan_purpose"><?php echo trim($purpose); ?></textarea></td>
            <td>&nbsp;</td>
		</tr>
         <tr>
			<th valign="top">Grace Period :</th>
			<td>
            	<?php 
						if ($method=="Semi-Balloon"){ 
							echo '<input type="text" class="inp-form" name="grace_period" id="grace_period" value="" autocomplete="off"/>';
                		}
						else{
							echo '<input type="text" class="inp-form" name="grace_period" id="grace_period" disabled="disabled" 
							value="Semi-Balloon Repayment Only"/>';
							}
				?>
            </td>
            <th valign="top">Percentage :</th>
			<td>
            	<?php 
						if ($method=="Percentage"){ 
							echo '<input type="text" class="inp-form" name="percentage" id="percentage" autocomplete="off"/>';
                		}
						else{
							echo '<input type="text" class="inp-form" name="percentage" id="percentage" disabled="disabled" 
							value="Percentage Repayment Only"/>';
							}
				?>
            </td>
		</tr>
         <tr>
			<th valign="top">Bor's Income :</th>
			<td>
            <input type="text" class="inp-form" name="bor_income" id="bor_income" value="0" onkeypress="return handleEnter(this, event);" 
            onkeyup="remaining()"/>
            </td>
            <th valign="top">Co-Bor's Income :</th>
			<td>
            <input type="text" class="inp-form" name="cobor_income" id="cobor_income" value="0" onkeypress="return handleEnter(this, event);" 
            onkeyup="remaining()"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Dependant's Income :</th>
			<td>
            <input type="text" class="inp-form" name="dependant_income" id="dependant_income" value="0" 
            onkeypress="return handleEnter(this, event);" onkeyup="remaining()"/>
            </td>
            <th valign="top">Other's Income :</th>
			<td>
            <input type="text" class="inp-form" name="other_income" id="other_income" value="0" onkeypress="return handleEnter(this, event);" 
            onkeyup="remaining()"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Family Expense :</th>
			<td>
            <input type="text" class="inp-form" name="family_ex" id="family_ex" value="0" onkeypress="return handleEnter(this, event);" 
            onkeyup="remaining()"/>
            </td>
            <th valign="top">Remain :</th>
			<td>
            <input type="text" class="inp-form" name="remain" id="remain" value="0" onkeypress="return handleEnter(this, event);" 
            readonly="readonly"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Ability :</th>
			<td>
            <input type="text" class="inp-form" name="ability" id="ability" value="0" onkeypress="return handleEnter(this, event);" 
            readonly="readonly"/>
            </td>
            <th valign="top">Loan Security</th>
			<td>
            <select class="styledselect_form_1" name="loan_security" id="loan_security" onkeypress="return handleEnter(this, event);">
                    <option value="None" selected="selected">None</option>
                    <option value="Available">Available</option>
            </select>
            </td>
		</tr>
        <tr>
			<th valign="top">&nbsp;</th>
			<td>
          		 	<h3>Collateral Information : _ &raquo; </h3>
            </td>
            <th valign="top">Ownership :</th>
			<td>
            <select class="styledselect_form_1" name="ownership" id="ownership" onkeypress="return handleEnter(this, event);">
                    <option value="0" selected="selected">--Select--</option>
                    <option value="borrower">Borrower</option>
                     <option value="co-borrower">Co-Borrower</option>
                    <option value="both">Borrower & Co-Borrower</option>
                     <option value="gurantor">Gurantor</option>
                    <option value="mortgogor">Entitile Mortgogor</option>
            </select>
            </td>
           
		</tr>
        
          <tr>
			 <th valign="top">Depositor Name</th>
			<td>
            <input type="text" class="inp-form" name="depositor" id="depositor" value="" onkeypress="return handleEnter(this, event);" 
            onblur="ChangeCase(this);" />
            </td>
            <th valign="top">Co-Depositor Name :</th>
			<td>
            <input type="text" class="inp-form" name="co_depositor" id="co_depositor" value="" onkeypress="return handleEnter(this, event);" 
            onblur="ChangeCase(this);" />
            </td>
		</tr> 
         <tr>
			 <th valign="top">Type Of Titile</th>
			<td>
            <input type="text" class="inp-form" name="title_type" id="title_type" value="" onkeypress="return handleEnter(this, event);" 
            onblur="ChangeCase(this);" />
            </td>
           <th valign="top">Type Of Collateral :</th>
			<td>
            <select class="styledselect_form_1" name="collateral_type" id="collateral_type" onkeypress="return handleEnter(this, event);">
                    <option value="0" selected="selected">--Select--</option>
                    <option value="flat">Flat</option>
                     <option value="villa">Villa</option>
                    <option value="land">Land</option>
                     <option value="factory">Factory</option>
                    <option value="land_wooden_house">Land and Wooden House</option>
                    <option value="land_brick_house">Land and Brick House</option>
            </select>
            </td>
		</tr>   
         <tr>
			<th valign="top">Title N<sup>o</sup> :</th>
			<td>
            <input type="text" class="inp-form" name="title_no" id="title_no" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">Issued Date :</th>
			<td>
            <input type="text" class="inp-form" name="issued_date" id="issued_date" value="" onkeypress="return handleEnter(this, event);" 
            onblur="doDate(this,'em_Date');"/>
            </td>
		</tr>    
        <tr>
			<th valign="top">&nbsp;</th>
			<td>
           		<h3>Boundary</h3>
            </td>
            <th valign="top">Issued By :</th>
			<td>
            <input type="text" class="inp-form" name="issued_by" id="issued_by" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
		</tr>
        <tr>
			<th valign="top">West :</th>
			<td>
            <input type="text" class="inp-form" name="west" id="west" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">East :</th>
			<td>
            <input type="text" class="inp-form" name="east" id="east" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
		</tr>
        <tr>
			<th valign="top">North :</th>
			<td>
            <input type="text" class="inp-form" name="north" id="north" value="" 
            onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">South :</th>
			<td>
            <input type="text" class="inp-form" name="south" id="south" value="" onkeypress="return handleEnter(this, event);"/>
            </td>
		</tr>
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="submit" class="form-submit" name="save" id="save" 
            onclick="return confirm('Are you sure wanna save ? Please check :Setting, Classify Purpose and loan Security before you click ok.');"/>
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