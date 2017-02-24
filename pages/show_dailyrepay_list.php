<?php
    session_start();
    if(empty($_SESSION['usr'])) header('location:../login.php');
	include("module.php");	
	include("conn.php");
?>
<html>
<link rel="stylesheet" type="text/css" href="../css/screen.css" media="all">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title>Daily Repayment List - OLMS</title>
<style type="text/css">
	p, li, td	{font:normal 12px/12px Arial;}
		table	{border:0;border-collapse:collapse;}
		td		{padding:3px; padding-left:10px; text-align:left}
		tr.odd	{background:#FFF;}
		tr.highlight	{background:#CCC;}
		tr.selected		{background:#FFF;color:#090;}
</style>
<script type="text/javascript">

function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}

function addClass(element,value) {
  if (!element.className) {
    element.className = value;
  } else {
    newClassName = element.className;
    newClassName+= " ";
    newClassName+= value;
    element.className = newClassName;
  }
}


function stripeTables() {
	var tbodies = document.getElementsByTagName("tbody");
	for (var i=0; i<tbodies.length; i++) {
		var odd = true;
		var rows = tbodies[i].getElementsByTagName("tr");
		for (var j=0; j<rows.length; j++) {
			if (odd == false) {
				odd = true;
			} else {
				addClass(rows[j],"odd");
				odd = false;
			}
		}
	}
}

function lockRow() {
	var tbodies = document.getElementsByTagName("tbody");
	for (var j=0; j<tbodies.length; j++) {
		var rows = tbodies[j].getElementsByTagName("tr");
		for (var i=0; i<rows.length; i++) {
			rows[i].oldClassName = rows[i].className
			rows[i].onclick = function() {
				if (this.className.indexOf("selected") != -1) {
					this.className = this.oldClassName;
				} else {
					addClass(this,"selected");
				}
			}
		}
	}
}

addLoadEvent(stripeTables);
addLoadEvent(lockRow);
</script>
</head>
<body topmargin="0">
<center>

			<? 
					$get_from=$_POST['from'];
					$get_to=$_POST['to'];
					$from =date('Y-m-d',strtotime($get_from));
					$to=date('Y-m-d',strtotime($get_to));
					$lid=$_POST['lid'];
					$co =$_POST['co'];
					$mycur=$_POST['cur'];
					$cashier = $_POST['cashier'];
					$br=$_POST['br'];
					$myfrom= date('D,d/m/Y',strtotime($from));
					$myto= date('D,d/m/Y',strtotime($to));
					///display branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$br' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$mybr=$row['br_name'];
										}
					////
				if(empty($get_from)&& empty($get_to) && ($cashier=='0') && ($co=='0') && ($br=='0')){
					echo "<h2><u>Daily Repayment Customer List</u></h2>";
					}
				else if(!empty($get_from)&& !empty($get_to)){
					echo "<h2><u> Daily Repayment Customer List</u></h2>";
					echo"
					<p>Repaid From <b>$myfrom</b> To <b>$myto</b><br/>Recommender : <b>$recommend</b>, Response CO : <b>$co</b> ,Branch : <b>$mybr</b> </p>
					";
				}
				else{	
					echo "<h2><u>Daily Repayment Customer List</u></h2>";
					echo"
					<p>Reveiver : <b>$cashier</b>, CO Name : <b>$co</b>, Branch : <b>$mybr</b> </p>
					";
				}
			 ?>
			<table width="1300" cellpadding="0" cellspacing="0" height="auto" class="form_border" border="1" style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#03F; color:#FFFFFF">
								<td width="20"><b>N<sup>o</sup></b></td>
                                <td><b>Invoice No</b></td>
								<td><b>LD</b></td>
                                <td><b>Repaid Date</b></td>
								<td><b>អ្នកខ្ចី</b></td>
								<td><b>Borrower</b></td>
								<td><b>Principal</b></td>
								<td><b>Interest</b></td>	
								<td><b>Total</b></td>
                                <td><b>Currency</b></td>
								<td><b>COs</b></td>
								<td><b>Cashier</b></td>
                                <td><b>Repaid At</b></td>
							</tr>
                           </thead>					
		<?php
				$GetTotal_Prin=0;
				$GetTotal_Int=0;
		
				mysql_query ('SET NAMES UTF8');	
					
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co!='0') && ($cashier=='0') && empty($lid) && ($br=='0') && ($cur=='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE paid_date BETWEEN '$from' and '$to' AND res_co='$co' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE paid_date between '$from' AND '$to' AND res_co='$co' ";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($cashier!='0') && empty($lid) && ($br=='0') && ($cur=='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE paid_date BETWEEN '$from' and '$to' AND cashier='$cashier' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE paid_date between '$from' AND '$to' AND cashier='$cashier' ";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($cashier=='0') && empty($lid) && $br!='0' && ($cur=='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE paid_date BETWEEN '$from' and '$to' AND reciev_at='$br' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE paid_date between '$from' AND '$to' AND  reciev_at='$br' ";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($cashier=='0') && empty($lid) && $br=='0' && ($cur=='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE paid_date BETWEEN '$from' and '$to' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE paid_date between '$from' AND '$to'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($cashier!='0') && empty($lid) && $br=='0' && ($cur=='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE cashier='$cashier' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE cashier='$cashier'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co!='0') && ($cashier=='0') && empty($lid) && $br=='0' && ($cur=='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE res_co='$co' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE res_co='$co'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($cashier=='0') && empty($lid) && $br!='0' && ($cur=='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE reciev_at='$br' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE reciev_at='$br'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($cashier=='0') && !empty($lid) && $br=='0' && ($cur=='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE lc='$lid' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE lc='$lid'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($cashier=='0') && empty($lid) && $br=='0' && ($cur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE cur='$mycur' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE cur='$mycur'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($cashier=='0') && empty($lid) && $br=='0' && ($cur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE paid_date BETWEEN '$from' and '$to' AND cur='$mycur' ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE paid_date BETWEEN '$from' AND
							 '$to' AND cur='$mycur'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co!='0') && ($cashier=='0') && empty($lid) && $br=='0' && ($cur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE paid_date BETWEEN '$from' and '$to' AND cur='$mycur' AND res_co='$co'
							 ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE paid_date BETWEEN '$from' AND
							 '$to' AND cur='$mycur' AND res_co='$co'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($cashier!='0') && empty($lid) && $br=='0' && ($cur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE paid_date BETWEEN '$from' and '$to' AND cur='$mycur' AND cashier='$cashier'
							 ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE paid_date BETWEEN '$from' AND
							 '$to' AND cur='$mycur' AND cashier='$cashier'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($cashier=='0') && empty($lid) && ($br!='0') && ($cur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `invoice` WHERE paid_date BETWEEN '$from' and '$to' AND cur='$mycur' AND reciev_at='$br'
							 ORDER BY id asc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(total) AS grand_total FROM `invoice` WHERE paid_date BETWEEN '$from' AND
							 '$to' AND cur='$mycur' AND  reciev_at='$br'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				
					$i=1;
					$check_record=mysql_num_rows($result);
					
					if($check_record==''){
						echo"<script>alert('No Records Found!');</script>";
						echo"<script>window.close();</script>";
						exit();
						}
					while($row=mysql_fetch_array($result))
					{
					
						$id=$row['reg_id'];
						//echo $currency_type;
						$mypaid_date=date('d-m-Y',strtotime($row['paid_date']));
						$invoice_no=$row['invioce_no'];
						$myld=$row['lc'];
						$principal=formatMoney(str_replace(",","",$row['prn_paid']),true);
						$interest =formatMoney($row['int_paid'],true);
						$total=formatMoney($row['prn_paid']+$row['int_paid'],true);
						$mycashier=$row['cashier'];
						$myco=$row['res_co'];
						$branch=$row['reciev_at'];
						$mygetcur=$row['cur'];
						///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
										}
						////
						///find approval info
								$more_info="SELECT * FROM register where id='$id' order by id";
									$result_info=mysql_query($more_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_info)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
										}
										//display frequency
												if($nor=='30'){
													$show_fr='ខែ';
													}
												else if($nor=='7'){
													$show_fr='អាទិត្យ';
													}
												else{
													$show_fr='ខែ';
													}
										//---end frequency----//	
						////
														 /*/echo "<script>alert('$principal')</script>";*/
							$GetTotal_Prin=$GetTotal_Prin+ str_replace(",","",$principal) ;
							$GetTotal_Int = $GetTotal_Int + str_replace(",","",$interest);
						echo " <tbody><tr>
									<td align='center'>$i</td>
									<td align='center'>$invoice_no</td>
									<td align='center'>$myld</td>
									<td align='center'>$mypaid_date</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$principal</td>
									<td align='center'>$interest </td>
									<td align='center'>$total</td>
									<td align='center'>$mygetcur</td>
									<td align='center'>$myco</td>
									<td align='center'>$mycashier</td>
									<td align='center'>$br_name</td>
									";
							
						echo "</tr>";
							$i++;
				}// end while
				
		?>
       					 <tr align="center" bgcolor="#CCFFFF" height="28">
								<td colspan="4">&nbsp;</td>
                                <td>&nbsp;</td>
								<td align="right"><font color="#FF0000"><b>Total: </b></font></td>	
								<td  align="center"><b><?php echo $cur .' '.formatMoney($GetTotal_Prin,true).' '.$currency_type ; ?></b></td>
                                <td align="center"><b><?php echo $cur .' '.formatMoney($GetTotal_Int,true).' '.$currency_type ; ?></b></td>
                                <td  align="center"><b><?php

								 echo $cur .' '.formatMoney($GetTotal_Prin+$GetTotal_Int,true).' '.$currency_type ; 
								 ?></b></td>
                                <td colspan="4" align="center">&nbsp;</td>
							</tr>
                          </tbody>	
</table>	
</center>
</body>
</html>