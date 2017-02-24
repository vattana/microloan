<script language = "Javascript">
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
<?php
include("pages/module.php");

	if(isset($_POST['delete'])){//delete
		$myid=$_GET['id'];
		if(!empty($myid)){
			$delete=mysql_query("delete from glp_caption WHERE id='$myid'");
			echo"<script>alert('Deleted Successfull!!');</script>";
			echo"<script>window.location.href='?pages=glpointerform&catch=rollback';</script>";
		}
	}
	if(isset($_POST['update'])){//update
		$myid=$_GET['id'];
		if(!empty($myid)){
			$user = $_SESSION['usr'];
			//$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			//$session_date=trim(date('Y-m-d',strtotime($_POST['session_date'])));
			//$times=date('H:i:s');
			$date=date('Y-m-d',strtotime(trim($_POST['repay_date'])));;
			$code=trim($_POST['glcode']);
			$name=trim($_POST['glname']);


			if(!empty($code)){
				$insert_user=mysql_query("UPDATE `glp_caption` SET `glcode` = '$code',
								`glname` = '$name',
								`post_date` = '$date',
								`post_by` = '$user'
								 WHERE `id` ='$myid';");
					echo"<script>alert('Update Successful!');</script>";
					echo"<script>window.location.href='?pages=glpointerform&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
					}
		}
	}
	if(isset($_GET['action'])=='edit'){//view edit
				$myid=trim($_GET['id']);
				$display_info="SELECT * FROM glp_caption WHERE id='$myid' limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$dcode=trim($row['glcode']);
						$dName=trim($row['glname']);
						
					}
		/*echo"<script>alert('$dFName !');</script>";*/
	}
	if(isset($_POST['submit'])){
			
			$user = $_SESSION['usr'];
			//$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			//$session_date=trim(date('Y-m-d',strtotime($_POST['session_date'])));
			//$times=date('H:i:s');
			$date=date('Y-m-d',strtotime(trim($_POST['repay_date'])));;
			$code=trim($_POST['glcode']);
			$name=trim($_POST['glname']);
			
			echo "<script>alert('$user');</script>";
				if(!empty($code)){
				$insert_user=mysql_query("
					INSERT INTO `glp_caption` (
							`glcode` ,
							`id` ,
							`glname` ,
							`post_date` ,
							`post_by`
							)
							VALUES (
						'$code', null, '$name', '$date', '$user');
					") or die(mysql_error($insert_user));
					
					
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
					echo"<script>window.location.href='?pages=glpointerform&catch=rollback&pb=$max&amount=$amt&desc=$desc';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
				}

			
		}
?>
<!-- Form -->
			<h3 class="tit">GL Pointer Form :</h3>
            <fieldset>
				<legend>GL Information</legend>
                   <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle">
               
                 
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
                    
                </tr>
                
                
              <tr>
              	<td style="width:100px;">GL Code :</td>
                    <td><input type="text" size="30" class="input-text" name="glcode" id="glcode" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dcode;
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
                    <td style="width:100px;">GL Name :</td>
                    <td><input type="text" size="30" class="input-text" name="glname" id="glname" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dName;
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
							}
							else{
								echo '<input type="submit" class="input-submit" value="Add" name="submit" disabled="disabled">';
								}
                            ?>
                             <?php 
							 if(isset($_GET['action'])==' ' && ($_GET['glcode']!='05' && $_GET['glcode']!='06')){
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
                	<th>GL Code</th>
                    <th>GL Name</th>
                    <th>Create GL Pointer</th>
                    <th>Action</th>
                    <th><a href="?pages=glpointerform&clear" title="Add GL Pointer"><img src="design/Add.png" border="0"/></a></th>
				</tr>
                </thead>
				<?php
					$show_user="Select glcode,glname,id from  glp_caption
;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$c_code = $row['glcode'];
						$c_name=$row['glname'];
						 
							echo"<tbody>
						<tr>
							<td>$c_code</td>
							<td>$c_name</td>
							<td><a href='?pages=glpointercreate&action=edit&clear&code=$c_code &name=$c_name' title='Add User' > Create GL Pointer</a></td>
							<td><a href='?pages=glpointerform&id=$id&action=edit&catch=done&glcode=$c_code' title='Edit User' name='edit'>Edit</a></td>

							<td>&nbsp;</td>
						
						
						";
						
						echo "</tr>";
						
					}
					
				?>
               <!-- <tr class="tit">
                    	<td colspan="3" align="right">
                        	<b><font color="#FF6600">Total Amount :</font></b> 
                        </td>
                    	<td>
                        	<?php echo $cur.' '.formatMoney($sum_debit,true); ?>
                        </td>
                        <td>
                        	<?php echo $cur.' '.formatMoney($sum_credit,true); ?>
                        </td>
                        <td colspan="3">&nbsp;
                        	
                        </td>
                    </tr>-->
                	<tr class="bg">
                    	<td colspan="10">&nbsp;</td>
                    </tr>
                    </tbody>
				</table>
				<!--  end product-table..... -->