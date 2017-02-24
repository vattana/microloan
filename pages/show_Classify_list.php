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
<title>Loan Classification List - OLMS</title>
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
					//$get_to=$_POST['to'];
					$from =date('Y-m-d',strtotime($get_from));
					//$to=date('Y-m-d',strtotime($get_to));
					$classLoan=trim($_POST['classLoan']);
					$period =trim($_POST['period']);
					$br=$_POST['br'];
					
					$mycur=trim($_POST['cur']);
					$myfrom= date('D,d/m/Y',strtotime($from));
					//$myto= date('D,d/m/Y',strtotime($to));
					///display branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$br' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$mybr=$row['br_name'];
										}
					////
				if(empty($get_from)&& empty($get_to) && ($recommend=='0') && ($co=='0') && ($br=='0') && ($mycur!='0')){
					echo "<h2><u>Loan Classification</u></h2>";
					}
				else if(!empty($get_from)&& !empty($get_to)){
					echo "<h2><u> None-Disbursed Customer List</u></h2>";
					echo"
					<p>Date <b>$myfrom</b>Branch : <b>$mybr</b>,Currency : <b>$mycur</b> </p>
					";
				}
				else{	
					echo "<h2><u>Loan Classification</u></h2>";
					echo"
					<p>Branch : <b>$mybr</b>,Currency : <b>$mycur</b> </p>
					";
				}
			 ?>
			<table width="1700" cellpadding="0" cellspacing="0" height="auto" class="form_border" border="1" style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#03F; color:#FFFFFF">
								<td><b>Classification</b></td>
                                <td><b>Loan Account</b></td>
                                <td><b>Register Date</b></td>
								<td><b>អ្នកខ្ចី</b></td>
								<td><b>Borrower</b></td>
								<td><b>អ្នករួមខ្ចី</b></td>
								<td><b>Co-Borower</b></td>
								<td><b>Late Days</b></td>
								<td><b>Number of Loan</b></td>	
								<td><b>Principal Balance</b></td>
								<td><b>Overdue Balance</b></td>
								<td><b>AIR</b></td>
                                <td><b>Pro-Rate (%)</b></td>
                                <td><b>Pro-Amount</b></td>
                                <td><b>Branch</b></td>
							</tr>
                           </thead>					
		<?php
		
				mysql_query ('SET NAMES UTF8');	
					
				/////////////////
				//First Condition (Select All)
				if(!empty($get_from)  && ($classLoan!='0') && ($period!='0') &&  ($br!='0') && ($mycur!='0')){
							
						/////////////////////////
						$cl_info="SELECT * FROM loan_classify where term='$period' and short_desc='$classLoan' group by id";
									$result_cl=mysql_query($cl_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cl)){
											$myF=$row['F'];
											$myT = $row['T'];
											$myPro= $row['provis'];
											$term = $row['term'];
										}
										// ((((sch.balance+sch.principal)-sch.prn_paid)*(r.rate/100))/r.freq)*datediff(LAST_DAY(sch.repayment_date),sch.repayment_date) AIR
										
							

							$sql = "select * from (select distinct g.g_status, sch.ld,sch.repayment_date,r.register_date,r.borrower,r.kh_borrower,r.co_borrower,r.kh_co_borrower,datediff('$from',sch.repayment_date) late,sum(principal-prn_paid) overduepaid,((sch.balance+sch.principal)-sch.prn_paid) OstandingBalance from schedule sch,   loan_process l, glp_caption g,register r
where sch.ld=l.ld and l.glcode=g.glcode and l.cid=r.cif and rp='0' and r.cur='$mycur' and sch.br_no='$br'  and g.g_status='$term'  group by sch.ld,late,r.borrower,sch.balance having late between '$myF' and '$myT') a
having late = datediff('$from',(select repayment_date from  schedule sch, loan_process l where sch.ld=l.ld and rp='0' and l.ld=a.ld order by repayment_date limit 1))";
							$result_last = mysql_query($sql) or die(mysql_error());
							$i=1;
							$check_record=mysql_num_rows($result_last);
					
					
						if($check_record=='0'){
							echo"<script>alert('No Records Found!');</script>";
							echo"<script>window.close();</script>";
							exit();
						}
					
					while($row=mysql_fetch_array($result_last))
					{
						$clas = $row['g_status'];
						$lid = $row['ld'];
						$registerdate = $row['register_date'];
						$bor = $row['borrower'];
						$kh_bor = $row['kh_borrower'];
						$co_bor = $row['co_borrower'];
						$kh_co_bor = $row['kh_co_borrower'];
						$late = $row['late'];
						$overduepaid = $row['overduepaid'];
						$os = $row['OstandingBalance'];
						
						//AIR
							$sql_AIR = "select * from (select distinct g.g_status, sch.ld,sch.repayment_date,r.register_date,r.borrower,r.kh_borrower,r.co_borrower,r.kh_co_borrower,datediff('$from',sch.repayment_date) late,sum(principal-prn_paid) overduepaid,((sch.balance+sch.principal)-sch.prn_paid) OstandingBalance from schedule sch,   loan_process l, glp_caption g,register r
where sch.ld=l.ld and l.glcode=g.glcode and l.cid=r.cif and rp='0' and r.cur='$mycur' and sch.br_no='$br'  and g.g_status='$term'  group by sch.ld,late,r.borrower,sch.balance) a
)";
						//END		
								///find cif info
						
						
									$cif_info="SELECT * FROM register where cif='$mycid' order by id";
									$result_cifinfo=mysql_query($cif_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cifinfo)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];
											$mycid=$row['cif'];
											$myl_type=$row['type_loan'];
											$purpose=$row['purpose'];
											break;
										}
									
									///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
									////
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
						if ($mycur=='USD'){
							$pro_amount = round(($overduepaid*$myPro)/100,2);
						}
						elseif ($mycur=='KHR'){
							$pro_amount = roundkhr(round(($overduepaid*$myPro)/100,2),$set);
						}
						echo "<tbody>";
						echo " <tr>
									<td align='center'>$classLoan</td>
									<td align='center' colspan='7'></td>
									<td align='center'>$check_record</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$myl_type</td>
									<td align='center'>$purpose</td>
									
									
									";
							
						echo "</tr>";
						echo " <tr>
									<td align='center'>$term</td>
									<td align='center'>$lid</td>
									<td align='center'>$registerdate</td>
									<td align='center'>$kh_bor</td>
									<td align='center'>$bor</td>
									<td align='center'>$kh_co_bor</td>
									<td align='center'>$co_bor</td>
									<td align='center'>$late</td>
									<td align='center'>-</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$myPro %</td>
									<td align='center'>$pro_amount</td>
									<td align='center'>$mybr</td>
									
									";
							
						echo "</tr>";
							$i++;
					}
						/////////////////////
						/////////////////////////
							//$sql_loan = "SELECT SUM(approval_amt) AS grand_total FROM `customer_app` WHERE approval_date between '$from' AND '$to' AND response_co='$co' and cur='$mycur' AND dis='0'";
							//$result_loan = mysql_query($sql_loan) or die(mysql_error());
							//$t = mysql_fetch_array($result_loan);	
							
						/////////////////////
				}
				
				//Second Condition (Select All No Branch)
				if(!empty($get_from)  && ($classLoan!='0') && ($period!='0') &&  ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
						
						$cl_info="SELECT * FROM loan_classify where term='$period' and short_desc='$classLoan' group by id";
									$result_cl=mysql_query($cl_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cl)){
											$myF=$row['F'];
											$myT = $row['T'];
											$myPro= $row['provis'];
											$term = $row['term'];
										}
			
							$sql = "select * from (select distinct g.g_status, sch.ld,sch.repayment_date,r.register_date,r.borrower,r.kh_borrower,r.co_borrower,r.kh_co_borrower,datediff('$from',sch.repayment_date) late,sum(principal-prn_paid) overduepaid,((sch.balance+sch.principal)-sch.prn_paid) OstandingBalance from schedule sch,   loan_process l, glp_caption g,register r
where sch.ld=l.ld and l.glcode=g.glcode and l.cid=r.cif and rp='0' and r.cur='$mycur'  and g.g_status='$term'  group by sch.ld,late,r.borrower,sch.balance having late between '$myF' and '$myT') a
having late = datediff('$from',(select repayment_date from  schedule sch, loan_process l where sch.ld=l.ld and rp='0' and l.ld=a.ld order by repayment_date limit 1))";
							$result_last = mysql_query($sql) or die(mysql_error());
					$i=1;
							$check_record=mysql_num_rows($result_last);
					
					
						if($check_record=='0'){
							echo"<script>alert('No Records Found!');</script>";
							echo"<script>window.close();</script>";
							exit();
						}
					
					while($row=mysql_fetch_array($result_last))
					{
						$clas = $row['g_status'];
						$lid = $row['ld'];
						$registerdate = $row['register_date'];
						$bor = $row['borrower'];
						$kh_bor = $row['kh_borrower'];
						$co_bor = $row['co_borrower'];
						$kh_co_bor = $row['kh_co_borrower'];
						$late = $row['late'];
						$overduepaid = $row['overduepaid'];
						$os = $row['OstandingBalance'];
								
								///find cif info
						
						
									$cif_info="SELECT * FROM register where cif='$mycid' order by id";
									$result_cifinfo=mysql_query($cif_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cifinfo)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];
											$mycid=$row['cif'];
											$myl_type=$row['type_loan'];
											$purpose=$row['purpose'];
											break;
										}
									
									///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
									////
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
						if ($mycur=='USD'){
							$pro_amount = round(($overduepaid*$myPro)/100,2);
						}
						elseif ($mycur=='KHR'){
							$pro_amount = roundkhr(round(($overduepaid*$myPro)/100,2),$set);
						}
						echo "<tbody>";
						echo " <tr>
									<td align='center'>$classLoan</td>
									<td align='center' colspan='7'></td>
									<td align='center'>$check_record</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$myl_type</td>
									<td align='center'>$purpose</td>
									
									
									";
							
						echo "</tr>";
						echo " <tr>
									<td align='center'>$term</td>
									<td align='center'>$lid</td>
									<td align='center'>$registerdate</td>
									<td align='center'>$kh_bor</td>
									<td align='center'>$bor</td>
									<td align='center'>$kh_co_bor</td>
									<td align='center'>$co_bor</td>
									<td align='center'>$late</td>
									<td align='center'>-</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$myPro %</td>
									<td align='center'>$pro_amount</td>
									<td align='center'>$mybr</td>
									
									
									";
							
						echo "</tr>";
							$i++;
					}

				}
				$i=1;
				//Third Condition (Select All No Branch and No Period)
				if(!empty($get_from)  && ($classLoan!='0') && ($period=='0') &&  ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
						
						$cl_info="SELECT * FROM loan_classify where short_desc='$classLoan' group by id";
									$result_cl=mysql_query($cl_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cl)){
											$myF=$row['F'];
											$myT = $row['T'];
											$myPro= $row['provis'];
											$term = $row['term'];
											
										

							$sql = "select * from (select distinct g.g_status, sch.ld,sch.repayment_date,r.register_date,r.borrower,r.kh_borrower,r.co_borrower,r.kh_co_borrower,datediff('$from',sch.repayment_date) late,sum(principal-prn_paid) overduepaid,((sch.balance+sch.principal)-sch.prn_paid) OstandingBalance from schedule sch,   loan_process l, glp_caption g,register r
where sch.ld=l.ld and l.glcode=g.glcode and l.cid=r.cif and rp='0' and r.cur='$mycur' and g.g_status='$term' group by sch.ld,late,r.borrower,sch.balance having late between '$myF' and '$myT') a
having late = datediff('$from',(select repayment_date from  schedule sch, loan_process l where sch.ld=l.ld and rp='0' and l.ld=a.ld order by repayment_date limit 1))";
							$result_last = mysql_query($sql) or die(mysql_error());

				
				
				//////////////////	
				
					
					$check_record=mysql_num_rows($result_last);
					
					if($i==1){
						if($check_record=='0'){
							echo"<script>alert('No Records Found!');</script>";
							echo"<script>window.close();</script>";
							exit();
						}
					}
					while($row=mysql_fetch_array($result_last))
					{
						$clas = $row['g_status'];
						$lid = $row['ld'];
						$registerdate = $row['register_date'];
						$bor = $row['borrower'];
						$kh_bor = $row['kh_borrower'];
						$co_bor = $row['co_borrower'];
						$kh_co_bor = $row['kh_co_borrower'];
						$late = $row['late'];
						$overduepaid = $row['overduepaid'];
						$os = $row['OstandingBalance'];
								
								///find cif info
						
						
									$cif_info="SELECT * FROM register where cif='$mycid' order by id";
									$result_cifinfo=mysql_query($cif_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cifinfo)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];
											$mycid=$row['cif'];
											$myl_type=$row['type_loan'];
											$purpose=$row['purpose'];
											break;
										}
									
									///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
									////
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
						if ($mycur=='USD'){
							$pro_amount = round(($overduepaid*$myPro)/100,2);
						}
						elseif ($mycur=='KHR'){
							$pro_amount = roundkhr(round(($overduepaid*$myPro)/100,2),$set);
						}
						echo "<tbody>";
						echo " <tr>
									<td align='center'>$classLoan</td>
									<td align='center' colspan='7'></td>
									<td align='center'>$check_record</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$myl_type</td>
									<td align='center'>$purpose</td>
									
									
									";
							
						echo "</tr>";
						echo " <tr>
									<td align='center'>$term</td>
									<td align='center'>$lid</td>
									<td align='center'>$registerdate</td>
									<td align='center'>$kh_bor</td>
									<td align='center'>$bor</td>
									<td align='center'>$kh_co_bor</td>
									<td align='center'>$co_bor</td>
									<td align='center'>$late</td>
									<td align='center'>-</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$myPro %</td>
									<td align='center'>$pro_amount</td>
									<td align='center'>$mybr</td>
									
									
									";
							
						echo "</tr>";
							$i++;
						}//End While Period
					}// end while
				} //End if condition
				//Forth Condition (Select All No ClassLoan and No Period)
				if(!empty($get_from)  && ($classLoan=='0') && ($period=='0') &&  ($br!='0') && ($mycur!='0')){
							
						/////////////////////////
						
						$cl_info="SELECT * FROM loan_classify group by id";
									$result_cl=mysql_query($cl_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cl)){
											$myF=$row['F'];
											$myT = $row['T'];
											$myPro= $row['provis'];
											$term = $row['term'];
											$classLoan = $row['short_desc'];

							$sql = "select * from (select distinct g.g_status, sch.ld,sch.repayment_date,r.register_date,r.borrower,r.kh_borrower,r.co_borrower,r.kh_co_borrower,datediff('$from',sch.repayment_date) late,sum(principal-prn_paid) overduepaid,((sch.balance+sch.principal)-sch.prn_paid) OstandingBalance from schedule sch,   loan_process l, glp_caption g,register r
where sch.ld=l.ld and l.glcode=g.glcode and l.cid=r.cif and rp='0' and r.cur='$mycur' and g.g_status='$term' and sch.br_no='$br'  group by sch.ld,late,r.borrower,sch.balance having late between '$myF' and '$myT') a
having late = datediff('$from',(select repayment_date from  schedule sch, loan_process l where sch.ld=l.ld and rp='0' and l.ld=a.ld order by repayment_date limit 1))";
							$result_last = mysql_query($sql) or die(mysql_error());

				
				
				//////////////////	
				
					
					$check_record=mysql_num_rows($result_last);
					
					if($i==1){
						if($check_record=='0'){
							echo"<script>alert('No Records Found!');</script>";
							echo"<script>window.close();</script>";
							exit();
						}
					}
					while($row=mysql_fetch_array($result_last))
					{
						$clas = $row['g_status'];
						$lid = $row['ld'];
						$registerdate = $row['register_date'];
						$bor = $row['borrower'];
						$kh_bor = $row['kh_borrower'];
						$co_bor = $row['co_borrower'];
						$kh_co_bor = $row['kh_co_borrower'];
						$late = $row['late'];
						$overduepaid = $row['overduepaid'];
						$os = $row['OstandingBalance'];
								
								///find cif info
						
						
									$cif_info="SELECT * FROM register where cif='$mycid' order by id";
									$result_cifinfo=mysql_query($cif_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cifinfo)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];
											$mycid=$row['cif'];
											$myl_type=$row['type_loan'];
											$purpose=$row['purpose'];
											break;
										}
									
									///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
									////
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
						if ($mycur=='USD'){
							$pro_amount = round(($overduepaid*$myPro)/100,2);
						}
						elseif ($mycur=='KHR'){
							$pro_amount = roundkhr(round(($overduepaid*$myPro)/100,2),$set);
						}
						echo "<tbody>";
						echo " <tr>
									<td align='center'>$classLoan</td>
									<td align='center' colspan='7'></td>
									<td align='center'>$check_record</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$myl_type</td>
									<td align='center'>$purpose</td>
									
									
									";
							
						echo "</tr>";
						echo " <tr>
									<td align='center'>$term</td>
									<td align='center'>$lid</td>
									<td align='center'>$registerdate</td>
									<td align='center'>$kh_bor</td>
									<td align='center'>$bor</td>
									<td align='center'>$kh_co_bor</td>
									<td align='center'>$co_bor</td>
									<td align='center'>$late</td>
									<td align='center'>-</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$myPro %</td>
									<td align='center'>$pro_amount</td>
									<td align='center'>$mybr</td>
									
									
									";
							
						echo "</tr>";
							$i++;
						}//End While Period
					}// end while
				} //End if condition
				//5 Condition (Select All No Period)
				if(!empty($get_from)  && ($classLoan!='0') && ($period=='0') &&  ($br!='0') && ($mycur!='0')){
							
						/////////////////////////
						
						$cl_info="SELECT * FROM loan_classify where short_desc='$classLoan' group by id";
									$result_cl=mysql_query($cl_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cl)){
											$myF=$row['F'];
											$myT = $row['T'];
											$myPro= $row['provis'];
											$term = $row['term'];
											$classLoan = $row['short_desc'];

							$sql = "select * from (select distinct g.g_status, sch.ld,sch.repayment_date,r.register_date,r.borrower,r.kh_borrower,r.co_borrower,r.kh_co_borrower,datediff('$from',sch.repayment_date) late,sum(principal-prn_paid) overduepaid,((sch.balance+sch.principal)-sch.prn_paid) OstandingBalance from schedule sch,   loan_process l, glp_caption g,register r
where sch.ld=l.ld and l.glcode=g.glcode and l.cid=r.cif and rp='0' and r.cur='$mycur' and g.g_status='$term' and sch.br_no='$br'  group by sch.ld,late,r.borrower,sch.balance having late between '$myF' and '$myT') a
having late = datediff('$from',(select repayment_date from  schedule sch, loan_process l where sch.ld=l.ld and rp='0' and l.ld=a.ld order by repayment_date limit 1))";
							$result_last = mysql_query($sql) or die(mysql_error());

				
				
				//////////////////	
				
					
					$check_record=mysql_num_rows($result_last);
					
					if($i==1){
						if($check_record=='0'){
							echo"<script>alert('No Records Found!');</script>";
							echo"<script>window.close();</script>";
							exit();
						}
					}
					while($row=mysql_fetch_array($result_last))
					{
						$clas = $row['g_status'];
						$lid = $row['ld'];
						$registerdate = $row['register_date'];
						$bor = $row['borrower'];
						$kh_bor = $row['kh_borrower'];
						$co_bor = $row['co_borrower'];
						$kh_co_bor = $row['kh_co_borrower'];
						$late = $row['late'];
						$overduepaid = $row['overduepaid'];
						$os = $row['OstandingBalance'];
								
								///find cif info
						
						
									$cif_info="SELECT * FROM register where cif='$mycid' order by id";
									$result_cifinfo=mysql_query($cif_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cifinfo)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];
											$mycid=$row['cif'];
											$myl_type=$row['type_loan'];
											$purpose=$row['purpose'];
											break;
										}
									
									///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
									////
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
						if ($mycur=='USD'){
							$pro_amount = round(($overduepaid*$myPro)/100,2);
						}
						elseif ($mycur=='KHR'){
							$pro_amount = roundkhr(round(($overduepaid*$myPro)/100,2),$set);
						}
						echo "<tbody>";
						echo " <tr>
									<td align='center'>$classLoan</td>
									<td align='center' colspan='7'></td>
									<td align='center'>$check_record</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$myl_type</td>
									<td align='center'>$purpose</td>
									
									
									";
							
						echo "</tr>";
						echo " <tr>
									<td align='center'>$term</td>
									<td align='center'>$lid</td>
									<td align='center'>$registerdate</td>
									<td align='center'>$kh_bor</td>
									<td align='center'>$bor</td>
									<td align='center'>$kh_co_bor</td>
									<td align='center'>$co_bor</td>
									<td align='center'>$late</td>
									<td align='center'>-</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$myPro %</td>
									<td align='center'>$pro_amount</td>
									<td align='center'>$mybr</td>
									
									
									";
							
						echo "</tr>";
							$i++;
						}//End While Period
					}// end while
				} //End if condition
				//6 Condition (Select All No Branch and No Classifiaction)
				if(!empty($get_from)  && ($classLoan=='0') && ($period!='0') &&  ($br=='0') && ($mycur!='0')){
							
						/////////////////////////
						
						$cl_info="SELECT * FROM loan_classify where term='$period' group by id";
									$result_cl=mysql_query($cl_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cl)){
											$myF=$row['F'];
											$myT = $row['T'];
											$myPro= $row['provis'];
											$term = $row['term'];
											$classLoan = $row['short_desc'];

							$sql = "select * from (select distinct g.g_status, sch.ld,sch.repayment_date,r.register_date,r.borrower,r.kh_borrower,r.co_borrower,r.kh_co_borrower,datediff('$from',sch.repayment_date) late,sum(principal-prn_paid) overduepaid,((sch.balance+sch.principal)-sch.prn_paid) OstandingBalance from schedule sch,   loan_process l, glp_caption g,register r
where sch.ld=l.ld and l.glcode=g.glcode and l.cid=r.cif and rp='0' and r.cur='$mycur' and g.g_status='$term'  group by sch.ld,late,r.borrower,sch.balance having late between '$myF' and '$myT') a
having late = datediff('$from',(select repayment_date from  schedule sch, loan_process l where sch.ld=l.ld and rp='0' and l.ld=a.ld order by repayment_date limit 1))";
							$result_last = mysql_query($sql) or die(mysql_error());

				
				
				//////////////////	
				
					
					$check_record=mysql_num_rows($result_last);
					
					if($i==1){
						if($check_record=='0'){
							echo"<script>alert('No Records Found!');</script>";
							echo"<script>window.close();</script>";
							exit();
						}
					}
					while($row=mysql_fetch_array($result_last))
					{
						$clas = $row['g_status'];
						$lid = $row['ld'];
						$registerdate = $row['register_date'];
						$bor = $row['borrower'];
						$kh_bor = $row['kh_borrower'];
						$co_bor = $row['co_borrower'];
						$kh_co_bor = $row['kh_co_borrower'];
						$late = $row['late'];
						$overduepaid = $row['overduepaid'];
						$os = $row['OstandingBalance'];
								
								///find cif info
						
						
									$cif_info="SELECT * FROM register where cif='$mycid' order by id";
									$result_cifinfo=mysql_query($cif_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cifinfo)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];
											$mycid=$row['cif'];
											$myl_type=$row['type_loan'];
											$purpose=$row['purpose'];
											break;
										}
									
									///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
									////
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
						if ($mycur=='USD'){
							$pro_amount = round(($overduepaid*$myPro)/100,2);
						}
						elseif ($mycur=='KHR'){
							$pro_amount = roundkhr(round(($overduepaid*$myPro)/100,2),$set);
						}
						echo "<tbody>";
						echo " <tr>
									<td align='center'>$classLoan</td>
									<td align='center' colspan='7'></td>
									<td align='center'>$check_record</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$myl_type</td>
									<td align='center'>$purpose</td>
									
									
									";
							
						echo "</tr>";
						echo " <tr>
									<td align='center'>$term</td>
									<td align='center'>$lid</td>
									<td align='center'>$registerdate</td>
									<td align='center'>$kh_bor</td>
									<td align='center'>$bor</td>
									<td align='center'>$kh_co_bor</td>
									<td align='center'>$co_bor</td>
									<td align='center'>$late</td>
									<td align='center'>-</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$myPro %</td>
									<td align='center'>$pro_amount</td>
									<td align='center'>$mybr</td>
									
									
									";
							
						echo "</tr>";
							$i++;
						}//End While Period
					}// end while
				} //End if condition
				//7 Condition (Select All No Classifiaction)
				if(!empty($get_from)  && ($classLoan=='0') && ($period!='0') &&  ($br!='0') && ($mycur!='0')){
							
						/////////////////////////
						
						$cl_info="SELECT * FROM loan_classify where term='$period' group by id";
									$result_cl=mysql_query($cl_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cl)){
											$myF=$row['F'];
											$myT = $row['T'];
											$myPro= $row['provis'];
											$term = $row['term'];
											$classLoan = $row['short_desc'];

							$sql = "select * from (select distinct g.g_status, sch.ld,sch.repayment_date,r.register_date,r.borrower,r.kh_borrower,r.co_borrower,r.kh_co_borrower,datediff('$from',sch.repayment_date) late,sum(principal-prn_paid) overduepaid,((sch.balance+sch.principal)-sch.prn_paid) OstandingBalance from schedule sch,   loan_process l, glp_caption g,register r
where sch.ld=l.ld and l.glcode=g.glcode and l.cid=r.cif and rp='0' and r.cur='$mycur' and g.g_status='$term'  and sch.br_no='$br'  group by sch.ld,late,r.borrower,sch.balance having late between '$myF' and '$myT') a
having late = datediff('$from',(select repayment_date from  schedule sch, loan_process l where sch.ld=l.ld and rp='0' and l.ld=a.ld order by repayment_date limit 1))";
							$result_last = mysql_query($sql) or die(mysql_error());

				
				
				//////////////////	
				
					
					$check_record=mysql_num_rows($result_last);
					
					if($i==1){
						if($check_record=='0'){
							echo"<script>alert('No Records Found!');</script>";
							echo"<script>window.close();</script>";
							exit();
						}
					}
					while($row=mysql_fetch_array($result_last))
					{
						$clas = $row['g_status'];
						$lid = $row['ld'];
						$registerdate = $row['register_date'];
						$bor = $row['borrower'];
						$kh_bor = $row['kh_borrower'];
						$co_bor = $row['co_borrower'];
						$kh_co_bor = $row['kh_co_borrower'];
						$late = $row['late'];
						$overduepaid = $row['overduepaid'];
						$os = $row['OstandingBalance'];
								
								///find cif info
						
						
									$cif_info="SELECT * FROM register where cif='$mycid' order by id";
									$result_cifinfo=mysql_query($cif_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_cifinfo)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
											$status=$row['type_cust'];
											$mycid=$row['cif'];
											$myl_type=$row['type_loan'];
											$purpose=$row['purpose'];
											break;
										}
									
									///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
									////
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
						if ($mycur=='USD'){
							$pro_amount = round(($overduepaid*$myPro)/100,2);
						}
						elseif ($mycur=='KHR'){
							$pro_amount = roundkhr(round(($overduepaid*$myPro)/100,2),$set);
						}
						echo "<tbody>";
						echo " <tr>
									<td align='center'>$classLoan</td>
									<td align='center' colspan='7'></td>
									<td align='center'>$check_record</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$status</td>
									<td align='center'>$myl_type</td>
									<td align='center'>$purpose</td>
									
									
									";
							
						echo "</tr>";
						echo " <tr>
									<td align='center'>$term</td>
									<td align='center'>$lid</td>
									<td align='center'>$registerdate</td>
									<td align='center'>$kh_bor</td>
									<td align='center'>$bor</td>
									<td align='center'>$kh_co_bor</td>
									<td align='center'>$co_bor</td>
									<td align='center'>$late</td>
									<td align='center'>-</td>
									<td align='center'>$overduepaid</td>
									<td align='center'>$os</td>
									<td align='center'>$recom_name</td>
									<td align='center'>$myPro %</td>
									<td align='center'>$pro_amount</td>
									<td align='center'>$mybr</td>
									
									
									";
							
						echo "</tr>";
							$i++;
						}//End While Period
					}// end while
				} //End if condition
		?>
       					 <tr align="center" bgcolor="#CCFFFF" height="28">
								<td colspan="6">&nbsp;</td>
								<td align="right"><font color="#FF0000"><b>Total: </b></font></td>	
								<td colspan="3" align="center"><?php echo $cur .' '.formatMoney($t[grand_total],true) ; ?></td>
                                <td colspan="5" align="center">&nbsp;</td>
							</tr>
                          </tbody>	
</table>	
</center>
</body>
</html>