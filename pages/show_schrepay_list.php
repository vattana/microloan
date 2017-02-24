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
<title>Schedule Repayment List - OLMS</title>
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
				if(empty($get_from)&& empty($get_to) && ($mycur=='0') && ($co=='0') && ($br=='0')){
					echo "<h2><u>Schedule Repayment Customer List</u></h2>";
					}
				else if(!empty($get_from)&& !empty($get_to)){
					echo "<h2><u>Schedule Repayment Customer List</u></h2>";
					echo"
					<p>From <b>$myfrom</b> To <b>$myto</b><br/> Response CO : <b>$co</b> ,Branch : <b>$mybr</b> </p>
					";
				}
				else{	
					echo "<h2><u>Schedule Repayment Customer List</u></h2>";
					echo"
					<p>Currency : <b>$mycur</b> CO Name : <b>$co</b>, Branch : <b>$mybr</b></p>
					";
				}
			 ?>
			<table width="2000" cellpadding="0" cellspacing="0" height="auto" class="form_border" border="1" 
            style="margin:5px; border-collapse:collapse">
							<thead>
							<tr align="center" height="28" style="background:#03F; color:#FFFFFF">
								<td><b>N<sup>o</sup></b></td>
                                <td width="100"><b>Date</b></td>
								<td width="150"><b>LD</b></td>
                                <td><b>Response CO</b></td>
                                <td><b>ឈ្មោះ</b></td>
                                <td><b>Cust Name</b></td>
								<td><b>HouseNo</b></td>
								<td><b>St-No</b></td>
								<td><b>Village</b></td>
								<td><b>Commune</b></td>	
								<td><b>District</b></td>
								<td><b>Province</b></td>
								<td><b>Phone</b></td>
                                <td><b>Sch-Principal</b></td>
                                <td><b>Sch-Interest</b></td>
                                <td><b>Late Days</b></td>
								<td><b>Act-Principal</b></td>
                                <td><b>Act-Interest</b></td>
                                <td><b>Penalty</b></td>
                                <td><b>Total</b></td>
                                <td><b>Balance</b></td>
                                <td><b>Branch</b></td>
							</tr>
                           </thead>					
		<?php
		
				mysql_query ('SET NAMES UTF8');	
				/////////////////
				if(!empty($from) && !empty($to) && ($co=='0') && ($br=='0') && ($mycur!='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND currency='$mycur' AND rp='0' Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND currency='$mycur' AND rp='0'";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con1');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($from) && !empty($to) && ($co=='0') && ($br=='0') && ($mycur=='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND rp='0' Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND rp='0'";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con2');</script>";*/
				}
				//////////////////
				/////////////////
				if(!empty($from) && !empty($to) && ($co!='0') && ($br=='0') && ($mycur!='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND currency='$mycur' AND response_co='$co' AND rp='0' Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND currency='$mycur' AND response_co='$co' AND rp='0'";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con3');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($from) && !empty($to) && ($co!='0') && ($br!='0') && ($mycur!='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND currency='$mycur' AND response_co='$co' AND rp='0' AND br_no='$br' Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND currency='$mycur' AND response_co='$co' AND rp='0' AND br_no='$br'";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con4');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($from) && !empty($to) && ($co!='0') && ($br=='0') && ($mycur=='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND response_co='$co' AND rp='0' Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' 
							AND response_co='$co' AND rp='0'";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con5');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($from) && !empty($to) && ($co!='0') && ($br!='0') && ($mycur=='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND response_co='$co' AND rp='0' AND br_no='$br' Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND response_co='$co' AND rp='0' AND br_no='$br'";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con6');</script>";*/
				}
				//////////////////
				/////////////////
				if(!empty($from) && !empty($to) && ($co=='0') && ($br!='0') && ($mycur!='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND currency='$mycur' AND rp='0' AND br_no='$br' Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND currency='$mycur' AND rp='0' AND br_no='$br'";
							$result_sch = mysql_query($sql_sch) or die(mysql_error());
							$t = mysql_fetch_array($result_sch);
						/////////////////////
						/*echo"<script>alert('con7');</script>";*/
				}
				//////////////////	
				/////////////////
				if(!empty($from) && !empty($to) && ($co=='0') && ($br!='0') && ($mycur=='0')){
						//////////////////
							$sql = "SELECT * FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' AND br_no='$br' AND rp='0' Order By response_co,repayment_date ASC;";
							$result = mysql_query($sql) or die(mysql_error());
						/////////////////////
						/////////////////////////
							$sql_sch = "SELECT SUM(total) AS grand_total FROM `schedule` WHERE repayment_date BETWEEN '$from' AND '$to' 
							AND br_no='$br' AND rp='0'";
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
						$sch_prn=$row['principal'];
						$prn_paid=$row['prn_paid'];
						$int_paid=$row['int_paid'];
						$total_paid=($prn_paid+$int_paid);
						$total_sch=$row['total'];
						$sch_int=$row['interest'];
						$days=dateDiff(date('Y-m-d',strtotime($repayment_date)),$get_from);
						$sch_total=formatMoney(round($total_sch-$total_paid,2));
						//get total
						$mytotal=round($total_sch-$total_paid,2);
						$lastTT=round(($lastTT+$mytotal),2);
						$mydisTotalfinal=formatMoney($lastTT,true);
						//Get Total Principle
						$mytprin = round($sch_prn-$prn_paid,2);
						$lastTP=round(($lastTP+$mytprin),2);
						$mydisTotalPrfinal=formatMoney($lastTP,true);
						//Get Total Interest
						$mytint = round($sch_int-$int_paid,2);
						$lastTI=round(($lastTI+$mytint),2);
						$mydisTotalintfinal=formatMoney($lastTI,true);
						
						if($mycur=='KHR'){
							$sch_total=formatMoney(roundkhr($total_sch-$total_paid,$set));
							$mydisTotalfinal=formatMoney(roundkhr($lastTT,$set),true);
							$mydisTotalPrfinal=formatMoney(roundkhr($lastTP,$set),true);
							$mydisTotalintfinal=formatMoney(roundkhr($lastTI,$set),true);
						}
						$branch=$row['br_no'];
						$mycurrency=$row['currency'];
						///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
										}
						////
						///find approval info
								$cobor_info="SELECT * FROM register where cif='$cid'";
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
											break;
										}
						//---end find approval----//	
					// get total paid
						
							$sql_tp = "SELECT SUM(prn_paid) AS myGtotal FROM `schedule` WHERE ld='$ld' and rp<>'6'";
							$result_tp= mysql_query($sql_tp) or die(mysql_error());
								$tp = mysql_fetch_array($result_tp);
									$mytp = $tp['myGtotal'];							
					///
					/// balance
						
							$sql_bl = "SELECT SUM(principal) AS myGtotal1 FROM `schedule` WHERE ld='$ld' AND dis='1' and rp<>'6'";
							$result_bl= mysql_query($sql_bl) or die(mysql_error());
								$tb = mysql_fetch_array($result_bl);
									$mytb = $tb['myGtotal1'];
									$remain_bl = round(($mytb-$mytp),2);
									$myremain=formatMoney($remain_bl,true);
					//
					/// accrued pn
						$acrued_pn=formatMoney($acrued_pn,2);
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
					/*echo"<script>alert('$mytb,$mytp,$remain_bl');</script>";*/
					
					$phone=wordwrap("$tel",3, " ", true); 
						
						echo"
						<tr>
									<td align='center'>$i</td>
									<td align='center'>$repayment_date</td>
									<td align='center'>$ld</td>
									<td align='center'>$myco</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$hoNo</td>
									<td align='center'>$stNo</td>
									<td align='center'>$get_village</td>
									<td align='center'>$get_commune </td>
									<td align='center'>$get_district</td>
									<td align='center'>$get_province</td>
									<td align='center'>$phone</td>
									<td align='center'>$sch_prn</td>
									<td align='center'>$sch_int</td>
									<td align='center'>$days</td>
									<td align='center'>$sch_prn</td>
									<td align='center'>$sch_int</td>
									<td align='center'>$acrued_pn</td>
									<td align='center'>$sch_total</td>
									<td align='center'>$myremain</td>
									<td align='center'>$br_name</td>
									";
							
						echo "</tr>";
							$i++;
				}// end while
				
		?>
       					 <tr align="center" bgcolor="#CCFFFF" height="28">
								<td colspan="6">&nbsp;</td>
                                
								<td colspan="2" align="right"><font color="#FF0000"><b>Total Principle: </b></font></td>	
								<td colspan="3" align="center"><?php echo $mycurrency .' '.$mydisTotalPrfinal ; ?></td>
                                <td colspan="2" align="right"><font color="#FF0000"><b>Total Interest: </b></font></td>	
								<td colspan="3" align="center"><?php echo $mycurrency .' '.$mydisTotalintfinal ; ?></td>
                                <td colspan="4" align="center">&nbsp;</td>
							</tr>
                          </tbody>	
</table>	
</center>
</body>
</html>