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
<title>Loan Member List - OLMS</title>
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
					$gid=$_GET['gid'];
					$br=$_GET['br'];
					///display branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$br' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$mybr=$row['br_name'];
										}
					////
				
					echo "<h2><u>Loan Member List</u></h2><br/>";
					echo "<h2><u>Group ID is :  $gid, Branch is : $mybr</u></h2>";
					
			 ?>
			<table width="1700" cellpadding="0" cellspacing="0" height="auto" class="form_border" border="1" style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#333; color:#FFFFFF">
								<td width="20"><b>N<sup>o</sup></b></td>
								<td width="150"><b>LD</b></td>
                                <td><b>Entried Date</b></td>
								<td><b>អ្នកខ្ចី</b></td>
								<td><b>Borrower</b></td>
								<td><b>អ្នករួមខ្ចី</b></td>
								<td><b>Co-Borower</b></td>
								<td><b>Amount</b></td>
								<td><b>Rate</b></td>	
								<td><b>Period</b></td>
								<td><b>COs</b></td>
								<td><b>Recommenders</b></td>
                                <td><b>Status</b></td>
                                <td><b>Loan Type</b></td>
								<td><b>Clasified Purpose</b></td>
                                <td><b>Entried At</b></td>
                                
							</tr>
                           </thead>					
		<?php
		
				mysql_query ('SET NAMES UTF8');			
						/////////////////////////
							$sql = "SELECT * FROM `loan_process` WHERE group_id='$gid' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						////////////////////
					$i=1;
					$check_record=mysql_num_rows($result);
					
					if($check_record==''){
						echo"<script>alert('No Records Found! Please check your loan information again!!');</script>";
						echo"<script>window.close();</script>";
						exit();
						}
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$reg_id=$row['regis_id'];
						$ld=$row['ld'];
						//echo $currency_type;
						$myloan_date=date('d-m-Y',strtotime($row['loan_date']));
						$response_co=$row['co'];
						$recom_name=$row['recom_name'];
						$branch=$row['loan_at'];
						$class_purpose=$row['classified_purpose'];
						$l_type=$row['loan_type'];
						///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
										}
						////
						///find cif info
								$cif_info="SELECT * FROM register where id='$reg_id' order by id";
									$result_cif=mysql_query($cif_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cif)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];	
											$approval_amt=formatMoney($row['loan_request'],true);
											$real_amt=$row['loan_request'];
											$approval_int=$row['rate'];
											$approval_period=$row['period'];
											$nor=$row['freq'];
										}
						
										//display frequency
												if($nor=='30'){
													$show_fr='ខែ';
													}
												else if($nor=='7'){
													$show_fr='អាទិត្យ';
													}
												else if($nor=='14'){
													$show_fr='២ អាទិត្យ';
													}
												else if($nor=='1'){
													$show_fr='ថ្ងៃ';
													}
												else if($nor=='5'){
													$show_fr='៥ ថ្ងៃ';
													}
												else{
													$show_fr='ខែ';
													}
										//---end frequency----//	
										$sum=round($sum+$real_amt,2);
										$final_amt=formatMoney($sum,true);
						////
						
						echo " <tbody><tr>
									<td align='center'>$i</td>
									<td align='center'>$ld</td>
									<td align='center'>$myloan_date</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$kh_co_borrower</td>
									<td align='center'>$co_borrower</td>
									<td align='center'>$cur $approval_amt </td>
									<td align='center'>$approval_int % </td>
									<td align='center'>$approval_period $show_fr</td>
									<td align='center'>$response_co</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$l_type</td>
									<td align='center'>$class_purpose</td>
									<td align='center'>$br_name</td>
									";
							
						echo "</tr>";
							$i++;
				}// end while
				
				
		?>
       					 <tr align="center" bgcolor="#CCFFFF" height="28">
								<td colspan="6">&nbsp;</td>
								<td align="right"><font color="#FF0000"><b>Total: </b></font></td>	
								<td colspan="3" align="center"><?php echo $cur .' '.$final_amt ; ?></td>
                                <td colspan="6" align="center">&nbsp;</td>
							</tr>
                          </tbody>	
</table>	
<?php
					////////do actions
									$myid=$_GET['id'];
									$action=$_GET['action'];
									$myreg_id=$_GET['regis_id'];
								if(isset($_GET['action'])){
									if($action=='delete'){
										$delete=mysql_query("DELETE FROM loan_process WHERE id='$myid'");
										$update=mysql_query("UPDATE register SET bloan ='0' WHERE id='$myreg_id'");
										echo"<script>alert('Delete Successful! Please Check Again!');</script>";
										echo"<script>window.close();</script>";
										}
									}//end isset
					/////////end actions
?>
</center>
</body>
</html>