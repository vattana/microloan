<script type="text/javascript">
	function focusit() {			
		document.getElementById("br_no").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<?php
	$id=$_GET['id'];
	/*echo"<script>alert('$id');</script>";*/
	
	$show_userip="SELECT * FROM br_ip_mgr WHERE id='$id' ORDER BY id ASC;";
					$resultip=mysql_query($show_userip);
					while($row=mysql_fetch_array($resultip))
					{
						$date=date('d-m-Y',strtotime($row['date']));
						$br_no = $row['br_no'];
						$br_name=$row['br_name'];
						$usr_name=$row['usr_name'];
						$set_ip=$row['set_ip'];
						$position=$row['position'];
					}
		//update user
		
		if(isset($_POST['edit'])){
				$mybr_no=$_POST['br_no'];
				$mybr_name=$_POST['br_name'];
				$myusr_name=$_POST['usr_name'];
				$myset_ip=$_POST['set_ip'];
				$myposition=$_POST['position'];
				if($myposition=='0'){
					$myposition=$position;
					}
				
				///transaction
				if(!empty($mybr_name) && !empty($myset_ip)){
					$sql_insert=mysql_query("UPDATE `br_ip_mgr` SET 
							`br_no` = '$mybr_no',
							`br_name` = '$mybr_name',
							`usr_name` = '$myusr_name',
							`set_ip` = '$myset_ip',
							`position` = '$myposition' WHERE `id` =$id");
					echo"<script>alert('Edit Successful!');</script>";
					echo"<script>window.location.href='?pages=edit_ip_list&id=$id';</script>";
				}//end empty	
				else{
					echo"<script>alert('Edit Unsuccessful!Try Again!');</script>";
					}
			}
?>
<h3 class="tit">Edit User IP Form :</h3>

		<!-- start id-form -->
        <form name="frmip" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
        <tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="input-text" name="date" id="date" value="<?php echo $date;?>" readonly="readonly"/></td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=show_ip_list&catch=loop" title="Go to list!">Go to list of IP management</a></td>
		</tr>
		<tr>
			<th valign="top">Branch No :</th>
			<td><input type="text" class="input-text" name="br_no" id="br_no" autocomplete="off" value="<?php echo $br_no;?>"/></td>
            <th valign="top">Branch Name :</th>
			<td><input type="text" class="input-text" name="br_name" id="br_name" autocomplete="off" value="<?php echo $br_name;?>"/></td>
		</tr>
        
        <tr>
			<th valign="top">User Name :</th>
			<td><input type="text" class="input-text" name="usr_name" id="usr_name" autocomplete="off" value="<?php echo $usr_name;?>"/></td>
            <th valign="top">Set IP :</th>
			<td><input type="text" class="input-text" name="set_ip" id="set_ip" autocomplete="off" value="<?php echo $set_ip;?>"/></td>
		</tr>
        <tr>
			<th valign="top">Position : </th>
			<td>	
                        <select class="input-text" name="position" id="position">
                            <option value="0">--Position--</option>
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
                         ( <?php echo $position; ?> )
            </td>
            
            <th valign="top">&nbsp;</th>
			<td>&nbsp;
            	
            </td>
		</tr>
        
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
		<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 13%;
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