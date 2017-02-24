<script type="text/javascript">
	function focusit() {			
		document.getElementById("kh_bor").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<style type="text/css">
	
		td		{padding:3px; padding-left:10px; text-align:left}
		tr.odd	{background:#FFF;}
		tr.highlight	{background:#CCC;}
		tr.selected		{background:#FFF;color:#00F;}
</style>
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
	var mycur=document.getElementById('cur').value;
	var loan_type=document.getElementById('ltype').value;
	var sex=document.getElementById('sex').value;
	var co=document.getElementById('co').value;
	var marital=document.getElementById('marital').value;
	var freq=document.getElementById("repay_type").value;
	
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
		$colType=$_POST['colType'];
		$titleNo=$_POST['titleNo'];
		
	///insert inforation to table request
		if(!empty($borrower) && !empty($kh_borrower)){
			$insert_sql =mysql_query("INSERT INTO `blacklist` (
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
											`coll_type` ,
											`titleNo` ,
											`idType` ,
											`idNumber`
											)
											VALUES (NULL, '$cid', '$regist_date', '$times', '$kh_borrower', '$borrower', '$kh_co_borrower', '$co_borrower', '$marital', '$mylCost', '$myhCost', '$inMaker', '$myeCost', '', '$spName', '$dependent', '$relation','$repay_type', '$mysex', '$tel', '$dob', '$pro', '$dist', '$com', '$vil','$houseNo','$streetNo', '$myloan', '$cur', '$int', '$period', '$recom_pos', '$recom_name', '$co', '$ltype', '$purposedes', '$image', 'new', '$get_br', '$appSet', '0', '1', '', '', '$colType', '$titleNo', '$idType', '$idNo'
											);");
					/////// 			
			echo"<script>alert('Saved Successful!');</script>";
			echo"<script>window.location.href='index.php?pages=add_blackList&session=restore';</script>";
			}
			else{
				echo"<script>alert('Unsuccessful!');</script>";
				}
	/////end insert infor
	
	}//end isset
?>

<h3 class="tit">Black List Form :</h3>

		<!-- start id-form -->
        <form name="cust_request" method="post" enctype="multipart/form-data" onsubmit="return formCheck(this);">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle">
		<tr>
			<th valign="top">Date :</th>
			<td><input type="text" name="reg_date" id="reg_date" value="<?php echo date('d-m-Y'); ?>" autocomplete="off"
             onblur="doDate(this,'em_Date');" class="input-text"/></td>
            <th valign="top">&nbsp;</th>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th valign="top">ឈ្មោះ :</th>
			<td><input type="text" class="input-text"​ name="kh_bor" id="kh_bor" autocomplete="off" 
            style="font-family:khmer OS; size:10pt" size="16" onkeypress="return handleEnter(this, event);"/>
            </td>
            <th valign="top">Name :</th>
			<td>
            <input type="text" class="input-text" name="bor" id="bor" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);"/></td>
		</tr>
		<!--<tr>
		<th valign="top">អ្នករួមខ្ចី :</th>
			<td><input type="text" class="input-text"​ name="kh_cobor" id="kh_cobor" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" style="font-family:khmer OS; size:10pt" size="16"/></td>
            <th valign="top">Co-Borrower :</th>
			<td><input type="text" class="input-text" name="cobor" id="cobor" autocomplete="off" onblur="ChangeCase(this);" 
            onkeypress="return handleEnter(this, event);"/></td>
		</tr>-->
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
                                        $kh_iden=trim($row['des_kh']);
										$code=trim($row['code']);
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
			<th valign="top">Collateral Type :</th>
			<td><input type="text" class="input-text"​ name="colType" id="colType" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);"/>
            </td>
            <th valign="top">Title No :</th>
			<td>
            <input type="text" class="input-text" name="titleNo" id="titleNo" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onblur="ChangeCase(this);"/></td>
			
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
		<th>&nbsp;</th>
		<td valign="top">
			<input type="submit" value="Add to Black List" class="input-text" name="submit" 
            onclick="return confirm('Are you sure wanna save?');"/>
            <input type="submit" value="Search" class="input-text" name="search"/>
			<input type="reset" value="Reset" class="input-text"  />
		</td>
		<td></td>
	</tr>
	</table>
  </form>  
  <!-- Table (TABLE) -->
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
                <thead>
				<tr>
                	<th>ឈ្មោះ</th>
					<th>Name</th>
					<th>Sex</th>
					<th>DOB</th>
                    <th>Coll-Type</th>
					<th>Title-No</th>
                    <th>Id-Type</th>
                    <th>Id-No</th>
					<th>H-No</th>
					<th>St-No</th>
                    <th>Village</th>
					<th>Commune</th>
                    <th>District</th>
                    <th>Province</th>
                    <th>Action</th>
				</tr>
                </thead>
				<?php
					if(isset($_POST['search'])){
						$colType=$_POST['colType'];
						$titleNo=$_POST['titleNo'];
						$name_kh=$_POST['kh_bor'];
						$name=$_POST['bor'];
						if(!empty($name_kh) && empty($name) && empty($colType) && empty($titleNo)){
							$show_user="SELECT * FROM blackList WHERE kh_borrower like '%$name_kh%' ORDER BY id DESC;";
							}
						else if(empty($name_kh) && !empty($name) && empty($colType) && empty($titleNo)){
							$show_user="SELECT * FROM blackList WHERE borrower like '%$name%' ORDER BY id DESC;";
							}
						else if(empty($name_kh) && empty($name) && !empty($colType) && empty($titleNo)){
							$show_user="SELECT * FROM blackList WHERE coll_type like '%$colType%' ORDER BY id DESC;";
							}
						else if(empty($name_kh) && empty($name) && empty($colType) && !empty($titleNo)){
							$show_user="SELECT * FROM blackList WHERE titleNo like '%$titleNo%' ORDER BY id DESC;";
							}
						else{
							$show_user="SELECT * FROM blackList ORDER BY id DESC limit 20;";
						}
						$result=mysql_query($show_user);
						$check_record=mysql_num_rows($result);
						if($check_record=='0'){
							echo"<script>alert('No Records Found!');</script>";
							echo"<script>window.location.href='index.php?pages=add_blackList&session=restore';</script>";
							
							}
						}
						else{
							$show_user="SELECT * FROM blackList ORDER BY id DESC limit 20;";
							$result=mysql_query($show_user);
						}
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$kh_name = $row['kh_borrower'];
						$name=$row['borrower'];
						$sex=$row['sex'];
						$dob=date('d-m-Y',strtotime($row['cust_dob']));
						$tel=$row['tel'];
						$houseNo=$row['houseNo'];
						$stNo=$row['streetNo'];
						$vil=$row['village'];
						$com=$row['commune'];
						$dist=$row['district'];
						$prov=$row['province'];
						$collType=$row['coll_type'];
						$titleNo=$row['titleNo'];
						$idType=$row['idType'];
						$idNo=$row['idNo'];
						//////show village					
					$village_sql="SELECT * FROM village WHERE id ='$vil'";
							$result_vil=mysql_query($village_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_vil))
									{
										$get_village=$row['village'];
										//echo $show_commune;
									}
					//////show commune
					$commune_sql="SELECT * FROM adr_commune WHERE id ='$com'";
							$result_com=mysql_query($commune_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_com))
									{
										$get_commune=$row['commune'];
										//echo $show_commune;
									}
					//////show district
					$district_sql="SELECT * FROM district WHERE id ='$dist'";
							$result_dis=mysql_query($district_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_dis))
									{
										$get_district=$row['district'];
										//echo $show_commune;
									}
					//////show province
					$province_sql="SELECT * FROM province WHERE id ='$prov'";
							$result_prov=mysql_query($province_sql) or die (mysql_error());
							while($row = mysql_fetch_array($result_prov))
									{
										$get_province=$row['province'];
										//echo $show_commune;
									}
						echo"<tbody>
						<tr>
							<td>$kh_name</td>
							<td>$name</td>
							<td>$sex</td>
							<td>$dob</td>
							<td>$collType</td>
							<td>$titleNo</td>
							<td>$idType</td>
							<td>$idNo</td>
							<td>$houseNo</td>
							<td>$stNo</td>
							<td>$get_village</td>
							<td>$get_commune</td>
							<td>$get_district</td>
							<td>$get_province</td>
							<td><a href='?pages=add_blackList&id=$id&action=delete&catch=done' title='Delete' 
							onclick ='return confirm(\"Are you sure wanna delete?\")' name='delete'>Delete</a></td>
							
						</tr>
						
						";
					}
					if(isset($_GET['action'])=='delete'){//delete
						$myid=$_GET['id'];
						if(!empty($myid)){
							$delete=mysql_query("DELETE FROM blackList WHERE id='$myid'");
							echo"<script>alert('Deleted Successfull!!');</script>";
							echo"<script>window.location.href='?pages=add_blackList&catch=rollback';</script>";
						}
					}
				?>
                	<tr class="bg">
                    	<td colspan="15">&nbsp;</td>
                    </tr>
                    </tbody>
				</table>
				<!--  end product-table..... -->