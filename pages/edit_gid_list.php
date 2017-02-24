<script type="text/javascript">
	function focusit() {			
		document.getElementById("gmember").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<?php
				$id=$_GET['id'];
				//retreive Data
					$show_user="SELECT * FROM gid where id='$id' ORDER BY id ASC;";
								$result=mysql_query($show_user);
								$myrow=mysql_num_rows($result);
								while($row=mysql_fetch_array($result))
								{
									$id=$row['id'];
									$gid = $row['g_id'];
									$g_member=$row['g_member'];
									$branch=$row['entry_at'];
									$entry_by=$row['entry_by'];
									$date=date('d-m-Y',strtotime($row['entry_date']));	 
								}
				////	
				///update
				if(isset($_POST['edit'])){
					$myg_member=trim($_POST['gmember']);
					if(!empty($myg_member)){
					$update_gmember=mysql_query("UPDATE gid SET g_member='$myg_member' where id='$id'");
						echo"<script>alert('$gid Now Has been update member to $myg_member member!');</script>";
						echo"<script>window.location.href='?pages=edit_gid_list&id=$id&action=edit&catch=user';</script>";
					}else{
						echo"<script>alert('Unsuccessful!Please Try Again!');</script>";
						}
				}
				///
?>
<h3 class="tit">Edit Group ID :</h3>

		<!-- start id-form -->
        <form name="gidSearchForm" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
        <tr>
			<th valign="top">&nbsp;</th>
			<td><a href="index.php?pages=search_gid_list&catch=enc_64">Search Group ID</a></td>
            <th valign="top">&nbsp;</th>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="input-text" name="date" id="date" autocomplete="off" onblur="doDate(this,'em_Date');" 
            value="<? echo $date; ?>" readonly="readonly"/></td>
            <th valign="top">Group ID :</th>
			<td><input type="text" class="input-text" name="gid" id="gid" autocomplete="off" value="<? echo $gid; ?>" readonly="readonly"/></td>
		</tr>
        <tr>
			<th valign="top">Group Members :</th>
			<td><input type="text" class="input-text" name="gmember" id="gmember" autocomplete="off" onblur="doDate(this,'em_Date');" 
            value="<? echo $g_member; ?>"/></td>
            <th valign="top">Entry By :</th>
			<td><input type="text" class="input-text" name="entry_by" id="entry_by" value="<? echo $_SESSION['usr']; ?>" readonly="readonly"/></td>
		</tr> 
	  	<tr>
		<th>&nbsp;</th>
		<td valign="top">
			<input type="submit" value="edit" class="form-submit" name="edit" onclick="return confirm('Are you sure wanna Edit?');"/>
			<input type="reset" value="reset" class="form-reset"  />
		</td>
		<td></td>
	</tr>
	</table>
    </form>