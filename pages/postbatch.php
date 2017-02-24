
	<script type="text/javascript">
				var nameArray = null;
	</script>
<script language = "Javascript">
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
                document.getElementById("pb").value = selection;
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
			
			
		
		
		function focusit() {			
				document.getElementById("fullname").focus();
				}
			window.onload = focusit;
			
			function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail Address")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail Address")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail Address")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail Address")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail Address")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail Address!")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail Address!")
		    return false
		 }

 		 return true					
	}

function ValidateForm(){
	var emailID=document.frmuser.email
	var btnNew=document.frmuser.addnew
	
	if ((emailID.value==null)||(emailID.value=="")){
		alert("Please Enter your Email Address!")
		emailID.focus()
		return false
	}
	if (echeck(emailID.value)==false){
		emailID.value=""
		emailID.focus()
		return false
	}
	return true
 }
 ///////////
 function clearForm(){
	 document.getElementById("fullname").value="";
	 document.getElementById("user_name").value="";
	 document.getElementById("password").value="";
	 document.getElementById("email").value="";
	 document.getElementById("session_date").value="";
	 document.getElementById("fullname").focus(); 
	  return false;
	 }
			
/**
 * DHTML email validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */
 </script>
<!-- start adres -->
<script type="text/javascript">
$(document).ready(function()
{
$(".macc").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "pages/ajax_sub.php",
data: dataString,
cache: false,
success: function(html)
{
$(".sub").html(html);
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
url: "pages/ajax_cur.php",
data: dataString,
cache: false,
success: function(html)
{
$(".communce").html(html);
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

<style type="text/css">

		tr.odd	{background:#FFF;}
		tr.highlight	{background:#CCC;}
		tr.selected		{background:#FFF;color:#090;}
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
<?php
		$query = "SELECT * FROM  auto_acc";
			$result = mysql_query($query);
			$counter = 0;
			
			echo("<script type='text/javascript'>");
			echo("this.nameArray = new Array();");
			if($result) {
				while($row = mysql_fetch_array($result)) {
					echo("this.nameArray[" . $counter . "] = '" . trim($row['acc_id']) . " ';");
					$counter += 1;
				}
			}
			echo("</script>");
?>
<?php
include("pages/module.php");

	if(isset($_POST['delete'])){//delete
		$myid=$_GET['id'];
		if(!empty($myid)){
			$delete=mysql_query("update chartacc_list set  c_enable =0 WHERE c_id='$myid'");
			echo"<script>alert('Deleted Successfull!!');</script>";
			echo"<script>window.location.href='?pages=chartofacc&catch=rollback';</script>";
		}
	}
	if(isset($_POST['update'])){//update
		$myid=$_GET['id'];
		if(!empty($myid)){
			$code=trim($_POST['code']);
			$name=trim($_POST['name']);
			$desc=trim($_POST['desc']);
			$leve=trim($_POST['level']);
			$r=trim($_POST['r']);
			$rd=trim($_POST['rd']);
			
			if ($r=="Header"){
				$ri = 1;	
			}
			else{
				$ri=0;	
			}
			
			if ($rd=="Debit"){
				$rdi = 1;	
			}
			else{
				$rdi=0;	
			}
			
			
			list($leve, $level) =
    			split(",", $leve, 2);
			if ($leve=="Root"){
				$level=0;	
			}
			else
			{
				$level=$level+1;	
			}
			//Get Info again
			$display_info="SELECT * FROM chartacc_list WHERE c_id='$myid' and  c_enable =1 limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$getc_refer=$row['c_refer'];
						$getlevel=$row['c_level'];
					}
					if($leve=='Root'){
						$leve=$getc_refer;
						$level=$getlevel;	
					}
			if(!empty($code)&& !empty($name)){
				$insert_user=mysql_query("UPDATE `chartacc_list` SET `c_code` = '$code',
								`c_name` = '$name',
								`c_refer` = '$leve',
								`c_level` = '$level',
								`c_des` = '$desc',
								`c_is_header` = '$ri',
								`c_is_debit` = '$rdi' WHERE `c_id` ='$myid';");
					echo"<script>alert('Update Successful!');</script>";
					echo"<script>window.location.href='?pages=chartofacc&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
					}
		}
	}
	if(isset($_GET['action'])=='edit'){//view edit
				$myid=trim($_GET['id']);
				$display_info="SELECT * FROM chartacc_list WHERE c_id='$myid' and  c_enable =1 limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$dcode=trim($row['c_code']);
						$dName=trim($row['c_name']);
						$ddesc=trim($row['c_des']);
						$drefer=trim($row['c_refer']);
						$disheader=trim($row['c_is_header']);
						$disdebit=trim($row['c_is_debit']);
						
						$getmain_info="SELECT * FROM chartacc_list WHERE c_code='$drefer' limit 0,1";
						$resultmain_info=mysql_query($getmain_info) or die (mysql_error());
						$activemain_num=mysql_num_rows($resultmain_info);
						while($row=mysql_fetch_array($resultmain_info)){
							$dLevel=$row['c_name'];
						}
					}
		/*echo"<script>alert('$dFName !');</script>";*/
	}
	if(isset($_POST['new'])){
		$max= $_POST['pb'];
		$ifhave=0;
		$query_ifhave = "SELECT * FROM account where a_notran='$max'"; 
		$result_ifhave = mysql_query($query_ifhave) or die(mysql_error());
		// Print out result
		while($row = mysql_fetch_array($result_ifhave)){
			$ifhave=1;
			$amt=$amt + $row['c_credit']+$row['c_debit'];
			$desc=$row['c_des'];
		}
		if ($ifhave==0){
			///////////Auto Number
					$query_maxid = "SELECT max(acc_id) as maxCode FROM auto_acc"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['maxCode'];
						$convert = intval($max);
						$max_org = $row['maxCode'];
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
			////////// End Number
			$insert_user=mysql_query("
					INSERT INTO `auto_acc` (
							`acc_id`
							)
							VALUES (
						'$max');
					") or die(mysql_error);
		}
		else{
			echo"<script>window.location.href='?pages=postbatch&catch=rollback&pb=$max&amount=$amt&desc=$desc';</script>";	
		}
	}
	if(isset($_POST['save'])){
			//include("pages/module.php");
			$max = $_POST['pb'];
			$desc = $_POST['desc'];
			$display_info="SELECT sum(c_credit) credit, sum(c_debit) debit FROM  account WHERE a_notran ='$max' group by a_notran limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$sum_credit1=$row['credit'];
						$sum_debit1=$row['debit'];
					}
					
			if($sum_credit1==$sum_debit1)	{
				$update_user=mysql_query("
					update account set issave=1,c_des='$desc' where a_notran='$max' ;
					") or die(mysql_error);
					echo"<script>alert('Saved Successful!');</script>";
					echo"<script>window.location.href='?pages=postbatch&catch=rollback';</script>";
			}
			else
			{
				echo "<script>alert('Credit must be the same debit');</script>";
				echo "<script>alert('Saved Unsuccessful! Try Again!');</script>";	
			}
	}
	if(isset($_POST['submit'])){
			
			
			//$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			//$session_date=trim(date('Y-m-d',strtotime($_POST['session_date'])));
			//$times=date('H:i:s');
			$date=date('Y-m-d',strtotime(trim($_POST['repay_date'])));;
			$code=trim($_POST['sub']);
			$cur=trim($_POST['cur']);
			$cd=trim($_POST['cd']);			
			$max=trim($_POST['pb']);
			$amt = trim($_POST['amount']);
			list($code, $code1) =
    			split(",", $code, 2);
			$display_info="SELECT * FROM chartacc_list WHERE c_code='$code' and  c_enable =1 limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$getc_debit=$row['c_is_debit'];
					}

			if($getc_debit==0){
				$c=$cd;
				$d=0;	
			}
			else{
				$d=$cd;
				$c=0;
			}
			
			$display_info="SELECT * FROM  account WHERE c_code='$code' and  a_notran ='$max' limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$getc_code=$row['c_code'];
					}
			
			if (!($getc_code)){
				if(!empty($code)){
				$insert_user=mysql_query("
					INSERT INTO `account` (
							`c_code` ,
							`c_cur` ,
							`c_credit` ,
							`c_debit` ,
							`a_id` ,
							`a_notran` ,
							`a_date`,
							`c_des`,
							`issave`,
							`branch`
							)
							VALUES (
						'$code', '$cur', '$c', '$d', null, '$max', '$date','$desc','0','$get_br');
					") or die(mysql_error);
					
					
					/*if ($max==$max_org+1){
						echo "<script>alert('$max,$max_org+1');</script>";
						$insert_user=mysql_query("
					INSERT INTO `auto_acc` (
							`acc_id`
							)
							VALUES (
						'$max');
					") or die(mysql_error);
												
					}*/
					/*echo"<script>alert('Saved Successful!');</script>";*/
					echo"<script>window.location.href='?pages=postbatch&catch=rollback&pb=$max&amount=$amt&desc=$desc';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
				}
			}
			else{
				if(!empty($code)){
				$update_user=mysql_query("update account set c_credit='$c', c_debit='$d' where c_code='$getc_code' and a_notran='$max';
					") or die(mysql_error);
					echo"<script>window.location.href='?pages=postbatch&catch=rollback&pb=$max&amount=$amt&desc=$desc';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
					}	
			}
			
		}
?>
<!-- Form -->
			<h3 class="tit">Post Batch Form :</h3>
            <fieldset>
				<legend>Account</legend>
                   <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle" onclick="document.getElementById('divSuggestions').style.visibility='hidden'" >
                <tr>
                	<td style="width:100px;">Post Batch
                    </td>
                       <td><input type="text" size="30" class="input-text" name="pb"  onKeyUp="doSuggestionBox(this.value);" id="pb" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $max;
							 }
							 else{
								$m = $_GET['pb'];
								
								if($m==''){
									echo $max;	
								}
								else{
									echo $m;	
								}
								
							}
								?>"/>&nbsp;
                                <input style="height:30px;vertical-align:middle;text-align:justify" type="submit" class="input-submit" value="+" name="new" onclick="return confirm('Are you sure do you want to do transaction ?')	"/><br /></td>
                     
                </tr>
                 <tr>
                 <th valign="top">&nbsp;</th>
		<td>	
				<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 15%;
						 	margin-top:-7px; background-color: #FFFFFF;float:right; color: #666666; 
                            height: 100px; padding-left: 5px;position:absolute;">
                </div>
		</td>
                 </tr>
                <tr>
                
                    <td style="width:100px;">Date :</td>
                    <td><input type="text" class="input-text" name="repay_date" id="repay_date"  readonly="readonly"
            value="<?php if(!empty($mydate)){
												echo $mydate;
											}
											 else{
											 	echo date('d-m-Y'); 
											 } ?>" 
            onblur="doDate(this,'em_Date');" autocomplete="off"/></td>
                    <td style="width:100px;">Amount :</td>
                    <td><input type="text" size="30" class="input-text" name="amount" id="amount" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $damount;
							 }
							 else{
								 echo $_GET['amount'];
								 }
								?>"/></td>
                </tr>
                
                <tr>
                     <td style="width:100px;vertical-align:top">Main Account :</td>
 <td style="vertical-align:top">	<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dmacc;
							 }
							 else{
								 echo '';
								 }
								?>
                                <select class="macc" name="macc" id="macc" onkeypress="return handleEnter(this, event);">
                                    <option value="Root" selected="selected" >--Root--</option>
                                     <?php 
                                    
                                        $str_recom="Select c_code,c_name,c_level from  chartacc_list where c_is_header=1 and  c_enable =1 and c_refer='Root'";
                                        $sql_recom=mysql_query($str_recom);
                                        while ($row=mysql_fetch_array($sql_recom))
                                        {
                                            $c_name=$row['c_name'];
											$c_code=$row['c_code'];
											$c_level=$row['c_level'];
                                            echo '<option value="'.$c_code.'">' .$c_name. '</option>';
                                        }
                                    ?>
                                </select>
                    </td>
                    <td style="width:100px;vertical-align:top">Sub Account :</td>
 <td style="vertical-align:top">	<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dLevel;
							 }
							 else{
								 echo '';
								 }
								?>
                                <select class="sub" name="sub" id="sub">
                                    <option value="Root" selected="selected">--Root--</option>
                                </select>
                    </td>
                </tr>
              <tr>
              	<td style="width:100px;vertical-align:top">Currentcy :</td>
 <td style="vertical-align:top">	<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dcur;
							 }
							 else{
								 echo '';
								 }
								?>
                                <select class="cur" name="cur" id="cur">
                                    <option value="Root" selected="selected">--Root--</option>
                                     <?php 
                                    
                                        $str_recom="Select types from  currency_type group by types";
                                        $sql_recom=mysql_query($str_recom);
                                        while ($row=mysql_fetch_array($sql_recom))
                                        {
                                            $types=$row['types'];
                                            echo '<option value="'.$types.'">' .$types. '</option>';
                                        }
                                    ?>
                                </select>
                    </td>
                    <td style="width:100px;">Credit/Debit :</td>
                    <td><input type="text" size="30" class="input-text" name="cd" id="cd" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dcd;
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
              </tr>
               <tr>
              	<td style="width:100px;vertical-align:top">Description :</td>
                    <td><textarea cols="27" rows="5" name="desc" id="desc"><?php echo $desc ?></textarea></td>
              </tr>
                    <tr>
                            <td colspan="3" class="t-right">
                            <?php if(isset($_GET['action'])!='edit'){
								echo'
                                <input type="submit" class="input-submit" value="Add" name="submit" 
                                onclick="return confirm(\'Are you sure wanna save ?\')"/>';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Add" name="submit" disabled="disabled">';
							}
                            ?>
                           
                           
                                <input type="submit" class="input-submit" value="save" name="save"/>
                               </td>
                            </tr>
                        </table>
                    </fieldset>
                    </form>
<!-- Table (TABLE) -->
			
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
                <thead>
				<tr>
                	<th>Main Account</th>
                    <th>Sub Account</th>
                    <th>Currentcy</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th><a href="?pages=postbatch&clear" title="Add Post Batch"><img src="design/Add.png" border="0"/></a></th>
				</tr>
                </thead>
				<?php
					$show_user="Select a.C_CODE,b.C_NAME ,(select C.C_NAME from chartacc_list C where SUBSTRING(c.C_CODE,1,1) = SUBSTRING(b.C_REFER,1,1) and c.C_IS_HEADER=1 and c.C_REFER='Root' limit 1,1) MainAcc,a.C_CUR,a.C_CREDIT,a.C_DEBIT,a.A_NOTRAN   from account A, chartacc_list B where a.C_CODE =b.C_CODE and a_notran='$m'
;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$id=$row['c_id'];
						$c_code = $row['C_CODE'];
						$c_name=$row['C_NAME'];
						$c_main=$row['MainAcc'];
						$cur=$row['C_CUR'];
						$debit = $row['C_DEBIT'];
						$credit = $row['C_CREDIT'];
						$sum_debit = $sum_debit+ $debit;
						$sum_credit = $sum_credit+ $credit;
						 
							echo"<tbody>
						<tr>
							<td>$c_main</td>
							<td>$c_name</td>
							<td>$cur</td>
							<td>$debit</td>
				
							<td>$credit</td>
							<td>&nbsp;</td>
						
						
						";
						
						echo "</tr>";
						
					}
					
				?>
                <tr class="tit">
                    	<td colspan="3" align="right">
                        	<b><font color="#FF6600">Total Amount :</font></b> 
                        </td>
                    	<td>
                        	<?php
								if($cur=='Root'){
									$cur ='';	
								} 
								echo $cur.' '.formatMoney($sum_debit,true); 
							?>
                        </td>
                        <td>
                        	<?php 
								if($cur=='Root'){
									$cur ='';	
								} 
								echo $cur.' '.formatMoney($sum_credit,true); 
							?>
                        </td>
                        <td colspan="3">&nbsp;
                        	
                        </td>
                    </tr>
                	<tr class="bg">
                    	<td colspan="10">&nbsp;</td>
                    </tr>
                    </tbody>
				</table>
				<!--  end product-table..... -->