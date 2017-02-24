<?php
    session_start();
    if(empty($_SESSION['usr'])) header('location:login.php');
	include("conn.php");
	include("module.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/schedule.css" media="all">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<head>
<title>
	Balance Sheet
</title>
</head>
<body>
<center>
<br />
<?php
					$get_from=$_POST['from'];
					$get_to=$_POST['to'];
					$from =date('Y-m-d',strtotime($get_from));
					$to=date('Y-m-d',strtotime($get_to));
					///Final Varaible
					$br=$_POST['br'];
					$mycur=$_POST['cur'];
					$myfrom= date('D,d/m/Y',strtotime($from));
					$myto= date('D,d/m/Y',strtotime($to));
$d =date('Y-m-d');
							$br_info="SELECT * FROM br_ip_mgr where br_no='$br' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$mybr=$row['br_name'];
										}
			$display_rates="SELECT exchrates FROM currency_type WHERE types='USD' order by date desc limit 1";
			$result_rates=mysql_query($display_rates) or die (mysql_error());
			while($row=mysql_fetch_array($result_rates)){
				$rates = $row['exchrates'];
			}
											

			mysql_query ('SET NAMES UTF8');
			$lid = trim($_POST['lid']);
			$display_info="SELECT * FROM loan_process WHERE ld='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$reg_id = $row['regis_id'];
						$dis=$row['dis'];
					}
				//check disbursement
				if($dis=='0'){
						echo"<script>alert('This customer is not yet disbursed! Check again pls!');</script>";
						echo"<script>window.close(); </script>";
						exit();
					}
			/////
			/*echo"<script>alert('$reg_id'); </script>";*/
			//get CID
			$query_cid = "SELECT * FROM register WHERE id ='$reg_id' ORDER BY id ASC"; 
					$result_cid = mysql_query($query_cid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_cid)){
						$cid=$row['cif'];
						$cur=$row['cur'];
						$co_name=$row['co'];
					}
		
					//-------find Co's phone
						$co_phone_sql = "SELECT s_phone FROM `staff_list` where s_name_kh ='$co_name';";
						$result_co_phone = mysql_query($co_phone_sql) or die(mysql_error());
							while($row = mysql_fetch_array($result_co_phone))
											{
											$co_phone=$row['s_phone'];
											$Cophone=wordwrap("$co_phone",3, " ", true); 
											}
						
					/////////////////////
					//////get more informatio from cif detail
					$get_more_info="SELECT * FROM register WHERE cif ='$cid'";
							$resultcif=mysql_query($get_more_info) or die (mysql_error());
							while($row = mysql_fetch_array($resultcif))
									{
										$tel=$row['tel'];
										/*$houseNo=$row['houseNo'];
										$streetNo=$row['streetNo'];*/
										$vil=$row['village'];
										$com=$row['commune'];
										$dist=$row['district'];
										$prov=$row['province'];
										$kh_borrower=$row['kh_borrower'];
										$en_borrower=$row['borrower'];
										break;
									}
					//get infor from loan process
					$get_loan_info="SELECT * FROM loan_process WHERE regis_id ='$reg_id'";
							$result_loan_info=mysql_query($get_loan_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_loan_info))
									{
										$lid=$row['ld'];
										$dis_date=date('d-m-Y',strtotime($row['dis_date']));
										$mydis_date=$row['dis_date'];
										$myregDate=date('Y-m-d',strtotime($row['reg_date']));
										$method=$row['payMethod'];
										break;
									}
					//get infor from approval
					$get_app_info="SELECT * FROM customer_app WHERE cid ='$cid' and register_date='$myregDate'";
							$result_app_info=mysql_query($get_app_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_app_info))
									{
										$amount=$row['approval_amt'];
										$display_amt=formatMoney($amount,true);
										$approval_rate=$row['approval_rate'];
										$approval_period=$row['approval_period'];
										$nor=$row['number_of_repay'];
										$method=$row['method'];
									}
					
					
					//////show village					
					$village_sql="SELECT * FROM village WHERE id ='$vil'";
							$result_vil=mysql_query($village_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_vil))
									{
										$get_village=$row['village'];
										//echo $show_commune;
									}
					//////show commune
					$commune_sql="SELECT * FROM adr_commune WHERE id ='$com'";
							$result_com=mysql_query($commune_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_com))
									{
										$get_commune=$row['commune'];
										//echo $show_commune;
									}
					//////show district
					$district_sql="SELECT * FROM district WHERE id ='$dist'";
							$result_dis=mysql_query($district_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_dis))
									{
										$get_district=$row['district'];
										//echo $show_commune;
									}
					//////show province
					$province_sql="SELECT * FROM province WHERE id ='$prov'";
							$result_prov=mysql_query($province_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_prov))
									{
										$get_province=$row['province'];
										//echo $show_commune;
									}
					//display frequency
						$myapproval_period=$approval_period;
						if($nor=='30'){
							$show_fr='ខែ';
							}
						else if($nor=='7'){
							$show_fr='អាទិត្យ';
							}
						else if($nor=='14'){
							$show_fr='អាទិត្យ';
							$myapproval_period *=2;
							}
						else if($nor=='15'){
							$show_fr='ខែ';
							$myapproval_period /=2;
							}
						else{
							$show_fr='ថ្ងៃ';
							}
				//---end frequency----//							
				
					//date_default_timezone_set('Australia/Melbourne');
	
	$myphone=wordwrap("$tel",3, " ", true); 
	echo "
		<table width='1090' height='auto' border='0' cellpadding='0' cellspacing='1'>
			<tr><td><img src='../tmp/logo.png' width='140' height='140'/></td>
				<td colspan='3' align='center'>
					<b><h3>PINPA FINANCIAL TRAINING AND CONSULTANCY</h3>
					<b><h4>Phnom Penh Branch</h4> 
					<b><h4>$from To $to</h4>
				</td>
			</tr>
		
			<tr>
				<td colspan='5' align='center'><u><h5>Balance Sheet</h5></u></td>
			</tr>
			
			
		</table>
	";	
?>
<br />
<table width="1090" height="auto" border="0" class="sortable resizable editable" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	<thead>
	<tr align="center" height="50">
		<th class="report_header_kh" align="center" colspan="3" valign="middle" id="no" style="border-top:none;border-left:none;border-right:none" >
			Description
		</th>
		<th class="report_header_kh" colspan="2" id="repayment_date" style="border-top:none;border-left:none;border-right:none">
			Debits
		</th>
		<th class="report_header_kh" colspan="2" id="principal" style="border-top:none;border-left:none;border-right:none">
			Credits	
		</th>
	</tr>
    </thead>
	<?php
			
			//////show schedule
					$credit=0;
					$debit =0;
					$show_user="select ca_name , ca_level ,ca_id from gl_caption where ca_isbl  =1 order by  indexs;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$amountd=0;
						$amountc=0;
						$id=$row['ca_id'];
						$id1=0;
						//Get ID From gl_Caption

						$c_name=$row['ca_name'];
						$level=$row['ca_level'];
						
						$getID="select ca_id from gl_caption where ca_isbl  =1 and ca_master='$c_name' order by  indexs;";
						$result_id=mysql_query($getID);
						while($row=mysql_fetch_array($result_id))
						{
							$id1=$row['ca_id'];
						}
					
					
						if ($br=='0'){
							$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit,a.c_cur from gllink g , chartacc_list c , account a   where a.a_date between '$from' and '$to' and isbl  =1 and ca_id='$id'  and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit,a.c_cur,a.a_date order by gl_code;";
						}
						else{
							$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit,a.c_cur from gllink g , chartacc_list c , account a   where a.branch='$mybr' and a.a_date between '$from' and '$to' and isbl  =1 and ca_id='$id'  and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit,a.c_cur order by gl_code;";
						}
						//echo $show_acc;
							$result_acc=mysql_query($show_acc);
							while($row=mysql_fetch_array($result_acc))
							{
								$isdebit = $row['c_is_debit'];
								$cur1= $row['c_cur'];
								if ($isdebit==1){
									if ($mycur=='KHR'){
										if($cur1=='USD'){
											$amountd = formatmoney($row['amount']*$rates,true);
										}
										else{
											$amountd = formatmoney($row['amount'],true);
										}
									}
									else{
										if($cur1=='KHR'){
											$amountd = formatmoney($row['amount']/$rates,true);
										}
										else{
											$amountd = formatmoney($row['amount'],true);
										}
									}
								}
								else{
									if ($mycur=='KHR'){
										if($cur1=='USD'){
											$amountc = formatmoney($row['amount']*$rates,true);
										}
										else{
											$amountc = formatmoney($row['amount'],true);
										}
									}
									else{
										if($cur1=='KHR'){
											$amountc = formatmoney($row['amount']/$rates,true);
										}
										else{
											$amountc = formatmoney($row['amount'],true);
										}
									}				
								}
							}
							
							if ($amountc=='0' && $amountd=='0'){
								if ($br=='0'){
									$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit,a.c_cur from gllink g , chartacc_list c , account a   where a.a_date between '$from' and '$to' and isbl  =1 and ca_id='$id1'  and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit,a.a_date,a.c_cur order by gl_code;";
								}
								else{
									$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit,a.c_cur from gllink g , chartacc_list c , account a   where a.branch='$mybr' and a.a_date between '$from' and '$to' and isbl  =1 and ca_id='$id1'  and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit,a.c_cur order by gl_code;";
								}
								
								$result_acc=mysql_query($show_acc);
								while($row=mysql_fetch_array($result_acc))
								{
									$isdebit = $row['c_is_debit'];
									$cur1= $row['c_cur'];
									if ($isdebit==1){
										if ($mycur=='KHR'){
											if($cur1=='USD'){
												$amountd = formatmoney($row['amount']*$rates,true);
											}
											else{
												$amountd = formatmoney($row['amount'],true);
											}
										}
										else{
											if($cur1=='KHR'){
												$amountd = formatmoney($row['amount']/$rates,true);
											}
											else{
												$amountd = formatmoney($row['amount'],true);
											}
										}
										
									}
									else{
										if ($mycur=='KHR'){
											if($cur1=='USD'){
												$amountc = formatmoney($row['amount']*$rates,true);
											}
											else{
												$amountc = formatmoney($row['amount'],true);
											}
										}
										else{
											if($cur1=='KHR'){
												$amountc = formatmoney($row['amount']/$rates,true);
											}
											else{
												$amountc = formatmoney($row['amount'],true);
											}
										}	
					
									}
								}	
							}
						if ($level==1){
			
							
						echo"<tbody><tr align='center'>
					<td class='tdpricipal' colspan='3' style='border-bottom:none;border-left:none'>
						$c_name
					</td>
				";
				echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:right'>$amountd</td>";
				echo"<td class='tdpricipal' colspan='2'  style='border-bottom:none;border-left:none;border-right:none;text-align:right'>$amountc</td>";
				echo"</tr>";
							if ($br=='0'){
								$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit,a.c_cur from gllink g , chartacc_list c , account a   where a.a_date between '$from' and '$to' and isbl  =1 and ca_id='$id'  and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit,a.c_cur,a.a_date order by gl_code;";
							}
							else{
								$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit,a.c_cur from gllink g , chartacc_list c , account a   where a.branch='$mybr' and a.a_date between '$from' and '$to' and isbl  =1 and ca_id='$id'  and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit,a.c_cur order by gl_code;";
							}
							
							/*$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit from gllink g , chartacc_list c , account a   where isbl  =1 and ca_id='$id' and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit order by gl_code;";*/
							$result_acc=mysql_query($show_acc);
							while($row=mysql_fetch_array($result_acc))
							{
								
								$id=$row['id'];
								$c_name1=$row['c_name'];
								$cur1= $row['c_cur'];
								//$level='0';
								$isdebit = $row['c_is_debit'];
								if ($isdebit==1){
									if ($mycur=='KHR'){
											if($cur1=='USD'){
												$amountd1 = $row['amount']*$rates;
											}
											else{
												$amountd1 = $row['amount'];
											}
										}
										else{
											if($cur1=='KHR'){
												$amountd1 = $row['amount']/$rates;
											}
											else{
												$amountd1 = $row['amount'];
											}
										}
									//$amountd1=$row['amount'];
									$amountd = formatmoney($amountd1,true);
									$debit1=$debit1+$amountd1;
									$debit=formatmoney($debit1,true);
								}
								else{
									if ($mycur=='KHR'){
											if($cur1=='USD'){
												$amountc1 = $row['amount']*$rates;
											}
											else{
												$amountc1 = $row['amount'];
											}
										}
										else{
											if($cur1=='KHR'){
												$amountc1 = $row['amount']/$rates;
											}
											else{
												$amountc1 = $row['amount'];
											}
										}	
			//						$amountc1=$row['amount'];
									$amountc = formatmoney($amountc1,true);
									$credit1=$credit1+$amountd1;
									$credit=formatmoney($credit1,true);
								}
								//$amount = $row['amount'];
								echo"<tbody><tr align='center'>
					<td class='tdpricipal' colspan='3' style='border-bottom:none ;border-top:none;border-left:none;color:#3F9'>
						$c_name1
					</td>
				";
				echo"<td class='tdpricipal' colspan='2' style='border-bottom:none ;border-top:none;border-left:none;text-align:right;color:#3F9'>$amountd</td>";
				echo"<td class='tdpricipal' colspan='2'  style='border-bottom:none ;border-top:none;border-left:none;border-right:none;text-align:right;color:#3F9'>$amountc</td>";
				echo"</tr>";	
							}
						}
						else{
						
							$str="";
							for ($i==0;$i<$level-1;$i++){
								$str=$str."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}
							$i=0;
								
							echo"<tbody><tr align='center'>
					<td class='tdpricipal' colspan='3' style='border-bottom:none;border-top:none;border-left:none'>
						$str $c_name
					</td>
				";
				echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;border-top:none;text-align:right'>$amountd</td>";
				echo"<td class='tdpricipal' colspan='2'  style='border-bottom:none;border-left:none;border-top:none;border-right:none;text-align:right'>$amountc</td>";
				echo"</tr>";
						if ($br=='0'){
							$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit,a.c_cur from gllink g , chartacc_list c , account a   where a.a_date between '$from' and '$to' and isbl  =1 and ca_id='$id'  and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit,a.a_date,a.c_cur order by gl_code;";
						}
						else{
							$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit,a.c_cur from gllink g , chartacc_list c , account a   where a.branch='$mybr' and a.a_date between '$from' and '$to' and isbl  =1 and ca_id='$id'  and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl,c.c_is_debit,a.c_cur order by gl_code;";
						}
							
						/*$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount,c.c_is_debit from gllink g , chartacc_list c , account a   where isbl  =1 and ca_id='$id' and g.gl_code=a.c_code and g.gl_code=c.c_code  group by gl_code,c.c_name,id,isbl,c.c_is_debit order by gl_code;";*/
							$result_acc=mysql_query($show_acc);
							while($row=mysql_fetch_array($result_acc))
							{
								$str=$str."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								$id=$row['id'];
								$c_name1=$row['c_name'];
								//$level='0';
									$cur1= $row['c_cur'];
									$isdebit = $row['c_is_debit'];
								if ($isdebit==1){
									if ($mycur=='KHR'){
											if($cur1=='USD'){
												$amountd1 = $row['amount']*$rates;
											}
											else{
												$amountd1 = $row['amount'];
											}
										}
										else{
											if($cur1=='KHR'){
												$amountd1 = $row['amount']/$rates;
											}
											else{
												$amountd1 = $row['amount'];
											}
										}
									//$amountd1=$row['amount'];
									$amountd = formatmoney($amountd1,true);
									$debit1=$debit1+$amountd1;
									$debit=formatmoney($debit1,true);
								}
								else{
									if ($mycur=='KHR'){
											if($cur1=='USD'){
												$amountc1 = $row['amount']*$rates;
											}
											else{
												$amountc1 = $row['amount'];
											}
										}
										else{
											if($cur1=='KHR'){
												$amountc1 = $row['amount']/$rates;
											}
											else{
												$amountc1 = $row['amount'];
											}
										}
									//$amountc1=$row['amount'];
									$amountc = formatmoney($amountc1,true);
									$credit1=$credit1+$amountd1;
									$credit=formatmoney($credit1,true);
								}
								echo"<tbody><tr align='center'>
					<td class='tdpricipal' colspan='3' style='border-bottom:none;border-top:none;border-left:none;color:#090'>
						$str $c_name1
					</td>
				";
				echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-top:none;border-left:none;text-align:right;color:#090'>$amountd</td>";
				echo"<td class='tdpricipal' colspan='2'  style='border-bottom:none;border-top:none;border-left:none;border-right:none;text-align:right;color:#090'>$amountc</td>";
				echo"</tr>";
							}
						}
						echo "</tr>";
						
					}
									
									//////
			
		//	$n+=1;	

			/////////////////////////total credit
	/*	$tot_pri_sql = "SELECT SUM(c_credit) AS c_credit from gllink g , chartacc_list c , account a   where isbl  =0 and ca_id='$id' and g.gl_code=a.c_code and g.gl_code=c.c_code and issave ='1' group by gl_code,c.c_name,id,isbl,c.c_is_debit order by gl_code";
				$result_pr = mysql_query($tot_pri_sql) or die(mysql_error());
				$credit=0;
				//$t_pr = mysql_fetch_array($result_pr);
				while($row=mysql_fetch_array($result_pr)){
					$credit = $row['c_credit'];
				}
			/////////////////////
			/////////////////////////total debit
				$tot_int_sql = "SELECT SUM(c_debit) AS c_debit FROM `account` WHERE issave ='1'";
				$result_int = mysql_query($tot_int_sql) or die(mysql_error());
				//$t_int = mysql_fetch_array($result_int);
				while($row=mysql_fetch_array($result_int)){
					$debit = $row['c_debit'];
				}*/
			/////////////////////
			///
			///////////
				echo"<tr align='center' >
					<td class='tdpricipal' colspan='3' style='border-bottom:none;border-left:none'>
						Total :
					</td>
				";
			echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:right'>&nbsp;$debit</td>";
			echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;border-right:none;text-align:right'>&nbsp;$credit</td>";
			echo"</tr></tbody>";
	?>
</table>

</cente>
<?php
	echo " <script> window.print(); </script> ";
?>
</body>
</html>