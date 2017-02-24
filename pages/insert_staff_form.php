<script type="text/javascript">
	function focusit() {			
		document.getElementById("s_id").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<?php
	if(isset($_POST['submit'])){
			$date=date('Y-m-d',strtotime($_POST['date']));
			$s_id=$_POST['s_id'];
			$kh_name=$_POST['kh_name'];
			$name=$_POST['name'];
			$sex=$_POST['sex'];
			$phone=$_POST['phone'];
			$dob=date('Y-m-d',strtotime($_POST['dob']));
			$salary=$_POST['salary'];
			$pos=$_POST['pos'];
			$pob=$_POST['pob'];
			$cur_adr=$_POST['cur_adr'];
			if(!empty($kh_name)&& !empty($phone)){
				$insert_user=mysql_query("
					INSERT INTO `staff_list` (
							`id` ,
							`s_id` ,
							`s_name` ,
							`s_name_kh` ,
							`s_position` ,
							`s_kh_position` ,
							`s_sex` ,
							`s_phone` ,
							`s_dob` ,
							`s_salary` ,
							`s_pob` ,
							`cur_adr` ,
							`br_no`
							)
							VALUES (
							NULL , '$s_id', '$name', '$kh_name', '$pos', '', '$sex', '$phone', '$dob', '$salary', '$pob', '$cur_adr', '$get_br'
							);
					");
					echo"<script>alert('Insert Successful!');</script>";
					echo"<script>window.location.href='?pages=insert_staff_form&catch=user';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Insert Unsuccessful! Try Again!');</script>";
					}
		}
?>
<!-- start content-outer -->
<h3 class="tit">Add Staff Form :</h3>
		<!-- start id-form -->
        <form name="frmuser" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
        <tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="input-text" name="date" id="date" value="<?php echo date('d-m-Y');?>" readonly="readonly"/></td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=search_staff_list&catch=loop" title="Go to list!">Go to list of Staff List</a></td>
		</tr>
		<tr>
			<th valign="top">Staff ID : </th>
			<td><input type="text" class="input-text" name="s_id" id="s_id" autocomplete="off"/></td>
            <th valign="top">ឈ្មោះ :</th>
			<td><input type="text" class="input-text" name="kh_name" id="kh_name" autocomplete="off"/></td>
		</tr>
        
        <tr>
			<th valign="top">Name :</th>
			<td><input type="text" class="input-text" name="name" id="name" autocomplete="off" onblur="ChangeCase(this);"/></td>
            <th valign="top">Sex :</th>
			<td>
            	<select class="input-text" name="sex" id="sex" onkeypress="return handleEnter(this, event);">
                    <option value="0">--ជ្រើសរើសភេទ--</option>
                    <option value="M">ប្រុស-Male</option>
                    <option value="F">ស្រី-Female</option>
                    <option value="U">មិនស្គាល់-Unknown</option>
                </select>
            </td>
		</tr>
        
         <tr>
			<th valign="top">Phone :</th>
			<td><input type="text" class="input-text" name="phone" id="phone" autocomplete="off" /></td>
            <th valign="top">Date Of Birth :</th>
			<td><input type="text" class="input-text" name="dob" id="dob" autocomplete="off" onblur="doDate(this,'em_Date');"/></td>
		</tr> 
        
        <tr>
			<th valign="top">Salary :</th>
			<td><input type="text" class="input-text" name="salary" id="salary" autocomplete="off" /></td>
            <th valign="top">Position :</th>
			<td>
            		<div>	
                        <select class="input-text" name="pos" id="pos">
                            <option value="0">--Position By--</option>
                             <?php 
							
								$str_posi="Select * from staff_pos Group by en_posi asc";
								$sql_posi=mysql_query($str_posi);
								while ($row=mysql_fetch_array($sql_posi))
								{
									$s_position=$row['en_posi'];
									echo '<option value="'.$s_position.'">' .$s_position. '</option>';
								}
							?>
                        </select>
                     </div>
            </td>
		</tr>
        
        <tr>
            <th valign="top">Place Of Birth :</th>
            <td><textarea rows="3" cols="25" class="form-textarea" name="pob" id="pob"></textarea></td>
            <td></td>
		</tr>
        
        <tr>
            <th valign="top">Current Address :</th>
            <td><textarea rows="3" cols="25" class="form-textarea" name="cur_adr" id="cur_adr"></textarea></td>
            <td></td>
		</tr>
        <tr>
		<th>&nbsp;</th>
        <td>&nbsp;</td>
        </tr>
	  	<tr>
		<th>&nbsp;</th>
		<td valign="top">
			<input type="submit" value="submit" class="form-submit" name="submit" onclick="return confirm('Are you sure wanna save?');"/>
			<input type="reset" value="reset" class="form-reset"  />
		</td>
		<td></td>
	</tr>
	</table>
    </form>