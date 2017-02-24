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
<title>Reject Customer List - OLMS</title>
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
					$reject_by=$_POST['reject_by'];
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
					echo "<h2><u>Rejected Customer List</u></h2>";
					}
				else if(!empty($get_from)&& !empty($get_to)){
					echo "<h2><u> Rejected Customer List</u></h2>";
					echo"
					<p>Rejected From <b>$myfrom</b> To <b>$myto</b><br/>Recommender : <b>$recommend</b>, Response CO : <b>$co</b> ,Branch : <b>$mybr</b> </p>
					";
				}
				else{	
					echo "<h2><u>Rejected Customer List</u></h2>";
					echo"
					<p>Recommender Name : <b>$recommend</b>, CO Name : <b>$co</b>, Branch : <b>$mybr</b> </p>
					";
				}
			 ?>
			<table width="1700" cellpadding="0" cellspacing="0" height="auto" class="form_border" border="1" style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#03F; color:#FFFFFF">
								<td><b>N<sup>o</sup></b></td>
								<td><b>CID</b></td>
                                <td><b>Canel Date</b></td>
								<td><b>អ្នកខ្ចី</b></td>
								<td><b>Borrower</b></td>
								<td><b>អ្នករួមខ្ចី</b></td>
								<td><b>Co-Borower</b></td>
								<td><b>COs</b></td>
								<td><b>Recommenders</b></td>
                                <td><b>Status</b></td>
								<td><b>Reason</b></td>
                                <td><b>Rejected By</b></td>
                                <td><b>Rejected At</b></td>
							</tr>
                           </thead>					
		<?php
		
				mysql_query ('SET NAMES UTF8');	
					
				/////////////////
				if(!empty($get_from) && !empty($get_to) && empty($reject_by) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `cancel_info` WHERE cancel_date BETWEEN '$from' and '$to' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
				}
				//////////////////
				/////////////////
				if(!empty($get_from) && !empty($get_to) && !empty($reject_by) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `cancel_info` WHERE cancel_date BETWEEN '$from' and '$to' AND cancel_by='$reject_by' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && !empty($get_to) && !empty($reject_by) && $br!='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `cancel_info` WHERE cancel_date BETWEEN '$from' and '$to' AND cancel_by='$reject_by' AND cancel_at='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
				}
				//////////////////	
				/////////////////
				if(!empty($get_from) && !empty($get_to) && empty($reject_by) && $br!='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `cancel_info` WHERE cancel_date BETWEEN '$from' and '$to' AND cancel_at='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
				}
				//////////////////	
				/////////////////
				if(empty($get_from) && empty($get_to) && empty($reject_by) && $br!='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `cancel_info` WHERE cancel_at='$br' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
				}
				//////////////////
				/////////////////
				if(empty($get_from) && empty($get_to) && !empty($reject_by) && $br=='0'){
							
						/////////////////////////
							$sql = "SELECT * FROM `cancel_info` WHERE cancel_by='$reject_by' ORDER BY id desc;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
				}
				//////////////////	
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
						$cancel_date=date('d-m-Y',strtotime($row['cancel_date']));
						$cancel_by=$row['cancel_by'];
						$branch=$row['cancel_at'];
						$reason=$row['reason'];
						///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
										}
						////
						///find approval info
								$app_info="SELECT * FROM register where cif='$mycid' and register_date='$register_date' order by id";
									$result_app=mysql_query($app_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_app)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];
											$purpose=$row['purpose'];
											$dis=$row['dis'];
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
						////
						
						echo " <tbody><tr>
									<td align='center'>$i</td>
									<td align='center'>$cid</td>
									<td align='center'>$cancel_date</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$kh_co_borrower</td>
									<td align='center'>$co_borrower</td>
									<td align='center'>$myco </td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$reason</td>
									<td align='center'>$cancel_by</td>
									<td align='center'>$br_name</td>
									";
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