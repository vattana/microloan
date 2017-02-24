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
<title>CIF List - OLMS</title>
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
					echo "<h2><u>CIF Information List</u></h2>";
					}
				else if(!empty($get_from)&& !empty($get_to)){
					echo "<h2><u>CIF Information List</u></h2>";
					echo"
					<p>Registered From <b>$myfrom</b> To <b>$myto</b><br/>Recommender : <b>$recommend</b>, Response CO : <b>$co</b> ,Branch : <b>$mybr</b>, Currency : <b>$mycur</b>  </p>
					";
				}
				else{	
					echo "<h2><u>CIF Information List</u></h2>";
					echo"
					<p>Recommender Name : <b>$recommend</b>, CO Name : <b>$co</b>, Branch : <b>$mybr</b>, Currency : <b>$mycur</b> </p>
					";
				}
			 ?>
			<table width="2400" cellpadding="0" cellspacing="0" height="auto" class="nostyle" border="1" style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#03F; color:#FFFFFF">
								<td width="20"><b>N<sup>o</sup></b></td>
								<td width="150"><b>CID</b></td>
                                <td><b>Register Date</b></td>
								<td><b>អ្នកខ្ចី</b></td>
								<td><b>Borrower</b></td>
								<td><b>អ្នករួមខ្ចី</b></td>
                                <td><b>Co-Borower</b></td>
                                <td><b>Loan Amount</b></td>
								<td><b>Rate</b></td>	
								<td><b>Period</b></td>
                                <td><b>House-No</b></td>
								<td><b>Street-No</b></td>
								<td><b>Village</b></td>	
								<td><b>Commune</b></td>
                                <td><b>District</b></td>
                                <td><b>Province</b></td>
								<td><b>COs</b></td>
								<td><b>Recommenders</b></td>
                                <td><b>Registered At</b></td>
								<td><b>Purpose</b></td>
                                <td><b>Disburse</b></td>
                                
							</tr>
                           </thead>					
		<?php
		
				mysql_query ('SET NAMES UTF8');	
					
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co!='0') && ($recommend=='0') && empty($cid) && ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND co='$co' and cur='$mycur' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date between '$from' AND '$to' AND co='$co' and cur='$mycur' ";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($recommend!='0') && empty($cid) && ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND recomend_name ='$recommend' and cur='$mycur' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date between '$from' AND '$to' AND recomend_name='$recommend' and cur='$mycur'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($recommend=='0') && empty($cid) && ($br!='0') && ($mycur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' AND branch ='$br' and cur='$mycur' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date between '$from' AND '$to' AND  branch='$br' and cur='$mycur'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && ($co=='0') && ($recommend=='0') && empty($cid) && ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE register_date BETWEEN '$from' and '$to' and cur='$mycur' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE register_date between '$from' AND '$to' and cur='$mycur'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($recommend!='0') && empty($cid) && ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE recomend_name='$recommend' and cur='$mycur' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE recomend_name='$recommend' and cur='$mycur'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co!='0') && ($recommend=='0') && empty($cid) && ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE co='$co' and cur='$mycur' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE co='$co' and cur='$mycur'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($recommend=='0') && empty($cid) && ($br!='0') && ($mycur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE branch='$br' and cur='$mycur' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE branch='$br' and cur='$mycur'";
							$result_loan = mysql_query($sql_loan) or die(mysql_error());
							$t = mysql_fetch_array($result_loan);
							
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && ($co=='0') && ($recommend=='0') && !empty($cid) && ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
							$sql = "SELECT * FROM `register` WHERE cif='$cid' and cur='$mycur' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_loan = "SELECT SUM(loan_request) AS grand_total FROM `register` WHERE cif='$cid' and cur='$mycur'";
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
					
						$reg_id=$row['reg_id'];
						$id=$row['id'];
						$mycid=$row['cif'];
						//echo $currency_type;
						$kh_borrower=$row['kh_borrower'];
						$borrower=$row['borrower'];
						$kh_co_borrower=$row['kh_co_borrower'];
						$co_borrower=$row['co_borrower'];
						$cur=$row['cur'];
						$status=$row['type_cust'];
						$purpose=$row['purpose'];
						$dis=$row['dis'];
						$register_date=date('Y-m-d',strtotime($row['register_date']));
						$loanAmt=formatMoney($row['loan_request'],true);
						$rate=$row['rate'];
						$term=$row['period'];
						$nor=$row['freq'];
						$response_co=$row['co'];
						$recom_name=$row['recomend_name'];
						$branch=$row['branch'];
						$houseNo=$row['houseNo'];
						$streetNo=$row['streetNo'];
						$vil=$row['village'];
						$com=$row['commune'];
						$dist=$row['district'];
						$prov=$row['province'];
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
						////
						
						echo " <tbody><tr>
									<td align='center'>$i</td>
									<td align='center'>$mycid</td>
									<td align='center'>$register_date</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$kh_co_borrower</td>
									<td align='center'>$co_borrower</td>
									<td align='center'>$cur $loanAmt </td>
									<td align='center'>$rate % </td>
									<td align='center'>$term $show_fr</td>
									
									
									<td align='center'>$houseNo</td>
									<td align='center'>$streetNo</td>
									<td align='center'>$get_village</td>
									<td align='center'>$get_commune</td>
									<td align='center'>$get_district</td>
									<td align='center'>$get_province</td>
									
									<td align='center'>$response_co</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$br_name</td>
									<td align='center'>$purpose</td>
									";
							//approve
							if($dis=='1'){
									echo"<td align='center'>
									<img src='../design/table/checked.png' title='$kh_borrower is dibursed already!'/>
									</td>";
									
								}
								else{
									echo"<td align='center'><img src='../design/table/check_box.gif'/ title='Not Yet Disburse!'></td>";
									}
							
						echo "</tr>";
							$i++;
				}// end while
				////////do actions
									$myid=$_GET['id'];
									$action=$_GET['action'];
									$myreg_id=$_GET['regis_id'];
								if(isset($_GET['delete'])){
									if($action=='delete'){
										$delete=mysql_query("DELETE FROM register WHERE id='$myid'");
										echo"<script>alert('Delete Successful!');</script>";
										}
									}//end isset
					/////////end actions
					
		?>
       					 <tr align="center" bgcolor="#CCFFFF" height="28">
								<td colspan="6">&nbsp;</td>
								<td align="right"><font color="#FF0000"><b>Total: </b></font></td>	
								<td colspan="3" align="center"><?php echo formatMoney($t[grand_total],true).' '.$currency_type ; ?></td>
                                <td colspan="11" align="center">&nbsp;</td>
							</tr>
                          </tbody>	
</table>	
<?php mysql_close(); ?>
</center>
</body>
</html>