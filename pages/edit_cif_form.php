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
	$query = "SELECT cif FROM register GROUP BY cif DESC";
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
	include("pages/module.php");
	if(isset($_POST['delete'])){
		$getCid=$_POST['cid'];
		$checkCid=mysql_query("select * from loan_process where cid='$getCid'");
		$mynumcid=mysql_num_rows($checkCid);
		if($mynumcid=='0'){
		$delete=mysql_query("Delete from register where cif='$getCid'");
		$delete=mysql_query("Delete from customer_app where cid='$getCid'");
			echo"<script>alert('$getCid has been deleted successfully');</script>";
			echo"<script>window.location.href='index.php?pages=edit_cif_form&session=restore';</script>";
		}
		else{
			echo"<script>alert('$getCid អតិថិជននេះមានប្រតិបត្តិការណ៍ឥណទាន!');</script>";
			echo"<script>window.location.href='index.php?pages=edit_cif_form&session=restore';</script>";
			}
	}
	//display
		if(isset($_POST['display'])){
			
			$cid_display=$_POST['cid'];
			$display_info="SELECT * FROM register WHERE cif='$cid_display' ORDER BY id DESC";
			$result_info=mysql_query($display_info) or die (mysql_error());
			while($row=mysql_fetch_array($result_info)){
					$regis_id=$row['id'];
					$reg_date=date('d-m-Y',strtotime($row['register_date']));
					$kh_borrower=$row['kh_borrower'];
					$borrower=$row['borrower'];
					$kh_co_borrower=$row['kh_co_borrower'];
					$co_borrower=$row['co_borrower'];
					$mysex=$row['sex'];
					$mytel=$row['tel'];
					$cus_dob=$row['cust_dob'];
					$mydob=date('d-m-Y',strtotime($cus_dob));
					$marital=$row['marital'];
					$lCost=formatMoney($row['landCost'],true);
					$hCost=formatMoney($row['houseCost'],true);
					$inMaker=$row['inMaker'];
					$eqCost=formatMoney($row['eqCost'],true);
					$enSpName=$row['enSpName'];
					$dependent=$row['dependent'];
					$relationType=$row['relationType'];
					$myStreetNo=$row['streetNo'];
					$myhouseNo=$row['houseNo'];
					$myStreetNo=$row['streetNo'];
					$vil=$row['village'];
					$com=$row['commune'];
					$dist=$row['district'];
					$prov=$row['province'];
					$getIdType=$row['idType'];
					$getIdNo=$row['idNumber'];
					break;
				}
				//////show village					
					$village_sql="SELECT * FROM village WHERE id ='$vil'";
							$result_vil=mysql_query($village_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_vil))
									{
										$get_village=$row['village'];
										//echo $show_commune;
										break;
									}
					//////show commune
					$commune_sql="SELECT * FROM adr_commune WHERE id ='$com'";
							$result_com=mysql_query($commune_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_com))
									{
										$get_commune=$row['commune'];
										//echo $show_commune;
										break;
									}
					//////show district
					$district_sql="SELECT * FROM district WHERE id ='$dist'";
							$result_dis=mysql_query($district_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_dis))
									{
										$get_district=$row['district'];
										//echo $show_commune;
										break;
									}
					//////show province
					$province_sql="SELECT * FROM province WHERE id ='$prov'";
							$result_prov=mysql_query($province_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_prov))
									{
										$get_province=$row['province'];
										//echo $show_commune;
										break;
									}
					
			}//end if
	//end display
	if(isset($_POST['edit'])){
		//end check branch no
		$cid=trim($_POST['cid']);
		//get again
		$display_info="SELECT * FROM register WHERE cif='$cid' ORDER BY id DESC";
			$result_info=mysql_query($display_info) or die (mysql_error());
			while($row=mysql_fetch_array($result_info)){
					$getSex=$row['sex'];
					$getMarital=$row['marital'];
					$getvil=$row['village'];
					$getcom=$row['commune'];
					$getdist=$row['district'];
					$getprov=$row['province'];
					break;
			}
		/////
		$editDate=date('Y-m-d',strtotime($_POST['edit_date']));
		$myregDate=date('Y-m-d',strtotime($_POST['reg_date']));
		$kh_bor=$_POST['kh_bor'];
		$bor=$_POST['bor'];
		$kh_co_bor=$_POST['kh_cobor'];
		$co_bor=$_POST['cobor'];
		$sex=$_POST['sex'];
		if($sex=='0'){
			$sex=$getSex;
			}
		$tel=$_POST['tel'];
		$dob=date('Y-m-d',strtotime($_POST['dob']));
		$mymarital=$_POST['marital'];
		if($mymarital=='0'){
			$mymarital=$getMarital;
			}
		$landCost=$_POST['landCost'];
		$houseCost=$_POST['houseCost'];
		$eCost=$_POST['ECost'];
		$inMaker=$_POST['incomeMaker'];
		$spName=$_POST['spName'];
		$dependent=$_POST['dependent'];
		//
		$spit = array(",", "'");
 		$mylCost = str_replace($spit, "",$landCost);
 		$myhCost = str_replace($spit, "",$houseCost);
 		$myeCost = str_replace($spit, "",$eCost);
		//
		$houseNo=$_POST['houseNo'];
		$streetNo=$_POST['streetNo'];
		$pro=$_POST['province'];
		$dis=$_POST['district'];
		$com=$_POST['commune'];
		$vil=$_POST['village'];
		$getRelation=trim($_POST['relation']);
		$idType=$_POST['kh_iden'];
		$idNo=$_POST['idNo'];
		
		if($pro=='0'){
			$pro=$getprov;
			}
		if($dis=='0'){
			$dis=$getdist;
			}
		if($com=='0'){
			$com=$getcom;
			}
		if($vil=='0'){
			$vil=$getvil;
			}
		//check if empty
		if(!empty($kh_bor)&&!empty($bor)&&!empty($cid)){
				$edit_cif=mysql_query("UPDATE `register` SET `register_date` = '$myregDate',
											`kh_borrower` = '$kh_bor',
											`borrower` = '$bor',
											`kh_co_borrower` = '$kh_co_bor',
											`co_borrower` = '$co_bor',
											`marital` = '$mymarital',
											`landCost` = '$mylCost',
											`houseCost` = '$myhCost',
											`inMaker` = '$inMaker',
											`eqCost` = '$myeCost',
											`enSpName` = '$spName',
											`dependent` = '$dependent',
											`relationType` = '$getRelation',
											`sex` = '$sex',
											`tel` = '$tel',
											`idType` = '$idType',
											`idNumber` = '$idNo',
											`cust_dob` = '$dob',
											`province` = '$pro',
											`district` = '$dis',
											`commune` = '$com',
											`village` = '$vil',
											`houseNo` = '$houseNo',
											`streetNo` = '$streetNo' WHERE `cif` ='$cid' LIMIT 1 ;");
				
				echo"<script>alert('Update Successful!!');</script>";
			}
			else{
				echo"<script>alert('Update Not Successful!Please Try Again!!');</script>";
				}
	}//end isset
?>
<!-- start content-outer -->
<h3 class="tit">Edit CIF Form :</h3>

		<!-- start id-form -->
        <form name="cust_request" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'" class="nostyle">
         <tr>
		<th valign="top">CID :</th>
		<td>	
		<input type="text" class="input-text" name="cid" id="cid" autocomplete="off" onKeyPress="return handleEnter(this, event);" 
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
			<th valign="top">Registerd Date :</th>
			<td><input type="text" class="input-text" name="reg_date" id="reg_date" value="<?php echo $reg_date ?>" autocomplete="off"
             onblur="doDate(this,'em_Date');"/></td>
            <th valign="top">Edit Date :</th>
			<td><input type="text" class="input-text" name="edit_date" id="edit_date" value="<?php echo date('d-m-Y'); ?>" autocomplete="off"
             onblur="doDate(this,'em_Date');"/></td>
		</tr>
		<tr>
			<th valign="top">អ្នកខ្ចី :</th>
			<td><input type="text" class="input-text"​ name="kh_bor" id="kh_bor" autocomplete="off" 
            value="<?php echo $kh_borrower ?>" onkeypress="return handleEnter(this, event);" style="font-family:khmer OS; size:10pt" size="16"/>
            </td>
            <th valign="top">Borrower :</th>
			<td>
            <input type="text" class="input-text" name="bor" id="bor" autocomplete="off" onblur="ChangeCase(this);"
            onkeypress="return handleEnter(this, event);" value="<?php echo $borrower ?>"/></td>
			
		</tr>
		<tr>
		<th valign="top">អ្នករួមខ្ចី :</th>
			<td><input type="text" class="input-text"​ name="kh_cobor" id="kh_cobor" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $kh_co_borrower ?>" style="font-family:khmer OS; size:10pt" size="16"/></td>
            <th valign="top">Co-Borrower :</th>
			<td><input type="text" class="input-text" name="cobor" id="cobor" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);" value="<?php echo $co_borrower ?>"/></td>
		</tr>
		<tr>
		<th valign="top">ភេទ :</th>
		<td>	
        <?php echo $mysex ?>
		<select class="input-text" name="sex" id="sex">
			<option value="0">--ជ្រើសរើសភេទ--</option>
			<option value="M">ប្រុស-Male</option>
			<option value="F">ស្រី-Female</option>
			<option value="U">មិនស្គាល់-Unknown</option>
		</select>
		</td>
		 <th valign="top">លេខទូរស័ព្ទ :</th>
			<td><input type="text" class="input-text" name="tel" id="tel" autocomplete="off" 
             value="<?php echo $mytel ?>" onkeypress="return handleEnter(this, event);"/></td>
		</tr>
         <tr>
			<th valign="top">ID Type :</th>
			<td><select class="input-text" name="kh_iden" id="kh_iden" onkeypress="return handleEnter(this, event);">
                            <option value="<? echo trim($getIdType);?>"><? echo $getIdType;?></option>
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
            <input type="text" class="input-text" name="idNo" id="idNo" autocomplete="off" 
            value="<? echo trim($getIdNo);?>" onkeypress="return handleEnter(this, event);"/></td>
		</tr>  
        <tr>
		<th valign="top">DOB :</th>
		<td>	
		<input type="text" class="input-text" name="dob" id="dob" autocomplete="off" onblur="doDate(this,'em_Date');" 
        onkeypress="return handleEnter(this, event);"  value="<?php echo $mydob ?>"/>
		</td>
			<th valign="top">Marital Status :</th>
		<td>
         <?php echo $marital ?>
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
            onkeypress="return handleEnter(this, event);" onchange="this.value=formatCurrency(this.value);" value="<? echo trim($lCost);?>"/>
            </td>
            <th valign="top">House Cost :</th>
			<td>
            <input type="text" class="input-text" name="houseCost" id="houseCost" autocomplete="off" 
            onchange="this.value=formatCurrency(this.value);" onkeypress="return handleEnter(this, event);" value="<? echo $hCost; ?>"/></td>
			
		</tr>
         <tr>
			<th valign="top">Income Maker :</th>
			<td><input type="text" class="input-text"​ name="incomeMaker" id="incomeMaker" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<? echo $inMaker; ?>"/>
            </td>
            <th valign="top">Equipment Cost :</th>
			<td>
            <input type="text" class="input-text" name="ECost" id="ECost" autocomplete="off" 
            onchange="this.value=formatCurrency(this.value);" onkeypress="return handleEnter(this, event);" value="<? echo $eqCost; ?>"/></td>
			
		</tr>
         <tr>
			<th valign="top">Spouse Name :</th>
			<td><input type="text" class="input-text"​ name="spName" id="spName" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);" value="<? echo $enSpName; ?>"/>
            </td>
            <th valign="top">Dependent :</th>
			<td>
            <input type="text" class="input-text" name="dependent" id="dependent" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);" value="<? echo $dependent; ?>"/></td>
			
		</tr>
         <tr>
			<th valign="top">Relationship :</th>
			<td><input type="text" class="input-text"​ name="relation" id="relation" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<? echo $relationType; ?>"/>
            </td>
           <th valign="top">Edit By :</th>
			<td><input type="text" class="input-text"​ name="editBy" id="editBy" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<? echo $user; ?>"/>
            </td>
			
		</tr>
        <tr>
			<th valign="top">House No :</th>
			<td><input type="text" class="input-text"​ name="houseNo" id="houseNo" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);" value="<? echo $myhouseNo; ?>"/>
            </td>
            <th valign="top">Street No :</th>
			<td>
            <input type="text" class="input-text" name="streetNo" id="streetNo" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);" value="<? echo $myStreetNo; ?>"/></td>
			
		</tr>
        <tr>
			<th valign="top">អាសយដ្ឋានចាស់ :</th>
			<td colspan="3">
            	<!-- address start -->
                <table hspace="10" class="nostyle">
                	<tr>
                    	<td>
                        	<input type="text" class="input-text"​ name="pro" id="pro" autocomplete="off" value="<? echo $get_province; ?>"/>
								
                        </td>
                        <td>	
                       		<input type="text" class="input-text"​ name="dist" id="dist" autocomplete="off" value="<? echo $get_district; ?>"/>
                        </td>
                        <td>	
                      		<input type="text" class="input-text"​ name="com" id="com" autocomplete="off" value="<? echo $get_commune; ?>"/>
                        </td>
                        <td>	
                       		<input type="text" class="input-text"​ name="vil" id="vil" autocomplete="off" value="<? echo $get_village; ?>"/>
                        </td>
                   	</tr>
                </table>
                <!-- end Loan Pro -->
            </td>
		</tr>
		<tr>
			<th valign="top">អាសយដ្ឋានថ្មី :</th>
			<td colspan="3">
            	<!-- address start -->
                <table hspace="10" class="nostyle">
                	<tr>
                    	<td>
                        		
									<select name="province" class="province" id="province" size="1">
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
                       			 
									<select name="district" class="district" id="district">
										<option value="0">--ជ្រើសរើសស្រុក--</option>
									</select>
								
                        </td>
                        <td>	
                      			 
									<select name="commune" class="commune" id="commune">
										<option value="0">--ជ្រើសរើសឃុំ--</option>
									</select>
								
                        </td>
                        <td>	
                       			
									<select name="village" class="village" id="village">
										<option value="0">--ជ្រើសរើសភូមិ--</option>
									</select>
								
                        </td>
                   	</tr>
                </table>
                <!-- end Loan Pro -->
            </td>
		</tr>
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="edit" class="input-text" name="edit" 
                onclick="return confirm('Are you sure wanna update <? echo $cid_display.':'.$kh_borrower ;?>?');"/>
                <input type="submit" value="Delete" class="input-text" name="delete" 
                onclick="return confirm('Are you sure wanna delete <? echo $cid_display.':'.$kh_borrower ;?>?');"/>
                <input type="reset" value="reset" class="input-text"  />
            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>