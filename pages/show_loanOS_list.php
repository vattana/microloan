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
<title>Loan Information Detail - OLMS</title>
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
					mysql_query ('SET NAMES UTF8');	
					$get_from=$_POST['from'];
					$get_to=$_POST['to'];
					$from =date('Y-m-d',strtotime($get_from));
					$to=date('Y-m-d',strtotime($get_to));
					$co =$_POST['co'];
					$mycur=$_POST['cur'];
					$br=trim($_POST['br']);

					$myto= date('D,d/m/Y');
					///display branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$br' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$mybr=$row['br_name'];
											
										}
										if($mybr==''){
												$mybr='All';
												}
					////
				if(empty($get_from) && ($mycur=='0') && ($co=='0') && ($br=='0')){
					echo "<h2><u>Loan Information Detail List</u></h2>";
					}
				else if(!empty($get_from)){
					echo "<h2><u>Loan Information Detail List</u></h2>";
					echo"
					<p>Data On :  <b>$myfrom</b> <br/> CO : <b>$co</b> ,Branch : <b>$mybr</b>, <b>Currency: $mycur </b></p>
					";
				}
				else{	
					echo "<h2><u>Loan Information Dedail List</u></h2>";
					echo"
					<p>Currency : <b>$mycur</b>, Branch : <b>$mybr</b> , As Of <b>$myto</b></p> 
					";
				}
				
				////
				
				if(($mycur!='0') && ($br!='0')){
					// total client
					$sqlTC=mysql_query("SELECT count(*) AS total_cl FROM loan_process WHERE cur='$mycur' AND loan_at='$br'");
					$tc=mysql_fetch_array($sqlTC);
					// total amount
					$sqlTAmt=mysql_query("SELECT SUM(principal) AS total_os FROM schedule WHERE rp in(1,6,9,0) AND currency='$mycur' AND br_no='$br'");
					$tamt=mysql_fetch_array($sqlTAmt);
					
					// total active client
					$sqlTAC=mysql_query("SELECT count(*) AS total_acl FROM loan_process WHERE status in(1,6,0) AND cur='$mycur' AND loan_at='$br'");
					$tac=mysql_fetch_array($sqlTAC);
					// total active amount
					$sqlTAAmt=mysql_query("SELECT SUM(principal) AS total_aos FROM schedule WHERE rp in(1,6,0) AND currency='$mycur' AND br_no='$br'");
					$taamt=mysql_fetch_array($sqlTAAmt);
					
					// total closed client
					$sqlTCC=mysql_query("SELECT count(*) AS total_ccl FROM loan_process WHERE status ='9' AND cur='$mycur' AND loan_at='$br'");
					$tcc=mysql_fetch_array($sqlTCC);
					// total closed amount
					$sqlTCAmt=mysql_query("SELECT SUM(principal) AS total_cos FROM schedule WHERE rp ='9' AND currency='$mycur' AND br_no='$br'");
					$tcamt=mysql_fetch_array($sqlTCAmt);
					
					// total principal paid
					$sqlTPP=mysql_query("SELECT SUM(prn_paid) AS total_tpp FROM schedule WHERE currency='$mycur' AND br_no='$br'");
					$tpp=mysql_fetch_array($sqlTPP);
					
					// total interest paid
					$sqlTPI=mysql_query("SELECT SUM(int_paid) AS total_tpi FROM schedule WHERE currency='$mycur' AND br_no='$br'");
					$tpi=mysql_fetch_array($sqlTPI);
					
					// total interest receiveable
					$sqlTRI=mysql_query("SELECT SUM(interest-int_paid) AS total_ri FROM schedule WHERE rp='0' AND currency='$mycur' AND br_no='$br'");
					$tri=mysql_fetch_array($sqlTRI);
					
					// total remaining balance
					$sqlRos=mysql_query("SELECT SUM(principal-prn_paid) AS total_ros FROM schedule WHERE currency='$mycur' AND br_no='$br'");
					$tros=mysql_fetch_array($sqlRos);
					
					// paratio
					$today=date('Y-m-d');
					$par_date= strtotime(date('Y-m-d',strtotime($today))." - 90 days");
					$myparDate=date('Y-m-d',$par_date);
					$activeOs=$taamt[total_aos];
					
					$sqlParAmt=mysql_query(" SELECT DISTINCT ld
											 FROM schedule
											 WHERE repayment_date <= '$myparDate'
											 AND rp =  '0'
											 AND currency =  '$mycur' AND br_no='$br' AND dis='1'");
											 
					while($catch=mysql_fetch_array($sqlParAmt)){
							$getLd=$catch['ld'];
							// sum partAmt
							$sumpar=mysql_query("SELECT SUM(principal-prn_paid) as parAmt
											 FROM schedule
											 WHERE ld='$getLd'
											 AND rp =  '0'
											 AND currency =  '$mycur' AND br_no='$br' AND dis='1'");
							$parAmt=mysql_fetch_array($sumpar);
							$myparAmt=$parAmt[parAmt];
							$mylastparAmt=$mylastparAmt+$myparAmt;
						}
					
					$paratio=round(($mylastparAmt/$activeOs)*100,2);				
					
					}
					////
				
				if(($mycur!='0') && ($br=='0')){
					
					// total client
					$sqlTC=mysql_query("SELECT count(*) AS total_cl FROM loan_process WHERE cur='$mycur'");
					$tc=mysql_fetch_array($sqlTC);
					// total amount
					$sqlTAmt=mysql_query("SELECT SUM(principal) AS total_os FROM schedule WHERE rp in(1,6,9,0) AND currency='$mycur'");
					$tamt=mysql_fetch_array($sqlTAmt);
					
					// total active client
					$sqlTAC=mysql_query("SELECT count(*) AS total_acl FROM loan_process WHERE status in(1,6,0) AND cur='$mycur'");
					$tac=mysql_fetch_array($sqlTAC);
					// total active amount
					$sqlTAAmt=mysql_query("SELECT SUM(principal) AS total_aos FROM schedule WHERE rp in(1,6,0) AND currency='$mycur'");
					$taamt=mysql_fetch_array($sqlTAAmt);
					
					// total closed client
					$sqlTCC=mysql_query("SELECT count(*) AS total_ccl FROM loan_process WHERE status ='9' AND cur='$mycur'");
					$tcc=mysql_fetch_array($sqlTCC);
					// total closed amount
					$sqlTCAmt=mysql_query("SELECT SUM(principal) AS total_cos FROM schedule WHERE rp ='9' AND currency='$mycur'");
					$tcamt=mysql_fetch_array($sqlTCAmt);
					
					// total principal paid
					$sqlTPP=mysql_query("SELECT SUM(prn_paid) AS total_tpp FROM schedule WHERE currency='$mycur'");
					$tpp=mysql_fetch_array($sqlTPP);
					
					// total interest paid
					$sqlTPI=mysql_query("SELECT SUM(int_paid) AS total_tpi FROM schedule WHERE currency='$mycur'");
					$tpi=mysql_fetch_array($sqlTPI);
					
					// total interest receiveable
					$sqlTRI=mysql_query("SELECT SUM(interest-int_paid) AS total_ri FROM schedule WHERE rp='0' AND currency='$mycur'");
					$tri=mysql_fetch_array($sqlTRI);
					
					// total remaining balance
					$sqlRos=mysql_query("SELECT SUM(principal-prn_paid) AS total_ros FROM schedule WHERE currency='$mycur'");
					$tros=mysql_fetch_array($sqlRos);
					
					// paratio
					$today=date('Y-m-d');
					$par_date= strtotime(date('Y-m-d',strtotime($today))." - 90 days");
					$myparDate=date('Y-m-d',$par_date);
					$activeOs=$taamt[total_aos];
					
					$sqlParAmt=mysql_query(" SELECT DISTINCT ld
											 FROM schedule
											 WHERE repayment_date <= '$myparDate'
											 AND rp =  '0'
											 AND currency =  '$mycur' AND dis='1'");
											 
					while($catch=mysql_fetch_array($sqlParAmt)){
							$getLd=$catch['ld'];
							// sum partAmt
							$sumpar=mysql_query("SELECT SUM(principal-prn_paid) as parAmt
											 FROM schedule
											 WHERE ld='$getLd'
											 AND rp =  '0'
											 AND currency =  '$mycur' AND dis='1'");
							$parAmt=mysql_fetch_array($sumpar);
							$myparAmt=$parAmt[parAmt];
							$mylastparAmt=$mylastparAmt+$myparAmt;
		
						}
					
					$paratio=round(($mylastparAmt/$activeOs)*100,2);				
					}
					
			 ?>
			<table width="750" cellpadding="0" cellspacing="0" height="auto" class="form_border" border="1" 
            style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#03F; color:#FFFFFF">
                                <td width='170'><b>Report Type</b></td>
                                <td width="80"><b>Clients</b></td>
                                <td width="120"><b>Amount</b></td>
                                <td width="300"><b>Description</b></td>
							</tr>
                           </thead>	
                           <tbody>				              
						  		<tr>
                                	<td>
                                    	Total Clients : 
                                    </td>
                                    <td>
                                    	<b><font color="#996600"><?php echo formatMoney($tc[total_cl],true); ?></font></b>
                                    </td>
                                    <td>
                                    	<b><font color="#996600"><?php echo formatMoney($tamt[total_os],true); ?></font></b>
                                    </td>
                                    <td>
                                    	All the clients both active and close in <?php echo $mycur; ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td>
                                    	Active Clients : 
                                    </td>
                                    <td>
                                    	<b><font color="#996600"><?php echo formatMoney($tac[total_acl],true); ?></font></b>
                                    </td>
                                    <td>
                                    	<b><font color="#996600"><?php echo formatMoney($taamt[total_aos],true); ?></font></b>
                                    </td>
                                    <td>
                                    	All the active clients in <?php echo $mycur; ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td>
                                    	Closed Clients : 
                                    </td>
                                    <td>
                                    	<b><font color="#996600"><?php echo formatMoney($tcc[total_ccl],true); ?></font></b>
                                    </td>
                                    <td>
                                    	<b><font color="#996600"><?php echo formatMoney($tcamt[total_cos],true); ?></font></b>
                                    </td>
                                    <td>
                                    	All the closed clients in <?php echo $mycur; ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="4">&nbsp;</td>
                                </tr>
                                 <tr>
                                	<td>
                                    	<font color="#FF0000"><b>Total Paid Principal :  </font>
                                    </td>
                                    <td colspan="2">
                                    	<b><font color="#996600"><?php echo formatMoney($tpp[total_tpp],true); ?></font></b>
                                    </td>
                                   		
                                    <td>
                                    	Total Paid Principal in <?php echo $mycur; ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td>
                                    	<font color="#FF0000"><b>Total Paid Interest :  </font>
                                    </td>
                                    <td colspan="2">
                                    	<b><font color="#996600"><?php echo formatMoney($tpi[total_tpi],true); ?></font></b>
                                    </td>
                                   		
                                    <td>
                                    	Total Paid Interest in <?php echo $mycur; ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td>
                                    	<font color="#FF0000"><b>Total Interest Receiveable :  </font>
                                    </td>
                                    <td colspan="2">
                                    	<b><font color="#996600"><?php echo formatMoney($tri[total_ri],true); ?></font></b>
                                    </td>
                                   		
                                    <td>
                                    	Total Interest Receiveable in <?php echo $mycur; ?>
                                    </td>
                                </tr>
                                 <tr>
                                	<td>
                                    	<font color="#FF0000"><b>Total Remain O/S : </font>
                                    </td>
                                    <td colspan="2">
                                    	<b><font color="#996600"><?php echo formatMoney($tros[total_ros],true); ?></font></b>
                                    </td>
                                   
                                    <td>
                                    	Total Remaining O/S in <?php echo $mycur; ?>
                                    </td>
                                </tr>
                                <tr>
                                	<td>
                                    	<font color="#FF0000"><b>Paratio Detail : </font>
                                    </td>
                                    <td colspan="2">
                       <b><font color="#996600"><?php echo 'Par Amount : '.formatMoney($mylastparAmt,true).' > '.$paratio.' %'; ?></font></b>
                                    </td>
                                   
                                    <td>
                                    	Total Paratio in <?php echo $mycur; ?>
                                    </td>
                                </tr>
		   					</tbody>		
			</table>	
</center>
</body>
</html>