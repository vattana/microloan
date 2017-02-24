<?php
    session_start();
    if(empty($_SESSION['usr'])) header('location:../login.php');
	include("module.php");	
	include("conn.php");
	///check branch no
	$br_ip = $_SERVER['REMOTE_ADDR'];
	$br_sql="Select * from br_ip_mgr where set_ip ='$br_ip'";
			$result_br=mysql_query($br_sql) or die (mysql_error());
				while($row = mysql_fetch_array($result_br))
								{
									$get_ip=$row['set_ip'];
									$get_br=$row['br_no'];	 
								}
		///end check branch no
	$reg_id=$_GET['regis_id'];
	$user_app=$_SESSION['usr'];
	$sql_display="SELECT * FROM register WHERE id='$reg_id' ORDER BY cif ASC;";
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
			$co=$row['co'];
			$recom_name=$row['recomend_name'];
			$cur=$row['cur'];
		}
		//-------------
		//select app info
		$sql_displayapp="SELECT * FROM customer_app WHERE reg_id='$reg_id' ORDER BY id ASC;";
		$result_displayapp = mysql_query($sql_displayapp);
		while($row = mysql_fetch_array($result_displayapp)){
				$rate_app=$row['approval_rate'];
				$amt_app=formatMoney($row['approval_amt'],true);
				$period_app=$row['approval_period'];
				$mymethod=$row['method'];
				$pay_fr=$row['number_of_repay'];
				
			}
		//----------
		//read fr
		$sql_fr="Select * from no_repayment where day_of_repayment='$pay_fr';";
		$result_fr = mysql_query($sql_fr);
		while($row = mysql_fetch_array($result_fr)){
				$fr=$row['type_of_repayment'];
				$nor=$row['day_of_repayment'];
			}
		//------
		//--request cycle
				$rcycle = "SELECT * FROM register WHERE cif ='$cid'";
				$result_rcycle=mysql_query($rcycle);
				$num_rows_rcycle = mysql_num_rows($result_rcycle);
		//----

	if(isset($_POST['submit'])){
			$de_reg_date=date('Y-m-d',strtotime($_POST['reg_date']));
			$app_amt=$_POST['app_amt'];
			//
			$spit = array(",", "'");
			$myloan = str_replace($spit, "",$app_amt);
			//
			$app_date=date('Y-m-d',strtotime($_POST['app_date']));
			$method_select=$_POST['method'];
			$no_repay=$_POST['repay_type'];
			$app_int=$_POST['app_int'];
			$app_period=$_POST['app_period'];
			$mycur=$_POST['cur'];
			
			if($method_select=='0'){
				$method_select=$mymethod;
				}
			if($no_repay=='0'){
				$no_repay=$nor;
				}
				
			if(!empty($app_amt)){
				$update_cust_app = mysql_query("UPDATE customer_app SET approval_amt='$myloan',
				approval_rate='$app_int',
				approval_period='$app_period',
				method='$method_select',
				number_of_repay='$no_repay' 
				WHERE reg_id='$reg_id'");
			echo"<script>alert('$borrower is Update Successful! Form will be close please check again!');</script>" ;
							
							echo"<script>window.close();</script>";
							mysql_close();
							exit();
				}
				else{
					echo"<script>alert('Approve Unsuccessful! Try again!');</script>" ;
					}
		
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Edit Approval Customer Form - OLMS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="../js/niceforms.js"></script>
<script language="javascript" type="text/javascript" src="../js/class_and_function.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/niceforms-default.css" />

<!-- start data security -->
<script language="JavaScript">
function formCheck(formobj){
	var method=document.getElementById('method').value;
	var repay_type=document.getElementById('repay_type').value;
	
	/*if(method=='0'){alert('Please Select Repayment Method!');return false;}
	if(repay_type=='0'){alert('Please Select Repayment Type!');return false;}*/
	
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
    	<div style="color:#FFF; font-size:20">Edition Form for : <?php echo $borrower .' with CID '.$cid.' AND Currency : '.$cur ;?></div>
    </fieldset>
<form method="post" class="niceform" onsubmit="return formCheck(this);">
	<fieldset>
    	<legend>Request Info</legend>
        <table width="1200" height="auto" border="0">
        	<tr>
            	<td><label for="request">Register Date :</label></td>
                <td><input type="text" name="reg_date" id="reg_date" size="20" readonly="readonly" value="<?php echo $reg_date ?>"/>
                	<input type="hidden" name="cur" value="<?php echo $cur ;?>"/></td>
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
    <fieldset>
    	<legend>Approval Info</legend>
        <table width="1200" height="auto" border="0">
        	<tr>
            	<td><label for="request">Approval Date :</label></td>
                <td>
                <input type="text" name="app_date" id="app_date" size="20" value="<?php echo date('d-m-Y'); ?>" 
                autocomplete="off" onblur="doDate(this,'em_Date');"/>
                </td>
                <td><label for="request">Approval Amount :</label></td>
                <td><input type="text" name="app_amt" id="app_amt" size="20" autocomplete="off" 
                onchange="this.value=formatCurrency(this.value);" onkeypress="return handleEnter(this, event);" 
                value="<?php echo $amt_app ?>"/></td>
                <td><label for="rate">Approval Rate :</label></td>
                <td><input type="text" name="app_int" id="app_int" size="20" autocomplete="off" 
                onkeypress="return handleEnter(this, event);" value="<?php echo $rate_app ?>"/></td>
                <td><label for="rate">Approval Period :</label></td>
                <td><input type="text" name="app_period" id="app_period" size="20" autocomplete="off" 
                onkeypress="return handleEnter(this, event);" value="<?php echo $period_app ?>"/></td>
                <td><label for="rate">Approval By :</label></td>
                <td><input type="text" name="app_by" id="app_by" size="20" readonly="readonly" 
                onkeypress="return handleEnter(this, event);" value="<?php echo $_SESSION['usr'] ?>"/></td>
        	</tr>
        </table>
    </fieldset>
    <fieldset>
    	<legend>Setting</legend>
        <table width="150" height="auto" border="0" align="left">
        	<tr>
                <td align="left" valign="middle">
                	
                	<select name="method" id="method" size="1" onkeypress="return handleEnter(this, event);">
                    	<option value="0">--Repayment Methods--</option>
                        <?php 
								$str_method="Select * from repay_method Group by method asc";
								$sql_method=mysql_query($str_method);
								while ($row=mysql_fetch_array($sql_method))
								{
									$method=$row['method'];
									echo '<option value="'.$method.'">' .$method. '</option>';
								}
							?>
                    </select>
                    <?php echo $mymethod  ?>
                </td>
                <td align="left" valign="middle">
                	<select name="repay_type" id="repay_type" size="1" onkeypress="return handleEnter(this, event);">
                    	<option value="0">--Repayment Types--</option>
                        <?php 
								$str_nor="Select * from no_repayment Group by day_of_repayment asc";
								$sql_nor=mysql_query($str_nor);
								while ($row=mysql_fetch_array($sql_nor))
								{
									$t_repay=$row['type_of_repayment'];
									$d_repay=$row['day_of_repayment'];
									echo '<option value="'.$d_repay.'">' .$t_repay. '</option>';
								}
							?>
                    </select>
                    <?php echo $fr  ?>
                </td>
        	</tr>
        </table>
    </fieldset>
     <fieldset class="action">
    	<input type="submit" name="submit" id="submit" value="Edit" 
        onclick="return confirm('Are you sure want to Update Approval info for <?php echo $borrower; ?> ?');"/>
        <input type="reset" name="reset" id="reset" value="Clear" />
    </fieldset>
</form>
</div>
</body>
</html>