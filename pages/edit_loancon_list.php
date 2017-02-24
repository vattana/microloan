<script type="text/javascript">
	function focusit() {			
		document.getElementById("proper").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<?php
	$id=$_GET['id'];
	/*echo"<script>alert('$id');</script>";*/
	
	$show_userip="SELECT * FROM loan_config WHERE id='$id' ORDER BY id ASC;";
					$resultip=mysql_query($show_userip);
					while($row=mysql_fetch_array($resultip))
					{
						$date=date('d-m-Y',strtotime($row['date']));
						$proper = $row['property'];
						$setting=$row['setting'];
					}
		//update user
		
		if(isset($_POST['edit'])){
				$myproper=$_POST['proper'];
				$mysetting=$_POST['setting'];
				///transaction
				if(!empty($myproper) && !empty($mysetting)){
					$sql_insert=mysql_query("UPDATE `loan_config` SET 
							`property` = '$myproper',
							`setting` = '$mysetting' WHERE `id` ='$id'");
					echo"<script>alert('Edit Successful!');</script>";
					echo"<script>window.location.href='?pages=edit_loancon_list&id=$id';</script>";
				}//end empty	
				else{
					echo"<script>alert('Edit Unsuccessful!Try Again!');</script>";
					}
			}
?>
<!-- start content-outer -->
<h3 class="tit">Edit Loan Configuration Form :</h3>

		<!-- start id-form -->
        <form name="frmip" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
        <tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="input-text" name="date" id="date" value="<?php echo $date;?>" readonly="readonly"/></td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=loan_config_list&catch=loop" title="Go to list!">Go to list of Loan Configuration</a></td>
		</tr>
		<tr>
			<th valign="top">Property :</th>
			<td><input type="text" class="input-text" name="proper" id="proper" autocomplete="off" value="<?php echo $proper;?>"/></td>
            <th valign="top">Settings :</th>
			<td><input type="text" class="input-text" name="setting" id="setting" autocomplete="off" value="<?php echo $setting;?>"/></td>
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