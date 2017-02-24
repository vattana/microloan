<?php 
	session_start(); 
		include('conn.php');
		include('module.php');											
?>
<!DOCTYPE HTML>
<html>
<head>
<title>OLMS - Administrator</title>
<meta charset="UTF-8" />
<link rel="stylesheet" type="text/css" href="../css/reset_login.css">
<link rel="stylesheet" type="text/css" href="../css/structure_login.css">
<script type="text/javascript">
		function focusit() {			
		document.getElementById("user_name").focus();
		}
		window.onload = focusit;
</script>

<?php
	if(isset($_POST['login'])){ 
	//Accrued Interest Saving
		$query_pnm=" select ld,cid,cur from deposit w group by ld";
		$result_pnm=mysql_query($query_pnm);
		echo mysql_error();
		while($row = mysql_fetch_array($result_pnm))
		{
			$lid=$row['ld'];
			$cid=$row['cid'];
			$cur=$row['cur'];
			//Get setting round khr
			$round_khinfo="SELECT setting FROM loan_config WHERE property='rounding'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_khrinfo)){
						$round_khr=$row['setting'];
					}
			$now = getdate();
			$today = date('Y-m-d', mktime(0, 0, 0, $now['mon'], $now['mday'], $now['year']));
			
			$query_pn=" select idate from accrued_sinter a where a.ld='$lid'  order by id desc limit 1";
			$result_pn=mysql_query($query_pn);
			echo mysql_error();
			while($row = mysql_fetch_array($result_pn))
			{
				$idate=$row['idate'];
			}
			
			$days_number=round(dateDiff($idate,$today));
			
			if($today==$idate){
				
				break;	
			}
			$due_amt=0;
			$query_pn=" select sum(w.amount) amt from witdraw w where w.ld='$lid'";
			$result_pn=mysql_query($query_pn);
			echo mysql_error();
			while($row = mysql_fetch_array($result_pn))
			{
				if($cur=='USD'){
					$due_amt1=round($row['amt'],2);
				}
				else if($cur=='THB'){
					$due_amt1=intval($row['amt'],2);
				}
				else{
					$due_amt1=roundkhr($row['amt'],$round_khr);
				}
			}
			
			$query_pn=" select sum(a.inter) amt from accrued_sinter a where a.ld='$lid'";
			$result_pn=mysql_query($query_pn);
			echo mysql_error();
			while($row = mysql_fetch_array($result_pn))
			{
				if($cur=='USD'){
					$due_amt2=round($row['amt'],3);
				}
				else if($cur=='THB'){
					$due_amt2=intval($row['amt'],3);
				}
				else{
					$due_amt2=roundkhr($row['amt'],$round_khr);
				}
			}
			
			$due_amt1=$due_amt1-$due_amt2;
			
			if ($due_amt1<0){
				$due_amt1=0;	
			}
							
			$query_pn=" select sum(d.amount) amt from deposit d where d.ld='$lid'";
			$result_pn=mysql_query($query_pn);
			echo mysql_error();
			while($row = mysql_fetch_array($result_pn))
			{
				if($cur=='USD'){
					$due_amt=round($row['amt']-$due_amt1,2);
				}
				else if($cur=='THB'){
					$due_amt=intval($row['amt']-$due_amt1,2);
				}
				else{
					$due_amt=roundkhr($row['amt']-$due_amt1,$round_khr);
				}
				
			}
			
			$query_pn=" select d.date,isfix,frate,nrate from deposit d where d.ld='$lid' limit 1";
			$result_pn=mysql_query($query_pn);
			echo mysql_error();
			while($row = mysql_fetch_array($result_pn))
			{
				$date_s =$row['date'];
				$isfix = $row['isfix'];
				$frate = $row['frate'];
				$nrate = $row['nrate'];
			}
			
			
			
			if($date_s!=$today){
				if ($isfix==0){
					/*$query_pn=" select setting from loan_config d where d.property='Nsaving'";
					$result_pn=mysql_query($query_pn);
					echo mysql_error();
					while($row = mysql_fetch_array($result_pn))
					{
						$rate =$row['setting'];
					}*/
					$rate = $nrate/365;
					$inte = (($due_amt*$rate)/100)*$days_number;
				}
				else{
					/*$query_pn=" select setting from loan_config d where d.property='fsaving'";
					$result_pn=mysql_query($query_pn);
					echo mysql_error();
					while($row = mysql_fetch_array($result_pn))
					{
						$rate =$row['setting'];
					}*/
					$rate = $frate/365;
					$inte = (($due_amt*$rate)/100)*$days_number;	
				}
				if($cur=='USD'){
					$inte= round($inte,3);
				}
				else if($cur=='THB'){
					$inte= round($inte,3);
				}
				else{
						
					$inte=roundkhr($inte,$round_khr);
				}
				$insert_sinter="insert into accrued_sinter(ld,cid,inter,idate,isfix,amount) values('$lid','$cid','$inte','$today','$isfix','$due_amt')";
				mysql_query($insert_sinter) or die (mysql_error());
			}
		}
	//End Saving
	
	///date times
	$date_time=date('Y-m-d H:i:s');
	$date=date('Y-m-d');
	$time=date('H:i:s');
	////////
	$user=$_POST['user_name'];
	$pass=$_POST['pass'];
	
	
	if(empty($user) || empty($pass)){
		echo "<script> alert('Please Input Your User Name And Password');</script>";
		echo "<script>location.href='login.php';</script>";
		
	}
	$sql="Select * from user_info where user_name='$user' and pass='$pass'";

	$sql=mysql_query($sql);

	$num_row=mysql_num_rows($sql);
	$row=mysql_fetch_array($sql);
	if($row['status']=='none-active'){
		echo "<script> alert('Your user name and password had been deactivated!Please contact your administrator!');</script>";
		echo "<script>location.href='login.php';</script>";
		}
	if(($num_row>=1) && ($row['status']=='active'))
	{	
	
	//	setcookie ("usr",$user,time()+10800);
		session_cache_limiter('private');
		$cache_limiter = session_cache_limiter();
		session_cache_expire(700);
		$cache_expire = session_cache_expire();	
               
        $myuser = $_SESSION['usr'] =$row['name'];
		$level = $_SESSION['permission']=$row['level'];
		$branch = $_SESSION['br']=$row['branch'];
		
		//////Branch Name
						$brname_sql="Select branch from user_info where name ='$myuser'";
						$result_brname=mysql_query($brname_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_brname))
									{
										$BR_Name=$_SESSION['BR_Name'] =$row['branch'];
									}
						/*echo"<script>alert('$BR_Name');</script>";*/
				//////////
			$_SESSION['level']=$row['level'];
			//when success
			$error_msg=mysql_query("INSERT INTO `user_log` (
										`log_id` ,
										`remote_addr` ,
										`user_catch` ,
										`message` ,
										`log_date`
										)
										VALUES (
										NULL , '$br_ip', '$myuser', 'Successfull!',
										CURRENT_TIMESTAMP
										);
								");
			///
			echo"<script>window.location.href='../index.php?home';</script>";
			//header("location:../index.php?home");
			
	}
	else
	{
		// is password and name incorrect
		$error1_msg=mysql_query("INSERT INTO `user_log` (
										`log_id` ,
										`remote_addr` ,
										`user_catch` ,
										`message` ,
										`log_date`
										)
										VALUES (
										NULL , '$br_ip', 'Error', 'Wrong User Name Or Password!',
										CURRENT_TIMESTAMP
										);
								");
		echo"<script>alert('Wrong User Name or Password!Try Again!');</script>";
		
	}
}//end isset
?>
</head>

<body>
<form class="box login" method="post">
	<fieldset class="boxBody">
	  <label>Username</label>
	  <input type="text" tabindex="1" placeholder="UserName" required name="user_name" id="user_name" autocomplete="off">
	  <label><a href="#" class="rLink" tabindex="5">Forget your password?</a>Password</label>
	  <input type="password" tabindex="2" required name="pass">
	</fieldset>
	<footer>
	  <label><input type="checkbox" tabindex="3">Keep me logged in</label>
	  <input type="submit" class="btnLogin" value="Login" tabindex="4" name="login">
	</footer>
</form>
<footer id="main">
 			&copy; 2012 ,All Right Reserved Sunway International School
</footer>
</body>
</html>
