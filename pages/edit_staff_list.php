<script type="text/javascript">
	function focusit() {			
		document.getElementById("s_id").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<?php

	$getId=$_GET['id'];
	$display_info="SELECT * FROM staff_list WHERE id='$getId' limit 1";
			$result_info=mysql_query($display_info) or die (mysql_error());
			while($row=mysql_fetch_array($result_info)){
					$s_id=$row['s_id'];
					$s_name_kh=$row['s_name_kh'];
					$s_name=$row['s_name'];
					$s_sex=$row['s_sex'];
					$s_phone=$row['s_phone'];
					$s_dob=date('d-m-Y',strtotime($row['s_dob']));
					$s_salary=$row['s_salary'];
					$s_position=$row['s_position'];
					$s_pob=$row['s_pob'];
					$cur_adr=$row['cur_adr'];
					break;
			}
	////////		
	if(isset($_POST['update'])){
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
				$update_staff=mysql_query("
					UPDATE `staff_list` SET `s_id` = '$s_id', `s_name` = '$name',
							`s_name_kh` = '$kh_name',
							`s_position` = '$pos',
							`s_kh_position` = '',
							`s_sex` = '$sex',
							`s_phone` = '$phone',
							`s_dob` = '$dob',
							`s_salary` = '$salary',
							`s_pob` = '$pob',
							`cur_adr` = '$cur_adr' WHERE `id` ='$getId' LIMIT 1 ;
					");
					echo"<script>alert('Update Successful!');</script>";
					echo"<script>window.location.href='?pages=edit_staff_list&catch=user&id=$getId&enc';</script>";
				
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
			<th valign="top"></th>
			<td>&nbsp;</td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=search_staff_list&catch=loop" title="Go to list!">Go to list of Staff List</a></td>
		</tr>
		<tr>
			<th valign="top">Staff ID : </th>
			<td><input type="text" class="input-text" name="s_id" id="s_id" value="<?php echo $s_id;?>"/></td>
            <th valign="top">ឈ្មោះ :</th>
			<td><input type="text" class="input-text" name="kh_name" id="kh_name" autocomplete="off" value="<?php echo $s_name_kh;?>"/></td>
		</tr>
        
        <tr>
			<th valign="top">Name :</th>
			<td><input type="text" class="input-text" name="name" id="name" autocomplete="off" onblur="ChangeCase(this);" value="<?php echo $s_name;?>"/></td>
            <th valign="top">Sex :</th>
			<td>
            	<select class="input-text" name="sex" id="sex" onkeypress="return handleEnter(this, event);">
                    <option value="<?php echo trim($s_sex);?>">--<?php echo $s_sex;?>--</option>
                    <option value="M">ប្រុស-Male</option>
                    <option value="F">ស្រី-Female</option>
                    <option value="U">មិនស្គាល់-Unknown</option>
                </select>
            </td>
		</tr>
        
         <tr>
			<th valign="top">Phone :</th>
			<td><input type="text" class="input-text" name="phone" id="phone" autocomplete="off" value="<?php echo $s_phone;?>"/></td>
            <th valign="top">Date Of Birth :</th>
			<td><input type="text" class="input-text" name="dob" id="dob" autocomplete="off" onblur="doDate(this,'em_Date');"  value="<?php echo $s_dob;?>"/></td>
		</tr> 
        
        <tr>
			<th valign="top">Salary :</th>
			<td><input type="text" class="input-text" name="salary" id="salary" autocomplete="off" value="<?php echo $s_salary;?>"/></td>
            <th valign="top">Position :</th>
			<td>
            		<div>	
                        <select class="input-text" name="pos" id="pos">
                            <option value="<?php echo $s_position;?>">--<?php echo $s_position;?>--</option>
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
            <td><textarea rows="3" cols="25" class="form-textarea" name="pob" id="pob"><?php echo $s_pob;?></textarea></td>
            <td></td>
		</tr>
        
        <tr>
            <th valign="top">Current Address :</th>
            <td><textarea rows="3" cols="25" class="form-textarea" name="cur_adr" id="cur_adr"><?php echo $cur_adr;?></textarea></td>
            <td></td>
		</tr>
        <tr>
		<th>&nbsp;</th>
        <td>&nbsp;</td>
        </tr>
	  	<tr>
		<th>&nbsp;</th>
		<td valign="top">
			<input type="submit" value="Update" class="form-submit" name="update" onclick="return confirm('Are you sure wanna update?');"/>
			<input type="reset" value="reset" class="form-reset"  />
		</td>
		<td></td>
	</tr>
	</table>
    </form>