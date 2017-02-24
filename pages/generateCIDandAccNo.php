<?php 
 session_start();
 
    if(empty($_SESSION['usr'])) header('location:login.woori.php?clear');
	include('conn.php');
	include('module.php');
			
			/*echo"<script>alert('$cid');</script>";*/
	$getreg=mysql_query("select * from loan_process where status='9'");		
	while($row=mysql_fetch_array($getreg)){
			$ld=$row['ld'];	
			$generateCID=mysql_query("UPDATE schedule set rp='9' where ld='$ld'");
			//$generateCIDlnpro=mysql_query("UPDATE lnprocess set cid='$cid',accNo='$accNo' where maxID='$max'");
			
	}
		echo"<script>alert('successful!');</script>";
		echo "$max customer has been updated";
			
?>