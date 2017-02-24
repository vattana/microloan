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
	$query = "SELECT cif FROM register WHERE appr='1' AND bcif='1' AND cancel='0' GROUP BY cif DESC";
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
<!-- end filter-->
<!-- start data security -->
<script language="JavaScript">
function formCheck(formobj){
	
	var loan_type=document.getElementById('ltype').value;
	var co=document.getElementById('co').value;
	var repayType=document.getElementById('repay_type').value;
	var mycur=document.getElementById('cur').value;
	if(repayType=='0'){alert('Please Select Frequency!');return false;}
	if(mycur=='0'){alert('Please Select Currency Type!');return false;}
	if(co=='0'){alert('Please Select CO!');return false;}
	if(loan_type=='0'){alert('Please Select Loan Type!');return false;}
	
	// Enter name of mandatory fields
	var fieldRequired = Array("reg_date","cid","loan_amt","int","period");
	// Enter field description to appear in the dialog box
	var fieldDescription = Array("Registration Date","CID","Amount","Rate","Period");
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
	
		///end check branch no
	if(isset($_POST['submit'])){
		$cid=$_POST['cid'];
		$times=date('H:i:s');
		$pro=$_POST['province'];
		$dist=$_POST['district'];
		$com=$_POST['commune'];
		$vil=$_POST['village'];
		$loan_amt=$_POST['loan_amt'];
		//
		$spit = array(",", "'");
 		$myloan = str_replace($spit, "",$loan_amt);
		//
		$cur=$_POST['cur'];
		$int=$_POST['int'];
		$period=$_POST['period'];
		$recom_pos=$_POST['recom_pos'];
		$recom_name=$_POST['recom'];
		$co=$_POST['co'];
		$ltype=$_POST['ltype'];
		$purposedes=$_POST['purpose'];
		$regist_date=date('Y-m-d',strtotime($_POST['reg_date']));
		$repay_type=$_POST['repay_type'];
		///select old information of borrower
					$sql_bor="SELECT * FROM register WHERE cif ='$cid' GROUP BY cif";
					$result_bor=mysql_query($sql_bor) or die (mysql_error());
						while($row = mysql_fetch_array($result_bor))
								{
									$kh_borrower=$row['kh_borrower']; 
									$borrower=$row['borrower'];
									$kh_co_borrower=$row['kh_co_borrower'];
									$co_borrower=$row['co_borrower'];
									$marital=$row['marital'];
									$landCost=$row['landCost'];
									$houseCost=$row['houseCost'];
									$inMaker=$row['inMaker'];
									$eqCost=$row['eqCost'];
									$khSpName=$row['khSpName'];
									$enSpName=$row['enSpName'];
									$dependent=$row['dependent'];
									$relationType=$row['relationType']; 
									$tel=$row['tel'];
									$sex=$row['sex'];
									$dob=$row['cust_dob'];
									$houseNo=$row['houseNo'];
									$streetNo=$row['streetNo'];
									$vil=$row['village'];
									$com=$row['commune'];
									$dist=$row['district'];
									$pro=$row['province'];
									break;
								}
		///end select old information of borrower
		
		/*echo"<script>alert('$kh_borrower,$kh_co_borrower,$borrower,$co_borrower!');</script>";*/
		
		//
		$spit = array(",", "'");
 		$myloan = str_replace($spit, "",$loan_amt);
		//
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
					$br_sql="SELECT * FROM br_ip_mgr WHERE set_ip ='$br_ip'";
					$result_br=mysql_query($br_sql) or die (mysql_error());
						while($row = mysql_fetch_array($result_br))
								{
									$get_ip=$row['set_ip'];
									$get_br=$row['br_no'];	 
								}
		///end check branch no
	///insert inforation to table request
		if(!empty($borrower) && !empty($kh_borrower) && ($loan_amt!='Amount Request') && ($int!='Rate %') && ($period!='Period Months') 
		&& ($co!='0') && ($ltype!='0')){
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
											VALUES (NULL, '$cid', '$regist_date', '$times', '$kh_borrower', '$borrower', '$kh_co_borrower', '$co_borrower', '$marital', '$landCost', '$houseCost', '$inMaker', '$eqCost', '$khSpName', '$enSpName', '$dependent', '$relation','$repay_type', '$sex', '$tel', '$dob', '$pro', '$dist', '$com', '$vil','$houseNo','$streetNo', '$myloan', '$cur', '$int', '$period', '$recom_pos', '$recom_name', '$co', '$ltype', '$purposedes', '$image', 'old', '$get_br', '$appSet', '0', '1', '0', '0', '$max', '$user', '', ''
											);");
			///
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
			///			
			echo"<script>alert('Saved Successful!');</script>";
			echo"<script>alert('Plese Note CID of Customer -> $cid if you need!');</script>";
			
			}
			else{
				echo"<script>alert('Unsuccessful!');</script>";
				}
	/////end insert infor
	
	}//end isset
?>
<!-- start content-outer -->
<h3 class="tit">Easy Registration Form For Existing Customer :</h3>
	
		<!-- start id-form -->
        <form name="cust_request" method="post" enctype="multipart/form-data" onsubmit="return formCheck(this);">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" class="nostyle">
		<tr>
			<th valign="top">Registerd Date :</th>
			<td><input type="text" class="input-text" name="reg_date" id="reg_date" value="<?php echo date('d-m-Y'); ?>" autocomplete="off"
             onblur="doDate(this,'em_Date');"/></td>
            <th valign="top">CID :</th>
			<td>
            <input type="text" class="input-text" name="cid" id="cid" value=""  onKeyUp="doSuggestionBox(this.value);" 
            onkeypress="return handleEnter(this, event);" autocomplete="off"/>
            </td>
		</tr>
        <tr>
		
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
            <th valign="top">&nbsp;</th>
		<td>	
		<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 13%;
						 	margin-top:-24px; background-color: #FFFFFF;float:right; 
							color: #666666; height: 100px; padding-left: 5px;position:absolute;">
                        </div>
		</td>
		</tr> 
		<tr>
			<th valign="top">Loan Amount :</th>
			<td colspan="3">
            	<!-- address start -->
                <table border="0" class="nostyle">
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
									$types=$row['types'];
									$desc=$row['descript'];
									echo '<option value="'.$types.'">'.$desc.'</option>';
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
			<td colspan="3">
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
                            <option value="0">--COs--</option>
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
		<td><textarea rows="" cols="20" class="form-textarea" name="purpose" id="purpose"></textarea></td>
		<td></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td valign="top">
			<input type="submit" value="submit" class="form-submit" name="submit"/>
			<input type="reset" value="reset" class="form-reset"  />
		</td>
		<td></td>
	</tr>
	</table>
    </form>

