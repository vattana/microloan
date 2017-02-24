<script language = "Javascript">
		function focusit() {			
				document.getElementById("fullname").focus();
				}
			window.onload = focusit;
/**
 * DHTML email validation script. 
 */

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
function doselect(){
	document.getElementById("rc_amount").value='';	
	document.getElementById("r_amount").value='';
	if(document.getElementById("op_name").checked==true){
		document.getElementById("rc_amount").readOnly=false;	
		document.getElementById("r_amount").readOnly=true;
	}	 
	else
	{
		document.getElementById("rc_amount").readOnly=true;	
		document.getElementById("r_amount").readOnly=false;	
	}
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
</script>
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
<?php
	include("pages/module.php");
	///////////Auto Number
					$query_maxid = "SELECT max(code) as maxCode FROM clear_advance_co"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['maxCode'];
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
			////////// End Number
	if(isset($_POST['delete'])){//delete
		$myid=$_GET['id'];
		if(!empty($myid)){
			$delete=mysql_query("DELETE FROM clear_advance_co WHERE id='$myid'");
			echo"<script>alert('Deleted Successfull!!');</script>";
			echo"<script>window.location.href='?pages=clear_advance_co&catch=rollback';</script>";
		}
	}
	if(isset($_POST['update'])){//update
		$myid=$_GET['id'];
		if(!empty($myid)){
			$user = $_SESSION['usr'];
			$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			$co_name=trim($_POST['co']);
			$recieve=trim($_POST['rc_amount']);
			$return=trim($_POST['r_amount']);
			$desc=trim($_POST['comments']);
			$cur = $_POST['cur'];
						
			if($co_name!='0'){
				list($a, $b) = explode(',',$co_name);
				$co_code = $a;
				$co_name = $b;
				}
				
			$round_khinfo="SELECT setting FROM loan_config WHERE property='rounding'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
			while($row=mysql_fetch_array($result_khrinfo)){
				$round_khr=$row['setting'];
			}
			//Get Info again
			$display_info="SELECT * FROM clear_advance_co WHERE id='$myid' limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$getco_name=$row['co_name'];
						$getco_code=$row['co_code'];
						$getcur = $row['cur'];
					}
					if($co_name=='0'){
						$co_code=$getco_code;
						$co_name = $getco_name;
						}
					if($cur=='0'){
						$cur=$getcur;
						}
						
			if($recieve==''){
		
				if ($cur=='KHR'){
				$recieve = 	roundkhr($return,$round_khr);
			}
			else{
				$recieve = round($return,2);
			}
	
						if(!empty($co_name) && !empty($return)){
				$insert_user=mysql_query("UPDATE clear_advance_co SET co_code  = '$co_code',
								co_name = '$co_name',
								return_a = '$return',
								return_date  = '$date',
								desc_a  = '$desc',
								cur = '$cur'
								 WHERE id ='$myid';")  or die (mysql_error());
					echo"<script>alert('Update Successful!');</script>";
					echo"<script>window.location.href='?pages=clear_advance_co&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
					}	
			}		
			else
			{
					
					if ($cur=='KHR'){
				$recieve = 	roundkhr($recieve,$round_khr);
			}
			else{
				$recieve = round($recieve,2);
			}
						if(!empty($co_name) && !empty($recieve)){
				$insert_user=mysql_query("UPDATE clear_advance_co SET co_code  = '$co_code',
								co_name = '$co_name',
								recieve = '$recieve',
								date_a  = '$date',
								desc_a  = '$desc',
								cur = '$cur'
								 WHERE id ='$myid';")  or die (mysql_error());
					echo"<script>alert('Update Successful!');</script>";
					echo"<script>window.location.href='?pages=clear_advance_co&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
					}		
			}
			//get infor again
			
		}
	}
	if(isset($_GET['action'])=='edit'){//view edit
				$myid=trim($_GET['id']);
				$display_info="SELECT * FROM clear_advance_co WHERE id='$myid' limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$ddate=trim(date('d-m-Y',strtotime($row['date_a'])));
						$dco_name=trim($row['co_name']);
						$drecieve=trim($row['recieve']);
						$dreturn=trim($row['return_a']);
						$ddesc=trim($row['desc_a']);
						$dcur=trim($row['cur']);	
						$dTRn=trim($row['cac_id']);
					}
		/*echo"<script>alert('$dFName !');</script>";*/
	}
	if(isset($_POST['submit'])){
		$user = $_SESSION['usr'];
			$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			$co_name=trim($_POST['co']);
			$recieve=trim($_POST['rc_amount']);
			$return=trim($_POST['r_amount']);
			$desc=trim($_POST['comments']);
			$cur = $_POST['cur'];
						

			list($a, $b) = explode(',',$co_name);
			$co_code = $a;
			$co_name = $b;
				
					$round_khinfo="SELECT setting FROM loan_config WHERE property='rounding'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_khrinfo)){
						$round_khr=$row['setting'];
					}
			if($recieve==''){
				echo "<script>alert('You must insert recieve amount.');</script>";
				
			}
			if ($cur=='KHR'){
				$recieve = 	roundkhr($recieve,$round_khr);
			}
			else{
				$recieve = round($recieve,2);
			}
			$return=0;
			
			if(!empty($co_name) && !empty($recieve)){
				$insert_cash=mysql_query("
					INSERT INTO clear_advance_co (
							id ,
							co_code ,
							co_name ,
							recieve ,
							return_a ,
							date_a ,
							desc_a ,
							user,
							cur,
							cac_id,
							code 
							)
							VALUES (
						NULL , '$co_code', '$co_name', '$recieve', '$return', '$date','$desc', '$user','$cur','$max','$max');
					")  or die (mysql_error());

					echo"<script>alert('Saved Successful!');</script>";
					echo"<script>window.location.href='?pages=clear_advance_co&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
					}
		}
?>
<!-- Form -->
			<h3 class="tit">Cash Advance Form :</h3>
            <fieldset>
				<legend>Clear Advance CO</legend>
                   <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle">
                <tr>
                    <td style="width:110px;">Transaction Date :</td>
                    <td><input type="text" size="30" class="input-text" name="date" id="date" 
                    value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $ddate;
							 }
							 else{
								 echo date('d-m-Y');
								 }
								?>" onblur="doDate(this,'em_Date');"/></td>
                    <td style="width:110px;">TRN No :</td>
                    <td><input type="text" size="30" class="input-text" name="trn" id="trn" 
                    value="<?php
							 if(isset($_GET['action'])=='edit'){
								 echo $dTRn;
							 }
							 else{
								 echo $max;
								 }
								?>" onblur="doDate(this,'em_Date');" autocomplete="off"/></td>
                </tr>
                <tr>
                    <td style="width:100px;">Staff Name :</td>
                    <td>	<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dco_name;
							 }
							 else{
								 echo '';
								 }
								?>
                                <select class="input-text" name="co" id="co">
                                    <option value="0" selected="selected">--Name--</option>
                                     <?php 
                                    
                                        $str_recom="Select s_id,s_name_kh from staff_list ";
                                        $sql_recom=mysql_query($str_recom);
                                        while ($row=mysql_fetch_array($sql_recom))
                                        {
                                            $s_id=$row['s_id'];
											$s_name=$row['s_name_kh'];
											//$s_id = '$s_id' + ',' + '$s_name';
                                            echo '<option value="'.$s_id.','.$s_name.'">' .$s_name. '</option>';
                                        }
                                    ?>
                                </select>
                    </td>
                    <td style="width:105px;">Options :</td>
                    <td><input type="radio" size="30" class="input-text" name="op_name" id="op_name" autocomplete="off" value='Recieve' checked="checked" onclick="doselect()"/> Recieve &nbsp;&nbsp;
                    <input type="radio" size="30" class="input-text" name="op_name" id="op_name" autocomplete="off" value='Return' onclick="doselect()"/> Return
                    </td>
                </tr>
                
                <tr>
                    <td style="width:105px;">Recieve Amount :</td>
                    <td><input type="text" size="30" class="input-text" name="rc_amount" id="rc_amount" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $drecieve;
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                    <td style="width:100px;">Return Amount :</td>
                    <td><input type="text" size="30" class="input-text" name="r_amount" id="r_amount" readonly="readonly" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dreturn;
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                </tr>
                <tr>
                    
                    <td style="width:100px;vertical-align:top" valign="top">Description :</td>
                    <td>
               	
<textarea name="comments" cols="27" rows="5">
<?php
if(isset($_GET['action'])=='edit'){
							 	echo $ddesc;
							 }
							 else{
								 echo '';
								 }
								?>
</textarea><br>
                    </td>
                    <td style="width:100px;vertical-align:top" valign="top">Currency :</td>
                      <td style="vertical-align:top">	<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dcur;
							 }
							 else{
								 echo '';
								 }
								?>
                                <select class="input-text" name="cur" id="cur" style="vertical-align:top">
                                    <option value="0" selected="selected">--cur--</option>
                                     <?php 
                                    
                                        $str_recom="Select   types   from currency_type ";
                                        $sql_recom=mysql_query($str_recom);
                                        while ($row=mysql_fetch_array($sql_recom))
                                        {
                                            $s_type=$row['types'];

                                            echo '<option value="'.$s_type.'">' .$s_type. '</option>';
                                        }
                                    ?>
                                </select>
                    </td>
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
                             <?php if(isset($_GET['action'])==' '){
								echo'
                                <input type="submit" class="input-submit" value="Delete" name="delete" 
                                onclick="return confirm(\'Are you sure wanna delete ?\')"/>';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Delete" name="delete" disabled="disabled">';
								}
                            ?>
                             <?php if(isset($_GET['action'])==' '){
								echo'
                                <input type="submit" class="input-submit" value="Return / Update" name="update" 
                                onclick="return confirm(\'Are you sure wanna update ?\')"/>';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Return / Update" name="update" disabled="disabled">';
								}
                            ?>
                           		<input type="submit" class="input-submit" value="search" name="search"  />
                                <input type="reset" class="input-submit" value="Reset" />
                               </td>
                            </tr>
                        </table>
                    </fieldset>
                    </form>
<!-- Table (TABLE) -->
			
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
                <thead>
				<tr>
                	<th>Transaction Number</th>
                	<th>Transaction Date</th>
					<th>Staff Code</th>
					<th>Staff Name</th>
					<th>Recieve Amount</th>
					<th>Return Amount</th>
					<th>Desction</th>
                    <th>Actions</th>
                    <th><a href="?pages=clear_advance_co&clear" title="Add User"><img src="design/Add.png" border="0"/></a></th>
				</tr>
                </thead>
				<?php
				if(isset($_POST['search'])){
					$mytrn=trim($_POST['trn']);
					$show_cash="SELECT * FROM clear_advance_co WHERE cac_id='$mytrn' ORDER BY cac_id ASC;";
					//sum receive
					$sql_ttrecieve = "SELECT SUM(recieve) AS total_recieve FROM `clear_advance_co` WHERE cac_id='$mytrn'";
							$result_ttrecieve = mysql_query($sql_ttrecieve) or die(mysql_error());
							$tRc = mysql_fetch_array($result_ttrecieve);
					//sum return
					$sql_ttreturn = "SELECT SUM(return_a) AS total_return FROM `clear_advance_co` WHERE cac_id='$mytrn'";
							$result_ttreturn = mysql_query($sql_ttreturn) or die(mysql_error());
							$tRt = mysql_fetch_array($result_ttreturn);
					
					$result=mysql_query($show_cash);
					///check
					$checkSearch=mysql_num_rows($result);
					if($checkSearch=='0'){
						echo"<script>alert('No Record Found!!');</script>";
						echo"<script>window.location.href='?pages=clear_advance_co&catch=rollback';</script>";
						}
				}
				else{
					$mydate=date('Y-m-d');
					$show_cash="SELECT * FROM clear_advance_co WHERE date_a='$mydate' ORDER BY cac_id ASC;";
					//sum receive
					$sql_ttrecieve = "SELECT SUM(recieve) AS total_recieve FROM `clear_advance_co` WHERE date_a='$mydate'";
							$result_ttrecieve = mysql_query($sql_ttrecieve) or die(mysql_error());
							$tRc = mysql_fetch_array($result_ttrecieve);
					//sum return
					$sql_ttreturn = "SELECT SUM(return_a) AS total_return FROM `clear_advance_co` WHERE date_a='$mydate'";
							$result_ttreturn = mysql_query($sql_ttreturn) or die(mysql_error());
							$tRt = mysql_fetch_array($result_ttreturn);
				}
				
					$result=mysql_query($show_cash);
					
					while($row=mysql_fetch_array($result))
					{
						$max = $row['cac_id'];
						$id=$row['id'];
						$co_code = $row['co_code'];
						$co_name=$row['co_name'];
						$recieve=formatMoney($row['recieve'],true);
						$return=formatMoney($row['return_a'],true);
						$date=date('d-m-Y',strtotime($row['date_a']));
						$desc=$row['desc_a'];
						$mycur=$row['cur'];
						echo"<tbody>
						<tr>
							<td>$max</td>
							<td>$date</td>
							<td>$co_code</td>
							<td>$co_name</td>
							<td>$mycur $recieve</td>
							<td>$mycur $return</td>
							<td>$desc</td>
							<td><a href='?pages=clear_advance_co&id=$id&action=edit&catch=done' title='Edit User' name='edit'>Edit</a></td>
							<td>&nbsp;</td>
						</tr>
						
						";
					}
					
				?>
                	<tr class="tit">
                    	<td colspan="4" align="right">
                        	<b><font color="#FF6600">Total Amount :</font></b> 
                        </td>
                    	<td>
                        	<?php echo $mycur.' '.formatMoney($tRc[total_recieve],true); ?>
                        </td>
                        <td>
                        	<?php echo $mycur.' '.formatMoney($tRt[total_return],true); ?>
                        </td>
                        <td colspan="3">&nbsp;
                        	
                        </td>
                    </tr>
                    </tbody>
				</table>
				<!--  end product-table..... -->