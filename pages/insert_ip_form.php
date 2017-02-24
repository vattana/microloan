<script type="text/javascript">
	function focusit() {			
		document.getElementById("br_no").focus();
		}
	window.onload = focusit;
</script>
<?php
	if(isset($_POST['submit'])){
			$date=date('Y-m-d',strtotime($_POST['date']));
			$br_no=$_POST['br_no'];
			$br_name=$_POST['br_name'];
			$usr_name=$_POST['usr_name'];
			$set_ip=$_POST['set_ip'];
			$position=$_POST['position'];
			if(!empty($set_ip)){
				$insert_user=mysql_query("
					INSERT INTO `br_ip_mgr` (
							`id` ,
							`date` ,
							`br_no` ,
							`br_name` ,
							`usr_name` ,
							`set_ip` ,
							`position`
							)
							VALUES (
							NULL , '$date', '$br_no', '$br_name', '$usr_name', '$set_ip', '$position'
							);

					");
					echo"<script>alert('Insert Successful!');</script>";
					echo"<script>window.location.href='?pages=insert_ip_form&catch=user';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Insert Unsuccessful! Try Again!');</script>";
					}
		}
?>
<h3 class="tit">Add New IP Form :</h3>
		<!-- start id-form -->
        <form name="frmip" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
        <tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="input-text" name="date" id="date" value="<?php echo date('d-m-Y');?>" readonly="readonly"/></td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=show_ip_list&catch=loop" title="Go to list!">Go to list of IP management</a></td>
		</tr>
		<tr>
			<th valign="top">Branch No :</th>
			<td><input type="text" class="input-text" name="br_no" id="br_no" autocomplete="off"/></td>
            <th valign="top">Branch Name :</th>
			<td><input type="text" class="input-text" name="br_name" id="br_name" autocomplete="off"/></td>
		</tr>
        <tr>
			<th valign="top">User Name :</th>
			<td><input type="text" class="input-text" name="usr_name" id="usr_name" autocomplete="off" /></td>
            <th valign="top">Set IP :</th>
			<td><input type="text" class="input-text" name="set_ip" id="set_ip" autocomplete="off"/></td>
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
            </td>
            <th valign="top">&nbsp;</th>
			<td>&nbsp;
            	
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