<script type="text/javascript">
	function focusit() {			
		document.getElementById("fullname").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<?php
	$id=$_GET['id'];
	/*echo"<script>alert('$id');</script>";*/
	$show_user="SELECT * FROM user_info WHERE id='$id' ORDER BY id ASC;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$user_name = $row['user_name'];
						$full_name=$row['name'];
						$level=$row['level'];
						$status=$row['status'];
						$email=$row['email'];
						$branch=$row['branch'];
						$session_date=date('d-m-Y',strtotime($row['session_date']));
						$password=$row['pass'];
					}
		//update user
		
		if(isset($_POST['edit'])){
				$myfull_name=$_POST['fullname'];
				$myuser_name=$_POST['usr_name'];
				$mylevel=$_POST['level'];
				$mystatus=$_POST['status'];
				$myemail=$_POST['email'];
				$mybranch=$_POST['br'];
				$mysession_date=date('Y-m-d',strtotime($_POST['session_date']));
				$mypassword=$_POST['password'];
				if($mylevel=='0'){
					$mylevel=$level;
					}
				if($mybranch=='0'){
					$mybranch=$branch;
					}
				
				///transaction
				if(!empty($myfull_name) && !empty($mypassword)){
					$sql_insert=mysql_query("UPDATE user_info SET name='$myfull_name',user_name='$myuser_name',pass='$mypassword',email='$myemail',level='$mylevel',status='$mystatus',session_date='$mysession_date',branch='$mybranch' WHERE id='$id'");
					echo"<script>alert('Edit Successful!');</script>";
					echo"<script>window.location.href='?pages=edit_user_list&id=$id';</script>";
				}//end empty	
				else{
					echo"<script>alert('Edit Unsuccessful!Try Again!');</script>";
					}
			}
?>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">
<div id="page-heading"><h1>Edit User Form :</h1></div>

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
			<div class="step-dark-left">Edit User</div>
			<div class="step-dark-right">&nbsp;</div>
			
		</div>
		<!--  end step-holder -->
		<!-- start id-form -->
        <form name="add_user" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%">
        <tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="inp-form" name="date" id="date" value="<?php echo date('d-m-Y');?>" readonly="readonly"/>
            	<input type="hidden" name="txtid" value="<?php echo $id; ?>"</td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=show_user_list&catch=loop" title="Go to list!">Go to list of user management</a></td>
		</tr>
		<tr>
			<th valign="top">ឈ្មោះ :</th>
			<td><input type="text" class="inp-form" name="fullname" id="fullname" autocomplete="off" value="<?php echo $full_name;?>" /></td>
            <th valign="top">User Name :</th>
			<td><input type="text" class="inp-form" name="usr_name" id="usr_name" autocomplete="off" value="<?php echo $user_name;?>"/></td>
		</tr>
        
        <tr>
			<th valign="top">Password :</th>
			<td><input type="text" class="inp-form" name="password" id="password" autocomplete="off" value="<?php echo $password;?>"/></td>
            <th valign="top">E-mail :</th>
			<td><input type="text" class="inp-form" name="email" id="email" autocomplete="off" value="<?php echo $email;?>"/></td>
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
                        ( <?php echo $level; ?> )
            </td>
            <th valign="top">Status :</th>
			<td>
                <input type="text" class="inp-form" name="status" id="status" autocomplete="off" 
                value="<?php echo $status;?>" readonly="readonly" />
            </td>
		</tr>
        <tr>
		 <th valign="top">Session Date :</th>
			<td><input type="text" class="inp-form" name="session_date" id="session_date" autocomplete="off" onblur="doDate(this,'em_Date');" 
            value="<?php echo $session_date;?>"/>
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
                         ( <?php echo $branch; ?> )
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
			<input type="submit" value="edit" class="form-submit" name="edit"/>
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