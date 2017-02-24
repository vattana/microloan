<?php
    session_start();
    if(empty($_SESSION['usr'])) header('location:login.php');
?>
<link rel="stylesheet" type="text/css" href="../css/unicode.css" media="all"/>
<style type="text/css">
	p, li, td	{font:normal 10px/10px Arial;}
		table	{border:0;border-collapse:collapse;}
		td		{padding:3px; padding-left:10px; text-align:left;}
		tr.odd	{background:#e4dcd9;}
		tr.highlight	{background:#FFF;}
		tr.selected		{background:#FFF;color:#00F;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Total Interest And O/S:</title>
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
												
			$type_of_staff=$_POST['staff'];
			//$performance=$_POST['performance'];
			$br_no=$_POST['br'];
			$getCur=$_POST['cur'];
			$from=date('Y-m-d',strtotime($_POST['from']));
			$to=date('Y-m-d',strtotime($_POST['to']));
			$myfrom= date('D,d/m/Y',strtotime($from));
			$myto= date('D,d/m/Y',strtotime($to));
			$staff=$_POST['staff'];
			///find branch name
					$br_info="SELECT * FROM br_ip_mgr where br_no='$br_no' group by br_no";
						$result_br=mysql_query($br_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_br)){
								$br_name=$row['br_name'];
							}
				////
			/*echo"<script>alert('$type_of_staff,$performance,$br_no,$from,$to');</script>";*/
					echo "<h2><u>Total Interest And O/S</u></h2>";
					echo"
					<p>From: <b>$myfrom</b> To <b>$myto</b></p>
					";
			 ?>
			<table width="1000px" cellpadding="0" cellspacing="0" height="auto" class="form_border" style="margin:0px; border-collapse:collapse" border="1" >
							<thead>
                        
							<tr align="center" style=" background-color:#06F;color:#FFF;" height="28">
								<td width="100"><b>No</b></td>
                                <td width="160"><b>Saving Code</b></td>
                           		<td width="160"><b>CIF Code</b></td>
                                <td width="180"><b>Name</b></td>
                                <td width="180"><b>Sex</b></td>
                                <td width="180"><b>Date Of Birth</b></td>
                                <td width="180"><b>Total Interest</b></td>
                                <td width="180"><b>Total O/S</b></td>
                                <td width="180"><b>Currency</b></td>
							</tr>	
							</thead>
                            <tbody>
                            	<?php
									$dp_info="Select i.ld, i.cid,borrower,sex,cust_dob,sum(inter) inte,d.amount- (case when (select sum(w.amount) from witdraw w where w.ld=d.ld) is null then 0 Else (select sum(w.amount) from witdraw w where w.cid=d.cid) end) amount,d.cur from accrued_sinter i,register r,deposit d where i.ld=d.ld and i.cid=r.cif and r.type_cust ='new' and  i.idate between '$from' and '$to' and d.cur='$getCur'  group by i.cid,borrower,sex,cust_dob,d.cur,I.ld";
						$result_dp=mysql_query($dp_info) or die (mysql_error());
								$i=1;
								$tint=0;
								$tos=0;
							while($row = mysql_fetch_array($result_dp)){
								$ld=$row['ld'];
								$cid=$row['cid'];
								$borrower = $row['borrower'];
								$sex = $row['sex'];
								$dob = $row['cust_dob'];
								if ($getCur=='KHR'){
									$inte = formatmoney(roundkhr($row['inte'],$set));
									$amount = formatmoney(roundkhr($row['amount'],$set));
								}
								else if($getCur=='THB'){
									$inte = formatmoney(intval($row['inte'],2));
									$amount = formatmoney(intval($row['amount'],2));
								}
								else{
									$inte = formatmoney(round($row['inte'],2));
									$amount = formatmoney(round($row['amount'],2));
								}
								$cur = $row['cur'];
								$tint = $tint + $row['inte'];
								$tos = $tos+ $row['amount'];
								echo "<tr>
										<td>$i</td>
										<td>$ld</td>
										<td>$cid</td>
										<td>$borrower</td>
										<td>$sex</td>
										<td>$dob</td>
										<td>$inte</td>
										<td>$amount</td>
										<td>$cur</td>
								
									</tr>
									";
									$i=$i+1;
							}
								?>
                            	
                                
							<!--
        					<tr align="center" bgcolor="#99FFFF" height="28">
								<td>&nbsp;</td>
								<td align="center"><font color="#FF0000"><b>Grand Total: </b></font></td>	
								<td align="center"><?php echo $total_all_new_client; ?></td>
                                <td align="center"><?php echo $total_all_old_client; ?></td>
                                <td align="center"><?php echo $total_all_total_client; ?></td>
                                <td align="center"><?php echo $mytotal_all_new_client_amt; ?></td>
                                <td align="center"><?php echo $mytotal_all_old_client_amt; ?></td>
                                <td align="center"><?php echo $mytotal_all_total_client_amt; ?></td>
							</tr>-->
               			<tr align="center" style=" background-color:#FC9;color:#FFF;" height="28">
								<td width="100" colspan="6"><b>Grand Total</b></td>
                                <td width="180"><b><?
								 	if ($getCur=='KHR'){
										$tint = formatmoney(roundkhr($tint,$set));
									}
									else if($getCur=='THB'){
										$tint = formatmoney(intval($tint,2));
									}
									else{
										$tint = formatmoney(round($tint,2));
									}
								 	echo $tint; 
								 
								 ?></b></td>
                                <td width="180" colspan="2"><b><? 
									if ($getCur=='KHR'){
										$tos = formatmoney(roundkhr($tos,$set));
									}
									else if($getCur=='THB'){
										$tos = formatmoney(intval($tos,2));
									}
									else{
										$tos = formatmoney(round($tos,2));
									}
								 	echo $tos; ?></b></td>
                       
						</tr>	
               </tbody>	
</table>

</center>
<br />
<center>
<!--<table width="55%">
	<tr>
    	<td width="50%">Approved By</td>
        <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepared By</td>
    </tr>
</table>-->
</center>
</body>
</html>