<?php
    session_start();
    if(empty($_SESSION['usr'])) header('location:login.php');
	include("conn.php");
	include("module.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/subsi_report.css" media="all">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<head>
</head>
<body>
<center>
<br /> 
<?php
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
					$get_more_info="SELECT * FROM register WHERE id ='$reg_id' limit 1";
							$resultcif=mysql_query($get_more_info) or die (mysql_error());
							while($row = mysql_fetch_array($resultcif))
									{
										$tel=$row['tel'];
										$houseNo=$row['houseNo'];
										$streetNo=$row['streetNo'];
										$vil=$row['village'];
										$com=$row['commune'];
										$dist=$row['district'];
										$prov=$row['province'];
										$kh_borrower=$row['kh_borrower'];
										$en_borrower=$row['borrower'];
										$method=$row['method'];
										$reg_date=date('Y-m-d',strtotime($row['register_date']));
									}
					//get infor from approval
					echo"<title>Susidiary Ledger-$kh_borrower</title>";
					$get_app_info="SELECT * FROM customer_app WHERE cid ='$cid' and register_date='$reg_date'";
							$result_app_info=mysql_query($get_app_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_app_info))
									{
										$amount=$row['approval_amt'];
										$display_amt=formatMoney($amount,true);
										$approval_rate=$row['approval_rate'];
										$approval_period=$row['approval_period'];
										$nor=$row['number_of_repay'];
										//$method=$row['method'];
									}
					//get infor from loan process
					$get_loan_info="SELECT * FROM loan_process WHERE regis_id ='$reg_id'";
							$result_loan_info=mysql_query($get_loan_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_loan_info))
									{
										$lid=$row['ld'];
										$dis_date=date('d-m-Y',strtotime($row['dis_date']));
										$mydis_date=$row['dis_date'];
										$mygetststus=$row['status'];
										break;
									}
									
									if($mygetststus=='6'){
											$loanStatus='(Reschedule)';
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
		<table width='1350' height='auto' border='0' cellpadding='0' cellspacing='1'>
			<tr>
				<td colspan='3' align='center'>
					<b><u><h3>ប្រតិបត្តិការណ៏បង់ប្រាក់របស់អតិថិជន</h3></u> 
				</td>
			</tr>
			<tr align='center'>
				<td align='left'>
					លេខឥណទាន : 
					 $lid $loanStatus
				</td>
				<td width='390'>
					&nbsp;
				</td>
				<td align='left'>
					លេខអតិថិជន :
					 $cid 
				</td>
			</tr>
			<tr align='center'>
				<td align='left'>
					ឈ្មោះអតិថិជន :
					 $kh_borrower 
				</td>
				<td width='200'>
					&nbsp;
				</td>
				<td align='left'>
					ទឹកប្រាក់ខ្ចី : 
					 $cur $display_amt   
				</td>
			</tr>
			<tr align='center'>
				<td align='left'>
					Customer:
				
					 $en_borrower 
				</td>
				<td width='200'>
					&nbsp;
				</td>
				<td align='left'>
					អាត្រាការប្រាក់  : 
					 $approval_rate %  
				</td>
			</tr>
			<tr align='center'>
				<td align='left'>
					កាលបរិច្ឆេទបើកប្រាក់ :
					 $dis_date 
				</td>
				<td width='200' align='center' valign='middle'>
					&nbsp;
				</td>
				<td align='left'>
					រយះពេលខ្ចី : 
					 $myapproval_period $show_fr  
				</td>
			</tr>
			<tr align='center'>
				<td align='left'>
					លេខទូរស័ព្ទ:
					 $myphone 
					
				</td>
				<td width='200'>
					&nbsp;
				</td>
				<td align='left'>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td align='justify' colspan='3'>
					អសយដ្ឋាន : 
					ផ្ទះលេខ  $houseNo , ផ្លូវ   $streetNo , ភូមិ/ក្រុម   $get_village ,​ 
					ឃុំសង្កាត់  $get_commune, ស្រុក/ខ័ណ្ឌ   $get_district , 
					ខេត្ត/ក្រុង  $get_province
					
				</td>
			</tr>
			<tr align='center'>
				<td align='left'>
					ភ្នាក់ងារ : 
					 $co_name ( $Cophone )
					
				</td>
				<td width='200' align='center' valign='middle'>
					&nbsp;
				</td>
				<td align='left'>
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan='3' height='30'>
					&nbsp;
				</td>
			</tr>
		</table>
	";	
?>
<br />
<table width="1750" height="auto" border="0" class="form_border" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	<tr align="center" height="50">
		<td class="report_header_kh" align="center" valign="middle" colspan="6">
			Scedule
		</td>
		<td class="report_header_kh" colspan="7">
			Repayment
		</td>
		<td class="report_header_kh" colspan="2">
			Penalty	
		</td>
		<td class="report_header_kh" colspan="3">	
			Penalty Repay
		</td>
	</tr>
    <tr>
    	<td class="tdpricipal" width="30">
        	N<sup>o</sup>
        </td>
        <td class="tdpricipal" colspan="2" width="45">
        	Date
        </td>
        <td  class="tdpricipal" width="100">
            Prin
        </td>
        <td class="tdpricipal" width="100">
            Int        
        </td>
        <td class="tdpricipal" width="100">
            Total
        </td>
        <td class="tdpricipal" width="50">
            Date
        
        </td>
        <td class="tdpricipal" width="100">
            Prin
        </td>
        <td class="tdpricipal" width="100">
            Int
        </td>
        <td class="tdpricipal" width="100">
            Disc
        
        </td>
        <td class="tdpricipal" width="100">
            Total
        </td>
        <td class="tdpricipal" width="35">
            O/S
        
        </td>
        <td class="tdpricipal" width="35">
            Day
        
        </td>
        <td class="tdpricipal" width="35">
            Accrued
        
        </td>
        <td class="tdpricipal" width="35">
            Waved
        
        </td>
        <td class="tdpricipal" width="35">
            Date
        
        </td>
         <td class="tdpricipal" width="35">
            Amount
        
        </td>
         <td class="tdpricipal" width="35">
            Fees
        </td>
    </tr>
	<?php
			
			//////show schedule
					$re_os=$amount;
					$schedule_sql="SELECT * FROM schedule WHERE ld ='$lid' and rp <> '6' ORDER BY repayment_date ASC";
							$result_sch=mysql_query($schedule_sql) or die (mysql_error());
							$n=1;
							while($row = mysql_fetch_array($result_sch))
									{
										$n=$row['no_install'];
										$Endate=$row['repayment_date'];
										//translate
											$check_date=date('D',strtotime($row[repayment_date]));
											if($check_date=='Mon'){
												$my_date='ច័ន្ទ';
												$repay_date=date('d/m/Y',strtotime($Endate));
											}
											else if($check_date=='Tue'){
												$my_date='អង្គារ៍';
												$repay_date= date('d/m/Y',strtotime($Endate));
											}
											else if($check_date=='Wed'){
												$my_date='ពុធ';
												$repay_date=date('d/m/Y',strtotime($Endate));
											}
											else if($check_date=='Thu'){
												$my_date='ព្រហ';
												$repay_date=date('d/m/Y',strtotime($Endate));
											}
											else if($check_date=='Fri'){
												$my_date='សុក្រ';
												$repay_date=date('d/m/Y',strtotime($Endate));
											}
											else{
												echo"<script>alert('There is a weekend day in your schedule!');</script>";
												exit();
												mysql_close();
											}
										///
										$mypaid_date=date('Y-m-d',strtotime($row[paid_date]));
										$mydue_date=date('Y-m-d',strtotime($row[repayment_date]));
										if($row[paid_date]!='0000-00-00'){
											$days=dateDiff(date('Y-m-d',strtotime($mypaid_date)),$mydue_date);
										}
										else{
											$days='';
											}
										$pricipal=formatMoney(round($row[principal],2),true);
										$interest=formatMoney(round($row[interest],2),true);
										$total=formatMoney(round($row[total],2),true);
										$os=formatMoney(round($row[balance],2),true);
										$normalPn=formatMoney(round($row[norpen_paid],2),true);
										$rp=$row['rp'];
										if($row['paid_date']!='0000-00-00'){
											$paid_date=date('d-m-Y',strtotime($row['paid_date']));
										}
										else{
											$paid_date='';
											}
											
										if($row[prn_paid]!='0'){
											$pri_paid=formatMoney(round($row[prn_paid],2),true);
										}
										else if($row[paid_date]!='0000-00-00'){
											$pri_paid='0.00';
										}
										else{
											$pri_paid='';
											}
											
										if($row[int_paid]!='0'){
											$int_paid=formatMoney(round($row[int_paid],2),true);
										}
										else{
											$int_paid='';
											}
										if($row[int_dis]!='0'){
											$int_dis=formatMoney(round($row[int_dis],2),true);
											
										}
										else if($row[paid_date]!='0000-00-00'){
											$int_dis='0.00';
											if($rp=='9'){
													$myint=$row[interest];
													$myintpaid=$row[int_paid];
													$int_dis=formatMoney($myint-$myintpaid,true);
												}
											}
										else{
											$int_dis='';
											}
											
											
										if($row[prn_paid]!='0' || $row[int_paid]!='0'){
											$total_paid=formatMoney(round(($row[prn_paid]+$row[int_paid]),2),true);
										}
										else{
											$total_paid='';
											}
										if($row[prn_paid]!='0' || $row[int_paid]!='0'){
											
											$re_os=round($re_os-$row[prn_paid],2);
											$myre_os=formatMoney($re_os,true);
										}
										else{
											$myre_os='';
											}
									//////
			echo"<tr align='center'>
					<td class='tdpricipal'>
						$n
					</td>
				";
				echo"<td class='tdpricipal' width='35'>$my_date</td>";
				echo"<td class='tdpricipal' width='50'>$repay_date</td>";
				echo"<td class='tdpricipal'> $pricipal</td>";
				echo"<td class='tdpricipal'> $interest</td>";
				echo"<td class='tdpricipal'> $total</td>";
				echo"<td class='tdpricipal'> $paid_date</td>";
				
				echo"<td class='tdpricipal'> $pri_paid</td>";
				echo"<td class='tdpricipal'> $int_paid</td>";
				echo"<td class='tdpricipal'> $int_dis </td>";
				echo"<td class='tdpricipal'> $total_paid </td>";
				echo"<td class='tdpricipal'> $myre_os </td>";
				echo"<td class='tdpricipal'> $days </td>";
				
				echo"<td class='tdpricipal'> &nbsp; </td>";
				echo"<td class='tdpricipal'> &nbsp; </td>";
				echo"<td class='tdpricipal'> &nbsp; </td>";
				echo"<td class='tdpricipal'> &nbsp; </td>";
				echo"<td class='tdpricipal'> &nbsp; </td>";
			echo"</tr>";
			$n+=1;	
			}
			/////////////////////////total pricipal
		$tot_pri_sql = "SELECT SUM(principal) AS pr_total FROM `schedule` WHERE ld ='$lid' and rp<>6";
				$result_pr = mysql_query($tot_pri_sql) or die(mysql_error());
				$t_pr = mysql_fetch_array($result_pr);
			/////////////////////
			/////////////////////////total interest
				$tot_int_sql = "SELECT SUM(ROUND(interest,2)) AS int_total FROM `schedule` WHERE ld ='$lid'";
				$result_int = mysql_query($tot_int_sql) or die(mysql_error());
				$t_int = mysql_fetch_array($result_int);
			/////////////////////
			/////////////////////////total payment
		$tot_pa_sql = "SELECT SUM(ROUND(total,2)) AS pa_total FROM `schedule` WHERE ld ='$lid'";
				$result_pa = mysql_query($tot_pa_sql) or die(mysql_error());
				$t_pa = mysql_fetch_array($result_pa);
			///////////
				echo"<tr align='center'>
					<td class='tdpricipal'>
						Total:
					</td>
				";
			echo"<td class='tdpricipal'>&nbsp;</td>";
			echo"<td class='tdpricipal'>&nbsp;</td>";
			echo"<td class='tdpricipal'>".formatMoney(round($t_pr[pr_total],2),true)."</td>";
			echo"<td class='tdpricipal'>&nbsp;</td>";
			echo"<td class='tdpricipal'>&nbsp;</td>";
			echo"<td class='tdpricipal'>&nbsp;</td>";
			echo"</tr>";
	?>
</table>
<table width="1200" height="244" border="0" cellpadding="0" cellspacing="0">
	<tr height="50 colspan="3">
    	<td>&nbsp;</td>
    </tr>
	<tr align="center">
		<td align="right" width="290">
			រៀបចំដោយ 
		</td>
		<td width="350">&nbsp;
			 
		</td>
		<td align="left">
			មូលហេតុ / Reason : .............................................................................................
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr align="center">
		<td>&nbsp;
			 
		</td>
		<td>&nbsp;
			
		</td>
		<td>&nbsp;
			 
		</td>
	</tr>
	<tr align="center">
		<td>&nbsp;
			
		</td>
		
		<td>&nbsp;
			
		</td>
		<td>&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr align="center" >
		<td height="109" align="right">
			<?php echo $_SESSION['usr']; ?>	
           </td>
		<td align="center" valign="bottom">&nbsp;
			
		</td>
		<td align="left">&nbsp;
			
		</td>
	</tr>
</table>
</cente>
<?php
	echo " <script> win dow.print(); </script> ";
	mysql_close();
?>
</body>
</html>