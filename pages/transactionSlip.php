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
	Transaction Slip OLMS
</title>
</head>
<body>
<center>
<br />
<?php
			mysql_query ('SET NAMES UTF8');
			$lid = trim($_GET['lid']);
			$invoiceNo = trim($_GET['inNo']);
			$getStatus=trim($_GET['mystatus']);
			$mycid=$_GET['cid'];
			$cur=$_GET['cur']; 
			$tp=$_GET['t'];
		
						if($tp=='rp'){
							$mytp='ប័ណ្ណបង់ប្រាក់';
							$enTp='REPAYMENT VOUCHER';
							}
						else{
							$mytp='ប័ណ្ណបើកប្រាក់';	
							$enTp='DISBURSEMENT VOUCHER';					
							}
			if(($lid=='')&&($invoiceNo=='')){
				$lid=$_POST['lid'];
				$invoiceNo=$_POST['inNo'];
			}
			///
			/*echo "<script>alert('$lid,$invoiceNo');</script>";*/
			
			if($tp=='rp'){
			
			$display_info="SELECT * FROM invoice WHERE lc='$lid' and invioce_no='$invoiceNo' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$regId = $row['reg_id'];
						$ld=$row['lc'];
						$saleDay=date('d',strtotime($row['paid_date']));
						$saleMonth=date('m',strtotime($row['paid_date']));
						$saleYear=date('Y',strtotime($row['paid_date']));
						//$cur=$row['cur'];
						$amt=formatMoney($row['total'],true);
						$myamt=($row['total']);								
								
						if($cur=='USD'){
							$mycur='ដុល្លារ';
							
								$mysplit=explode(".",$myamt);
								$amt1=$mysplit[0];
								$cent=$mysplit[1];
								//$ext=substr($myamt,-2,2);
								if (!empty($cent)){
									$addWords=' និង '.convert_number_to_words($cent)."សេនគត់";
								}
								else{
									$addWords='គត់';
								}
								$mywords=convert_number_to_words($amt1).''.$mycur.''.$addWords;
								
							}
							
						if($cur=='KHR'){
							
							$mycur='រៀលគត់';
						
							$mywords=convert_number_to_words($myamt).' '.$mycur;
							
							}
						if($cur=='THB'){
							
							$mycur='បាតគត់';
						
							$mywords=convert_number_to_words($myamt).' '.$mycur;
							
							}			
						/*echo "<script>alert('$myamt,$amt1,$cent');</script>";*/
						//////
						
									$cif_sql="SELECT borrower,kh_borrower FROM register WHERE id ='$regId'";
									$result_cif=mysql_query($cif_sql) or die (mysql_error());
									while($row = mysql_fetch_array($result_cif))
											{
												$khName=$row['kh_borrower'];
												//echo $show_commune;
												break;
											}
						
						break;
					}
			}
			if($tp=='d'){
			$amt=formatMoney($_GET['lcred'],true);
			$myamt=round($_GET['lcred']);
			
			$display_info="SELECT * FROM loan_process WHERE ld='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$regId = $row['reg_id'];
						$ld=$row['ld'];
						$saleDay=date('d',strtotime($row['dis_date']));
						$saleMonth=date('m',strtotime($row['dis_date']));
						$saleYear=date('Y',strtotime($row['dis_date']));
												
						if($cur=='USD'){
							$mycur='ដុល្លារ';
							
								$mysplit=explode(".",$myamt);
								$amt1=$mysplit[0];
								$cent=$mysplit[1];
								//$ext=substr($myamt,-2,2);
								if (!empty($cent)){
									$addWords=' និង '.convert_number_to_words($cent)."សេនគត់";
								}
								else{
									$addWords='គត់';
								}
								$mywords=convert_number_to_words($amt1).''.$mycur.''.$addWords;	
							}
						else{
							$mycur='រៀលគត់';
							$mywords=convert_number_to_words($myamt).' '.$mycur;
							
							}		
						
						/////
									$cif_sql="SELECT borrower,kh_borrower FROM register WHERE cif ='$mycid'";
									$result_cif=mysql_query($cif_sql) or die (mysql_error());
									while($row = mysql_fetch_array($result_cif))
											{
												$khName=$row['kh_borrower'];
												//echo $show_commune;
												break;
											}
						
								break;
						
					}
			}
			
					/*echo "<script>alert('$lid,$cid,$khName');</script>";*/
				//check disbursement						
					//date_default_timezone_set('Australia/Melbourne');
	
	$myphone=wordwrap("$tel",3, " ", true); 
	echo "
		<table width='1000' height='auto' border='0' cellpadding='0' cellspacing='1'>
			<tr>
				<td align='left' width='100'>
					<img src='../tmp/logo.png' border='0' title='FTC' width='100'>
				</td>
				<td>
					<div style='font-family:Khmer OS Muol; size:12pt; text-decoration:none'>សមាគម ឥណទាន សារីណា </div><br/><br/>
					Saryna Credit Association
				</td>
				<td valign='bottom' align='right'>
					<div style='font-family:Khmer OS Muol; size:12pt; text-decoration:none'><i>$mytp</i></div>
					<hr width='205' align='right'>
					<i>$enTp</i>
				</td>
			</tr>
		</table>
		
		<table width='1000' height='auto' border='1' cellpadding='10' cellspacing='10'>
			<tr height='50'>
				<td align='left' width='290'>
					លេខឥណទានៈ LID : $getStatus
				</td>
				<td align='center'>
					$lid
				</td>
				<td valign='middle' align='center' width='320'>
					កាលបរិច្ឆេទ (Date):$saleDay/$saleMonth/$saleYear
				</td>
			</tr>
			<tr height='50'>
				<td align='left' width='290'>
				    ឈ្មោះអតិថិជន Client's Name: 
				</td>
				<td align='center'>
					$khName
				</td>
				<td valign='middle' align='center' width='320'>
					រូបិយប័ណ្ណ (Currency Types)
				</td>
			</tr>
			<tr height='50'>
				<td align='left' width='290'>
				    ចំនួនទឹកប្រាក់ជាលេខ Amount: 
				</td>
				<td align='center'>
					$cur $amt
				</td>
				<td valign='middle' align='center' width='320'>
					";
				if($cur=='USD'){
				echo"
					<div class='footer_report'><input type='checkbox'>ប្រាក់រៀល <input type='checkbox' checked>ប្រាក់ដុល្លា <input type='checkbox' >ប្រាក់បាត </div>
					";
				}
				if($cur=='KHR'){
					echo"
					<div class='footer_report'><input type='checkbox' checked>ប្រាក់រៀល <input type='checkbox' >ប្រាក់ដុល្លា <input type='checkbox' >ប្រាក់បាត </div>
					";
					}
				if($cur=='THB'){
					echo"
					<div class='footer_report'><input type='checkbox'>ប្រាក់រៀល <input type='checkbox' >ប្រាក់ដុល្លា <input type='checkbox' checked>ប្រាក់បាត </div>
					";
					}
				
				echo"
				</td>
			</tr>
		</table>
		<table width='1000' height='auto' border='1' cellpadding='10' cellspacing='10'>
			
			<tr height='50'>
				<td align='left' width='290'>
				    ចំនួនទឹកប្រាក់ជាអក្សរ Words: 
				</td>
				<td align='center'>
					<div class='footer_report'>$mywords</div>
				</td>
				<td valign='top' align='center' width='320' rowspan='3'>
					<table border='1' width='auto'>
						<tr>
							<td colspan='4' bgcolor='#999999' align='center' valign='middle'>
								<div class='footer_report'>Denomindtion</div>
							</td>
						</tr>
						<tr>
							<td class='footer_report' width='auto'>
								500,000<br/>
								200,000<br/>
								100,000<br/>
								50,000<br/>
								20,000<br/>
								10,000<br/>
								5,000<br/>
								2,000<br/>
								1,000<br/>
								500<br/>
								100
							</td>
							<td class='footer_report' width='190'>
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
							</td>
							
							<td class='footer_report' valign='top'>
								100<br/>
								50<br/>
								20<br/>
								10<br/>
								5<br/>
								2<br/>
								1
							</td>
							<td class='footer_report' width='190' valign='top'>
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
							</td>
						</tr>
						<tr>
							<td colspan='4' bgcolor='#999999' align='center' valign='middle'>
								<div class='footer_report'>Total:....................................&nbsp;&nbsp; Total:....................................</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr height='100'>
				<td align='left' width='290' colspan='2'>
				   <table border='0' width='100%'>
				   		<tr>
							<td align='center' class='footer_report' valign='bottom'>
								<hr width='205' align='center'>
								ហត្តលេខាអ្នកទទួល Receiver's Signature
							</td>
							<td align='center' class='footer_report' valign='bottom'>
								<hr width='205' align='center'>
								ហត្តលេខាអ្នកប្រគល់ Payer's Signature
							</td>
						</tr>
				  	</table>
				</td>
			</tr>
			<tr height='100'>
				<td colspan='2'>
					<table border='0' width='100%' height='135'>
						<tr>
							<td colspan='2' align='center' valign='top' bgcolor='#999999' height='20'>
								<div style='font-family:Khmer OS Muol; font-size:10pt; text-decoration:none'>សម្រាប់អេស ស៊ី អេ FOR SCA USE ONLY</div>
							</td>
						</tr>
				   		<tr>
							<td align='center' class='footer_report' valign='bottom'>
								<hr width='205' align='center'>
								ពិនិត្យ និង អនុម័ត Check/Authorized
							</td>
							<td align='center' class='footer_report' valign='bottom'>
								<hr width='205' align='center'>
								បេឡាករ Teller
							</td>
						</tr>
				  	</table>
				</td>
			</tr>
		</table>
	";	
	echo"
		<table name='space' width='1000' height='200'>
			<tr>
				<td align='center' valign='middle'>
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
				</td>
			</tr>
		</table>
	
	";
	echo "
		<table width='1000' height='auto' border='0' cellpadding='0' cellspacing='1'>
			<tr>
				<td align='left' width='100'>
					<img src='../tmp/logo.png' border='0' title='FTC' width='100'>
				</td>
				<td>
					<div style='font-family:Khmer OS Muol; size:12pt; text-decoration:none'>សមាគម ឥណទាន សារីណា </div><br/><br/>
					Saryna Credit Association
				</td>
				<td valign='bottom' align='right'>
					<div style='font-family:Khmer OS Muol; size:12pt; text-decoration:none'><i>$mytp</i></div>
					<hr width='205' align='right'>
					<i>$enTp</i>
				</td>
			</tr>
		</table>
		
		<table width='1000' height='auto' border='1' cellpadding='10' cellspacing='10'>
			<tr height='50'>
				<td align='left' width='290'>
					លេខឥណទានៈ LID :  $getStatus
				</td>
				<td align='center'>
					$lid
				</td>
				<td valign='middle' align='center' width='320'>
					កាលបរិច្ឆេទ (Date):$saleDay/$saleMonth/$saleYear
				</td>
			</tr>
			<tr height='50'>
				<td align='left' width='290'>
				    ឈ្មោះអតិថិជន Client's Name: 
				</td>
				<td align='center'>
					$khName
				</td>
				<td valign='middle' align='center' width='320'>
					រូបិយប័ណ្ណ (Currency Types)
				</td>
			</tr>
			<tr height='50'>
				<td align='left' width='290'>
				    ចំនួនទឹកប្រាក់ជាលេខ Amount: 
				</td>
				<td align='center'>
					$cur $amt
				</td>
				<td valign='middle' align='center' width='320'>
					";
				if($cur=='USD'){
				echo"
					<div class='footer_report'><input type='checkbox'>ប្រាក់រៀល <input type='checkbox' checked>ប្រាក់ដុល្លា <input type='checkbox' >ប្រាក់បាត </div>
					";
				}
				if($cur=='KHR'){
					echo"
					<div class='footer_report'><input type='checkbox' checked>ប្រាក់រៀល <input type='checkbox' >ប្រាក់ដុល្លា <input type='checkbox' >ប្រាក់បាត </div>
					";
					}
				if($cur=='THB'){
					echo"
					<div class='footer_report'><input type='checkbox'>ប្រាក់រៀល <input type='checkbox' >ប្រាក់ដុល្លា <input type='checkbox' checked>ប្រាក់បាត </div>
					";
					}
				
				echo"
				</td>
			</tr>
		</table>
		<table width='1000' height='auto' border='1' cellpadding='10' cellspacing='10'>
			
			<tr height='50'>
				<td align='left' width='290'>
				    ចំនួនទឹកប្រាក់ជាអក្សរ Words: 
				</td>
				<td align='center'>
					<div class='footer_report'>$mywords</div>
				</td>
				<td valign='top' align='center' width='320' rowspan='3'>
					<table border='1' width='auto'>
						<tr>
							<td colspan='4' bgcolor='#999999' align='center' valign='middle'>
								<div class='footer_report'>Denomindtion</div>
							</td>
						</tr>
						<tr>
							<td class='footer_report' width='auto'>
								500,000<br/>
								200,000<br/>
								100,000<br/>
								50,000<br/>
								20,000<br/>
								10,000<br/>
								5,000<br/>
								2,000<br/>
								1,000<br/>
								500<br/>
								100
							</td>
							<td class='footer_report' width='190'>
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
							</td>
							
							<td class='footer_report' valign='top'>
								100<br/>
								50<br/>
								20<br/>
								10<br/>
								5<br/>
								2<br/>
								1
							</td>
							<td class='footer_report' width='190' valign='top'>
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
								x...........=...........
							</td>
						</tr>
						<tr>
							<td colspan='4' bgcolor='#999999' align='center' valign='middle'>
								<div class='footer_report'>Total:....................................&nbsp;&nbsp; Total:....................................</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr height='100'>
				<td align='left' width='290' colspan='2'>
				   <table border='0' width='100%'>
				   		<tr>
							<td align='center' class='footer_report' valign='bottom'>
								<hr width='205' align='center'>
								ហត្តលេខាអ្នកទទួល Receiver's Signature
							</td>
							<td align='center' class='footer_report' valign='bottom'>
								<hr width='205' align='center'>
								ហត្តលេខាអ្នកប្រគល់ Payer's Signature
							</td>
						</tr>
				  	</table>
				</td>
			</tr>
			<tr height='100'>
				<td colspan='2'>
					<table border='0' width='100%' height='135'>
						<tr>
							<td colspan='2' align='center' valign='top' bgcolor='#999999' height='20'>
								<div style='font-family:Khmer OS Muol; font-size:10pt; text-decoration:none'>សម្រាប់អេស ស៊ី អេ FOR SCA USE ONLY</div>
							</td>
						</tr>
				   		<tr>
							<td align='center' class='footer_report' valign='bottom'>
								<hr width='205' align='center'>
								ពិនិត្យ និង អនុម័ត Check/Authorized
							</td>
							<td align='center' class='footer_report' valign='bottom'>
								<hr width='205' align='center'>
								បេឡាករ Teller
							</td>
						</tr>
				  	</table>
				</td>
			</tr>
		</table>
	";	
?>

</cente>
<?php
	echo " <script> window.print(); </script> ";
	mysql_close();
?>
</body>
</html>