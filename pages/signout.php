<?                   	
    session_start();
	include('conn.php');
	$user=$_SESSION['usr'];
	$br_ip = $_SERVER['REMOTE_ADDR'];
	//when click
			$error3_msg=mysql_query("INSERT INTO `user_log` (
										`log_id` ,
										`remote_addr` ,
										`user_catch` ,
										`message` ,
										`log_date`
										)
										VALUES (
										NULL , '$br_ip', '$user', 'Sign Out!',
										CURRENT_TIMESTAMP
										);
								");
			/// 
    if(isset($_GET['action'])) if($_GET['action'] == 'signout') unset($_SESSION['usr']);	
	
        header("location:../");                  
?>