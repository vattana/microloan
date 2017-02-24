<script type="text/javascript">
	function focusit() {			
		document.getElementById("fullname").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<script language = "Javascript">
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
</script>
<?php
	if(isset($_POST['submit'])){
			$date=date('Y-m-d',strtotime($_POST['date']));
			$session_date=date('Y-m-d',strtotime($_POST['session_date']));
			$times=date('H:i:s');
			$password=$_POST['password'];
			$fullname=$_POST['fullname'];
			$usr_name=$_POST['usr_name'];
			$leve=$_POST['level'];
			$status=$_POST['status'];
			$branch=$_POST['br'];
			$email=$_POST['email'];
			if(!empty($usr_name)&& !empty($password)){
				$insert_user=mysql_query("
					INSERT INTO `user_info` (
							`id` ,
							`name` ,
							`user_name` ,
							`pass` ,
							`email` ,
							`level` ,
							`status` ,
							`session_date` ,
							`dates` ,
							`times` ,
							`branch`
							)
							VALUES (
						NULL , '$fullname', '$usr_name', '$password', '$email', '$leve', '$status', '$session_date', '$date', '$times', '$branch'
							);
					");
					echo"<script>alert('Insert Successful!');</script>";
					echo"<script>window.location.href='?pages=insert_user_form&catch=user';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Insert Unsuccessful! Try Again!');</script>";
					}
		}
?>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">
<div id="page-heading"><h1>Add User Form :</h1></div>

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table" 
 onclick="document.getElementById('divSuggestions').style.visibility='hidden'">
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
			<div class="step-no">+</div>
			<div class="step-dark-left">Add More User</div>
			<div class="step-dark-right">&nbsp;</div>
			
		</div>
		<!--  end step-holder -->
		<!-- start id-form -->
        <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%">
        <tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="inp-form" name="date" id="date" value="<?php echo date('d-m-Y');?>" readonly="readonly"/></td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=show_user_list&catch=loop" title="Go to list!">Go to list of user management</a></td>
		</tr>
		<tr>
			<th valign="top">ឈ្មោះ :</th>
			<td><input type="text" class="inp-form" name="fullname" id="fullname" autocomplete="off"/></td>
            <th valign="top">User Name :</th>
			<td><input type="text" class="inp-form" name="usr_name" id="usr_name" autocomplete="off"/></td>
		</tr>
        
        <tr>
			<th valign="top">Password :</th>
			<td><input type="password" class="inp-form" name="password" id="password" autocomplete="off" /></td>
            <th valign="top">E-mail :</th>
			<td><input type="text" class="inp-form" name="email" id="email" autocomplete="off"/></td>
		</tr>
        <tr>
			<th valign="top">Level :</th>
			<td>	
                        <select class="styledselect_form_1" name="level" id="level">
                            <option value="0">--Level--</option>
                             <?php 
							
								$str_recom="Select * from staff_list Group by s_position asc";
								$sql_recom=mysql_query($str_recom);
								while ($row=mysql_fetch_array($sql_recom))
								{
									$s_position=$row['s_position'];
									echo '<option value="'.$s_position.'">' .$s_position. '</option>';
								}
							?>
                        </select>
            </td>
            <th valign="top">Status :</th>
			<td>
            	<select class="styledselect_form_1" name="status" id="status">
						<option value="active">Active</option>
						<option value="none-active">None-Active</option>           
                </select>
            </td>
		</tr>
        <tr>
		 <th valign="top">Session Date :</th>
			<td><input type="text" class="inp-form" name="session_date" id="session_date" autocomplete="off" onblur="doDate(this,'em_Date');"/>
            </td>
			<th valign="top" align="right">Branch :</th>
			<td>
            	<select class="styledselect_form_1" name="br" id="br">
                            <option value="0">--Branch--</option>
                           <?php 
							
								$str_br="Select * from br_ip_mgr Group by br_name asc";
								$sql_br=mysql_query($str_br);
								while ($row=mysql_fetch_array($sql_br))
								{
									$br_name=$row['br_name'];
									$br_no=$row['br_no'];
									echo '<option value="'.$br_name.'">' .$br_name. '</option>';
								}
							?>
                        </select>
            </td>
		</tr> 
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
		<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 15%;
						 	margin-top:-24px; background-color: #FFFFFF;float:right; 
							color: #666666; height: 100px; padding-left: 5px;position:absolute;">
                        </div>
		</td>
			<th valign="top" align="right">&nbsp;</th>
			<td>&nbsp;
            	
            </td>
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