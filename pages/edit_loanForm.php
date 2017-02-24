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
	$query = "SELECT cif FROM register where bloan='0' GROUP BY cif DESC";
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
	//display
		if(isset($_POST['display'])){
			$cid_display=trim($_POST['cid']);
			$checkRegDate=$_POST['reg_date'];
			$myreg_date=date('Y-m-d',strtotime($_POST['reg_date']));
			$disRegDate=date('d-m-Y',strtotime($_POST['reg_date']));
			if($checkRegDate==''){
				echo"<script>alert('Please inpute register date to search!');</script>";
				$disRegDate='';
				}
			$display_info="SELECT * FROM register WHERE cif='$cid_display' AND register_date='$myreg_date' AND bloan='0' ORDER BY id DESC";
			$result_info=mysql_query($display_info) or die (mysql_error());
			$checkLoan=mysql_num_rows($result_info);
			
			while($row=mysql_fetch_array($result_info)){
					$regis_id=$row['id'];
					$kh_borrower=$row['kh_borrower'];
					$borrower=$row['borrower'];
					$myLoanAmt=formatMoney($row['loan_request'],true);
					$myrate=$row['rate'];
					$myterm=$row['period'];
					$mycur=$row['cur'];
					$myrecomend_name=$row['recomend_name'];
					$myco=$row['co'];
					$nor=$row['freq'];
					$myltype=$row['type_loan'];
					break;
				}
				//display frequency
						if($nor=='30'){
							$show_fr='Monthly';
							
							}
						else if($nor=='14'){
							$show_fr='Two Weeks';
							
							}
						else if($nor=='7'){
							$show_fr='Weekly';
							
							}
						else if($nor=='1'){
							$show_fr='Daily';
							
							}
						else{
							$show_fr='Monthly';
							
							}
			}//end if
	//end display
	if(isset($_POST['edit'])){
		//end check branch no
		$cid=trim($_POST['cid']);
		$myreg_date=date('Y-m-d',strtotime($_POST['reg_date']));
		$getloanAmt=$_POST['loanAmt'];
		$getRate=$_POST['rate'];
		$getTerm=$_POST['term'];
		$getRepayType=$_POST['repay_type'];
		$getCur=$_POST['cur'];
		$getRecom=$_POST['recom'];
		$getCO=$_POST['resCO'];
		$getLtype=$_POST['ltype'];
		//
		$spit = array(",", "'");
 		$myfloanAmt = str_replace($spit, "",$getloanAmt);
		//
		//check if empty
		if(!empty($getloanAmt)&&!empty($getRate)&&!empty($getTerm)&&!empty($getLtype)&&!empty($getRepayType)){
				$edit_loan=mysql_query("UPDATE `register` SET `loan_request` = '$myfloanAmt',
												`cur` = '$getCur',
												`freq` = '$getRepayType',
												`rate` = '$getRate',
												`period` = '$getTerm',
												`recomend_name` = '$getRecom',
												`co` = '$getCO',
												`type_loan` = '$getLtype' WHERE `cif` ='$cid' AND `register_date`='$myreg_date';");
				//edit approval
				$editApp=mysql_query("UPDATE `customer_app` SET `approval_amt` = '$myfloanAmt',
												`approval_rate` = '$getRate',
												`approval_period` = '$getTerm',
												`number_of_repay` = '$getRepayType',
												`recom_name` = '$getRecom',
												`response_co` = '$getCO' WHERE `cid` ='$cid' AND `register_date`='$myreg_date';");
				echo"<script>alert('Update Successful!!');</script>";
				echo"<script>window.location.href='index.php?pages=edit_loanForm&catch=back';</script>";
			}
			else{
				echo"<script>alert('Update Not Successful!Please Try Again!!');</script>";
				}
	}//end isset
?>
<h3 class="tit">Edit Loan Information Form :</h3>
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
        <th valign="top">Registerd Date :</th>
			<td><input type="text" class="input-text" name="reg_date" id="reg_date" autocomplete="off"
             onblur="doDate(this,'em_Date');" value="<?php echo $disRegDate; ?>"/></td>
       
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
			<th valign="top">អ្នកខ្ចី :</th>
			<td><input type="text" class="input-text"​ name="kh_bor" id="kh_bor" autocomplete="off" 
            value="<?php echo $kh_borrower ?>" onkeypress="return handleEnter(this, event);" readonly="readonly"/>
            </td>
            <th valign="top">Borrower :</th>
			<td>
            <input type="text" class="input-text" name="bor" id="bor" autocomplete="off" onblur="ChangeCase(this);"
            onkeypress="return handleEnter(this, event);" value="<?php echo $borrower ?>" readonly="readonly"/></td>
			
		</tr>
        <tr>
			<th valign="top">Loan Size :</th>
			<td><input type="text" class="input-text"​ name="loanAmt" id="loanAmt" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" onchange="this.value=formatCurrency(this.value);" value="<? echo trim($myLoanAmt);?>"/>
            </td>
            <th valign="top">Currency :</th>
			<td> 
            	<select class="input-text" name="cur" id="cur" onkeypress="return handleEnter(this, event);">
                            <option value="<? echo $mycur; ?>"><? echo $mycur; ?></option>
                             <?php 
								$str="Select * from currency_type group by types desc";
								$sql=mysql_query($str);
								while ($row=mysql_fetch_array($sql))
								{
									$types=$row['types'];
									$desc=$row['descript'];
									echo '<option value="'.$types.'">'.$desc.'</option>';
								}
						     ?>
                 </select>
            </td>
           
		</tr>
         <tr>
			<th valign="top">Term :</th>
			<td><input type="text" class="input-text"​ name="term" id="term" autocomplete="off" 
            onkeypress="return handleEnter(this, event);" value="<? echo $myterm; ?>"/>
            </td>
            
			 <th valign="top">Frequency</th>
			<td>
            	<select name="repay_type" id="repay_type" size="1" class="input-text">
                    	<option value="<? echo $nor; ?>"><? echo $show_fr; ?></option>
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
          <th valign="top">Rate :</th>
			<td>
            <input type="text" class="input-text" name="rate" id="rate" autocomplete="off" 
            onchange="this.value=formatCurrency(this.value);" onkeypress="return handleEnter(this, event);" value="<? echo $myrate; ?>"/> % </td>
			
             <th valign="top">Response COs</th>
			<td>
            	<select name="resCO" id="resCO" size="1" class="input-text">
                    	<option value="<? echo $myco; ?>"><? echo $myco; ?></option>
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
            </td>
		</tr>
         <tr>
           <th valign="top">Loan Type :</th>
			<td> 
            	<select class="input-text" name="ltype" id="ltype" onkeypress="return handleEnter(this, event);">
                            <option value="<? echo $myltype; ?>"><? echo $myltype; ?></option>
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
            </td>
             <th valign="top">Recommend Name</th>
			<td>
            	 <select class="input-text" name="recom" id="recom" onkeypress="return handleEnter(this, event);">
                           <option value="<? echo $myrecomend_name; ?>"><? echo $myrecomend_name; ?></option>
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
            </td>
		</tr>
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="edit" class="form-submit" name="edit" 
                onclick="return confirm('Are you sure wanna update <? echo $cid_display.':'.$kh_borrower ;?>?');"/>
                <input type="reset" value="reset" class="form-reset"  />
            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>