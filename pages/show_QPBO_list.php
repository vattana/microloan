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
		
	#odd{ background:#ffff99;}
	#En{background:#e4dcd9;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quality Portfolio By Officer List:</title>
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
			$lt = $_POST['lt'];
			$staff=$_POST['staff'];
			///find branch name
					$br_info="SELECT * FROM br_ip_mgr where br_no='$br_no' group by br_no";
						$result_br=mysql_query($br_info) or die (mysql_error());
							while($row = mysql_fetch_array($result_br)){
								$br_name=$row['br_name'];
							}
				////
			/*echo"<script>alert('$type_of_staff,$performance,$br_no,$from,$to');</script>";*/
					echo "<h2><u>Quality Portfolio By Officer</u></h2>";
					echo"
					<p>From: <b>$myfrom</b> To <b>$myto</b></p>
					";
			 ?>
			<table width="1000px" cellpadding="0" cellspacing="0" height="auto" class="form_border" style="margin:0px; border-collapse:collapse" border="1" >
							<thead>
                        
							<tr align="center" style=" background-color:#06F;color:#FFF;" height="28">
								<td width="180"><b>Officer</b></td>
								<td width="180"><b>Total</b></td>
								<?
								ini_set('max_execution_time', 300);	
									if ($type_of_staff=='0'){
										$i=2;
										
										if($lt=='0'){
											$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9' group by co,cur";	
										}
										else if($lt=='1'){
											$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and loan_type='individual' and dis='1' and status<>'9' group by co,cur";	
										}
										else{
											$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and loan_type='group' and status<>'9' and dis='1' group by co,cur";	
										}
										$result_br=mysql_query($co_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$co_name=$row['co'];
											$i++;
											echo"<td width=180>$co_name</td>";
										}
									}
									else{
										$i=2;
										if($lt=='0'){
											$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and cur='$getCur' and dis='1' group by co,cur";	
										}
										else if($lt=='1'){
											$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and cur='$getCur' and dis='1' and loan_type='individual' group by co,cur";	
										}
										else{
											$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and cur='$getCur' and dis='1' and loan_type='group' group by co,cur";	
										}
										$result_br=mysql_query($co_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$co_name=$row['co'];
											$i++;
									
											echo"<td>$co_name</td>";
										}
									}
								?>
                                	
							</tr>	
							</thead>
                            <tbody>
                            	<tr align="center" bgcolor="#000000" style="color:#000" height="28" id="En">
									<td colspan="<? echo $i; ?>"><font size="-1">PORTFOLIO SIZE (End of Period)</font></td>
                                </tr>
                                     <?
									 	if($lt=='0' || $lt=='2')
										{
											if($lt=='1'){
												echo "<tr align='center' style=' background-color:#FF9;color:#333;' id='odd' height='28'>";	
											}
											else{
												echo "<tr align='center' style=' background-color:#FF9;color:#333;' id='En' height='28'>";	
											}
											
											echo "<td><font size='-1'># Group Loans Outstanding</font></td>"; 	
											if ($type_of_staff=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE loan_type='group' and cur='$getCur' and dis='1' and status<>'9'  group by co,cur order by co";
												$result_br=mysql_query($co_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_br)){
													$co_name=$row['co'];
													
													//Count
													$count_info="SELECT count(ld) count,co,cur FROM `loan_process` WHERE loan_type='group' and dis='1' and co='$co_name' and cur='$getCur' and status<>'9' group by co,cur order by co";
													$result_count=mysql_query($count_info) or die (mysql_error());
													while($row = mysql_fetch_array($result_count)){
														$count=$row['count'];
														$Total += $count;
													}
													//End
												}
											}
											else{
												 $co_info="SELECT co FROM `loan_process` WHERE loan_type='group' and cur='$getCur' and co='$staff' and dis='1'  and status<>'9' group by co,cur order by co";
												$result_br=mysql_query($co_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_br)){
													$co_name=$row['co'];
													
													//Count
													$count_info="SELECT count(ld) count,co,cur FROM `loan_process` WHERE loan_type='group' and dis='1' and co='$co_name' and cur='$getCur' and status<>'9' group by co,cur order by co";
													$result_count=mysql_query($count_info) or die (mysql_error());
													while($row = mysql_fetch_array($result_count)){
														$count=$row['count'];
														$Total += $count;
													}
													//End
												}
											}
										
											if ($Total==0){
												
												$Total='-';
											}
											echo "<td>$Total</td>";
										}
									?>
                                    <?
										if($lt=='0' || $lt=='2')
										{
									
											if ($type_of_staff=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE loan_type='group' and cur='$getCur' and dis='1' and status<>'9' group by co,cur order by co";
												$result_br=mysql_query($co_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_br)){
													$co_name=$row['co'];
													
													//Count
													$count_info="SELECT count(ld) count,co,cur FROM `loan_process` WHERE loan_type='group' and dis='1' and co='$co_name' and cur='$getCur' and status<>'9' group by co,cur order by co";
													$result_count=mysql_query($count_info) or die (mysql_error());
													while($row = mysql_fetch_array($result_count)){
														$count=$row['count'];
														$Total += $count;
														echo"<td>$count</td>";
													}
													//End
												}
											}
											else{
												 $co_info="SELECT co FROM `loan_process` WHERE loan_type='group' and cur='$getCur' and dis='1' and co='$staff' and status<>'9' group by co,cur order by co";
												$result_br=mysql_query($co_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_br)){
													$co_name=$row['co'];
													
													//Count
													$count_info="SELECT count(ld) count,co,cur FROM `loan_process` WHERE loan_type='group' and dis='1' and co='$co_name' and cur='$getCur' and status<>'9' group by co,cur order by co";
													$result_count=mysql_query($count_info) or die (mysql_error());
													while($row = mysql_fetch_array($result_count)){
														$count=$row['count'];
														$Total += $count;
														echo"<td>$count</td>";
													}
													//End
												}
											}
									   
											if ($Total==0){
												for ($j=0;$j<$i-2;$j++){
													echo"<td>-</td>";
												}
												$Total='-';
											}
											echo "</tr>";
										}
									?>
                                    <?
										if ($lt=='0' || $lt=='1')
										{
											if ($lt=='1'){
												echo "<tr align='center' bgcolor='#000000' style='color:#000' id='odd' height='28'>";
											}
											else
											{
												echo "<tr align='center' bgcolor='#000000' style='color:#000' id='En' height='28'>";
											}
											
											echo "<td><font size='-1'># Loans Outstanding</font></td>";
											if ($type_of_staff=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE   cur='$getCur' and dis='1'  and status<>'9' group by co,cur";
												$result_br=mysql_query($co_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_br)){
													$co_name=$row['co'];
													//Count
													$count_info="SELECT count(ld) count,co,cur FROM `loan_process` WHERE   co='$co_name' and dis='1' and cur='$getCur' and status<>'9' group by co,cur";
													$result_count=mysql_query($count_info) or die (mysql_error());
													while($row = mysql_fetch_array($result_count)){
														$count=$row['count'];
														$Total += $count;
														
													}
													//End
												}
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE   cur='$getCur' and co='$staff' and status<>'9' and dis='1'  group by co,cur";
												$result_br=mysql_query($co_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_br)){
													$co_name=$row['co'];
													//Count
													$count_info="SELECT count(ld) count,co,cur FROM `loan_process` WHERE co='$co_name' and dis='1' and cur='$getCur' and status<>'9' group by co,cur";
													$result_count=mysql_query($count_info) or die (mysql_error());
													while($row = mysql_fetch_array($result_count)){
														$count=$row['count'];
														$Total += $count;
					
													}
													//End
												}
											}
										
											if ($Total==0){
												$Total='-';
											}
											echo "<td>$Total</td>";
										}
                                    ?>

                                     <?
										if ($lt=='0' || $lt=='1')
										{
											if ($type_of_staff=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE  cur='$getCur' and dis='1' and status<>'9' group by co,cur";
												$result_br=mysql_query($co_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_br)){
													$co_name=$row['co'];
													//Count
													$count_info="SELECT count(ld) count,co,cur FROM `loan_process` WHERE  co='$co_name' and dis='1' and cur='$getCur' and status<>'9' group by co,cur";
													$result_count=mysql_query($count_info) or die (mysql_error());
													while($row = mysql_fetch_array($result_count)){
														$count=$row['count'];
														$Total += $count;
														echo"<td>$count</td>";
													}
													//End
												}
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE  cur='$getCur' and co='$staff' and status<>'9' and dis='1'  group by co,cur";
												$result_br=mysql_query($co_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_br)){
													$co_name=$row['co'];
													//Count
													$count_info="SELECT count(ld) count,co,cur FROM `loan_process` WHERE co='$co_name' and dis='1' and cur='$getCur' and status<>'9' group by co,cur";
													$result_count=mysql_query($count_info) or die (mysql_error());
													while($row = mysql_fetch_array($result_count)){
														$count=$row['count'];
														$Total += $count;
														echo"<td>$count</td>";
													}
													//End
												}
											}
											
											if ($Total==0){
												for ($j=0;$j<$i-2;$j++){
													echo"<td>-</td>";
												}
												$Total='-';
											}
											echo "</tr>";
										}
                                    ?>
                                    <?
										if($lt=='0'){
											echo "<tr align='center'  id='odd' height='28'>";
										}
										else{
											echo "<tr align='center' id='En' height='28'>";	
										}
                                    ?>
                                
                                    <td><font size="-1">Value of Loans Outstanding</font></td>
                                    <?
									
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9'";	
											}
											else if($lt=='1'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9'";	
											}
											else{
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and loan_type='group' and dis='1' and status<>'9' group by co,cur";	
											}
                                            
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												$ld = $row['ld'];
												//Count
												
												
                                                $os_info="SELECT (balance+principal)-prn_paid as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc limit 1";
												$result_os=mysql_query($os_info) or die (mysql_error());
												$OS=0;
												while($row = mysql_fetch_array($result_os)){
													if ($getCur=='KHR'){
														$OS=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$OS=intval($row['OS'],2);
													}
													else{
														$OS=round($row['OS'],2);
													}
													
													$Total += $OS;
													$OS = formatmoney($OS,true);
													
												}
												
												//End
                                            }
											
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and status<>'9'";	
											}
											else if($lt=='1'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and status<>'9'";	
											}
											else{
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												$ld = $row['ld'];
												//Count
												
												
                                                $os_info="SELECT (balance+principal)-prn_paid as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc limit 1";
												$result_os=mysql_query($os_info) or die (mysql_error());
												$OS=0;
												while($row = mysql_fetch_array($result_os)){
													if ($getCur=='KHR'){
														$OS=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$OS=intval($row['OS'],2);
													}
													else{
														$OS=round($row['OS'],2);
													}
													
													$Total += $OS;
													$OS = formatmoney($OS,true);
						
												}
											
												//End
                                            }
                                        }
								
										if ($Total==0){
											
											$Total='-';
										}
                                    ?>
                                     <td><? echo formatmoney($Total,true); ?></td>
                                      <?

                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												if($lt=='0'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$co_name' and dis='1' and status<>'9'";	
												}
												else if($lt=='1'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and co='$co_name' and status<>'9'";	
												}
												else{
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and co='$co_name' and status<>'9' group by co,cur";	
												}
												$result_ld=mysql_query($ld_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_ld)){
													$co_name=$row['co'];
													$ld = $row['ld'];
													$os_info="SELECT (balance+principal)-prn_paid as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc limit 1";
													$result_os=mysql_query($os_info) or die (mysql_error());
													$OS=0;
													while($row = mysql_fetch_array($result_os)){
														if ($getCur=='KHR'){
															$OS=roundkhr($row['OS'],$set);
														}
														else if($getCur=='THB'){
															$OS=intval($row['OS'],2);
														}
														else{
															$OS=round($row['OS'],2);
														}
														
														$Total += $OS;
														
													}
													
					
												}
                                                	
												$Total = formatmoney($Total,true);
													echo"<td>$Total</td>";
													if($OS==0){
														echo"<td>-</td>";
													}								
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and dis='1' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and dis='1' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												if($lt=='0'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$co_name' and dis='1' and status<>'9'";	
												}
												else if($lt=='1'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and co='$co_name' and status<>'9'";	
												}
												else{
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and co='$co_name' and status<>'9' group by co,cur";	
												}
												$result_ld=mysql_query($ld_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_ld)){
													$co_name=$row['co'];
													$ld = $row['ld'];
													$os_info="SELECT (balance+principal)-prn_paid as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc limit 1";
													$result_os=mysql_query($os_info) or die (mysql_error());
													$OS=0;
													while($row = mysql_fetch_array($result_os)){
														if ($getCur=='KHR'){
															$OS=roundkhr($row['OS'],$set);
														}
														else if($getCur=='THB'){
															$OS=intval($row['OS'],2);
														}
														else{
															$OS=round($row['OS'],2);
														}
														
														$Total += $OS;
														
													}
													
					
												}
                                                	
												$Total = formatmoney($Total,true);
													echo"<td>$Total</td>";
													if($OS==0){
														echo"<td>-</td>";
													}								
												//End
                                            }
                                        }
								
										if ($Total==0){
											$T=$i;
											$i=0;
											for ($j=0;$j<$i-2;$j++){
												echo"<td>-</td>";
											}
											$i=$T;
											$Total='-';
										}
                                    ?>
								</tr>
                                <?
										if($lt=='0'){
											echo " <tr align='center' id='En' height='28'>";
										}
										else{
											echo "<tr align='center' id='odd' height='28'>";	
										}
                                    ?>
                                
                                    <td><font size="-1">Value of Interest Outstanding</font></td>
                                    <?
									
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9'";	
											}
											else if($lt=='1'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9'";	
											}
											else{
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and loan_type='group' and dis='1' and status<>'9' group by co,cur";	
											}
                                            
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												$ld = $row['ld'];
												//Count
												
												
                                                $os_info="SELECT (interest-int_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc ";
												$result_os=mysql_query($os_info) or die (mysql_error());
												$OS=0;
												while($row = mysql_fetch_array($result_os)){
													if ($getCur=='KHR'){
														$OS=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$OS=intval($row['OS'],2);
													}
													else{
														$OS=round($row['OS'],2);
													}
													
													$Total += $OS;
													$OS = formatmoney($OS,true);
													
												}
												
												//End
                                            }
											
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and status<>'9'";	
											}
											else if($lt=='1'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and status<>'9'";	
											}
											else{
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												$ld = $row['ld'];
												//Count
												
												
                                                $os_info="SELECT (interest-int_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc";
												$result_os=mysql_query($os_info) or die (mysql_error());
												$OS=0;
												while($row = mysql_fetch_array($result_os)){
													if ($getCur=='KHR'){
														$OS=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$OS=intval($row['OS'],2);
													}
													else{
														$OS=round($row['OS'],2);
													}
													
													$Total += $OS;
													$OS = formatmoney($OS,true);
						
												}
											
												//End
                                            }
                                        }
								
										if ($Total==0){
											
											$Total='-';
										}
                                    ?>
                                     <td><? echo formatmoney($Total,true); ?></td>
                                     <?

                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												if($lt=='0'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$co_name' and dis='1' and status<>'9'";	
												}
												else if($lt=='1'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and co='$co_name' and status<>'9'";	
												}
												else{
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and co='$co_name' and status<>'9' group by co,cur";	
												}
												$result_ld=mysql_query($ld_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_ld)){
													$co_name=$row['co'];
													$ld = $row['ld'];
													$os_info="SELECT (interest-int_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' and ln.status<>'9' order by OS desc";
													$result_os=mysql_query($os_info) or die (mysql_error());
													$OS=0;
													while($row = mysql_fetch_array($result_os)){
														if ($getCur=='KHR'){
															$OS=roundkhr($row['OS'],$set);
														}
														else if($getCur=='THB'){
															$OS=intval($row['OS'],2);
														}
														else{
															$OS=round($row['OS'],2);
														}
														
														$Total += $OS;
														
													}
													
					
												}
                                                	
												$Total = formatmoney($Total,true);
													echo"<td>$Total</td>";
													if($OS==0){
														echo"<td>-</td>";
													}								
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												if($lt=='0'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$co_name' and dis='1'";	
												}
												else if($lt=='1'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and co='$co_name'";	
												}
												else{
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and co='$co_name' group by co,cur";	
												}
												$result_ld=mysql_query($ld_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_ld)){
													$co_name=$row['co'];
													$ld = $row['ld'];
													$os_info="SELECT (interest-int_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc";
													$result_os=mysql_query($os_info) or die (mysql_error());
													$OS=0;
													while($row = mysql_fetch_array($result_os)){
														if ($getCur=='KHR'){
															$OS=roundkhr($row['OS'],$set);
														}
														else if($getCur=='THB'){
															$OS=intval($row['OS'],2);
														}
														else{
															$OS=round($row['OS'],2);
														}
														
														$Total += $OS;
														
													}
													
					
												}
                                                	
												$Total = formatmoney($Total,true);
											
													echo"<td>$Total</td>";
													if($OS==0){
														echo"<td>-</td>";
													}								
												//End
                                            }
                                        }
								
										if ($Total==0){
											$T=$i;
											$i=0;
											for ($j=0;$j<$i-2;$j++){
												echo"<td>-</td>";
											}
											$i=$T;
											$Total='-';
										}
                                    ?>
								</tr>
                                <?
										if($lt=='0'){
											echo " <tr align='center' id='odd' height='28'>";
										}
										else{
											echo "<tr align='center' id='En' height='28'>";	
										}
                                    ?>
                                    <td><font size="-1">Value of Total Outstanding</font></td>
                                    <?
									
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9'";	
											}
											else if($lt=='1'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9'";	
											}
											else{
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and loan_type='group' and dis='1' and status<>'9' group by co,cur";	
											}
                                            
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												$ld = $row['ld'];
												//Count
												
												
                                                $os_info="SELECT (balance+principal)-prn_paid as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc limit 1";
												
												$result_os=mysql_query($os_info) or die (mysql_error());
												
												$OS=0;
												while($row = mysql_fetch_array($result_os)){
													if ($getCur=='KHR'){
														$OS=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$OS=intval($row['OS'],2);
													}
													else{
														$OS=round($row['OS'],2);
													}
													
													$Total += $OS;
													$OS = formatmoney($OS,true);
												}
												
												$int_info="SELECT (interest-int_paid) as os,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc ";
													$result_int=mysql_query($int_info) or die (mysql_error());
													$interest=0;
													while($row1 = mysql_fetch_array($result_int)){
														$interest = $row1['os'];	
														$Total += $interest;
														
													}
												
												//End
                                            }
											
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and status<>'9'";	
											}
											else if($lt=='1'){
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and status<>'9'";	
											}
											else{
												$co_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												$ld = $row['ld'];
												//Count
												
												
                                                $os_info="SELECT (balance+principal)-prn_paid as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc limit 1";
												
												$result_os=mysql_query($os_info) or die (mysql_error());
												
												$OS=0;
												while($row = mysql_fetch_array($result_os)){
													if ($getCur=='KHR'){
														$OS=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$OS=intval($row['OS'],2);
													}
													else{
														$OS=round($row['OS'],2);
													}
													
													$Total += $OS;
													$OS = formatmoney($OS,true);
												}
												
												$int_info="SELECT (interest-int_paid) as os,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc ";
													$result_int=mysql_query($int_info) or die (mysql_error());
													$interest=0;
													while($row1 = mysql_fetch_array($result_int)){
														$interest = $row1['os'];	
														$Total += $interest;
														
													}
											
												//End
                                            }
                                        }
								
										if ($Total==0){
											
											$Total='-';
										}
                                    ?>
									
                                     <td><? if($Total=='-'){ 
									 	echo $Total;
									 }
									 else{
									   echo formatmoney($Total,true); 
									 }
									   ?>
                                     
                                       </td>
                                       <?

                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and status<>'9' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												if($lt=='0'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$co_name' and dis='1' and status<>'9'";	
												}
												else if($lt=='1'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and co='$co_name' and status<>'9'";	
												}
												else{
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and co='$co_name' and status<>'9' group by co,cur";	
												}
												$result_ld=mysql_query($ld_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_ld)){
													$co_name=$row['co'];
													$ld = $row['ld'];
													
													$os_info="SELECT (balance+principal)-prn_paid as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc limit 1";
												
													$result_os=mysql_query($os_info) or die (mysql_error());
													
													$OS=0;
													while($row = mysql_fetch_array($result_os)){
														if ($getCur=='KHR'){
															$OS=roundkhr($row['OS'],$set);
														}
														else if($getCur=='THB'){
															$OS=intval($row['OS'],2);
														}
														else{
															$OS=round($row['OS'],2);
														}
														
														$Total += $OS;
														$OS = formatmoney($OS,true);
													}
													
													$int_info="SELECT (interest-int_paid) as os,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc ";
													$result_int=mysql_query($int_info) or die (mysql_error());
													$interest=0;
													while($row1 = mysql_fetch_array($result_int)){
														$interest = $row1['os'];	
														$Total += $interest;
														
													}
												}
                                                	
												$Total = formatmoney($Total,true);
													echo"<td>$Total</td>";
													if($OS==0){
														echo"<td>-</td>";
													}								
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and dis='1' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and dis='1' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and dis='1' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												if($lt=='0'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and co='$co_name' and dis='1' and status<>'9'";	
												}
												else if($lt=='1'){
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and co='$co_name' and status<>'9'";	
												}
												else{
													$ld_info="SELECT co,ld FROM `loan_process` WHERE cur='$getCur' and dis='1' and loan_type='group' and co='$co_name' and status<>'9' group by co,cur";	
												}
												$result_ld=mysql_query($ld_info) or die (mysql_error());
												$Total=0;
												while($row = mysql_fetch_array($result_ld)){
													$co_name=$row['co'];
													$ld = $row['ld'];
													$os_info="SELECT (balance+principal)-prn_paid as OS,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc limit 1";
												
													$result_os=mysql_query($os_info) or die (mysql_error());
													
													$OS=0;
													while($row = mysql_fetch_array($result_os)){
														if ($getCur=='KHR'){
															$OS=roundkhr($row['OS'],$set);
														}
														else if($getCur=='THB'){
															$OS=intval($row['OS'],2);
														}
														else{
															$OS=round($row['OS'],2);
														}
														
														$Total += $OS;
														$OS = formatmoney($OS,true);
													}
													
													$int_info="SELECT (interest-int_paid) as os,co,cur FROM loan_process ln,schedule s WHERE s.ld=ln.ld and rp=0 and cur='$getCur' and co='$co_name' and ln.ld='$ld' order by OS desc ";
													$result_int=mysql_query($int_info) or die (mysql_error());
													$interest=0;
													while($row1 = mysql_fetch_array($result_int)){
														$interest = $row1['os'];	
														$Total += $interest;
														
													}
												}
                                                	
												$Total = formatmoney($Total,true);
													echo"<td>$Total</td>";
													if($OS==0){
														echo"<td>-</td>";
													}								
												//End
                                            }
                                        }
								
										if ($Total==0){
											$T=$i;
											$i=0;
											for ($j=0;$j<$i-2;$j++){
												echo"<td>-</td>";
											}
											$i=$T;
											$Total='-';
										}
                                    ?>
								</tr>
                                <?
										if($lt=='0'){
											echo " <tr align='center' id='En' height='28'>";
										}
										else{
											echo "<tr align='center' id='odd' height='28'>";	
										}
                                 ?>
                            
									<td colspan="<? echo $i; ?>"><font size="-1">PORTFOLIO QUALITY (End of Period)</font></td>
                                </tr>
                                 <?
										if($lt=='0'){
											echo " <tr align='center' id='odd' height='28'>";
										}
										else{
											echo "<tr align='center' id='En' height='28'>";	
										}
                                 ?>
                                
                                    <td><font size="-1">Number of Defaults</font></td>
                                    <?
						
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and  loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and  loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												//Count
										
                                                $NOD_info="select count(s.ld)  count,co,cur FROM `loan_process` l ,
(SELECT distinct s.ld FROM schedule s WHERE  s.rp=0 and s.repayment_date between '$myfrom' and '$myto') s
WHERE  l.ld=s.ld and  co='$co_name' and cur='$getCur' and l.status<>'9'  group by co,cur";
												$result_NOD=mysql_query($NOD_info) or die (mysql_error());
												$NOD=0;
												while($row = mysql_fetch_array($result_NOD)){
													$NOD=$row['count'];
													$Total += $NOD;
											
												}
								
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and loan_type='individual' and status<>'9' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												//Count
									
                                                $NOD_info="select count(s.ld)  count,co,cur FROM `loan_process` l ,
(SELECT distinct s.ld FROM schedule s WHERE  s.rp=0 and s.repayment_date between '$myfrom' and '$myto') s
WHERE  l.ld=s.ld and  co='$co_name' and cur='$getCur' and l.status<>'9'  group by co,cur";
												$result_NOD=mysql_query($NOD_info) or die (mysql_error());
												$NOD=0;
												while($row = mysql_fetch_array($result_NOD)){
													$NOD=$row['count'];
													$Total += $NOD;
													
												}
									
												//End
                                            }
                                        }
										if ($Total==0){
											$i=0;
							
											$Total='-';
										}
                                    ?>
                                     <td><? echo $Total; ?></td>
                                      <?
							
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur'  and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												//Count
										
                                                $NOD_info="select count(s.ld)  count,co,cur FROM `loan_process` l ,
(SELECT distinct s.ld FROM schedule s WHERE  s.rp=0 and s.repayment_date between '$myfrom' and '$myto') s
WHERE  l.ld=s.ld and  co='$co_name' and cur='$getCur' and l.status<>'9' group by co,cur";
												$result_NOD=mysql_query($NOD_info) or die (mysql_error());
												$NOD=0;
												while($row = mysql_fetch_array($result_NOD)){
													$NOD=$row['count'];
													$Total += $NOD;
													echo"<td>$NOD</td>";
												}
												if($NOD==0){
													echo"<td>-</td>";
												}
										
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and loan_type='individual' and status<>'9' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												//Count
									
                                                $NOD_info="select count(s.ld)  count,co,cur FROM `loan_process` l ,
(SELECT distinct s.ld FROM schedule s WHERE  s.rp=0 and s.repayment_date between '$myfrom' and '$myto') s
WHERE  l.ld=s.ld and  co='$co_name' and cur='$getCur' and l.status<>'9' group by co,cur";
												$result_NOD=mysql_query($NOD_info) or die (mysql_error());
												$NOD=0;
												while($row = mysql_fetch_array($result_NOD)){
													$NOD=$row['count'];
													$Total += $NOD;
													echo"<td>$NOD</td>";
												}
												if($NOD==0){
													echo"<td>-</td>";
												}
											
												//End
                                            }
                                        }
										if ($Total==0){
											$i=0;
											for ($j=0;$j<$i-2;$j++){
												echo"<td>-</td>";
											}
											$Total='-';
										}
                                    ?>
								</tr>
                                 <?
										if($lt=='0'){
											echo " <tr align='center' id='En' height='28'>";
										}
										else{
											echo "<tr align='center' id='odd' height='28'>";	
										}
                                 ?>
                                
                                    <td><font size="-1">Value of Balance At Risk</font></td>
                                    <?
							
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and loan_type='group' and status<>'9' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												//Count
									
                                                $BAR_info="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto' and co='$co_name' group by co,cur";
												$result_BAR=mysql_query($BAR_info) or die (mysql_error());
												$BAR=0;
												while($row = mysql_fetch_array($result_BAR)){
													if ($getCur=='KHR'){
														$BAR=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$BAR=intval($row['OS'],2);
													}
													else{
														$BAR=round($row['OS'],2);
													}
													
													$Total += $BAR;
													$BAR = formatmoney($BAR,true);
												
												}
									
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												//Count
										
                                                $BAR_info="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto' and co='$co_name' group by co,cur";
												$result_BAR=mysql_query($BAR_info) or die (mysql_error());
												$BAR=0;
												while($row = mysql_fetch_array($result_BAR)){
													if ($getCur=='KHR'){
														$BAR=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$BAR=intval($row['OS'],2);
													}
													else{
														$BAR=round($row['OS'],2);
													}
													
													$Total += $BAR;
													$BAR = formatmoney($BAR,true);
													
												}
							
												//End
                                            }
                                        }
										if ($Total==0){
											$i=0;
											$Total='-';
										}
                                    ?>
                                     <td><? if($Total=='-'){ 
									 	echo $Total;
									 }
									 else{
									   echo formatmoney($Total,true); 
									 }
									   ?>
                                     
                                       </td>
                                         <?
								
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												//Count
											
                                                $BAR_info="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto' and co='$co_name' group by co,cur";
												$result_BAR=mysql_query($BAR_info) or die (mysql_error());
												$BAR=0;
												while($row = mysql_fetch_array($result_BAR)){
													if ($getCur=='KHR'){
														$BAR=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$BAR=intval($row['OS'],2);
													}
													else{
														$BAR=round($row['OS'],2);
													}
													
													$Total += $BAR;
													$BAR = formatmoney($BAR,true);
													echo"<td>$BAR</td>";
												}
												if($BAR==0){
													echo"<td>-</td>";
												}
										
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												//Count
									
                                                $BAR_info="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto' and co='$co_name' group by co,cur";
												$result_BAR=mysql_query($BAR_info) or die (mysql_error());
												$BAR=0;
												while($row = mysql_fetch_array($result_BAR)){
													if ($getCur=='KHR'){
														$BAR=roundkhr($row['OS'],$set);
													}
													else if($getCur=='THB'){
														$BAR=intval($row['OS'],2);
													}
													else{
														$BAR=round($row['OS'],2);
													}
													
													$Total += $BAR;
													$BAR = formatmoney($BAR,true);
													echo"<td>$BAR</td>";
												}
												if($BAR==0){
													echo"<td>-</td>";
												}
								
												//End
                                            }
                                        }
										if ($Total==0){
											$i=0;
											for ($j=0;$j<$i-2;$j++){
												echo"<td>-</td>";
											}
											$Total='-';
										}
                                    ?>
									 								
                                </tr>
                                 <?
										if($lt=='0'){
											echo " <tr align='center' id='odd' height='28'>";
										}
										else{
											echo "<tr align='center' id='En' height='28'>";	
										}
                                 ?>
                                
                                    <td><font size="-1">Risk Rate of Loan Outstanding</font></td>
                                    <?
								
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur'  and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur'  and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												//Count
									
												$RROLO_F="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto'  and co='$co_name' group by co,cur";
												$result_RROLO_F = mysql_query($RROLO_F) or die (mysql_error());
												$RROLO=0;
												while($row = mysql_fetch_array($result_RROLO_F)){
													$RROLO_AMT_F=$row['OS'];
													$VLO_F="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto'  and co='$co_name' group by co,cur";
													$result_VLO_F=mysql_query($VLO_F) or die (mysql_error());
													
													while($row = mysql_fetch_array($result_VLO_F)){
														$RROLO=($RROLO_AMT_F/$row['OS'])*100;
														$Total += $RROLO;
												
													}
												}
									
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												//Count
										
                                                $RROLO_F="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto' and co='$co_name' group by co,cur";
												$result_RROLO_F = mysql_query($RROLO_F) or die (mysql_error());
												$RROLO=0;
												while($row = mysql_fetch_array($result_RROLO_F)){
													$RROLO_AMT_F=$row['OS'];
													$VLO_F="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto'  and co='$co_name' group by co,cur";
													$result_VLO_F=mysql_query($VLO_F) or die (mysql_error());
													
													while($row = mysql_fetch_array($result_VLO_F)){
														$RROLO=($RROLO_AMT_F/$row['OS'])*100;
														$Total += $RROLO;
													}
												}
								
												//End
                                            }
                                        }
										if ($Total==0){
											$i=0;
										
											$Total='-';
										}
                                    ?>
                                     <td><? echo $Total; ?></td>
                                      <?
                                        if ($type_of_staff=='0'){
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and status<>'9' and loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												//Count
										
												$RROLO_F="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto'  and co='$co_name' group by co,cur";
												$result_RROLO_F = mysql_query($RROLO_F) or die (mysql_error());
												$RROLO=0;
												while($row = mysql_fetch_array($result_RROLO_F)){
													$RROLO_AMT_F=$row['OS'];
													$VLO_F="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto'  and co='$co_name' group by co,cur";
													$result_VLO_F=mysql_query($VLO_F) or die (mysql_error());
													
													while($row = mysql_fetch_array($result_VLO_F)){
														$RROLO=($RROLO_AMT_F/$row['OS'])*100;
														$Total += $RROLO;
														echo"<td>$RROLO %</td>";
													}
												}
												if($RROLO==0){
													echo"<td>-</td>";
												}
											
												//End
                                            }
                                        }
                                        else{
											if($lt=='0'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' group by co,cur";	
											}
											else if($lt=='1'){
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and loan_type='individual' group by co,cur";	
											}
											else{
												$co_info="SELECT co FROM `loan_process` WHERE cur='$getCur' and co='$staff' and status<>'9' and loan_type='group' group by co,cur";	
											}
                                            $result_br=mysql_query($co_info) or die (mysql_error());
                                            $Total=0;
											while($row = mysql_fetch_array($result_br)){
                                                $co_name=$row['co'];
												
												//Count
											
                                                $RROLO_F="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto' and co='$co_name' group by co,cur";
												$result_RROLO_F = mysql_query($RROLO_F) or die (mysql_error());
												$RROLO=0;
												while($row = mysql_fetch_array($result_RROLO_F)){
													$RROLO_AMT_F=$row['OS'];
													$VLO_F="SELECT sum((balance+principal)-prn_paid) as OS,co,cur FROM loan_process ln,schedule s WHERE ln.ld=s.ld and rp='0' and cur='$getCur' and s.repayment_date between '$myfrom' and '$myto'  and co='$co_name' group by co,cur";
													$result_VLO_F=mysql_query($VLO_F) or die (mysql_error());
													
													while($row = mysql_fetch_array($result_VLO_F)){
														$RROLO=($RROLO_AMT_F/$row['OS'])*100;
														$Total += $RROLO;
														echo"<td>$RROLO %</td>";
													}
												}
												if($RROLO==0){
													echo"<td>-</td>";
												}
										
												//End
                                            }
                                        }
										if ($Total==0){
											$i=0;
											for ($j=0;$j<$i-2;$j++){
												echo"<td>-</td>";
											}
											$Total='-';
										}
                                    ?>
								</tr>
                                
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
               </tbody>	
</table>

</center>
<br />
<center>
<table width="1000px" border="1" style="border-collapse:collapse; background:#FFF">
	<tr>
    	<td style="padding-left:50px">Approved By</td>
        <td style="padding-left:300px">Prepared By</td>
    </tr>
</table>
</center>
</body>
</html>