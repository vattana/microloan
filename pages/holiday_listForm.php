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
	
	include("pages/module.php");
	$sqlHoli="SELECT * FROM holiday";
	$result_holi=mysql_query($sqlHoli) or die (mysql_error());
	$holi_num=mysql_num_rows($result_holi);
		
	if(isset($_POST['delete'])){//delete
		$myid=$_GET['id'];
		if(!empty($myid)){
			$delete=mysql_query("DELETE FROM holiday WHERE id='$myid'");
			echo"<script>alert('Deleted Successfull!!');</script>";
			echo"<script>window.location.href='?pages=holiday_listForm&catch=rollback';</script>";
		}
	}
	if(isset($_POST['update'])){//update
		$myid=$_GET['id'];
		if(!empty($myid)){
			$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			$full_desc=trim($_POST['nameOf']);			//get infor again
			
			if(!empty($date)){
				$update_holi=mysql_query("UPDATE `holiday` SET `name_of_holiday` = '$full_desc',
`holiday` = '$date' WHERE `id` =$myid LIMIT 1 ;");
					echo"<script>alert('Update Successful!');</script>";
					echo"<script>window.location.href='?pages=holiday_listForm&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
					}
		}
	}
	if(isset($_GET['action'])=='edit'){//view edit
				$myid=trim($_GET['id']);
				$display_info="SELECT * FROM holiday WHERE id='$myid' limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$id=$row['id'];
						$ddate = date('d-m-Y',strtotime($row['holiday']));
						$dfull_name=$row['name_of_holiday'];
					}
		/*echo"<script>alert('$dFName !');</script>";*/
	}
	if(isset($_POST['submit'])){
			$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			$mycheckDate=$_POST['date'];
			$full_desc=trim($_POST['nameOf']);
			if(!empty($mycheckDate)){
				$insert_user=mysql_query("
					INSERT INTO `holiday` (
											`id` ,
											`name_of_holiday` ,
											`holiday`
											)
											VALUES (
											NULL , '$full_desc', '$date'
											);
					");
					echo"<script>alert('Saved Successful!');</script>";
					echo"<script>window.location.href='?pages=holiday_listForm&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
					}
		}
?>
<!-- Form -->
			<h3 class="tit">Holiday Form : <? echo formatMoney($holi_num,true).' Holiday'; ?></h3>
            <fieldset>
				<legend>Holiday</legend>
                   <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle">
                <tr>
                    <td style="width:100px;">Holiday Date:</td>
                    <td><input type="text" size="30" class="input-text" name="date" id="date" 
                    value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $ddate;
							 }
							 else{
								 echo '';
								 }
								?>" onblur="doDate(this,'em_Date');" autocomplete="off"/></td>
                   <td style="width:100px;">Holiday :</td>
                    <td><input type="text" size="30" class="input-text" name="nameOf" id="nameOf" 
                    autocomplete="off" style="font-family:khmer OS; size:10pt" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo trim($dfull_name);
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                </tr>
                  
                    <tr>
                            <td colspan="3" class="t-right">
                            <?php if(isset($_GET['action'])!='edit'){
								echo'
                                <input type="submit" class="input-submit" value="Add" name="submit" 
                                onclick="return confirm(\'Are you sure wanna save ?\')"/>';
								echo'
                                <input type="submit" class="input-submit" value="Search" name="search"/>';
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
                	<th>Holiday</th>
					<th>Name Of Holiday</th>
                    <th>Actions</th>
                    <th><a href="?pages=holiday_listForm&clear" title="Add Holiday"><img src="design/Add.png" border="0"/></a></th>
				</tr>
                </thead>
				<?php
				
				$show_user="SELECT * FROM holiday ORDER BY holiday DESC limit 50;";
				if(isset($_POST['search'])){
							$date=trim(date('Y-m-d',strtotime($_POST['date'])));
							$mydate=$_POST['date'];
							$full_desc=trim($_POST['nameOf']);
						if(!empty($mydate) && empty($full_desc)){
							$show_user="SELECT * FROM holiday WHERE holiday ='$date' ORDER BY holiday DESC;";
							}
						else if(empty($mydate) && !empty($full_desc)){
							$show_user="SELECT * FROM holiday WHERE name_of_holiday like '%$full_desc%' ORDER BY holiday DESC;";
						}
						else{
							$show_user="SELECT * FROM holiday ORDER BY holiday DESC limit 50;";
						}
					}
					$result=mysql_query($show_user);
					$i=1;
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$date = date('d-m-Y',strtotime($row['holiday']));
						$full_name=$row['name_of_holiday'];
						
						echo"<tbody>
						<tr>
							<td>$i</td>
							<td>$date</td>
							<td>$full_name</td>
							<td><a href='?pages=holiday_listForm&id=$id&action=edit&catch=done' title='Edit Holiday' name='edit'>Edit</a></td>
							<td>&nbsp;</td>
						</tr>
						
						";
						$i++;
					}
				?>
                	<tr class="bg">
                    	<td colspan="10">&nbsp;</td>
                    </tr>
                    </tbody>
				</table>
				<!--  end product-table..... -->