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
	Collateral Information
</title>
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
										
										$ownership=$row['ownership'];
										$depositor_name=$row['depositor_name'];
										$co_depositor_name=$row['co_depositor_name'];
										$title_type=$row['title_type'];
										$callateral_type=$row['callateral_type'];
										$title_no=$row['title_no'];
										$issue_date=date('d-m-Y',strtotime($row['issue_date']));
										break;
									}
					if($ownership=='0'){
						echo"<script>alert('អតិថិជននេះមិនមានទ្រព្យធានាទេ!'); window.close();</script>";
						
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
		 <tr>
				<td width='130'>
					<img src='../tmp/logo.png' border='0' title='FTC' width='130'>
					
				</td>
				<td valign='middle'>
					<div style='font-family:Khmer OS Muol; font-size:12pt; text-decoration:underline'>សមាគម ឥណទាន សារីណា </div> <br/>
					<div style='font-size:12pt; text-decoration:underline'><b>Saryna Credit Association</b></div>
				</td>
			</tr>
		</table>
		<table width='1090' height='auto' border='0' cellpadding='0' cellspacing='1'>
		   
			<tr>
				<td colspan='3' align='center'>
					<b><u><h3>ពត៍មានទ្រព្យតម្កល់ធានា</h3></u> 
				</td>
			</tr>
			<tr align='center'>
				<td align='left'>
					លេខឥណទាន : 
					 $lid 
				</td>
				<td width='200'>
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
					ភ្នាក់ងារ : 
					 $co_name ( $Cophone )
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
					
					
				</td>
				<td width='200' align='center' valign='middle'>
					&nbsp;
				</td>
				<td align='left'>
					&nbsp;
				</td>
			</tr>
			
			<tr align='center'>
				<td align='left'>
					ម្ចាស់ដម្កល់ទ្រព : $ownership
				</td>
				<td width='200' align='center' valign='middle'>
					&nbsp;
				</td>
				<td align='left'>
					&nbsp;
				</td>
			</tr>
			
			<tr align='center'>
				<td align='left'>
					ឈ្មោះអ្នកដាក់តម្កល់ : $depositor_name
				</td>
				<td width='200' align='center' valign='middle'>
					&nbsp;
				</td>
				<td align='left'>
					ឈ្មោះអ្នករួមដាក់តម្កល់ : $co_depositor_name
				</td>
			</tr>
			
			<tr align='center'>
				<td align='left'>
					ប្រភេទប្លង់ : $title_type
				</td>
				<td width='200' align='center' valign='middle'>
					&nbsp;
				</td>
				<td align='left'>
					ប្រភេទទ្រព្យដាក់តម្កល់ : $callateral_type
				</td>
			</tr>
			
			<tr align='center'>
				<td align='left'>
					លេខប្លង់ : $title_no
				</td>
				<td width='200' align='center' valign='middle'>
					&nbsp;
				</td>
				<td align='left'>
					ថ្ងៃចេញប្លង់ : $issue_date
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

<table width="1090" height="244" border="0" cellpadding="0" cellspacing="0">
	<tr align="center">
		<td align="right" width="290">
			រៀបចំដោយ 
		</td>
		<td>&nbsp;
			 
		</td>
		<td align="left">
			ស្នាមមេដៃអតិថិជន 
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
		<td align="center" valign="bottom">
		<b class="footer_report">ម៉ោងបំរើអតិថិជន : ចាប់ពីម៉ោង ៧:៣០ ព្រឹក ដល់ម៉ោង ៤:៣០ រសៀល <br/>( ចាប់ពីថ្ងៃ ច័ន្ទ ដល់ ថ្ងៃសុក្រ ) </b>
			
		</td>
		<td align="left">
			<?php echo $kh_borrower ;?> 
		</td>
	</tr>
</table>
</cente>
<?php
	echo " <script> window.print(); </script> ";
?>
</body>
</html>