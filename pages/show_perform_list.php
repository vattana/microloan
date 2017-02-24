<?php
    session_start();
    if(empty($_SESSION['usr'])) header('location:login.php');
?>
<link rel="stylesheet" type="text/css" href="../css/unicode.css" media="all"/>
<style type="text/css">
	p, li, td	{font:normal 12px/12px Arial;}
		table	{border:0;border-collapse:collapse;}
		td		{padding:3px; padding-left:10px; text-align:left}
		tr.odd	{background:#e4dcd9;}
		tr.highlight	{background:#CCC;}
		tr.selected		{background:#FFF;color:#00F;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Performance List:</title>
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
<?php 
	include('conn.php'); 
	include("module.php");	
?>	
<center>	
<?php 					
			///////////////////////////////////////
												
			$type_of_staff=$_POST['type_of_staff'];
			$performance=$_POST['performance'];
			$br_no=$_POST['br'];
			$getCur=$_POST['cur'];
			$from=date('Y-m-d',strtotime($_POST['from']));
			$to=date('Y-m-d',strtotime($_POST['to']));
			$myfrom= date('D,d/m/Y',strtotime($from));
			$myto= date('D,d/m/Y',strtotime($to));
			///find branch name
					$br_info="SELECT * FROM br_ip_mgr where br_no='$br_no' group by br_no";
						$result_br=mysql_query($br_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_br)){
								$br_name=$row['br_name'];
							}
				////
			/*echo"<script>alert('$type_of_staff,$performance,$br_no,$from,$to');</script>";*/
				if($performance=='dis'){
					$trantype='Disbursement';
					}
				if($performance=='nonedis'){
					$trantype='None-Disbursement';
					}
				if($performance=='lr'){
					$trantype='Loan Request';
					}
					echo "<h2><u>Daily Performance Report</u></h2>";
					echo"
					<p>From: <b>$myfrom</b> To <b>$myto</b></p>
					";
			 ?>
			<table width="1000px" cellpadding="0" cellspacing="0" height="auto" class="form_border" style="margin:0px; border-collapse:collapse" border="1" >
							<thead>
                            <tr align="center" style="background:#0033FF; color:#FFF" height="28">
								<td colspan="2"><?php echo '<b>'.$trantype.' - '.$type_of_staff.' - At  '.$br_name.' - '.'Currency '.$getCur; ?></td>
                                <td colspan="3" align="center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clients</b></td>
                                <td colspan="3" align="center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Amount</b></td>
							</tr>	
							<tr align="center" bgcolor="#0000FF" style="color:#FFF" height="28">
								<td><b>N<sup>o</sup></b></td>
								<td><b>COs / Recommenders</b></td>
								
								<td><b>New</b></td>
                                <td><b>Old</b></td>
                                <td><b>Total</b></td>
                                
                                <td><b>New</b></td>
								<td><b>Old</b></td>
								<td><b>Total</b></td>	
							</tr>	
							</thead>
                            <tbody>
		<?PHP
			mysql_query ('SET NAMES UTF8');
			//-----------------------------------disbursement by co---------------------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0') && ($getCur!='0')){///
				if(($performance=='dis') && ($type_of_staff=='byCO') && ($br_no=='0') && ($getCur!='0')){//check dis and by CO
						echo"<script>alert('condition 1! Disbursement by Co!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and dis='1' and cur='$getCur' Group By co asc;";
						$result=mysql_query($sql);
						
					
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['cur'];
				
				if($co!=''){//check empty
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date between '$from' and '$to' and co='$co' and type_cust='old' and dis='1' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date between '$from' and '$to' and co='$co' and type_cust='new' and dis='1' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date between '$from' and '$to' and co='$co' AND type_cust='new' and dis='1' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date between '$from' and '$to' and co='$co' AND type_cust='old' and dis='1' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}///end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
					
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------end disbursment by co-------------------------------------------------------//
		//-----------------------------------disbursement by recommender---------------------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0') && ($getCur!='0')){///
				if(($performance=='dis') && ($type_of_staff=='byRecommender')&& ($br_no=='0') && ($getCur!='0')){//check dis and by Recommender
						echo"<script>alert('condition 2! Disbursement by recomender!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and dis='1' and cur='$getCur' Group By recomend_name asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recomend_name'];
				$cur=$row['cur'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date between '$from' and '$to' and recomend_name='$recom_name' and type_cust='old' and dis='1' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date between '$from' and '$to' and recomend_name='$recom_name' and type_cust='new' and dis='1' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date between '$from' and '$to' and recomend_name='$recom_name' AND type_cust='new' and dis='1' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date between '$from' and '$to' and recomend_name='$recom_name' AND type_cust='old' and dis='1' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
					
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------end disbursment by recommender-------------------------------------------------------//
		//-----------------------------------disbursement by recommender and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0') && ($getCur!='0')){///
				if(($performance=='dis') && ($type_of_staff=='byRecommender')&& ($br_no!='0') && ($getCur!='0')){//check dis and by Recommender
						echo"<script>alert('condition 3! Disbursement by recomender and branch!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and branch='$br_no' and dis='1' and cur='$getCur' Group By branch,recomend_name;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recomend_name'];
				$cur=$row['cur'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and branch='$br_no' and recomend_name='$recom_name' and type_cust='old' and dis='1' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and branch='$br_no' and recomend_name='$recom_name' and type_cust='new' and dis='1' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and branch='$br_no' and recomend_name='$recom_name' AND type_cust='new' and dis='1' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and branch='$br_no' and recomend_name='$recom_name' AND type_cust='old' and dis='1' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------end disbursment by recommender and branch-----------------------------//
		//-----------------------------------disbursement by CO and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0') && ($getCur!='0')){///
				if(($performance=='dis') && ($type_of_staff=='byCO')&& ($br_no!='0') && ($getCur!='0')){//check dis and by Recommender
						echo"<script>alert('condition 4! Disbursement by CO and branch!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and branch='$br_no' and dis='1' Group By branch,co asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['cur'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and branch='$br_no' and co='$co' and type_cust='old' and dis='1' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and branch='$br_no' and co='$co' and type_cust='new' and dis='1' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and branch='$br_no' and co='$co' AND type_cust='new' and dis='1' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and branch='$br_no' and co='$co' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------end disbursment by CO and branch-----------------------------//
		//-----------------------------------None-Disbursement by CO----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0') && ($getCur!='0')){///
				if(($performance=='nonedis') && ($type_of_staff=='byCO')&& ($br_no=='0') && ($getCur!='0')){//check dis and by Recommender
						echo"<script>alert('condition 5! None-Disbursment by CO!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and dis='0' and cur='$getCur' Group By co asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['cur'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and co='$co' and dis='0' and type_cust='old' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and co='$co' and dis='0' and type_cust='new' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and co='$co' and dis='0' AND type_cust='new' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and co='$co' and dis='0' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End None-Disbursment by CO-----------------------------//
		//-----------------------------------None-Disbursement by recommender----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0') && ($getCur!='0')){///
				if(($performance=='nonedis') && ($type_of_staff=='byRecommender')&& ($br_no=='0') && ($getCur!='0')){
					//check dis and by Recommender
						echo"<script>alert('condition 6! None-Disbursement by recommender!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and dis='0' and cur='$getCur' Group By recom_name asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recomend_name'];
				$cur=$row['cur'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and dis='0' and type_cust='old' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and dis='0' and type_cust='new' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and dis='0' AND type_cust='new' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and dis='0' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End None-Disbursment by recommender-----------------------------//
		//-----------------------------------None-Disbursement by CO and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0') && ($getCur!='0')){///
				if(($performance=='nonedis') && ($type_of_staff=='byCO')&& ($br_no!='0') && ($getCur!='0')){//check dis and by Recommender
						echo"<script>alert('condition 7! None-Disbursment by CO and branch!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and branch='$br_no' and cur='$getCur' Group By co,branch asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['cur'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and co='$co' and branch='$br_no' and dis='0' and type_cust='old' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and co='$co' and branch='$br_no' and dis='0' and type_cust='new' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and co='$co' and branch='$br_no' and dis='0' AND type_cust='new' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and co='$co' and branch='$br_no' and dis='0' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End None-Disbursment by CO and branch-----------------------------//
		//-----------------------------------None-Disbursement by recommender and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0') && ($getCur!='0')){///
				if(($performance=='nonedis') && ($type_of_staff=='byRecommender')&& ($br_no!='0') && ($getCur!='0')){//check nonedis and by Recommender
						echo"<script>alert('condition 8! None-Disbursement by recommender and branch!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and branch='$br_no' and cur='$getCur' Group By recomend_name,branch asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recomend_name'];
				$cur=$row['cur'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and branch='$br_no' and dis='0' and type_cust='old' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and branch='$br_no' and dis='0' and type_cust='new' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and branch='$br_no' and dis='0' AND type_cust='new' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and branch='$br_no' and dis='0' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End None-Disbursment by recommender and branch-----------------------------//
		//-----------------------------------Loan Approval by CO----------------------------------------------------//
		/*	if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0')){///
				if(($performance=='appr') && ($type_of_staff=='byCO')&& ($br_no=='0')){//check app by co
						echo"<script>alert('condition 9! Approval by CO!');</script>";
						$sql="select * from approval where date_app Between '$from' and '$to' Group By co;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['currency'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and co='$co' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and co='$co' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_app) AS new_client_amt FROM `approval` where date_app Between '$from' and '$to' and co='$co' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_app) AS old_client_amt FROM `approval` where date_app Between '$from' and '$to' and co='$co' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Approval by CO-----------------------------//
		//-----------------------------------Loan Approval by CO and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0')){///
				if(($performance=='appr') && ($type_of_staff=='byCO')&& ($br_no!='0')){//check app by co
						echo"<script>alert('condition 10! Approval by CO and branch!');</script>";
						$sql="select * from approval where date_app Between '$from' and '$to' and reject='0' and br_no='$br_no' Group By co,br_no asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['currency'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and co='$co' and br_no='$br_no' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and co='$co' and br_no='$br_no' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_app) AS new_client_amt FROM `approval` where date_app Between '$from' and '$to' and co='$co' and br_no='$br_no' AND c_types='new'";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_app) AS old_client_amt FROM `approval` where date_app Between '$from' and '$to' and co='$co' and   br_no='$br_no' AND c_types='old'";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Approval by CO and branch-----------------------------//
		//-----------------------------------Loan Approval by Recommender----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0')){///
				if(($performance=='appr') && ($type_of_staff=='byRecommender')&& ($br_no=='0')){//check app by co
						echo"<script>alert('condition 11! Approval by recommender!');</script>";
						$sql="select * from approval where date_app Between '$from' and '$to' Group By recom_name asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recom_name'];
				$cur=$row['currency'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name'  and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_app) AS new_client_amt FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_app) AS old_client_amt FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Approval by Recommender-----------------------------//
		//-----------------------------------Loan Approval by Recommender and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0')){///
				if(($performance=='appr') && ($type_of_staff=='byRecommender')&& ($br_no!='0')){//check app by co
						echo"<script>alert('condition 12! Approval by recommender and branch!');</script>";
						$sql="select * from approval where date_app Between '$from' and '$to' and br_no='$br_no' Group By recom_name,br_no asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recom_name'];
				$cur=$row['currency'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and br_no='$br_no' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and br_no='$br_no' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_app) AS new_client_amt FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and br_no='$br_no' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_app) AS old_client_amt FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and br_no='$br_no' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Approval by Recommender and branch-----------------------------//
		//-----------------------------------Loan Reject After Approve by CO----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0')){///
				if(($performance=='re_after_app') && ($type_of_staff=='byCO')&& ($br_no=='0')){//check app by co
						echo"<script>alert('condition 13! Reject after approve by CO!');</script>";
						$sql="select * from approval where date_app Between '$from' and '$to' and reject='1' Group By co asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['currency'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and co='$co' and reject='1' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and co='$co' and reject='1' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_app) AS new_client_amt FROM `approval` where date_app Between '$from' and '$to' and co='$co' and reject='1' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_app) AS old_client_amt FROM `approval` where date_app Between '$from' and '$to' and co='$co' and    reject='1' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Reject After Approve by CO-----------------------------//
		//-----------------------------------Loan Reject After Approve by CO and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0')){///
				if(($performance=='re_after_app') && ($type_of_staff=='byCO')&& ($br_no!='0')){//check app by co
						echo"<script>alert('condition 13! Reject after approve by CO and branch!');</script>";
						$sql="select * from approval where date_app Between '$from' and '$to' and reject='1' and br_no='$br_no' Group By co,br_no;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['currency'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and co='$co' and reject='1' and br_no='$br_no' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and co='$co' and reject='1' and br_no='$br_no' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_app) AS new_client_amt FROM `approval` where date_app Between '$from' and '$to' and co='$co' and reject='1' and br_no='$br_no' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_app) AS old_client_amt FROM `approval` where date_app Between '$from' and '$to' and co='$co' and    reject='1' and br_no='$br_no' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Reject After Approve by CO and branch-----------------------------//
		//-----------------------------------Loan Reject after approve by Recommender----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0')){///
				if(($performance=='re_after_app') && ($type_of_staff=='byRecommender')&& ($br_no=='0')){//check app by co
						echo"<script>alert('condition 14! Reject after approve by recommender!');</script>";
						$sql="select * from approval where date_app Between '$from' and '$to' and reject='1' Group By recom_name asc;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recom_name'];
				$cur=$row['currency'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_app) AS new_client_amt FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and reject='1' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_app) AS old_client_amt FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and reject='1' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>

			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Reject after approve by Recommender-----------------------------//
		//-----------------------------------Loan Reject after approve by Recommender and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0')){///
				if(($performance=='re_after_app') && ($type_of_staff=='byRecommender')&& ($br_no!='0')){//check app by co
						echo"<script>alert('condition 15! Reject after approve by recommender and branch!');</script>";
						$sql="select * from approval where date_app Between '$from' and '$to' and reject='1' and br_no='$br_no' Group By recom_name,br_no;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recom_name'];
				$cur=$row['currency'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and br_no='$br_no' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and br_no='$br_no' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_app) AS new_client_amt FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and br_no='$br_no' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_app) AS old_client_amt FROM `approval` where date_app Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and br_no='$br_no' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>

			";
			$i++;
			}//////
		  }/////
		}//// */
		//--------------------------------------------------End Loan Reject after approve by Recommender and branch-----------------------------//
		//-----------------------------------Loan Request by CO----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0') && ($getCur!='0')){///
				if(($performance=='lr') && ($type_of_staff=='byCO')&& ($br_no=='0') && ($getCur!='0')){//check lr by co
						echo"<script>alert('condition 16! request by CO!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and cur='$getCur' Group By co;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['cur'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and co='$co' and type_cust='old' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and co='$co' and type_cust='new' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and co='$co' AND type_cust='new' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and co='$co' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Request by CO-----------------------------//
		//-----------------------------------Loan Request by CO and brnach----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0') && ($getCur!='0')){///
				if(($performance=='lr') && ($type_of_staff=='byCO')&& ($br_no!='0') && ($getCur!='0')){//check lr by co and branch
						echo"<script>alert('condition 17! request by CO and branch!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and branch='$br_no' and cur='$getCur' Group By co,branch;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['co'];
				$cur=$row['cur'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and co='$co' and branch='$br_no' and type_cust='old' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and co='$co' and branch='$br_no' and type_cust='new' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and co='$co' and branch='$br_no' AND type_cust='new' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and co='$co' and branch='$br_no' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Request by CO and branch-----------------------------//
		//-----------------------------------Loan Request by recommender----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0') && ($getCur!='0')){///
				if(($performance=='lr') && ($type_of_staff=='byRecommender')&& ($br_no=='0') && ($getCur!='0')){//check lr by co
						echo"<script>alert('condition 18! request by recommender!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and cur='$getCur' Group By recomend_name;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recomend_name'];
				$cur=$row['cur'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and type_cust='old' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and type_cust='new' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' AND type_cust='new' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Request by recommender-----------------------------//
		//-----------------------------------Loan Request by recommender and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0') && ($getCur!='0')){///
				if(($performance=='lr') && ($type_of_staff=='byRecommender')&& ($br_no!='0') && ($getCur!='0')){//check lr by recom and branch
						echo"<script>alert('condition 19! request by recommender and branch!');</script>";
						$sql="select * from register where register_date Between '$from' and '$to' and branch='$br_no' and cur='$getCur' Group By recomend_name,branch;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recomend_name'];
				$cur=$row['cur'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and branch='$br_no' and type_cust='old' and cur='$getCur'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and branch='$br_no' and type_cust='new' and cur='$getCur'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan_request) AS new_client_amt FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and branch='$br_no' AND type_cust='new' and cur='$getCur';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan_request) AS old_client_amt FROM `register` where register_date Between '$from' and '$to' and recomend_name='$recom_name' and branch='$br_no' AND type_cust='old' and cur='$getCur';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Request by recommender and branch-----------------------------//
		//-----------------------------------Loan Reject by CO----------------------------------------------------//
		/*	if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0')){///
				if(($performance=='all_re') && ($type_of_staff=='byCO')&& ($br_no=='0')){//check lr by co
						echo"<script>alert('condition 20! Reject by CO!');</script>";
						$sql="select * from cust_con_info where reg_date Between '$from' and '$to' and reject='1' Group By response_co;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['response_co'];
				$cur=$row['currency'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `cust_con_info` where reg_date Between '$from' and '$to' and response_co='$co' and reject='1' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `cust_con_info` where reg_date Between '$from' and '$to' and response_co='$co' and reject='1' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan) AS new_client_amt FROM `cust_con_info` where reg_date Between '$from' and '$to' and response_co='$co' and reject='1' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan) AS old_client_amt FROM `cust_con_info` where reg_date Between '$from' and '$to' and response_co='$co' and reject='1' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Reject by CO-----------------------------//
		//-----------------------------------Loan Reject by CO and branch----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0')){///
				if(($performance=='all_re') && ($type_of_staff=='byCO')&& ($br_no!='0')){//check lr by co
						echo"<script>alert('condition 21! Reject by CO and branch!');</script>";
						$sql="select * from cust_con_info where reg_date Between '$from' and '$to' and reject='1' and br_no='$br_no' Group By response_co;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$co=$row['response_co'];
				$cur=$row['currency'];
				if($co!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `cust_con_info` where reg_date Between '$from' and '$to' and response_co='$co' and reject='1' and br_no='$br_no' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `cust_con_info` where reg_date Between '$from' and '$to' and response_co='$co' and reject='1' and br_no='$br_no' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan) AS new_client_amt FROM `cust_con_info` where reg_date Between '$from' and '$to' and response_co='$co' and reject='1' and br_no='$br_no' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan) AS old_client_amt FROM `cust_con_info` where reg_date Between '$from' and '$to' and response_co='$co' and reject='1' and br_no='$br_no' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$co
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Reject by CO and branch-----------------------------//
		//-----------------------------------Loan Reject by Recommender----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no=='0')){///
				if(($performance=='all_re') && ($type_of_staff=='byRecommender')&& ($br_no=='0')){//check reject by recommender
						echo"<script>alert('condition 22! Reject by recommender!');</script>";
						$sql="select * from cust_con_info where reg_date Between '$from' and '$to' and reject='1' Group By recom_name;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recom_name'];
				$cur=$row['currency'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `cust_con_info` where reg_date Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `cust_con_info` where reg_date Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan) AS new_client_amt FROM `cust_con_info` where reg_date Between '$from' and '$to' and recom_name='$recom_name' and reject='1' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan) AS old_client_amt FROM `cust_con_info` where reg_date Between '$from' and '$to' and recom_name='$recom_name' and reject='1' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt
					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////
		//--------------------------------------------------End Loan Reject by Recommender and branch-----------------------------//
		//-----------------------------------Loan Reject by Recommender----------------------------------------------------//
			if(!empty($from) && !empty($to) && ($type_of_staff!='0') && ($performance!='0') && ($br_no!='0')){///
				if(($performance=='all_re') && ($type_of_staff=='byRecommender')&& ($br_no!='0')){//check reject by recommender
						echo"<script>alert('condition 23! Reject by recommender!');</script>";
						$sql="select * from cust_con_info where reg_date Between '$from' and '$to' and reject='1' and br_no='$br_no' Group By recom_name;";
						$result=mysql_query($sql);
			$i=1;
			while($row=mysql_fetch_array($result))			
				{
				$recom_name=$row['recom_name'];
				$cur=$row['currency'];
				if($recom_name!=''){
				////////Clients
				//////////sum old client
					$sum_old_client=mysql_query("SELECT * FROM `cust_con_info` where reg_date Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and br_no='$br_no' and c_types='old'");
					$old_clients = mysql_num_rows($sum_old_client);
				//////////////////////
				//////////sum new client
					$sum_new_client=mysql_query("SELECT * FROM `cust_con_info` where reg_date Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and br_no='$br_no' and c_types='new'");
					$new_clients = mysql_num_rows($sum_new_client);
				//////////////////////
				////total client
					$total_client=round($old_clients+$new_clients,2);
				////////
				////total all old client
					$total_all_old_client=round($total_all_old_client+$old_clients,2);
				////////
				////total all new client
					$total_all_new_client=round($total_all_new_client+$new_clients,2);
				////////
				////total all total client
					$total_all_total_client=round($total_all_total_client+$total_client,2);
				////////
				///////////////////////Amount
				///////////sum new amount
				$sum_new_client_amt = "SELECT SUM(loan) AS new_client_amt FROM `cust_con_info` where reg_date Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and br_no='$br_no' AND c_types='new';";
				$result_new_client_amt = mysql_query($sum_new_client_amt) or die(mysql_error());
				$new_client_amt = mysql_fetch_array($result_new_client_amt);
				$new_client_amt=$new_client_amt[new_client_amt];
				$mynew_client_amt=formatMoney($new_client_amt,true);
				/////////////////////////
				///////////sum old amount
				$sum_old_client_amt = "SELECT SUM(loan) AS old_client_amt FROM `cust_con_info` where reg_date Between '$from' and '$to' and recom_name='$recom_name' and reject='1' and br_no='$br_no' AND c_types='old';";
				$result_old_client_amt = mysql_query($sum_old_client_amt) or die(mysql_error());
				$old_client_amt = mysql_fetch_array($result_old_client_amt);
				$old_client_amt=$old_client_amt[old_client_amt];
				$myold_client_amt=formatMoney($old_client_amt,true);
				/////////////////////////
				////////total client amt
				$total_client_amt=round($new_client_amt+$old_client_amt,2);
				$mytotal_client_amt=formatMoney($total_client_amt,true);
				////////
				///////////total all new client amt
				$total_all_new_client_amt=round($total_all_new_client_amt+$new_client_amt,2);
				$mytotal_all_new_client_amt=formatMoney($total_all_new_client_amt,true);
				//////////
				///////////total all old client amt
				$total_all_old_client_amt=round($total_all_old_client_amt+$old_client_amt,2);
				$mytotal_all_old_client_amt=formatMoney($total_all_old_client_amt,true);
				//////////
				///////////total all total client amt
				$total_all_total_client_amt=round($total_all_total_client_amt+$total_client_amt,2);
				$mytotal_all_total_client_amt=formatMoney($total_all_total_client_amt,true);
				//////////
				}// end check empty
			echo"
				<tr align='center' valig='middle'>
					<td>
						$i
					</td>
					<td>
						$recom_name
					</td>
					
					<td>
						$new_clients
					</td>
					<td>
						$old_clients
					</td>
					<td>
						$total_client
					</td>
					<td>
						$mynew_client_amt
					</td>
					<td>
						$myold_client_amt
					</td>
					
					<td>
						$mytotal_client_amt

					</td>
				</tr>
			";
			$i++;
			}//////
		  }/////
		}////*/
					$check_record=mysql_num_rows($result);
					if($check_record==''){
						echo"<script>alert('No Records Found!');</script>";
						echo"<script>window.close();</script>";
						exit();
						}
		//--------------------------------------------------End Loan Reject by Recommender and branch-----------------------------//
							
?>							<tr align="center" bgcolor="#99FFFF" height="28">
								<td>&nbsp;</td>
								<td align="center"><font color="#FF0000"><b>Grand Total: </b></font></td>	
								<td align="center"><?php echo $total_all_new_client; ?></td>
                                <td align="center"><?php echo $total_all_old_client; ?></td>
                                <td align="center"><?php echo $total_all_total_client; ?></td>
                                <td align="center"><?php echo $mytotal_all_new_client_amt; ?></td>
                                <td align="center"><?php echo $mytotal_all_old_client_amt; ?></td>
                                <td align="center"><?php echo $mytotal_all_total_client_amt; ?></td>
							</tr>
               </tbody>	
</table>
</center>
</body>
</html>