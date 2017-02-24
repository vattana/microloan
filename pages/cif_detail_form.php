<script type="text/javascript">
	function focusit() {			
		document.getElementById("cid").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<!-- suggestion cif -->
	<script type="text/javascript">
				var nameArray = null;
	</script>
	 <script type="text/javascript">
            function doSuggestionBox(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestions').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestions').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestions(text);
                }
            }
            function outClick() {
                document.getElementById('divSuggestions').style.visibility = 'hidden';
            }
            function doSelection(text) {
                var selection = text;
                document.getElementById('divSuggestions').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("cid").value = selection;
            }
            function changeBG(obj) {
                element = document.getElementById(obj);
                oldColor = element.style.backgroundColor;
                if (oldColor == "white" || oldColor == "") {
                    element.style.background = "blue";
                    element.style.color = "white";
                    element.style.cursor = "pointer";
                } else {
                    element.style.background = "white";
                    element.style.color = "#333333";
                    element.style.cursor = "pointer";
                }
            }
            function doSuggestions(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBG(this.id);' onMouseOut='changeBG(this.id);' onclick='doSelection(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClick();
                }
                document.getElementById('divSuggestions').innerHTML = code;
                document.getElementById('divSuggestions').style.overflow='auto';
            }
        </script>

<style type="text/css">
            <!--
            div.suggestions {
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                border: 1px solid #999999;
                text-align: left;
				z-index:0;
            }
            -->
</style>
<!-- end suggestion cif -->
<?php
	$query = "SELECT cif FROM register where appr='1' and cancel ='0' and bcif='0' GROUP BY cif DESC";
        $result = mysql_query($query);
        $counter = 0;
        echo("<script type='text/javascript'>");
        echo("this.nameArray = new Array();");
        if($result) {
            while($row = mysql_fetch_array($result)) {
                echo("this.nameArray[" . $counter . "] = '" . trim($row['cif']) . " ';");
                $counter += 1;
            }
        }
        echo("</script>");
?>
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
function formCheck(formobj){
	var person_type=document.getElementById('per_type').value;
	var relational=document.getElementById('cust_kind').value;
	var biz_type=document.getElementById('biz_type').value;
	if(person_type=='0'){alert('Please Select Personal Type!');return false;}
	if(relational=='0'){alert('Please Select Relational Type!');return false;}
	if(biz_type=='0'){alert('Please Select Business Type!');return false;}
	
	// Enter name of mandatory fields
	var fieldRequired = Array("entry_date","kh_name","en_name","cid");
	// Enter field description to appear in the dialog box
	var fieldDescription = Array("Registration Date","ឈ្មោះ","Name","Customer ID");
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
<?php
	$user = $_SESSION['usr'];
	//display
		if(isset($_POST['display'])){
			
			$cid_display=$_POST['cid'];
			$display_info="SELECT * FROM register WHERE cif='$cid_display' AND appr='1' AND cancel='0' AND bcif='0' AND bloan='0' AND dis='0' ORDER BY id DESC";
		$result_info=mysql_query($display_info) or die (mysql_error());
			while($row=mysql_fetch_array($result_info)){
					$regis_id=$row['id'];
					$reg_date=date('d-m-Y',strtotime($row['register_date']));
					$kh_borrower=$row['kh_borrower'];
					$borrower=$row['borrower'];
					$mysex=$row['sex'];
					$mytel=$row['tel'];
					$cus_dob=$row['cust_dob'];
					$mydob=date('d-m-Y',strtotime($cus_dob));
				}
			}//end if
	//end display
	if(isset($_POST['submit'])){
		
		///check branch no
					$br_ip = $_SERVER['REMOTE_ADDR'];
					$br_sql="Select * from br_ip_mgr where set_ip ='$br_ip'";
					$result_br=mysql_query($br_sql) or die (mysql_error());
						while($row = mysql_fetch_array($result_br))
								{
									$get_ip=$row['set_ip'];
									$get_br=$row['br_no'];	 
								}
		//end check branch no
		$cid=trim($_POST['cid']);
		$entry_date=date('Y-m-d',strtotime($_POST['entry_date']));
		$per_type=$_POST['per_type'];
		$kh_name=$_POST['kh_name'];
		$en_name=$_POST['en_name'];
		$kh_nation_post=$_POST['kh_nation'];
		$en_nation_post=$_POST['en_nation'];
		$sex=$_POST['sex'];
		$sw_sex=$_POST['de_sex'];
		if($sex=='0'){
			$sex=$sw_sex;
			}
		$tel=$_POST['tel'];
		$dob=date('Y-m-d',strtotime($_POST['dob']));
		$kh_marital=$_POST['kh_marital'];
		$en_marital=$_POST['en_marital'];
		$children=$_POST['children'];
		$son=$_POST['son'];
		$daughter=$_POST['daughter'];
		$load_person=$_POST['loan_person'];
		$income_member=$_POST['income_member'];
		$kh_iden_post=$_POST['kh_iden'];
		$id_no=$_POST['id_no'];
		$kh_issued_by=$_POST['kh_issued_by'];
		$issued_date=$_POST['issued_date'];
		$houseNo=$_POST['houseNo'];
		$streetNo=$_POST['streetNo'];
		$pro=$_POST['province'];
		$dis=$_POST['district'];
		$com=$_POST['commune'];
		$vil=$_POST['village'];
		
		$posi=$_POST['posi'];
		$occu=$_POST['occu'];
		$repre_for=$_POST['repre_for'];
		$company_adr=$_POST['company_adr'];
		$license=$_POST['license'];
		$form_biz=$_POST['form_biz'];
		$place_occu=$_POST['place_occu'];
		$no_branch=$_POST['no_branch'];
		$duration=$_POST['duration'];
		$target_market=$_POST['target_market'];
		$no_customer=$_POST['no_customer'];
		$occ_type_post=$_POST['occ_type'];
		$biz_type_post=$_POST['biz_type'];
		$biz_type_cat_post=$_POST['biz_type_cat'];
		$cust_kind=$_POST['cust_kind'];
		$relationship=trim($_POST['relationship']);
		//check if empty
		if(!empty($kh_name)&&!empty($en_name) && !empty($per_type) && !empty($biz_type_post)){
				$insert_cif=mysql_query("INSERT INTO `cif_detail` (
								`id` ,
								`reg_id` ,
								`date_entry` ,
								`cif` ,
								`kh_name` ,
								`name` ,
								`person_type` ,
								`nationality` ,
								`nationality_kh` ,
								`sex` ,
								`tel` ,
								`dob` ,
								`marital_status` ,
								`marital_status_kh` ,
								`children` ,
								`son` ,
								`daughter` ,
								`load_person` ,
								`income_member` ,
								`identification` ,
								`identification_kh` ,
								`id_no` ,
								`issued_by` ,
								`issued_by_kh` ,
								`issued_date` ,
								`houseNo` ,
								`streetNo` ,
								`village` ,
								`commune` ,
								`district` ,
								`province` ,
								`position` ,
								`occupation` ,
								`represented_for` ,
								`company_adr` ,
								`license` ,
								`form_of_business` ,
								`place_of_occupation` ,
								`no_of_branch` ,
								`duration_of_occu` ,
								`target_market` ,
								`no_of_customer` ,
								`occupation_type` ,
								`business_type` ,
								`business_type_cat` ,
								`relationship` ,
								`cust_kind` ,
								`entry_by` ,
								`entry_at`
								)
								VALUES (
								NULL , '', '$entry_date', '$cid', '$kh_name', '$en_name', '$per_type', '$en_nation_post', '$kh_nation_post', '$sex', '$tel', '$dob', '$en_marital', '$kh_marital', '$children', '$son', '$daughter', '$load_person', '$income_member', '', '$kh_iden', '$id_no', '', '$kh_issued_by', '$issued_date', '$houseNo', '$streetNo', '$vil', '$com', '$dis', '$pro', '$posi', '$occu', '$repre_for', '$company_adr', '$license', '$form_biz', '$place_occu', '$no_branch', '$duration', '$target_market', '$no_customer', '$occ_type_post', '$biz_type_post', '$biz_type_cat_post', '$relationship', '$cust_kind', '$user', '$get_br'
);");
				echo"<center><h3 style='color:blue;'>Save Successful! Please input Co-Borrower information if you have !</h3></center>";
				//------update register
				$update_regis=mysql_query("UPDATE register SET bcif='1' where cif ='$cid'");
				//-------------------
			}
			else{
				echo"<script>alert('Save Not Successful! Try Again!');</script>";
				}
	}//end isset
?>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">
<div id="page-heading"><h1>Easy CIF Detail Form :</h1></div>

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>	
		<!--  start step-holder -->
		<div id="step-holder">
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no">2</div>
			<div class="step-dark-left">CIF Detail</div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no">3</div>
			<div class="step-dark-left">Loan & Disburse</div>
			<div class="step-dark-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
		<!-- start id-form -->
        <form name="cust_request" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'">
         <tr>
		<th valign="top">CID :</th>
		<td>	
		<input type="text" class="inp-form" name="cid" id="cid" autocomplete="off" onKeyPress="return handleEnter(this, event);" 
        onKeyUp="doSuggestionBox(this.value);" value="<?php echo $cid; ?>"/>
         <input type="submit" name="display" value="+"/>
		</td>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
        </tr>
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
				<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 15%;
						 	margin-top:-24px; background-color: #FFFFFF;float:right; 
							color: #666666; height: 100px; padding-left: 5px;position:absolute;">
                </div>
		</td>
			<th>&nbsp;</th>
			<td>&nbsp;</td>
		</tr> 
		<tr>
			<th valign="top">Entry Date :</th>
			<td><input type="text" class="inp-form" name="entry_date" id="entry_date" value="<?php echo date('d-m-Y'); ?>" autocomplete="off"
             onblur="doDate(this,'em_Date');"/></td>
            <th valign="top">Personal Type :</th>
			<td>
            	<select class="styledselect_form_1" name="per_type" id="per_type" onkeypress="return handleEnter(this, event);">
                    <option value="0">--Choose--</option>
                    <option value="single">Single Person</option>
                    <option value="legal">Legal Person</option>
				</select>
            </td>
		</tr>
		<tr>
			<th valign="top">ឈ្មោះ :</th>
			<td><input type="text" class="inp-form"​ name="kh_name" id="kh_name" autocomplete="off" 
            value="<?php echo $kh_borrower ?>" onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">Name :</th>
			<td>
            <input type="text" class="inp-form" name="en_name" id="en_name" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $borrower ?>"/></td>
			
		</tr>
		<tr>
		<th valign="top">សញ្ជាតិ :</th>
			<td>
            <select class="styledselect_form_1" name="kh_nation" id="kh_nation" onkeypress="return handleEnter(this, event);">
                            <option value="0">--ជ្រើសរើស--</option>
                             <?php 
								$str_kh_nation="Select * from nation order by id ASC;";   
                                      $sql_kh_nation=mysql_query($str_kh_nation);
                                      while ($row=mysql_fetch_array($sql_kh_nation))
                                        {
                                        $id=$row['id'];
                                        $kh_nation=$row['na_kh'];
										$code=$row['code'];
                                        echo '<option value="'.$kh_nation.'">'.$kh_nation.'</option>';
                                        }
							?>
                        </select>
            </td>
            <th valign="top">Nationality :</th>
			<td>
             <select class="styledselect_form_1" name="en_nation" id="en_nation" onkeypress="return handleEnter(this, event);">
                            <option value="0">--Choose--</option>
                             <?php 
								$str_en_nation="Select * from nation order by id ASC;";   
                                      $sql_en_nation=mysql_query($str_en_nation);
                                      while ($row=mysql_fetch_array($sql_en_nation))
                                        {
                                        $id=$row['id'];
                                        $en_nation=$row['na_en'];
										$code=$row['code'];
                                        echo '<option value="'.$en_nation.'">'.$en_nation.'</option>';
                                        }
							?>
                        </select>
            </td>
		</tr>
		<tr>
		<th valign="top">ភេទ :</th>
		<td>	
            <select class="styledselect_form_1" name="sex" id="sex" onkeypress="return handleEnter(this, event);">
                <option value="0">--ជ្រើសរើសភេទ--</option>
                <option value="M">ប្រុស-Male</option>
                <option value="F">ស្រី-Female</option>
                <option value="U">មិនស្គាល់-Unknown</option>
            </select>
            <?php echo 'Current Sex is <font color="#FF0000">' .$mysex.'</font>'; ?>
            <input type="hidden" name="de_sex" value="<? echo $mysex; ?>"/>
		</td>
		 <th valign="top">លេខទូរស័ព្ទ :</th>
			<td><input type="text" class="inp-form" name="tel" id="tel" autocomplete="off" 
            value="<?php echo $mytel; ?>" onkeypress="return handleEnter(this, event);"/></td>
		</tr> 
        <tr>
		<th valign="top">DOB :</th>
		<td>	
		<input type="text" class="inp-form" name="dob" id="dob" autocomplete="off" onblur="doDate(this,'em_Date');" 
        onkeypress="return handleEnter(this, event);" value="<?php echo $mydob; ?>"/>
		</td>
			<td align="left"><div class="error-left"></div>
			<div class="error-inner">dd-mm-yyyy</div></td>
		</tr> 
		<tr>
		<th valign="top">ស្ថានភាពគ្រួសារ :</th>
		<td>	
            <select class="styledselect_form_1" name="kh_marital" id="kh_marital" onkeypress="return handleEnter(this, event);">
                    <option value="0">--ជ្រើសរើស--</option>
                    <option value="M">រៀបការរួច</option>
                    <option value="S">នៅលីវ</option>
                    <option value="W">ពោះម៉ាយ/ម៉េម៉ាយ</option>
                    <option value="D">លែងលះ</option>
                    <option value="P">រស់នៅផ្សេងគ្នា</option>
                    <option value="F">គូរស្រករឥតខាន់ស្លា</option>
                    <option value="U">មិនដឹង</option>
            </select>
		</td>
		 <th valign="top">Marital Status :</th>
			<td>
            <select name="en_marital"  class="styledselect_form_1" name="en_marital" id="en_marital">
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
		<th valign="top">Children :</th>
			<td><input type="text" class="inp-form"​ name="children" id="children" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $children;?>"/></td>
            <th valign="top">Son :</th>
			<td><input type="text" class="inp-form" name="son" id="son" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $son ;?>"/></td>
		</tr>
        <tr>
		<th valign="top">Daughter :</th>
			<td><input type="text" class="inp-form"​ name="daughter" id="daughter" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $daughter ;?>"/></td>
            <th valign="top">Load Person :</th>
			<td><input type="text" class="inp-form" name="load_person" id="load_person" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $load_person ;?>"/></td>
		</tr>
        <tr>
		<th valign="top">Income Member :</th>
			<td><input type="text" class="inp-form"​ name="income_member" id="income_member" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $income_member ;?>"/></td>
            <th valign="top">លិខិតបញ្ជាក់ :</th>
			<td>
            	<select class="styledselect_form_1" name="kh_iden" id="kh_iden" onkeypress="return handleEnter(this, event);">
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
		</tr>
         <tr>
		<th valign="top">ID No :</th>
			<td><input type="text" class="inp-form"​ name="id_no" id="id_no" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $id_no ;?>"/></td>
            <th valign="top">ចេញដោយ :</th>
			<td><input type="text" class="inp-form" name="kh_issued_by" id="kh_issued_by" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $kh_issued_by ;?>"/></td>
		</tr>
        <tr>
		<th valign="top">Issued Date :</th>
		<td>	
		<input type="text" class="inp-form" name="issued_date" id="issued_date" autocomplete="off" onblur="doDate(this,'em_Date');" 
        onkeypress="return handleEnter(this, event);" value="<?php echo $issued_date ;?>"/>
		</td>
			<td align="left"><div class="error-left"></div>
			<div class="error-inner">dd-mm-yyyy</div></td>
		</tr> 
		<tr>
		<th valign="top">House N<sup>o</sup> :</th>
			<td><input type="text" class="inp-form"​ name="houseNo" id="houseNo" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $houseNo ;?>"/></td>
            <th valign="top">Street N<sup>o</sup> :</th>
			<td><input type="text" class="inp-form" name="streetNo" id="streetNo" autocomplete="off"  
            onkeypress="return handleEnter(this, event);" value="<?php echo $streetNo ;?>"/></td>
		</tr>
        <tr>
			<th valign="top">អាសយដ្ឋាន :</th>
			<td colspan="3">
            	<!-- address start -->
                <table hspace="10">
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
        <th valign="top">Position :</th>
			<td><input type="text" class="inp-form"​ name="posi" id="posi" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $posi ;?>"/></td>
            <th valign="top">Occupation :</th>
			<td><input type="text" class="inp-form" name="occu" id="occu" autocomplete="off"  
            onkeypress="return handleEnter(this, event);" value="<?php echo $occu ;?>"/></td>
		</tr>
         <tr>
        <th valign="top">Represented For :</th>
			<td><input type="text" class="inp-form"​ name="repre_for" id="repre_for" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $repre_for ;?>"/></td>
            <th valign="top">&nbsp;</th>
			<td>&nbsp;
            	
            </td>
		</tr>
        <tr>
		<th valign="top">Company Address :</th>
            <td><textarea rows="" cols="" class="form-textarea" name="company_adr" id="company_adr"><?php echo $load_person ;?></textarea></td>
            <td>&nbsp;</td>
		</tr>
         <tr>
        <th valign="top">Number Of Customer :</th>
			<td><input type="text" class="inp-form"​ name="no_customer" id="no_customer" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $no_customer ;?>"/></td>
            <th valign="top">Occupatoin Type :</th>
			<td>
            <select class="styledselect_form_1" name="occ_type" id="occ_type" onkeypress="return handleEnter(this, event);">
                            <option value="0">--Choose--</option>
                             <?php 
								$str_occ_type="Select * from occu_type order by id DESC;";   
                                      $sql_occ_type=mysql_query($str_occ_type);
                                      while ($row=mysql_fetch_array($sql_occ_type))
                                        {
                                        $id=$row['id'];
                                        $occ_type=$row['occ_type'];
                                        echo '<option value="'.$occ_type.'">'.$occ_type.'</option>';
                                        }
							?>
                        </select>
            </td>
		</tr>
        <tr>
        <th valign="top">Business Type :</th>
			<td>
            <select class="styledselect_form_1" name="biz_type" id="biz_type" onkeypress="return handleEnter(this, event);">
                            <option value="0">--Choose--</option>
                             <?php 
								$str_biz_type="Select * from business_type order by id ASC;";   
                                      $sql_biz_type=mysql_query($str_biz_type);
                                      while ($row=mysql_fetch_array($sql_biz_type))
                                        {
                                        $id=$row['id'];
                                        $biz_type=$row['business'];
                                        echo '<option value="'.$biz_type.'">'.$biz_type.'</option>';
                                        }
							?>
                        </select>
            </td>
            <th valign="top">Categories :</th>
			<td>
            <select class="styledselect_form_1" name="biz_type_cat" id="biz_type_cat" onkeypress="return handleEnter(this, event);">
                            <option value="0">--Choose--</option>
                             <?php 
								$str_biz_type_cat="Select * from business_type_cat order by id ASC;";   
                                      $sql_biz_type_cat=mysql_query($str_biz_type_cat);
                                      while ($row=mysql_fetch_array($sql_biz_type_cat))
                                        {
                                        $id=$row['id'];
                                        $bu_kh=$row['bu_kh'];
                                        echo '<option value="'.$bu_kh.'">'.$bu_kh.'</option>';
                                        }
							?>
                        </select>
            </td>
		</tr>
        <tr>
        <th valign="top">Relational Type :</th>
			<td>
             <select class="styledselect_form_1" name="cust_kind" id="cust_kind" onkeypress="return handleEnter(this, event);">
                <option value="0">--ជ្រើសរើស--</option>
                <option value="borrower">Borrower</option>
                <option value="co-borrower">Co-Borrower</option>
            </select>
            </td>
            <th valign="top">Relationship :</th>
			<td><input type="text" class="inp-form" name="relationship" id="relationship" autocomplete="off"  
            onkeypress="return handleEnter(this, event);" value="<?php echo $relationship ;?>"/></td>
		</tr>
        <tr>
        <th valign="top">License :</th>
			<td><input type="text" class="inp-form"​ name="license" id="license" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $license ;?>"/></td>
            <th valign="top">Form Of Business :</th>
			<td><input type="text" class="inp-form" name="form_biz" id="form_biz" autocomplete="off"  
            onkeypress="return handleEnter(this, event);" value="<?php echo $form_biz ;?>"/></td>
		</tr>
        <tr>
        <th valign="top">Place Of Occupation :</th>
			<td><input type="text" class="inp-form"​ name="place_occu" id="place_occu" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $place_occu ;?>"/></td>
            <th valign="top">Number Of Branches :</th>
			<td><input type="text" class="inp-form" name="no_branch" id="no_branch" autocomplete="off"  
            onkeypress="return handleEnter(this, event);" value="<?php echo $no_branch ;?>"/></td>
		</tr>
         <tr>
        <th valign="top">Duration Of Occu :</th>
			<td><input type="text" class="inp-form"​ name="duration" id="duration" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $duration ;?>"/></td>
            <th valign="top">Target Market :</th>
			<td><input type="text" class="inp-form" name="target_market" id="target_market" autocomplete="off"  
            onkeypress="return handleEnter(this, event);" value="<?php echo $target_market ;?>"/></td>
		</tr>
       
        
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="submit" class="form-submit" name="submit"/>
                <input type="reset" value="reset" class="form-reset"  />
            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>
	<!-- end id-form  -->
	</td>
	<td>
	<!--  start related-activities -->
	<?php
		include("pages/right_menu.php");
	?>
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>
<div class="clear">&nbsp;</div>
</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->