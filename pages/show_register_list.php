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
<title>Register Customer List - OLMS</title>
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
					$cid=$_POST['cid'];
					$co =$_POST['co'];
					$recommend = $_POST['recommender'];
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
				if(empty($get_from)&& empty($get_to) && ($recommend=='0') && ($co=='0') && ($br=='0')){
					echo "<h2><u>Registered Customer List</u></h2>";
					}
				else if(!empty($get_from)&& !empty($get_to)){
					echo "<h2><u> Registered Customer List</u></h2>";
					echo"
					<p>Registered From <b>$myfrom</b> To <b>$myto</b><br/>Recommender : <b>$recommend</b>, Response CO : <b>$co</b> ,Branch : <b>$mybr</b> </p>
					";
				}
				else{	
					echo "<h2><u>Registered Customer List</u></h2>";
					echo"
					<p>Recommender Name : <b>$recommend</b>, CO Name : <b>$co</b>, Branch : <b>$mybr</b> </p>
					";
				}
			 ?>
			<table width="1700" cellpadding="0" cellspacing="0" height="auto" class="form_border" border="1" style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:url(../images/table/table_header_checkbox.gif); color:#FFFFFF">
								<td><b>N<sup>o</sup></b></td>
								<td><b>CID</b></td>
                                <td><b>Register Date</b></td>
								<td><b>អ្នកខ្ចី</b></td>
								<td><b>Borrower</b></td>
								<td><b>អ្នករួមខ្ចី</b></td>
								<td><b>Co-Borower</b></td>
								<td><b>Amount</b></td>
								<td><b>Rate</b></td>	
								<td><b>Period</b></td>
								<td><b>COs</b></td>
								<td><b>Recommenders</b></td>
                                <td><b>Commune</b></td>
                                <td><b>Status</b></td>
                                <td><b>Branch</b></td>
								<td><b>Purpose</b></td>
								<td><b>Approve</b></td>
                                <td><b>CIF Detail</b></td>
								<td><b>Cancel</b></td>
								<td><b>Edit</b></td>
                                <td><b>Delete</b></td>
							</tr>
                           </thead>					
		<?php
		
				mysql_query ('SET NAMES UTF8');	
					
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co!='0') && ($recommend=='0') && empty($cid) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND co='$co' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date between '$from' AND '$to' AND co='$co' ";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($recommend!='0') && empty($cid) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND recomend_name='$recommend' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date between '$from' AND '$to' AND recomend_name='$recommend' ";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($recommend=='0') && empty($cid) && $br!='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND branch='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date between '$from' AND '$to' AND  branch='$br' ";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($recommend=='0') && empty($cid) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date between '$from' AND '$to'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($recommend!='0') && empty($cid) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE recomend_name='$recommend' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE recomend_name='$recommend'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co!='0') && ($recommend=='0') && empty($cid) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE co='$co' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE co='$co'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($recommend=='0') && empty($cid) && $br!='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE branch='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE branch='$br'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($recommend=='0') && !empty($cid) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE cif='$cid' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE cif='$cid'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				
					$i=1;
					$check_record=mysql_num_rows($result_loan);
					
					if($check_record==''){
						echo"<script>alert('No Records Found!');</script>";
						echo"<script>window.close();</script>";
						exit();
						}
					while($row=mysql_fetch_array($result))
					{
					
						$id=$row['id'];
						$cid = $row['cif'];
						$borrower = $row['borrower'];
						$kh_borrower =$row['kh_borrower'];
						$co_borrower = $row['co_borrower'];
						$kh_co_borrower =$row['kh_co_borrower'];
						$amount = $row['loan_request'];
						
						$reg_date=$row['register_date'];
						$myreg_date=date('d/m/Y',strtotime($reg_date));
						$type_loan=$row['type_loan'];
						$money= formatMoney($amount, true);
						$period = $row['period'];
						$rate = $row['rate'];
						$co = $row['co'];
						$commune =$row['commune'];
						$desc = $row['purpose'];
						
						$recom_name = $row['recomend_name'];
						$recom_by = $row['recomend_by'];
						$app = $row['appr'];
						$cancel = $row['cancel'];
						$dis=$row['dis'];
						$cur=$row['cur'];
						$status=$row['type_cust'];
						$branch=$row['branch'];
						$bcif=$row['bcif'];
						//echo $currency_type;
						///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
										}
						////
						///find cancel info
								$cancel_info="SELECT * FROM cancel_info where reg_id='$id' order by id";
									$result_cancel=mysql_query($cancel_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cancel)){
											$reason=$row['reason'];
										}
						////
						///find approval info
								$app_info="SELECT * FROM customer_app where reg_id='$id' order by id";
									$result_app=mysql_query($app_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_app)){
											$approval_amt=formatMoney($row['approval_amt'],true);
											$approval_int=$row['approval_rate'];
											$approval_period=$row['approval_period'];
											$nor=$row['number_of_repay'];
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
						
						echo " <tbody><tr>
									<td align='center'>$i</td>
									<td align='center'>$cid</td>
									<td align='center'>$myreg_date</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$kh_co_borrower</td>
									<td align='center'>$co_borrower</td>
									<td align='center'>$cur $money </td>
									<td align='center'>$rate % </td>
									<td align='center'>$period </td>
									<td align='center'>$co</td>
									<td align='center'>$recom_name</td>
								";
							$commune_sql="Select * from adr_commune where id ='$commune'";
							$result_com=mysql_query($commune_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_com))
									{
										$show_commune=$row['commune'];
										//echo $show_commune;
									}
								echo "
									<td align='center'>$show_commune</td>
									<td align='center'>$status</td>
									<td align='center'>$br_name</td>
									<td align='center'>$desc</td>
									";
							//approve
							if($app=='1'){
									echo"<td align='center'>
									<img src='../images/table/checked.png' 
						title='Approved already! Approval Amount: $cur $approval_amt, Rate: $approval_int % , Period: $approval_period $show_fr'/>
									</td>";
									
								}
								else{
									echo"<td align='center'><a href='approve_cust_form.php?id=$id' title='Click to approve this customer'>
									<img src='../images/table/check_box.gif'/></a></td>";
									}
							//view cif
							if($bcif=='1'){
									echo"<td align='center'><a href='view_cif_detail.php?id=$id' title='View Detail CIF'>
									<img src='../images/table/detail.png'/></a></td>";
								}
								else{
									echo"<td align='center'>
									<img src='../images/table/warning.png' title='Not allow until you input CIF for this Customer'/></td>";
									}
							//cancel
							if($cancel=='1'){
									echo"<td align='center'>
									<img src='../images/table/checked.png' title='Canceled Already! Reason is $reason'/></td>";
								}
								else{
									echo"<td align='center'><a href='cancel_cust_form.php?id=$id' title='Click to cancel this customer'>
									<img src='../images/table/check_box.gif'/></a></td>";
									}
							//edit
							echo"<td align='center'><a href='edit_cust_reg_form.php?id=$id' title='Click to edit this customer'>
									<img src='../images/table/modify.png'/></a></td>";
							//delete
							echo"<td align='center'><a href='delete_cust_reg_form.php?id=$id' title='Click to delete this customer'>
									<img src='../images/table/icon_close_blue.gif'/></a></td>";
							//
						echo "</tr>";
							$i++;
				}// end while
				
		?>
       					 <tr align="center" bgcolor="#CCFFFF" height="28">
								<td colspan="6">&nbsp;</td>
								<td align="right"><font color="#FF0000"><b>Total: </b></font></td>	
								<td colspan="3" align="center"><?php echo formatMoney($t[grand_total],true).' '.$currency_type ; ?></td>
                                <td colspan="12" align="center">&nbsp;</td>
							</tr>
                          </tbody>	
</table>	
</center>
</body>
</html>