<?php
$user="root";
$pass="vattana168";
$db="sarina_db";
$link=@mysql_connect("localhost",$user,$pass)or die("connection to the server fail".mysql_error());
@mysql_select_db($db) or die("could not open db:$db");
mysql_query("SET NAMES UTF8");
date_default_timezone_set('Asia/Phnom_Penh');
////////////
						$br_ip = $_SERVER['REMOTE_ADDR'];
						$br_sql="Select * from br_ip_mgr where set_ip ='$br_ip'";
						$result_br=mysql_query($br_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_br))
									{
										$get_ip=$row['set_ip'];
										$get_br1=$row['br_no'];	 
									}
									/*if($br_ip!=$get_ip){
										echo "<script>alert('Please Contact Your Top management.$br_ip'); self.close();</script>";
										echo"<script>window.location.href='about:blank';</script>";
										exit();
									}*/
					///check appset
					$app_sqlget="Select setting from loan_config where property ='app'";
					$result_app=mysql_query($app_sqlget) or die (mysql_error());
						while($row = mysql_fetch_array($result_app))
								{
									$appSet=$row['setting'];	
								}			
					///check rounding
					$round_sqlget="Select setting from loan_config where property ='rounding'";
					$result_round=mysql_query($round_sqlget) or die (mysql_error());
						while($row = mysql_fetch_array($result_round))
								{
									$set=intval($row['setting']);	
								}
						///check lpn
					$round_sqllpn="Select setting from loan_config where property ='Lpn'";
					$result_lpn=mysql_query($round_sqllpn) or die (mysql_error());
						while($row = mysql_fetch_array($result_lpn))
								{
									$setLpn=intval($row['setting']);	
								}							

/*echo"<script>alert('$br_name');</script>";*/
?>