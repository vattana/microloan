<?php
    session_start();
    if(empty($_SESSION['usr'])) header('location:../login.php');
	include("module.php");	
	include("conn.php");
	///check branch no
					$user=$_SESSION['usr'];
					$br_ip = $_SERVER['REMOTE_ADDR'];
					$br_sql="Select * from br_ip_mgr where set_ip ='$br_ip'";
					$result_br=mysql_query($br_sql) or die (mysql_error());
						while($row = mysql_fetch_array($result_br))
								{
									$get_ip=$row['set_ip'];
									$get_br=$row['br_no'];	 
								}
		///end check branch no
	$id=$_GET['id'];
	$user_app=$_SESSION['usr'];
	$sql_display="SELECT * FROM register WHERE id='$id' ORDER BY cif ASC;";
	$result_display = mysql_query($sql_display);
	while($row = mysql_fetch_array($result_display)){
			$reg_date=date('d-m-Y',strtotime($row['register_date']));
			$myloan_re=formatMoney($row['loan_request'],true);
			$rate=$row['rate'];
			$period=$row['period'];
			$post_by=$row['post_by'];
			$borrower=$row['borrower'];
			$cid=$row['cif'];
			$app_status=$row['appr'];
			$cur=$row['cur'];
			
		}
		//-------------
		//display app info
	$sql_appdisplay="SELECT * FROM customer_app WHERE reg_id='$id' ORDER BY cid ASC;";
	$result_appdisplay = mysql_query($sql_appdisplay);
	while($row = mysql_fetch_array($result_appdisplay)){
			$date_app=date('d-m-Y',strtotime($row['approval_date']));
			$app_amt=formatMoney($row['approval_amt'],true);
			$app_int=$row['approval_rate'];
			$app_period=$row['approval_period'];
			$app_by=$row['approval_by'];
			$app_at=$row['approval_at'];
		}
		
	if(isset($_POST['disapp'])){//start disapp
			$date_cancel=date('Y-m-d',strtotime($_POST['cancel_date']));
			$myreason=$_POST['reason'];
			$mycur=$_POST['cur'];
			//
			if(!empty($myreason)){
			$cancel_tran=mysql_query("
					INSERT INTO `cancel_info` (
							`id` ,
							`reg_id` ,
							`cancel_date` ,
							`reason` ,
							`cancel_by` ,
							`cancel_at`,
							`cur`
							)
							VALUES (
							NULL , '$id', '$date_cancel', '$myreason', '$user', '$get_br', '$mycur'
							);
			");
				$update_register=mysql_query("UPDATE register SET cancel='1' WHERE id='$id'");
				echo"<script>alert('$borrower is Cancel Successful By $user!');</script>" ;
				echo"<script>window.close();</script>";
				mysql_close();
				exit();
			}
			else{
				echo"<script>alert('Oops...! Try Again!');</script>" ;
				}
		
		}//end disapp
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cancel Form - OLMS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="../js/niceforms.js"></script>
<script language="javascript" type="text/javascript" src="../js/class_and_function.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/niceforms-default.css" />

<!-- start data security -->
<script language="JavaScript">
function formCheck(formobj){
	var reason=document.getElementById('reason').value;
	
	
	if(reason=='0'){alert('Please Select reason!');return false;}
	
	// Enter name of mandatory fields
	var fieldRequired = Array("app_amt","app_int","app_period","app_date");
	// Enter field description to appear in the dialog box
	var fieldDescription = Array("Approval Amount","Approval Rate","Approval Period","Approval Date");
	// dialog message
	var alertMsg = " សូមបំពេញពត៍មានខាងក្រោម ៖ \n Please complete the following fields:\n";
	
	var l_Msg = alertMsg.length;
	
	for (var i = 0; i < fieldRequired.length; i++){
		var obj = formobj.elements[fieldRequired[i]];
		if (obj){
			switch(obj.type){
			case "select-one":
				if (obj.selectedIndex == -1 || obj.options[obj.selectedIndex].text == ""){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			case "select-multiple":
				if (obj.selectedIndex == -1){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			case "text":
			case "textarea":
				if (obj.value == "" || obj.value == null){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			default:
			}
			if (obj.type == undefined){
				var blnchecked = false;
				for (var j = 0; j < obj.length; j++){
					if (obj[j].checked){
						blnchecked = true;
					}
				}
				if (!blnchecked){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
			}
		}
	}
	if (alertMsg.length == l_Msg){
		return true;
	}else{
		alert(alertMsg);
		return false;
	}
	
}
// -->
</script>

</head>
<body topmargin="0">
<center>
<div id="container">
	<table width="1200" border="0">
    	<tr>
        	<td align="left" valign="middle">
            	<img src="../images/shared/logo.png" border="0" title="Online Loan Management System"/>
            </td>
        </tr>
    </table>
	 </fieldset>
     <fieldset class="action">
    	<div style="color:#FFF; font-size:20">Cancel Form for : <?php echo $borrower ;?></div>
    </fieldset>
<form method="post" class="niceform" onsubmit="return formCheck(this);">
	<fieldset>
    	<legend>Request Info</legend>
        <table width="1200" height="auto" border="0">
        	<tr>
            	<td><label for="request">Register Date :</label></td>
                <td><input type="text" name="reg_date" id="reg_date" size="20" readonly="readonly" value="<?php echo $reg_date ?>"/>
                <input type="hidden" name="cur" value="<?php echo $cur; ?>"</td>
                <td><label for="request">Request Amount :</label></td>
                <td><input type="text" name="request_amt" id="request_amt" size="20" readonly="readonly" value="<?php echo $myloan_re ?>"/></td>
                <td><label for="rate">Rate :</label></td>
                <td><input type="text" name="int" id="int" size="20" readonly="readonly" value="<?php echo $rate ?>"/></td>
                <td><label for="rate">Period :</label></td>
                <td><input type="text" name="period" id="period" size="20" readonly="readonly" value="<?php echo $period ?>"/></td>
                <td><label for="rate">Post By :</label></td>
                <td><input type="text" name="post_by" id="post_by" size="20" readonly="readonly" value="<?php echo $post_by ?>"/></td>
        	</tr>
        </table>
    </fieldset>
    <?php if($app_status=='1'){ echo ' 
    <fieldset>
    	<legend>Approval Info</legend>
        <table width="1200" height="auto" border="0">
        	<tr>
            	<td><label for="request">Approval Date :</label></td>
                <td>
                <input type="text" name="app_date" id="app_date" size="20" value="'.$date_app.'" 
                autocomplete="off" onblur="doDate(this,\'em_Date\');"/>
                </td>
                <td><label for="request">Approval Amount :</label></td>
                <td><input type="text" name="app_amt" id="app_amt" size="20" readonly="readonly"  value="'.$app_amt.'"/></td>
                <td><label for="rate">Approval Rate :</label></td>
                <td><input type="text" name="app_int" id="app_int" size="20" readonly="readonly"  value="'.$app_int.'"/></td>
                <td><label for="rate">Approval Period :</label></td>
                <td><input type="text" name="app_period" id="app_period" size="20" value="'.$app_period.'" readonly="readonly"/></td>
                <td><label for="rate">Approval By :</label></td>
                <td><input type="text" name="app_by" id="app_by" size="20" readonly="readonly" value="'.$app_by.'"/></td>
        	</tr>
        </table>
    </fieldset>
      '; }?>
    <fieldset>
    	<legend>Cancel Info</legend>
        <table width="500" height="auto" border="0" align="left">
        	<tr>
            	<td align="left"><label for="request">Canceled Date :</label></td>
                <td align="left"><input type="text" name="cancel_date" id="cancel_date" size="20" value="<?php echo date('d-m-Y') ?>"/></td>
                <td align="left"><label for="rate">Cancel By :</label></td>
                <td align="left"><input type="text" name="cancel_by" id="cancel_by" size="20" readonly="readonly" value="<?php echo $user ?>"/>
                </td>
               
        	</tr>
        </table>
    </fieldset>
    <fieldset>
    	<legend>Why?</legend>
        <table width="500" height="auto" border="0" align="left">
        	<tr>
                <td align="left" valign="middle">
                	<select name="reason" id="reason" size="1">
                    	<option value="0">--Reason--</option>
                        <?php 
								$str_method="Select * from disapp_reason order by reason asc";
								$sql_method=mysql_query($str_method);
								while ($row=mysql_fetch_array($sql_method))
								{
									$reason=$row['reason'];
									echo '<option value="'.$reason.'">' .$reason. '</option>';
								}
							?>
                    </select>
                </td>
                <td align="left" valign="middle">&nbsp;
                	
                </td>
        	</tr>
        </table>
    </fieldset>
     <fieldset class="action">
    	<input type="submit" name="disapp" id="disapp" value="Cancel" 
        onclick="return confirm('Are you sure want to cancel <?php echo $borrower; ?> ?');"/>
        <input type="reset" name="reset" id="reset" value="Clear" />
    </fieldset>
</form>
</div>
</body>
</html>
