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
	Full Trail Balance
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
				<td colspan='5' align='center'><u><h5>Full Trail Balance</h5></u></td>
			</tr>
			
			
		</table>
	";	
?>
<br />

<table width="1090" height="auto" border="0" class="sortable resizable editable" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
	<thead>
	<tr align="center" height="50">
		<th class="tdpricipal" align="left" colspan="2" valign="middle" id="no" style="border-top:none;border-left:none;border-right:none" >
			<u>Sort Code</u>
		</th>
        <th class="tdpricipal" align="center" colspan="3" valign="middle" id="no" style="border-top:none;border-left:none;border-right:none" >
			<u>Description</u>
		</th>
		<th class="tdpricipal" align="center" colspan="2"  style="border-top:none;border-left:none;border-right:none">
			<u>Debit</u>	
		</th>
        <th class="tdpricipal" align="center" colspan="2"  style="border-top:none;border-left:none;border-right:none">
			<u>Credit</u>
		</th>
	</tr>

    </thead>
	<?php
			
			//////show schedule
					
					$t_credit=0;
					$t_debit=0;
					$i=0;
					$trn_number1='';
					$show_user="select c.c_code,c.c_name,c.c_name,c_is_header,c_is_debit from chartacc_list c where c_enable =1 order by c_code,c_refer;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$credit=0;
						$debit =0;
						$c_code=$row['c_code'];
						$c_name=$row['c_name'];
						$c_is_header=$row['c_is_header'];
						$c_is_debit=$row['c_is_debit'];
						if ($br=='0'){
							$sub_ba="select sum(c_credit) c_credit, sum(c_debit) c_debit from account a, chartacc_list c where a.a_date between '$from' and '$to' and c_enable =1 and 
						a.c_code in (select c_code from chartacc_list where c_refer=(select c_code from chartacc_list where c_refer='$c_code' limit 1)) order by c.c_code,c.c_refer;";
						}
						else{
							$sub_ba="select sum(c_credit) c_credit, sum(c_debit) c_debit from account a, chartacc_list c where a.branch='$mybr' and a.a_date between '$from' and '$to' and c_enable =1 and 
						a.c_code in (select c_code from chartacc_list where c_refer=(select c_code from chartacc_list where c_refer='$c_code' limit 1)) order by c.c_code,c.c_refer;";
						}
						
						
						$result_bl=mysql_query($sub_ba);
						while($row=mysql_fetch_array($result_bl))
						{
							$credit1=$row['c_credit'];
							$debit1=$row['c_debit'];
							$credit=formatMoney($row['c_credit'],true);
							$debit=formatMoney($row['c_debit'],true);
						}
						if($c_is_debit==1){
							$credit1=formatmoney(0,true);	
							$credit=formatmoney(0,true);
						}
						else
						{
							$debit1	=formatmoney(0,true);
							$debit=formatmoney(0,true);	
						}
							
							//$t_credit=$t_credit+$credit;
							//$t_debit=$t_debit+$debit;
						if ($c_is_header==1){
							
							echo"<tr align='center' >
						<td  class='tdpricipal' align='left' colspan='2' style='border-bottom:none;border-left:none;border-right:none'>
							<b>$c_code</b>
						</td>
					";
				echo"<td class='tdpricipal' colspan='3' style='border-bottom:none;border-left:none;text-align:left;border-right:none'>&nbsp;<b>$c_name</b></td>";
	
				echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:left;border-right:none'>&nbsp;<b>$debit</b></td>";
	
				echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:right;border-right:none'>&nbsp;<b>$credit</b></td>";
	
				echo"</tr>";
						}
						else
						{
							$t_credit1=$t_credit1+$credit1;
							$t_debit1=$t_debit1+$debit1;
							$t_credit=formatmoney($t_credit1,true);
							$t_debit=formatmoney($t_debit1,true);
							echo"<tr align='center' >
						<td  class='tdpricipal' align='left' colspan='2' style='border-bottom:none;border-left:none;border-right:none'>
							$c_code
						</td>
					";
				echo"<td class='tdpricipal' colspan='3' style='border-bottom:none;border-left:none;text-align:left;border-right:none'>&nbsp;$c_name</td>";
	
				echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:left;border-right:none'>&nbsp;$debit</td>";
	
				echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:right;border-right:none'>&nbsp;$credit</td>";
	
				echo"</tr>";
	
						}						
						if($i==0){
							$trn_number1=$trn_number;
						}
						$i++;
						if ($trn_number!=$trn_number1){
							$i=0;
	
						}
					if ($i==0){
						
			///////////
				echo"<tr align='center' >
					<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;border-right:none'>
							
					</td>
				";
							echo"<td class='tdpricipal' colspan='3' style='border-bottom:none;border-left:none;text-align:left;border-right:none'>&nbsp;Total :</td>";

			echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:left;border-right:none'>&nbsp;<b>$t_debit</b></td>";

			echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:right;border-right:none'>&nbsp;<b>$t_credit</b></td>";

			echo"</tr>";
					$t_debit=formatmoney(0,true);
					$t_credit=formatmoney(0,true);
				}
			}
			echo"<tr align='center' >
					<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;border-right:none'>
							
					</td>
				";
							echo"<td class='tdpricipal' colspan='3' style='border-bottom:none;border-left:none;text-align:left;border-right:none'>&nbsp;<b>Total :</b></td>";

			echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:left;border-right:none'>&nbsp;<b>$t_debit</b></td>";

			echo"<td class='tdpricipal' colspan='2' style='border-bottom:none;border-left:none;text-align:right;border-right:none'>&nbsp;<b>$t_credit</b></td>";

			echo"</tr>";
			echo "</tbody>";
	?>
</table>

</cente>
<?php
	echo " <script> window.print(); </script> ";
?>
</body>
</html>