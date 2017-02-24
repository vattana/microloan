<script type="text/javascript">
	function focusit() {			
		document.getElementById("kh_bor").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<!-- start adres -->
<script type="text/javascript">
		$(document).ready(function()
		{
		$(".province").change(function()
		{
		var id=$(this).val();
		var dataString = 'id='+ id;
		
		$.ajax
		({
		type: "POST",
		url: "pages/ajax_dis.php",
		data: dataString,
		cache: false,
		success: function(html)
		{
		$(".district").html(html);
		} 
		});
		
		});
		});
		///////////////
		$(document).ready(function()
		{
		$(".district").change(function()
		{
		var id=$(this).val();
		var dataString = 'id='+ id;
		
		$.ajax
		({
		type: "POST",
		url: "pages/ajax_com.php",
		data: dataString,
		cache: false,
		success: function(html)
		{
		$(".commune").html(html);
		} 
		});
		
		});
		});
		//////////////////////
		$(document).ready(function()
		{
		$(".commune").change(function()
		{
		var id=$(this).val();
		var dataString = 'id='+ id;
		
		$.ajax
		({
		type: "POST",
		url: "pages/ajax_vil.php",
		data: dataString,
		cache: false,
		success: function(html)
		{
		$(".village").html(html);
		} 
		});
		
		});
		});
//////////
</script>
<!-- end adr -->
<!-- start data security -->
<script language="JavaScript">
function doselect(){
	if(document.getElementById("type").checked==false){
		document.getElementById("type").value= "Saving";
	}	 
	else
	{
		document.getElementById("type").value= "Loan";
	}
}

function formCheck(formobj){
	var mycur=document.getElementById('cur').value;
	var loan_type=document.getElementById('ltype').value;
	var sex=document.getElementById('sex').value;
	var co=document.getElementById('co').value;
	var marital=document.getElementById('marital').value;
	var freq=document.getElementById("repay_type").value;
	var type =document.getElementById('type').value;
	

	if (type=='Loan'){
		if(sex=='0'){alert('សូមជ្រើសរើសភេទ !');return false;}
		if(marital=='0'){alert('Please Select Marital Status!');return false;}
		if(freq=='0'){alert('Please Select Frequency!');return false;}
		if(mycur=='0'){alert('Please Select Currency Type!');return false;}
		if(co=='0'){alert('Please Select CO!');return false;}
		if(loan_type=='0'){alert('Please Select Loan Type!');return false;}
		
		// Enter name of mandatory fields
		var fieldRequired = Array("reg_date","kh_bor","bor","kh_cobor","cobor","dob","tel","loan_amt","int","period");
		// Enter field description to appear in the dialog box
		var fieldDescription = Array("Registration Date","អ្នកខ្ចី","Borrower","អ្នករួមខ្ចី","Co-Borrower","ថ្ងៃខែឆ្នាំកំណើត","លេខទូរស័ព្ទ","Amount","Rate","Period");
		// dialog message
		var alertMsg = " សូមបំពេញពត៍មានខាងក្រោម ៖ \n Please complete the following fields:\n";
	}
	else{
		var fieldRequired = Array("reg_date","kh_bor","bor","kh_cobor","cobor","dob","tel");
		// Enter field description to appear in the dialog box
		var fieldDescription = Array("Registration Date","អ្នកខ្ចី","Borrower","អ្នករួមខ្ចី","Co-Borrower","ថ្ងៃខែឆ្នាំកំណើត","លេខទូរស័ព្ទ");
		// dialog message
		var alertMsg = " សូមបំពេញពត៍មានខាងក្រោម ៖ \n Please complete the following fields:\n";
	}
	
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
<?php
	$user = $_SESSION['usr'];
	if(isset($_POST['submit'])){
		$get_sex=$_POST['sex'];
		$mysex=$_POST['sex'];
		$get_yearbirth=substr($_POST['dob'],-2,2);
		$get_reg_month=date('m',strtotime($_POST['reg_date']));
		$get_reg_year=date('y',strtotime($_POST['reg_date']));
		
		//////////get data from form input
		$borrower=$_POST['bor'];
		$kh_borrower=$_POST['kh_bor'];
		$co_borrower=$_POST['cobor'];
		$kh_co_borrower=$_POST['kh_cobor'];
		$regist_date=date('Y-m-d',strtotime($_POST['reg_date']));
		$times=date('H:i:s');
		$tel=$_POST['tel'];
		$dob=date('Y-m-d',strtotime($_POST['dob']));
		$pro=$_POST['province'];
		$dist=$_POST['district'];
		$com=$_POST['commune'];
		$vil=$_POST['village'];
		$loan_amt=$_POST['loan_amt'];
		
		$cur=$_POST['cur'];
		$int=$_POST['int'];
		$period=$_POST['period'];
		$recom_pos=$_POST['recom_pos'];
		$recom_name=$_POST['recom'];
		$co=$_POST['co'];
		$ltype=$_POST['ltype'];
		$purposedes=$_POST['purpose'];
		$marital=$_POST['marital'];
		$landCost=$_POST['landCost'];
		$houseCost=$_POST['houseCost'];
		$eCost=$_POST['ECost'];
		$inMaker=$_POST['incomeMaker'];
		$spName=$_POST['spName'];
		$dependent=$_POST['dependent'];
		$relation=$_POST['relation'];
		$repay_type=$_POST['repay_type'];
		$houseNo=$_POST['houseNo'];
		$streetNo=$_POST['streetNo'];
		$idType=$_POST['kh_iden'];
		$idNo=$_POST['idNo'];
		$type=$_POST['type'];
		
		//
		$spit = array(",", "'");
 		$myloan = str_replace($spit, "",$loan_amt);
 		$mylCost = str_replace($spit, "",$landCost);
 		$myhCost = str_replace($spit, "",$houseCost);
 		$myeCost = str_replace($spit, "",$eCost);
		//
		
		//cut image
		error_reporting(0);
		$change="";
		$abc="";

		 define ("MAX_SIZE","1024");
		 function getExtension($str) {
				 $i = strrpos($str,".");
				 if (!$i) { return ""; }
				 $l = strlen($str) - $i;
				 $ext = substr($str,$i+1,$l);
				 return $ext;
		 }
		 $errors=0;
		  
		 if($_SERVER["REQUEST_METHOD"] == "POST")
		 {
			$image =$_FILES["file"]["name"];
			$uploadedfile = $_FILES['file']['tmp_name'];
			
			if ($image) 
			{
			
				$filename = stripslashes($_FILES['file']['name']);
			
				$extension = getExtension($filename);
				$extension = strtolower($extension);
				
		 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
				{
				
					$change='<div class="msgdiv">Unknown Image extension </div> ';
					$errors=1;
				}
				else
				{

		 $size=filesize($_FILES['file']['tmp_name']);

		if ($size > MAX_SIZE*1024)
		{
			$change='<div class="msgdiv">You have exceeded the size limit!</div> ';
			$errors=1;
		}

		if($extension=="jpg" || $extension=="jpeg" )
		{
		$uploadedfile = $_FILES['file']['tmp_name'];
		$src = imagecreatefromjpeg($uploadedfile);

		}
		else if($extension=="png")
		{
		$uploadedfile = $_FILES['file']['tmp_name'];
		$src = imagecreatefrompng($uploadedfile);

		}
		else 
		{
		$src = imagecreatefromgif($uploadedfile);
		}
		list($width,$height)=getimagesize($uploadedfile);

		$newheight=150;
		$newwidth=($width/$height)*$newheight;
		$tmp=imagecreatetruecolor($newwidth,$newheight);

		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

		$filename = "photo_co/". $image;

		imagejpeg($tmp,$filename,100);

		imagedestroy($src);
		imagedestroy($tmp);
		
		}}
		}

	//---end cut image
	//check sex
	if($get_sex=='M'){
		$get_sex='1';
		}
		else if($get_sex=='F'){
			$get_sex='2';
			}
		else if($get_sex=='U'){
			$get_sex='3';
			}
			else{
				echo"<script>alert('You did not Select Sex!');</script>";
				echo"<script>window.location.href='index.php?pages=new_cust_register&session=restore';</script>";
				}
		//end check sex
		//check max id
		//////////////////
				$query_maxid = "SELECT max(max_id) as code FROM register"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['code'];
						$convert = intval($max);
						$max += 1;
						if (strlen($max)==1){ 
							$max='0000'.$max;
						}
						else if((strlen($max)==2)){
							$max='000'.$max;
						}
						else if((strlen($max)==3)){
							$max='00'.$max;
						}
						else if((strlen($max)==4)){
							$max='0'.$max;
						}
						else {
							$max = $max ;
						}
					}	
		///end check max id
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
	$cid=$get_sex.$get_yearbirth.'-'.$get_reg_month.$get_reg_year.'-'.$get_br.'-'.$max;
	///insert inforation to table request
		if($type=='Loan'){
			if(!empty($borrower) && !empty($kh_borrower) && !empty($loan_amt) && !empty($int) && !empty($period) && !empty($co) && !empty($ltype)){
				$insert_sql =mysql_query("INSERT INTO `register` (
												`id` ,
												`cif` ,
												`register_date` ,
												`times` ,
												`kh_borrower` ,
												`borrower` ,
												`kh_co_borrower` ,
												`co_borrower` ,
												`marital` ,
												`landCost` ,
												`houseCost` ,
												`inMaker` ,
												`eqCost` ,
												`khSpName` ,
												`enSpName` ,
												`dependent` ,
												`relationType` ,
												`freq` ,
												`sex` ,
												`tel` ,
												`idType` ,
												`idNumber` ,
												`cust_dob` ,
												`province` ,
												`district` ,
												`commune` ,
												`village` ,
												`houseNo` ,
												`streetNo` ,
												`loan_request` ,
												`cur` ,
												`rate` ,
												`period` ,
												`recomend_by` ,
												`recomend_name` ,
												`co` ,
												`type_loan` ,
												`purpose` ,
												`cust_photo` ,
												`type_cust` ,
												`branch` ,
												`appr` ,
												`cancel` ,
												`bcif` ,
												`bloan` ,
												`dis` ,
												`max_id` ,
												`post_by` ,
												`dis_by` ,
												`dis_at`
												)
												VALUES (NULL, '$cid', '$regist_date', '$times', '$kh_borrower', '$borrower', '$kh_co_borrower', '$co_borrower', '$marital', '$mylCost', '$myhCost', '$inMaker', '$myeCost', '', '$spName', '$dependent', '$relation','$repay_type', '$mysex', '$tel','$idType','$idNo', '$dob', '$pro', '$dist', '$com', '$vil','$houseNo','$streetNo', '$myloan', '$cur', '$int', '$period', '$recom_pos', '$recom_name', '$co', '$ltype', '$purposedes', '$image', 'new', '$get_br', '$appSet', '0', '1', '0', '0', '$max', '$user', '', ''
												);");
				///insert Approval
				if($appSet=='1'){
				$app_sql=mysql_query("INSERT INTO `customer_app` (
								`id` ,
								`cid` ,
								`register_date` ,
								`approval_date` ,
								`approval_amt` ,
								`approval_rate` ,
								`approval_period` ,
								`method` ,
								`number_of_repay` ,
								`approval_by` ,
								`recom_name` ,
								`response_co` ,
								`description` ,
								`approval_at`,
								`cur`
								)
								VALUES (
								NULL, '$cid', '$regist_date', '$regist_date', '$myloan', '$int', '$period', '', '$repay_type', '','$recom_name','$co', '','$get_br','$cur'
								);"); 
				}
						/////// 			
				echo"<script>alert('Saved Successful!');</script>";
				echo"<script>alert('Plese Note CID of Customer -> $cid');</script>";
				echo"<script>window.location.href='index.php?pages=new_cust_register&session=restore';</script>";
				}
				else{
					echo"<script>alert('Unsuccessful!');</script>";
					}
		}
		else{
			if(!empty($borrower) && !empty($kh_borrower) ){
				$insert_sql =mysql_query("INSERT INTO `register` (
												`id` ,
												`cif` ,
												`register_date` ,
												`times` ,
												`kh_borrower` ,
												`borrower` ,
												`kh_co_borrower` ,
												`co_borrower` ,
												`marital` ,
												`landCost` ,
												`houseCost` ,
												`inMaker` ,
												`eqCost` ,
												`khSpName` ,
												`enSpName` ,
												`dependent` ,
												`relationType` ,
												`freq` ,
												`sex` ,
												`tel` ,
												`idType` ,
												`idNumber` ,
												`cust_dob` ,
												`province` ,
												`district` ,
												`commune` ,
												`village` ,
												`houseNo` ,
												`streetNo` ,
												`loan_request` ,
												`cur` ,
												`rate` ,
												`period` ,
												`recomend_by` ,
												`recomend_name` ,
												`co` ,
												`type_loan` ,
												`purpose` ,
												`cust_photo` ,
												`type_cust` ,
												`branch` ,
												`appr` ,
												`cancel` ,
												`bcif` ,
												`bloan` ,
												`dis` ,
												`max_id` ,
												`post_by` ,
												`dis_by` ,
												`dis_at`
												)
												VALUES (NULL, '$cid', '$regist_date', '$times', '$kh_borrower', '$borrower', '$kh_co_borrower', '$co_borrower', '$marital', '$mylCost', '$myhCost', '$inMaker', '$myeCost', '', '$spName', '$dependent', '$relation','$repay_type', '$mysex', '$tel','$idType','$idNo', '$dob', '$pro', '$dist', '$com', '$vil','$houseNo','$streetNo', '$myloan', '$cur', '$int', '$period', '$recom_pos', '$recom_name', '$co', '$ltype', '$purposedes', '$image', 'new', '$get_br', '$appSet', '0', '1', '0', '0', '$max', '$user', '', ''
												);");
				///insert Approval
				if($appSet=='1'){
				$app_sql=mysql_query("INSERT INTO `customer_app` (
								`id` ,
								`cid` ,
								`register_date` ,
								`approval_date` ,
								`approval_amt` ,
								`approval_rate` ,
								`approval_period` ,
								`method` ,
								`number_of_repay` ,
								`approval_by` ,
								`recom_name` ,
								`response_co` ,
								`description` ,
								`approval_at`,
								`cur`
								)
								VALUES (
								NULL, '$cid', '$regist_date', '$regist_date', '$myloan', '$int', '$period', '', '$repay_type', '','$recom_name','$co', '','$get_br','$cur'
								);"); 
				}
						/////// 			
				echo"<script>alert('Saved Successful!');</script>";
				echo"<script>alert('Plese Note CID of Customer -> $cid');</script>";
				echo"<script>window.location.href='index.php?pages=new_cust_register&session=restore';</script>";
				}
				else{
					echo"<script>alert('Saving Unsuccessful!');</script>";
					}
		}
	/////end insert infor
	
	}//end isset
?>

<h3 class="tit">Easy New Registration Form :</h3>

		<!-- start id-form -->
        <form name="cust_request" method="post" enctype="multipart/form-data" onsubmit="return formCheck(this);">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle">
		<tr>
			<td><input type="radio" name="type" id="type" value="Loan" checked="checked" onclick="doselect()"/> Loan</td>
			<td><input type="radio" name="type" id="type" value="Saving" onclick="doselect()"/> Saving</td>
		</tr>
        <tr>
			<th valign="top">Registerd Date :</th>
			<td><input type="text" name="reg_date" id="reg_date" value="<?php echo date('d-m-Y'); ?>" autocomplete="off"
             onblur="doDate(this,'em_Date');" class="input-text"/></td>
            <th valign="top">CID :</th>
			<td><input type="text" class="input-text" readonly value="Auto-Generate"/></td>
		</tr>
		<tr>
			<th valign="top">អ្នកខ្ចី :</th>
			<td><input type="text" class="input-text"​ name="kh_bor" id="kh_bor" autocomplete="off" 
            style="font-family:khmer OS; size:10pt" size="16" onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">Borrower :</th>
			<td>
            <input type="text" class="input-text" name="bor" id="bor" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);"/></td>
		</tr>
		<tr>
		<th valign="top">អ្នករួមខ្ចី :</th>
			<td><input type="text" class="input-text"​ name="kh_cobor" id="kh_cobor" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" style="font-family:khmer OS; size:10pt" size="16"/></td>
            <th valign="top">Co-Borrower :</th>
			<td><input type="text" class="input-text" name="cobor" id="cobor" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);"/></td>
		</tr>
		<tr>
		<th valign="top">ភេទ :</th>
		<td>	
		<select class="input-text" name="sex" id="sex" onkeypress="return handleEnter(this, event);">
			<option value="0">--ជ្រើសរើសភេទ--</option>
			<option value="M">ប្រុស-Male</option>
			<option value="F">ស្រី-Female</option>
			<option value="U">មិនស្គាល់-Unknown</option>
		</select>
		</td>
		 <th valign="top">លេខទូរស័ព្ទ :</th>
			<td><input type="text" class="input-text" name="tel" id="tel" autocomplete="off" onkeypress="return handleEnter(this, event);"/></td>
		</tr>
        <tr>
			<th valign="top">ID Type :</th>
			<td><select class="input-text" name="kh_iden" id="kh_iden" onkeypress="return handleEnter(this, event);">
                            <option value="0">--ជ្រើសរើស--</option>
                             <?php 
								$str_kh_iden="Select * from identify order by code DESC;";   
                                      $sql_kh_iden=mysql_query($str_kh_iden);
                                      while ($row=mysql_fetch_array($sql_kh_iden))
                                        {
                                        $id=$row['id'];
                                        $kh_iden=$row['des_kh'];
										$code=$row['code'];
                                        echo '<option value="'.$kh_iden.'">'.$kh_iden.'</option>';
                                        }
							?>
                        </select>
            </td>
            <th valign="top">ID Number :</th>
			<td>
            <input type="text" class="input-text" name="idNo" id="idNo" autocomplete="off" onkeypress="return handleEnter(this, event);"/></td>
		</tr> 
        <tr>
		<th valign="top">DOB :</th>
		<td>	
		<input type="text" class="input-text" name="dob" id="dob" autocomplete="off" onblur="doDate(this,'em_Date');" 
        onkeypress="return handleEnter(this, event);"/>
		</td>
			<th valign="top">Marital Status :</th>
		<td>	
		<select class="input-text" name="marital" id="marital" onkeypress="return handleEnter(this, event);">
					<option value="0">--Choose--</option>
                    <option value="M">Married</option>
                    <option value="S">Single</option>
                    <option value="W">Widow/Widower</option>
                    <option value="D">Divorced</option>
                    <option value="P">Separated</option>
                    <option value="F">Defacto</option>
                    <option value="U">Unknown</option>
		</select>
		</td>
		</tr> 
        <tr>
			<th valign="top">Land Cost :</th>
			<td><input type="text" class="input-text"​ name="landCost" id="landCost" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onchange="this.value=formatCurrency(this.value);"/>
            </td>
            <th valign="top">House Cost :</th>
			<td>
            <input type="text" class="input-text" name="houseCost" id="houseCost" autocomplete="off" 
            onchange="this.value=formatCurrency(this.value);" onkeypress="return handleEnter(this, event);"/></td>
			
		</tr>
         <tr>
			<th valign="top">Income Maker :</th>
			<td><input type="text" class="input-text"​ name="incomeMaker" id="incomeMaker" autocomplete="off" 
            onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">Equipment Cost :</th>
			<td>
            <input type="text" class="input-text" name="ECost" id="ECost" autocomplete="off" 
            onchange="this.value=formatCurrency(this.value);" onkeypress="return handleEnter(this, event);"/></td>
			
		</tr>
         <tr>
			<th valign="top">Spouse Name :</th>
			<td><input type="text" class="input-text"​ name="spName" id="spName" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);"/>
            </td>
            <th valign="top">Dependent :</th>
			<td>
            <input type="text" class="input-text" name="dependent" id="dependent" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);"/></td>
			
		</tr>
         <tr>
			<th valign="top">Relationship :</th>
			<td><input type="text" class="input-text"​ name="relation" id="relation" autocomplete="off" 
            onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">Frequency</th>
			<td>
            	<select name="repay_type" id="repay_type" size="1" class="input-text">
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
            </td>
			
		</tr>
        <tr>
			<th valign="top">House No :</th>
			<td><input type="text" class="input-text"​ name="houseNo" id="houseNo" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);"/>
            </td>
            <th valign="top">Street No :</th>
			<td>
            <input type="text" class="input-text" name="streetNo" id="streetNo" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);"/></td>
			
		</tr>
		<tr>
			<th valign="top">អាសយដ្ឋាន :</th>
			<td colspan="3">
            	<!-- address start -->
                <table hspace="10" class="nostyle">
                	<tr>
                    	<td>
                        		
									<select name="province" class="province" id="province" onkeypress="return handleEnter(this, event);">
											<option value="0">--ជ្រើសរើសខេត្ត/ក្រុង--</option>
												<?php
												
												$sql=mysql_query("select id,province from province");
												while($row=mysql_fetch_array($sql))
												{
												$id=$row['id'];
												$data=$row['province'];
												echo '<option value="'.$id.'">'.$data.'</option>';
												}
											?>
											</select>
								
                        </td>
                        <td>	
                       			 
									<select name="district" class="district" id="district" onkeypress="return handleEnter(this, event);">
										<option value="0">--ជ្រើសរើសស្រុក--</option>
									</select>
								
                        </td>
                        <td>	
                      			 
									<select name="commune" class="commune" id="commune" onkeypress="return handleEnter(this, event);">
										<option value="0">--ជ្រើសរើសឃុំ--</option>
									</select>
								
                        </td>
                        <td>	
                       			
									<select name="village" class="village" id="village" onkeypress="return handleEnter(this, event);">
										<option value="0">--ជ្រើសរើសភូមិ--</option>
									</select>
								
                        </td>
                   	</tr>
                </table>
                <!-- end Loan Pro -->
            </td>
		</tr>
		<tr>
			<th valign="top">Loan Amount :</th>
			<td colspan="3">
            	<!-- address start -->
                <table class="nostyle">
                	<tr>
                    	<td>
                        <div>
                        <input type="text" value="Amount Request" class="input-text" name="loan_amt" id="loan_amt" onblur="if (this.value=='') { this.value='Amount Request'; }" onfocus="if (this.value=='Amount Request') { this.value=''; }" autocomplete="off"
                         onchange="this.value=formatCurrency(this.value);" onkeypress="return handleEnter(this, event);"/>
                        </div>
                        </td>
                        <td>	
                        <div>
                         <select class="input-text" name="cur" id="cur" onkeypress="return handleEnter(this, event);">
                            <option value="0">--Choose Currency--</option>
                             <?php 
								$str="Select * from currency_type group by types desc";
								$sql=mysql_query($str);
								while ($row=mysql_fetch_array($sql))
								{
									$types=trim($row['types']);
									$desc=$row['descript'];
									echo '<option value="'.$types.'">'.$types.'</option>';
								}
						     ?>
                        </select>
                        </div>
                        </td>
                        <td>
                        <div>	
                       <input type="text" value="Rate %" class="input-text" name="int" id="int" onblur="if (this.value=='') { this.value='Rate %'; }" onfocus="if (this.value=='Rate %') { this.value=''; }" autocomplete="off" onkeypress="return handleEnter(this, event);"/>
                       </div>
                        </td>
                        <td>
                        <div>	
                        <input type="text" value="Period Months" class="input-text" name="period" id="period" onblur="if (this.value=='') { this.value='Period Months'; }" onfocus="if (this.value=='Period Months') { this.value=''; }" autocomplete="off"
                         onkeypress="return handleEnter(this, event);"/>
                        </div>
                        </td>
                   	</tr>
                </table>
                <!-- end Loan Pro -->
            </td>
		</tr>
        <tr>
			<th valign="top">Recom's Position :</th>
			<td colspan="3" class="nostyle">
            	<!-- address recom name -->
                <table class="nostyle">
                	<tr>
                    	<td>
                        <div>	
                        <select class="input-text" name="recom_pos" id="recom_pos" onkeypress="return handleEnter(this, event);">
                            <option value="0">--Recommend By--</option>
                             <?php 
							
								$str_posi="Select * from staff_list Group by s_position asc";
								$sql_posi=mysql_query($str_posi);
								while ($row=mysql_fetch_array($sql_posi))
								{
									$s_position=$row['s_position'];
									echo '<option value="'.$s_position.'">' .$s_position. '</option>';
								}
							?>
                        </select>
                        </div>
                        </td>
                        <td>	
                        <div>
                        <select class="input-text" name="recom" id="recom" onkeypress="return handleEnter(this, event);">
                            <option value="0">--Recommender--</option>
                           <?php 
							
								$str_recomname="Select * from staff_list Group by s_name asc";
								$sql_recomname=mysql_query($str_recomname);
								while ($row=mysql_fetch_array($sql_recomname))
								{
									$s_name=$row['s_name'];
									$posi=$row['s_position'];
									echo '<option value="'.$s_name.'">' .$s_name. '  -  (' .$posi. ')</option>';
								}
							?>
                        </select>
                        </div>
                        </td>
                        <td>	
                        <div>
                        <select class="input-text" name="co" id="co" onkeypress="return handleEnter(this, event);">
                            <option value="0">--ភ្នាក់ងារ--</option>
                            <?php 
							
								$str_posi="Select * from staff_list where s_position ='CO' Group by s_name asc";
								$sql_posi=mysql_query($str_posi);
								while ($row=mysql_fetch_array($sql_posi))
								{
									$co_name=$row['s_name_kh'];
									echo '<option value="'.$co_name.'">' .$co_name. '</option>';
								}
							?>
                        </select>
                        </div>
                        </td>
                        <td>	
                        <div>
                        <select class="input-text" name="ltype" id="ltype" onkeypress="return handleEnter(this, event);">
                            <option value="0">--Loan Types--</option>
                             <?php 
							
								$str_ltype="Select * from loan_type order by en_ltype asc";
								$sql_ltype=mysql_query($str_ltype);
								while ($row=mysql_fetch_array($sql_ltype))
								{
									$en_ltype=$row['en_ltype'];
									echo '<option value="'.$en_ltype.'">'.$en_ltype.'</option>';
								}
						?>
                        </select>
                        </div>
                        </td>
                   	</tr>
                </table>
                <!-- end recom name -->
            </td>
		</tr>
	<tr>
		<th valign="top">គោលបំណងខ្ចី :</th>
		<td><textarea rows="" cols="30" class="form-textarea" name="purpose" id="purpose"></textarea></td>
		<td></td>
	</tr>
	<tr>
	<th>Customer's Photo:</th>
	<td><input type="file" class="file_1" name="file" id="file"/></td>
	<td align="left">
	JPEG, GIF 1024px max</div>
	</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td valign="top">
			<input type="submit" value="submit" class="form-submit" name="submit" onclick="return confirm('Are you sure wanna save?');"/>
			<input type="reset" value="reset" class="form-reset"  />
		</td>
		<td></td>
	</tr>
	</table>
    </form>