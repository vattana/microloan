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
<title>Loan Disbursement by Area - OLMS</title>
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
					$getPro=$_POST['province'];
					$getDis =$_POST['district'];
					$getCom = $_POST['commune'];
					$getVil = $_POST['village'];
					$br=$_POST['br'];
					$mycur=$_POST['cur'];
					$myfrom= date('D,d/m/Y',strtotime($from));
					$myto= date('D,d/m/Y',strtotime($to));
					///display branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$br' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$mybr=$row['br_name'];
										}
					////
				if(empty($get_from)&& empty($get_to) && ($recommend=='0') && ($co=='0') && ($br=='0')){
					echo "<h2><u>Loan Disbursement by Area</u></h2>";
					}
				else if(!empty($get_from)&& !empty($get_to)){
					echo "<h2><u>Loan Disbursement by Area</u></h2>";
					echo"
					<p>Registered From <b>$myfrom</b> To <b>$myto</b><br/> Branch : <b>$mybr</b>, Currency : <b>$mycur</b>  </p>
					";
				}
				else{	
					echo "<h2><u>Loan Disbursement by Area</u></h2>";
					echo"
					<p>Branch : <b>$mybr</b>, Currency : <b>$mycur</b> </p>
					";
				}
			 ?>
			<table width="1400" cellpadding="0" cellspacing="0" height="auto" class="nostyle" border="1" style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#03F; color:#FFFFFF">
								<td width="50"><b>N<sup>o</sup></b></td>
								<td><b>Province</b></td>	
								<td><b>District</b></td>
                                <td><b>Commune</b></td>
                                <td><b>Village</b></td>
                                <td width="150"><b>CID</b></td>
                                <td width="100"><b>LD</b></td>
                                <td><b>ឈ្មោះ</b></td>
                                <td><b>Name</b></td>
								<td><b>Loan Size</b></td>
                                <td><b>Rate</b></td>
                                <td><b>Term</b></td>
                                <td><b>COs</b></td>
                                <td><b>Branch</b></td>
                                <td><b>Status</b></td>
                            
							</tr>
                           </thead>					
		<?php
				mysql_query ('SET NAMES UTF8');	
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro=='0') && ($getDis=='0') && ($getCom=='0') && ($getVil=='0') && ($br=='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' ";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////	
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro=='0') && ($getDis=='0') && ($getCom=='0') && ($getVil=='0') && ($br!='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and branch='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and branch='$br'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro!='0') && ($getDis=='0') && ($getCom=='0') && ($getVil=='0') && ($br=='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro!='0') && ($getDis=='0') && ($getCom=='0') && ($getVil=='0') && ($br!='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and branch='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and branch='$br'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro!='0') && ($getDis!='0') && ($getCom=='0') && ($getVil=='0') && ($br=='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro!='0') && ($getDis!='0') && ($getCom=='0') && ($getVil=='0') && ($br!='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and branch='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and branch='$br'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro!='0') && ($getDis!='0') && ($getCom!='0') && ($getVil=='0') && ($br=='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and commune='$getCom' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and commune='$getCom'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro!='0') && ($getDis!='0') && ($getCom!='0') && ($getVil=='0') && ($br!='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and commune='$getCom' and branch='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and commune='$getCom' and branch='$br'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro!='0') && ($getDis!='0') && ($getCom!='0') && ($getVil!='0') && ($br=='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and commune='$getCom' and village='$getVil' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and commune='$getCom' and village='$getVil'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
				/////////////////
if(!empty($get_from) && !empty($get_to) && ($getPro!='0') && ($getDis!='0') && ($getCom!='0') && ($getVil!='0') && ($br!='0') && ($mycur!='0')){							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and commune='$getCom' and village='$getVil' and branch='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND cur='$mycur' and dis='1' and province='$getPro' and district='$getDis' and commune='$getCom' and village='$getVil' and branch='$br'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
							
				}
				//////////////////
					$i=1;
					$os=formatMoney($t[grand_total],true);
					$check_record=mysql_num_rows($result);
					
					if($check_record=='0'){
						echo"<script>alert('No Records Found!');</script>";
						echo"<script>window.close();</script>";
						exit();
						}
					while($row=mysql_fetch_array($result))
					{
					
						$reg_id=$row['reg_id'];
						$id=$row['id'];
						$mycid=$row['cif'];
						$loan=formatMoney($row['loan_request'],true);
						$co_borrower=$row['co_borrower'];
						$cur=$row['cur'];
						$register_date=date('Y-m-d',strtotime($row['register_date']));
						$branch=$row['branch'];
						$houseNo=$row['houseNo'];
						$streetNo=$row['streetNo'];
						$vil=$row['village'];
						$com=$row['commune'];
						$dist=$row['district'];
						$prov=$row['province'];
						$nor=$row['freq'];
						$mycid=$row['cif'];
						$kh_borrower=$row['kh_borrower'];
						$borrower=$row['borrower'];
						$kh_co_borrower=$row['kh_co_borrower'];
						$co_borrower=$row['co_borrower'];
						$rate=$row['rate'];
						$term=$row['period'];
						$response_co=$row['co'];
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
						//////show LD					
					$ld_sql="SELECT ld,status FROM loan_process WHERE regis_id ='$id'";
							$result_ld=mysql_query($ld_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_ld))
									{
										$mylid=$row['ld'];
										$getSt=$row['status'];
										
									}
					///////////////////
					
									
									if($getSt==9){
											$mySt='Closed';
											}
											else if($getSt==1){
												$mySt='Active';
												}
												else{
													$mySt='Resch';
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
						///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
									}
						////
						echo " <tbody><tr>
									<td align='center'>$i</td>
									<td align='center'>$get_province</td>
									<td align='center'>$get_district</td>
									<td align='center'>$get_commune</td>
									<td align='center'>$get_village</td>
									<td align='center'>$mycid</td>
									<td align='center'>$mylid</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$cur $loan</td>
									<td align='center'>$rate %</td>
									<td align='center'>$term $show_fr</td>
									<td align='center'>$response_co</td>
									<td align='center'>$br_name</td>
									<td align='center'>$mySt</td>
									";
						echo "</tr>";
							$i++;
				}// end while
		?>
       					 <tr align="center" bgcolor="#CCFFFF" height="28">
								<td colspan="8">&nbsp;</td>
								<td align="right"><font color="#FF0000"><b>Total: </b></font></td>	
								<td colspan="6" align="center"><?php echo $cur.' '.formatMoney($t[grand_total],true); ?></td>
							</tr>
                          </tbody>	
</table>	
<?php mysql_close(); ?>
</center>
</body>
</html>