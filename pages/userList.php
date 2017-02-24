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
		tr.selected		{background:#FFF;color:#00C;}
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
			$delete=mysql_query("DELETE FROM user_info WHERE id='$myid'");
			echo"<script>alert('Deleted Successfull!!');</script>";
			echo"<script>window.location.href='?pages=userList&catch=rollback';</script>";
		}
	}
	if(isset($_POST['update'])){//update
		$myid=$_GET['id'];
		if(!empty($myid)){
			$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			$session_date=trim(date('Y-m-d',strtotime($_POST['session_date'])));
			$times=date('H:i:s');
			$password=trim($_POST['password']);
			$fullname=trim($_POST['fullname']);
			$usr_name=trim($_POST['usr_name']);
			$level=trim($_POST['level']);
			$status=trim($_POST['status']);
			$branch=trim($_POST['br']);
			$email=trim($_POST['email']);
			//get infor again
			$display_info="SELECT * FROM user_info WHERE id='$myid' limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$getBR=$row['branch'];
						$getLevel=$row['level'];
					}
					if($level=='0'){
						$level=$getLevel;
						}
					if($branch=='0'){
						$branch=$getBR;
						}
			if(!empty($usr_name)&& !empty($password)){
				$insert_user=mysql_query("UPDATE `user_info` SET `name` = '$fullname',
								`user_name` = '$usr_name',
								`pass` = '$password',
								`email` = '$email',
								`level` = '$level',
								`status` = '$status',
								`session_date` = '$session_date',
								`dates` = '$date',
								`times` = '$times',
								`branch` = '$branch' WHERE `id` ='$myid';");
					echo"<script>alert('Update Successful!');</script>";
					echo"<script>window.location.href='?pages=userList&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
					}
		}
	}
	if(isset($_GET['action'])=='edit'){//view edit
				$myid=trim($_GET['id']);
				$display_info="SELECT * FROM user_info WHERE id='$myid' limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$dReg_date=trim(date('d-m-Y',strtotime($row['dates'])));
						$dFName=trim($row['name']);
						$dUserName=trim($row['user_name']);
						$dEmail=trim($row['email']);
						$dPass=trim($row['pass']);
						$dLevel=trim($row['level']);	
						$dStatus=trim($row['status']);
						$dSesDate=trim(date('d-m-Y',strtotime($row['session_date'])));
						$dDate=trim(date('d-m-Y',strtotime($row['dates'])));
						$dBr=trim($row['branch']);
					}
		/*echo"<script>alert('$dFName !');</script>";*/
	}
	if(isset($_POST['submit'])){
			$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			$session_date=trim(date('Y-m-d',strtotime($_POST['session_date'])));
			$times=date('H:i:s');
			$password=trim($_POST['password']);
			$fullname=trim($_POST['fullname']);
			$usr_name=trim($_POST['usr_name']);
			$leve=trim($_POST['level']);
			$status=trim($_POST['status']);
			$branch=trim($_POST['br']);
			$email=trim($_POST['email']);
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
					echo"<script>alert('Saved Successful!');</script>";
					echo"<script>window.location.href='?pages=userList&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
					}
		}
?>
<!-- Form -->
			<h3 class="tit">User Form :</h3>
            <fieldset>
				<legend>User</legend>
                   <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle">
                <tr>
                    <td style="width:100px;">Register Date :</td>
                    <td><input type="text" size="30" class="input-text" name="date" id="date" 
                    value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dReg_date;
							 }
							 else{
								 echo date('d-m-Y');
								 }
								?>" onblur="doDate(this,'em_Date');"/></td>
                    <td style="width:100px;">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="width:100px;">ឈ្មោះ :</td>
                    <td><input type="text" size="24" class="input-text" name="fullname" id="fullname" 
                    autocomplete="off" style="font-family:khmer OS; size:10pt" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo trim($dFName);
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                    <td style="width:100px;">User Name :</td>
                    <td><input type="text" size="30" class="input-text" name="usr_name" id="usr_name" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dUserName;
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                </tr>
                
                <tr>
                    <td style="width:100px;">Password :</td>
                    <td><input type="text" size="30" class="input-text" name="password" id="password" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dPass;
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                    <td style="width:100px;">E-mail :</td>
                    <td><input type="text" size="30" class="input-text" name="email" id="email" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dEmail;
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                </tr>
                <tr>
                    <td style="width:100px;">Level :</td>
                    <td>	<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dLevel;
							 }
							 else{
								 echo '';
								 }
								?>
                                <select class="input-text" name="level" id="level">
                                    <option value="0" selected="selected">--Level--</option>
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
                    <td style="width:100px;">Status :</td>
                    <td><?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dStatus;
							 }
							 else{
								 echo '';
								 }
								?>
                        <select class="input-text" name="status" id="status">
                                <option value="active">Active</option>
                                <option value="none-active">None-Active</option>           
                        </select>
                    </td>
                </tr>
                <tr>
                 <td style="width:100px;">Session Date :</td>
                    <td><input type="text" size="30" class="input-text" name="session_date" id="session_date" 
                    autocomplete="off" onblur="doDate(this,'em_Date');" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dSesDate;
							 }
							 else{
								 echo '';
								 }
								?>"/>
                    </td>
                    <td style="width:100px;">Branch :</td>
                    <td><?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dBr;
							 }
							 else{
								 echo '';
								 }
								?>
                        <select class="input-text" name="br" id="br">
                                    <option value="0">--Branch--</option>
                                   <?php 
                                    
                                        $str_br="Select * from br_ip_mgr Group by br_name asc";
                                        $sql_br=mysql_query($str_br);
                                        while ($row=mysql_fetch_array($sql_br))
                                        {
                                            $br_name=$row['br_name'];
                                            $br_no=$row['br_no'];
                                            echo '<option value="'.$br_no.'">' .$br_no.'-'.$br_name. '</option>';
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
                	<th>Register Date</th>
					<th>Name</th>
					<th>User Name</th>
					<th>Email</th>
					<th>Status</th>
					<th>Level</th>
                    <th>Session Date</th>
					<th>Branch</th>
                    <th>Actions</th>
                    <th><a href="?pages=userList&clear" title="Add User"><img src="design/Add.png" border="0"/></a></th>
				</tr>
                </thead>
				<?php
					$show_user="SELECT * FROM user_info ORDER BY id ASC;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$user_name = $row['user_name'];
						$full_name=$row['name'];
						$level=$row['level'];
						$status=$row['status'];
						$email=$row['email'];
						$branch=$row['branch'];
						$session_date=date('d-m-Y',strtotime($row['session_date']));
						$reg_date=date('d-m-Y',strtotime($row['dates']));
						echo"<tbody>
						<tr>
							<td>$reg_date</td>
							<td>$full_name</td>
							<td>$user_name</td>
							<td>$email</td>
							<td>$status</td>
							<td>$level</td>
							<td>$session_date</td>
							<td>$branch</td>
							<td><a href='?pages=userList&id=$id&action=edit&catch=done' title='Edit User' name='edit'>Edit</a></td>
							<td>&nbsp;</td>
						</tr>
						
						";
					}
					
				?>
                	<tr class="bg">
                    	<td colspan="10">&nbsp;</td>
                    </tr>
                    </tbody>
				</table>
				<!--  end product-table..... -->