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
<title>Area Repayment List - OLMS</title>
<style type="text/css">
	p, li, td	{font:normal 13px/13px Arial;}
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
					$co =$_POST['co'];
					$mycur=$_POST['cur'];
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
				if(empty($get_from) && ($mycur=='0') && ($co=='0') && ($br=='0')){
					echo "<h2><u>Area Repayment Customer List</u></h2>";
					}
				else if(!empty($get_from)){
					echo "<h2><u>Area Repayment Customer List</u></h2>";
					echo"
					<p>Data On :  <b>$myfrom</b> <br/> CO : <b>$co</b> ,Branch : <b>$mybr</b>, <b>Currency: $mycur </b></p>
					";
				}
				else{	
					echo "<h2><u>Area Repayment Customer List</u></h2>";
					echo"
					<p>Currency : <b>$mycur</b> CO Name : <b>$co</b>, Branch : <b>$mybr</b></p> 
					";
				}
			 ?>
			<table width="1400" cellpadding="0" cellspacing="0" height="auto" class="form_border" border="1" 
            style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#03F; color:#FFFFFF">
								<td width="20"><b>N<sup>o</sup></b></td>
                                <td><b>Date</b></td>
								<td width="100"><b>LD</b></td>
                                <td width="30"><b>CO</b></td>
                                <td><b>ឈ្មោះ</b></td>
                              <!--  <td><b>Cust Name</b></td>
								<td><b>HouseNo</b></td>
								<td><b>St-No</b></td> -->
								<td><b>Village</b></td>
								<td><b>Commune</b></td>	
								 <!--<td><b>District</b></td>
								<td><b>Province</b></td> -->
								<td><b>Phone</b></td>
                                <td><b>Sch-Principal</b></td>
                                <td><b>Sch-Interest</b></td>
                                <td width='50'><b>Penalty</b></td>
                                <td width="40"><b>Late-D</b></td>
                                <td width="35"><b>L-Inst</b></td>
                                <td><b>Total</b></td>
                                <td><b>Balance</b></td>
                                 <!-- <td width="30"><b>Br</b></td> -->
							</tr>
                           </thead>					
		<?php
		
				mysql_query ('SET NAMES UTF8');	
				/////////////////
				if(!empty($get_from) && ($co=='0') && ($br=='0') && ($mycur=='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0 group by ld Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
							/*echo"<script>alert('con1,$from');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && ($co!='0') && ($br=='0') && ($mycur=='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date < '$from' AND response_co='$co' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0 group by ld Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date < '$from' AND response_co='$co' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
							/*echo"<script>alert('con2,$from');</script>";*/
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && ($co=='0') && ($br!='0') && ($mycur=='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date < '$from' AND br_no='$br' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0 group by ld Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
						$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date < '$from' AND br_no='$br' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con3,$from');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && ($co=='0') && ($br=='0') && ($mycur!='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date < '$from' AND currency='$mycur' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0 group by ld Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date < '$from' AND currency='$mycur' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con4');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && ($co!='0') && ($br!='0') && ($mycur=='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date < '$from' AND response_co='$co' AND br_no='$br' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0 group by ld Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date < '$from' AND response_co='$co' AND br_no='$br' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con5');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && ($co!='0') && ($br=='0') && ($mycur!='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date < '$from' AND response_co='$co' AND rp='0' AND currency='$mycur' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0 group by ld Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date < '$from' AND response_co='$co' AND rp='0' AND currency='$mycur' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con6');</script>";*/
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && ($co=='0') && ($br!='0') && ($mycur!='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date < '$from' AND currency='$mycur' AND rp='0' AND br_no='$br' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0 group by ld Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date < '$from' AND currency='$mycur' AND rp='0' AND br_no='$br' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con7');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && ($co!='0') && ($br!='0') && ($mycur!='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date < '$from' AND response_co='$co' AND currency='$mycur' AND br_no='$br' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0 group by ld Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date < '$from' AND response_co='$co' AND currency='$mycur' AND br_no='$br' AND rp='0' AND dis='1' and ((principal+interest)-(prn_paid+int_paid))>0";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con8');</script>";*/
				}
				//////////////////			
					$i=1;
					$check_record=mysql_num_rows($result);
					
					if($check_record=='0'){
						echo"<script>alert('No Records Found!');</script>";
						echo"<script>window.close();</script>";
						exit();
						}
					///////header
					echo " <tbody>
						";
					///end header
					while($row=mysql_fetch_array($result))
					{
						$repayment_date=date('d-m-Y',strtotime($row['repayment_date']));
						//echo $currency_type;
						$ld=$row['ld'];
						$cid=$row['cid'];
						$myco=$row['response_co'];
						$sch_prn=formatMoney($row['principal'],true);
						$sch_int=formatMoney($row['interest'],true);
						$sch_total=formatMoney($row['total'],true);
						$prn_paid=$row['prn_paid'];
						$myPrnSch=$row['principal'];
						$branch=$row['br_no'];
						$mycurrency=$row['currency'];
						$days=dateDiff(date('Y-m-d',strtotime($repayment_date)),$get_from);
						
						///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
						////
						// get late installments
						if(!empty($get_from) && ($co=='0') && ($br=='0') && ($mycur=='0')){
							
							$sql_countLate = "SELECT * from schedule WHERE repayment_date < '$from' AND rp='0' and ld='$ld' and dis='1'";
							$result_countLate= mysql_query($sql_countLate) or die(mysql_error());
								$countLate = mysql_num_rows($result_countLate);
								////////////////
								/////////////////////////
								$sql_pr = "SELECT SUM(principal-prn_paid) AS grand_pri FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1'";
									$result_pr = mysql_query($sql_pr) or die(mysql_error());
									$pri = mysql_fetch_array($result_pr);
									
								/////////////////////
								/////////////////////////
								$sql_int = "SELECT SUM(interest-int_paid) AS grand_int FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1'";
									$result_int = mysql_query($sql_int) or die(mysql_error());
									$int = mysql_fetch_array($result_int);
								/////////////////////
								/////////////////////////
								$sql_schTotal = "SELECT SUM((principal+interest)-(prn_paid+int_paid)) AS grand_schTotal FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1'";
									$result_schTotal = mysql_query($sql_schTotal) or die(mysql_error());
									$schTotal = mysql_fetch_array($result_schTotal);
								/////////////////////
								/*echo"<script>alert('$ld,$countLate');</script>";*/
								
						}
						if(!empty($get_from) && ($co!='0') && ($br=='0') && ($mycur=='0')){
							
							$sql_countLate = "SELECT * from schedule WHERE repayment_date < '$from' AND rp='0' and ld='$ld' and dis='1' AND response_co='$co'";
							$result_countLate= mysql_query($sql_countLate) or die(mysql_error());
								$countLate = mysql_num_rows($result_countLate);
								////////////////
								/////////////////////////
								$sql_pr = "SELECT  SUM(principal-prn_paid) AS grand_pri FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND response_co='$co'";
									$result_pr = mysql_query($sql_pr) or die(mysql_error());
									$pri = mysql_fetch_array($result_pr);
								/////////////////////
								/////////////////////////
								$sql_int = "SELECT SUM(interest-int_paid) AS grand_int FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND response_co='$co'";
									$result_int = mysql_query($sql_int) or die(mysql_error());
									$int = mysql_fetch_array($result_int);
								/////////////////////
								/////////////////////////
								$sql_schTotal = "SELECT SUM((principal+interest)-(prn_paid+int_paid)) AS grand_schTotal FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND response_co='$co'";
									$result_schTotal = mysql_query($sql_schTotal) or die(mysql_error());
									$schTotal = mysql_fetch_array($result_schTotal);
								/////////////////////
								/*echo"<script>alert('$ld,$countLate');</script>";*/
								
						}
						if(!empty($get_from) && ($co=='0') && ($br!='0') && ($mycur=='0')){
								$sql_countLate = "SELECT * from schedule WHERE repayment_date < '$from' AND rp='0' and ld='$ld' and dis='1' AND br_no='$br'";
							$result_countLate= mysql_query($sql_countLate) or die(mysql_error());
								$countLate = mysql_num_rows($result_countLate);
								////////////////
								/////////////////////////
								$sql_pr = "SELECT SUM(principal-prn_paid) AS grand_pri FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br'";
									$result_pr = mysql_query($sql_pr) or die(mysql_error());
									$pri = mysql_fetch_array($result_pr);
								/////////////////////
								/////////////////////////
								$sql_int = "SELECT SUM(interest-int_paid) AS grand_int FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br'";
									$result_int = mysql_query($sql_int) or die(mysql_error());
									$int = mysql_fetch_array($result_int);
								/////////////////////
								/////////////////////////
								$sql_schTotal = "SELECT SUM((principal+interest)-(prn_paid+int_paid)) AS grand_schTotal FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br'";
									$result_schTotal = mysql_query($sql_schTotal) or die(mysql_error());
									$schTotal = mysql_fetch_array($result_schTotal);
								/////////////////////
						}
						if(!empty($get_from) && ($co=='0') && ($br=='0') && ($mycur!='0')){
								$sql_countLate = "SELECT * from schedule WHERE repayment_date < '$from' AND rp='0' and ld='$ld' and dis='1' AND currency='$mycur'";
							$result_countLate= mysql_query($sql_countLate) or die(mysql_error());
								$countLate = mysql_num_rows($result_countLate);
								////////////////
								/////////////////////////
								$sql_pr = "SELECT SUM(principal-prn_paid) AS grand_pri FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND currency='$mycur'";
									$result_pr = mysql_query($sql_pr) or die(mysql_error());
									$pri = mysql_fetch_array($result_pr);
								/////////////////////
								/////////////////////////
								$sql_int = "SELECT SUM(interest-int_paid) AS grand_int FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND currency='$mycur'";
									$result_int = mysql_query($sql_int) or die(mysql_error());
									$int = mysql_fetch_array($result_int);
								/////////////////////
								/////////////////////////
								$sql_schTotal = "SELECT SUM((principal+interest)-(prn_paid+int_paid)) AS grand_schTotal FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND currency='$mycur'";
									$result_schTotal = mysql_query($sql_schTotal) or die(mysql_error());
									$schTotal = mysql_fetch_array($result_schTotal);
						}
						if(!empty($get_from) && ($co!='0') && ($br!='0') && ($mycur=='0')){
								$sql_countLate = "SELECT * from schedule WHERE repayment_date < '$from' AND rp='0' and ld='$ld' and dis='1' AND br_no='$br' AND response_co='$co'";
							$result_countLate= mysql_query($sql_countLate) or die(mysql_error());
								$countLate = mysql_num_rows($result_countLate);
								////////////////
								/////////////////////////
								$sql_pr = "SELECT SUM(principal-prn_paid) AS grand_pri FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND response_co='$co'";
									$result_pr = mysql_query($sql_pr) or die(mysql_error());
									$pri = mysql_fetch_array($result_pr);
								/////////////////////
								/////////////////////////
								$sql_int = "SELECT SUM(interest-int_paid) AS grand_int FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND response_co='$co'";
									$result_int = mysql_query($sql_int) or die(mysql_error());
									$int = mysql_fetch_array($result_int);
								/////////////////////
								/////////////////////////
								$sql_schTotal = "SELECT SUM((principal+interest)-(prn_paid+int_paid)) AS grand_schTotal FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND response_co='$co'";
									$result_schTotal = mysql_query($sql_schTotal) or die(mysql_error());
									$schTotal = mysql_fetch_array($result_schTotal);
								/////////////////////
						}
						if(!empty($get_from) && ($co!='0') && ($br=='0') && ($mycur!='0')){
								$sql_countLate = "SELECT * from schedule WHERE repayment_date < '$from' AND rp='0' and ld='$ld' and dis='1' AND response_co='$co' AND currency='$mycur'";
							$result_countLate= mysql_query($sql_countLate) or die(mysql_error());
								$countLate = mysql_num_rows($result_countLate);
								////////////////
								/////////////////////////
								$sql_pr = "SELECT SUM(principal-prn_paid) AS grand_pri FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND response_co='$co' AND currency='$mycur'";
									$result_pr = mysql_query($sql_pr) or die(mysql_error());
									$pri = mysql_fetch_array($result_pr);
								/////////////////////
								/////////////////////////
								$sql_int = "SELECT SUM(interest-int_paid) AS grand_int FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND response_co='$co' AND currency='$mycur'";
									$result_int = mysql_query($sql_int) or die(mysql_error());
									$int = mysql_fetch_array($result_int);
								/////////////////////
								/////////////////////////
								$sql_schTotal = "SELECT SUM((principal+interest)-(prn_paid+int_paid)) AS grand_schTotal FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND response_co='$co' AND currency='$mycur'";
									$result_schTotal = mysql_query($sql_schTotal) or die(mysql_error());
									$schTotal = mysql_fetch_array($result_schTotal);
								/////////////////////	
						}
						if(!empty($get_from) && ($co!='0') && ($br!='0') && ($mycur!='0')){
								$sql_countLate = "SELECT * from schedule WHERE repayment_date < '$from' AND rp='0' and ld='$ld' and dis='1' AND br_no='$br' AND response_co='$co' AND currency='$mycur'";
							$result_countLate= mysql_query($sql_countLate) or die(mysql_error());
								$countLate = mysql_num_rows($result_countLate);
								////////////////
								/////////////////////////
								$sql_pr = "SELECT SUM(principal-prn_paid) AS grand_pri FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND response_co='$co' AND currency='$mycur'";
									$result_pr = mysql_query($sql_pr) or die(mysql_error());
									$pri = mysql_fetch_array($result_pr);
								/////////////////////
								/////////////////////////
								$sql_int = "SELECT SUM(interest-int_paid) AS grand_int FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND response_co='$co' AND currency='$mycur'";
									$result_int = mysql_query($sql_int) or die(mysql_error());
									$int = mysql_fetch_array($result_int);
								/////////////////////
								/////////////////////////
								$sql_schTotal = "SELECT SUM((principal+interest)-(prn_paid+int_paid)) AS grand_schTotal FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND response_co='$co' AND currency='$mycur'";
									$result_schTotal = mysql_query($sql_schTotal) or die(mysql_error());
									$schTotal = mysql_fetch_array($result_schTotal);
								/////////////////////	
						}
						if(!empty($get_from) && ($co=='0') && ($br!='0') && ($mycur!='0')){
								$sql_countLate = "SELECT * from schedule WHERE repayment_date < '$from' AND rp='0' and ld='$ld' and dis='1' AND br_no='$br' AND currency='$mycur'";
							$result_countLate= mysql_query($sql_countLate) or die(mysql_error());
								$countLate = mysql_num_rows($result_countLate);
								////////////////
								/////////////////////////
								$sql_pr = "SELECT SUM(principal-prn_paid) AS grand_pri FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND currency='$mycur'";
									$result_pr = mysql_query($sql_pr) or die(mysql_error());
									$pri = mysql_fetch_array($result_pr);
						
								/////////////////////
								/////////////////////////
								$sql_int = "SELECT SUM(interest-int_paid) AS grand_int FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND currency='$mycur'";
									$result_int = mysql_query($sql_int) or die(mysql_error());
									$int = mysql_fetch_array($result_int);
								/////////////////////
								/////////////////////////
								$sql_schTotal = "SELECT SUM((principal+interest)-(prn_paid+int_paid)) AS grand_schTotal FROM `schedule` WHERE repayment_date < '$from' AND rp='0' AND ld='$ld' and dis='1' AND br_no='$br' AND currency='$mycur'";
									$result_schTotal = mysql_query($sql_schTotal) or die(mysql_error());
									$schTotal = mysql_fetch_array($result_schTotal);
								/////////////////////	
						}
						
						
						///find regdate
								$regDateStr="SELECT * FROM loan_process where ld='$ld'";
									$resultregDate=mysql_query($regDateStr) or die (mysql_error());
										while($row = mysql_fetch_array($resultregDate)){
											$myregDate=date('Y-m-d',strtotime($row['reg_date']));
											break;
										}
						////
					// get total paid
							$sql_tp = "SELECT SUM(prn_paid) AS myGtotal FROM `schedule` WHERE ld='$ld' AND dis='1' and rp<>'6'";
							$result_tp= mysql_query($sql_tp) or die(mysql_error());
								$tp = mysql_fetch_array($result_tp);
									$mytp = $tp['myGtotal'];							
					///
					///pri+int+total display
						$myPri=formatMoney($pri['grand_pri'],0,true);
						$myInt=formatMoney($int['grand_int'],0,true);
						$mySchTotal=formatMoney($schTotal['grand_schTotal'],0,true);
						$myTotal=($schTotal['grand_schTotal']);
						
					/// balance
						
							$sql_bl = "SELECT SUM(principal) AS myGtotal1 FROM `schedule` WHERE ld='$ld' AND dis='1' and rp<>'6'";
							$result_bl= mysql_query($sql_bl) or die(mysql_error());
								$tb = mysql_fetch_array($result_bl);
									$mytb = $tb['myGtotal1'];
									
									$remain_bl = ($mytb-$mytp);
									
									$myremain=formatMoney($remain_bl,0,true);
					//
					
						///find approval info
								$cobor_info="SELECT * FROM register where cif='$cid' and register_date='$myregDate'";
									$result_coborinfo=mysql_query($cobor_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_coborinfo)){
											$borrower=$row['borrower'];
											$kh_borrower=$row['kh_borrower'];
											$hoNo=$row['houseNo'];
											$stNo=$row['streetNo'];
											$vil=$row['village'];
											$com=$row['commune'];
											$dist=$row['district'];
											$prov=$row['province'];
											$tel=$row['tel'];
											$rate=$row['rate'];
											$frq=$row['freq'];
										}
										//---end frequency----//	
						/// accrued pn
							$pn_int=mysql_query("SELECT SUM(penalty-norpen_paid) as npn_tt FROM schedule WHERE ld='$ld' and dis='1'");
							$pn_tt=mysql_fetch_array($pn_int);
							//$odPn = $pn_tt['npn_tt'];
							if($odPn<0){
								$odPn=0;	
								
							}
			
							
							$query_pn=" SELECT * FROM schedule where ld='$ld' AND dis='1' AND rp='0' and repayment_date <= '$from' order by repayment_date desc";
							$result_pn=mysql_query($query_pn);
							echo mysql_error();
							while($row = mysql_fetch_array($result_pn))
								{
									$sch_pn=$row['total'];
									$get_remain=$row['remain_amt'];
									$date_pn=date('Y-m-d',strtotime($row['repayment_date']));
									$days_pn=intval(dateDiff($date_pn,$from));
									
									if($days_pn>=$setLpn){
										if ($get_remain==0)
										{
											if ($mycur=='KHR'){
												$due_pn=roundkhr(round(($sch_pn*$rate/100)*$days_pn*2/$frq,2),$set);
												$due_pn= roundkhr($due_pn,$set);
											}
											else{
												
												$due_pn=round(($sch_pn*$rate/100)*$days_pn*2/$frq,2);
												
											}
										}
										else
										{
											if ($mycur=='KHR'){
												$due_pn=roundkhr(round(($get_remain*$rate/100)*$days_pn*2/$frq,2),$set);
												$due_pn= roundkhr($due_pn,$set);
											}
											else{
												$due_pn=round(($get_remain*$rate/100)*$days_pn*2/$frq,2);
											}
											
										}
									}	
									else{
										$due_pn=0.00;
										}
										
								}
								
							
							if($mycurrency=='KHR'){
									//$due_pn = roundkhr(($myTotal*$rate/100*$days*2/$frq),$set);
								
									$acrued_pn = roundkhr(round(($due_pn+$odPn),2),$set);
									$acrued_pn=formatMoney($acrued_pn,0,true);
									
								}
								else{
								//	$due_pn= formatMoney(round($myTotal*$rate/100*$days*2/$frq),2,true);
									
									$acrued_pn = formatMoney($due_pn+$odPn,2,true);
									}
									///
												//////show village					
									$village_sql="SELECT * FROM village WHERE id ='$vil'";
											$result_vil=mysql_query($village_sql) or die (mysql_error());
											while($row = mysql_fetch_array($result_vil))
													{
														$get_village=$row['village'];			
													}
									//////show commune
									$commune_sql="SELECT * FROM adr_commune WHERE id ='$com'";
											$result_com=mysql_query($commune_sql) or die (mysql_error());
											while($row = mysql_fetch_array($result_com))
													{
														$get_commune=$row['commune'];
													}
									//////show district
									$district_sql="SELECT * FROM district WHERE id ='$dist'";
											$result_dis=mysql_query($district_sql) or die (mysql_error());
											while($row = mysql_fetch_array($result_dis))
													{
														$get_district=$row['district'];
													}
									//////show province
									$province_sql="SELECT * FROM province WHERE id ='$prov'";
											$result_prov=mysql_query($province_sql) or die (mysql_error());
											while($row = mysql_fetch_array($result_prov))
													{
														$get_province=$row['province'];
													}
										////
									$phone=wordwrap("$tel",3, " ", true); 
									
						echo"
						<tr>
									<td align='center'>$i</td>
									<td align='center'>$repayment_date</td>
									<td align='center'>$ld</td>
									<td align='center'>$myco</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$get_village</td>
									<td align='center'>$get_commune </td>
									<td align='center'>$phone</td>
									<td align='center'>$myPri</td>
									<td align='center'>$myInt</td>
									<td align='center'>$acrued_pn</td>
									<td align='center'>$days</td>
									<td align='center'>$countLate</td>
									<td align='center'>$mySchTotal</td>
									<td align='center'>$myremain</td>";
									
							
						echo "</tr>";
							$i++;
				}// end while
				
		?>
       					 <tr align="center" bgcolor="#CCFFFF" height="28">
								<td colspan="11">&nbsp;</td>
                                <td>&nbsp;</td>
								<td align="right"><font color="#FF0000"><b>Total: </b></font></td>	
								<td colspan="2" align="center"><b><?php echo $mycur .' '.formatMoney($t[grand_total],true); ?></b></td>
                                
							</tr>
                          </tbody>	
</table>	
</center>
</body>
</html>