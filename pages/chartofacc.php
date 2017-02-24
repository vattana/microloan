<script language = "Javascript">
		function focusit() {			
				document.getElementById("fullname").focus();
				}
			window.onload = focusit;
/**
 * DHTML email validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
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
	if(isset($_POST['submit'])){
			//$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			//$session_date=trim(date('Y-m-d',strtotime($_POST['session_date'])));
			//$times=date('H:i:s');
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

			if(!empty($code)&& !empty($name)){
				$insert_user=mysql_query("
					INSERT INTO `chartacc_list` (
							`c_code` ,
							`c_name` ,
							`c_refer` ,
							`c_id` ,
							`c_level` ,
							`c_des` ,
							`c_is_header` ,
							`c_is_debit` ,
							`c_enable` 
							)
							VALUES (
						'$code', '$name', '$leve', Null, '$level', '$desc', '$ri', '$rdi', '1');
					") or die(mysql_error);
					echo"<script>alert('Saved Successful!');</script>";
					echo"<script>window.location.href='?pages=chartofacc&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
					}
		}
?>
<!-- Form -->
			<h3 class="tit">Chart Of Account Form :</h3>
            <fieldset>
				<legend>Account</legend>
                   <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle">
                <tr>
                <td></td>
                    <td style="width:100px;" colspan="4">
                    	<fieldset style="width:69%">
                        	<legend>Please select header or account</legend>
                            <?php
								
							 	if ($disheader==1){
									 echo "<input type='radio' value='Header' name='r' id='r' checked='checked'/>&nbsp;&nbsp;Header&nbsp;";
								}
								else{
									echo "<input type='radio' value='Header' name='r' id='r' />&nbsp;&nbsp;Header&nbsp;";
								}
							
								if ($disheader==0){
									 echo "<input type='radio' value='Account' name='r' id='r' checked='checked'/>&nbsp;&nbsp;Account&nbsp;";
								}
								else{
									echo "<input type='radio' value='Account' name='r' id='r' />&nbsp;&nbsp;Account&nbsp;";
								}
							?>
                            
                    	</fieldset>
                    </td>
          
                </tr>
                <tr>
                    <td style="width:100px;">Account No :</td>
                    <td><input type="text" size="24" class="input-text" name="code" id="code" 
                    autocomplete="off" style="font-family:khmer OS; size:10pt" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo trim($dcode);
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                    <td style="width:100px;">Account Name :</td>
                    <td><input type="text" size="30" class="input-text" name="name" id="name" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dName;
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                </tr>
                
                <tr>
                    <td style="width:100px; vertical-align:top">Description :</td>
                    <td><textarea  cols="27" rows="5" name="desc" id="desc"><?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $ddesc;
							 }
							 else{
								 echo '';
								 }
								?></textarea></td>
                    <td style="width:100px;vertical-align:top">Main :</td>
 <td style="vertical-align:top">	<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dLevel;
							 }
							 else{
								 echo '';
								 }
								?>
                                <select class="input-text" name="level" id="level">
                                    <option value="Root" selected="selected">--Root--</option>
                                     <?php 
                                    
                                        $str_recom="Select c_code,c_name,c_level from  chartacc_list where c_is_header=1 and  c_enable =1";
                                        $sql_recom=mysql_query($str_recom);
                                        while ($row=mysql_fetch_array($sql_recom))
                                        {
                                            $c_name=$row['c_name'];
											$c_code=$row['c_code'];
											$c_level=$row['c_level'];
                                            echo '<option value="'.$c_code.','.$c_level.'">' .$c_name. '</option>';
                                        }
                                    ?>
                                </select>
                    </td>
                </tr>
                      <tr>
                <td></td>
                    <td style="width:100px;" colspan="4">
                    	<fieldset style="width:69%">
                        	<legend>Please select debit or credit</legend>
                             <?php
								
							 	if ($disdebit==1){
									 echo "<input type='radio' value='Debit' name='rd' id='rd' checked='checked'/>&nbsp;&nbsp;Debit&nbsp;";
								}
								else{
									echo "<input type='radio' value='Debit' name='rd' id='rd' />&nbsp;&nbsp;Debit&nbsp;";
								}
							
								if ($disdebit==0){
									 echo "<input type='radio' value='Credit' name='rd' id='rd' checked='checked'/>&nbsp;&nbsp;Credit&nbsp;";
								}
								else{
									echo "<input type='radio' value='Credit' name='rd' id='rd' />&nbsp;&nbsp;Credit&nbsp;";
								}
							?>
                   
                    	</fieldset>
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
                                <input type="submit" class="input-submit" value="Update" name="update" 
                                onclick="return confirm(\'Are you sure wanna update ?\')"/>';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Update" name="update" disabled="disabled">';
								}
                            ?>
                           
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
                	<th>Chart of Account</th>
                    <th>Actions</th>
                    <th><a href="?pages=chartofacc&clear" title="Add Chart Of Account"><img src="design/Add.png" border="0"/></a></th>
				</tr>
                </thead>
				<?php
					$show_user="select c_code,c_name, c_level,c_id from chartacc_list where c_enable =1 order by c_code,c_refer;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$id=$row['c_id'];
						$c_code = $row['c_code'];
						$c_name=$row['c_name'];
						$level=$row['c_level'];
						if ($level==0){
							echo"<tbody>
						<tr>
							<td>$c_code $c_name</td>
							
							<td><a href='?pages=chartofacc&id=$id&action=edit&catch=done' title='Edit User' name='edit'>Edit</a></td>
							<td>&nbsp;</td>
						
						
						";
						}
						else{
							$str="";
							for ($i==0;$i<$level;$i++){
								$str=$str."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}
							$i=0;
								
							echo"
							<td>$str$c_code $c_name</td>
							
							<td><a href='?pages=chartofacc&id=$id&action=edit&catch=done' title='Edit User' name='edit'>Edit</a></td>
							<td>&nbsp;</td>
							
						
						";	
						}
						echo "</tr>";
						
					}
					
				?>
                	<tr class="bg">
                    	<td colspan="10">&nbsp;</td>
                    </tr>
                    </tbody>
				</table>
				<!--  end product-table..... -->