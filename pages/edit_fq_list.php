<script type="text/javascript">
	function focusit() {			
		document.getElementById("type_fq").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<?php
	$id=$_GET['id'];
	/*echo"<script>alert('$id');</script>";*/
	
	$show_userip="SELECT * FROM no_repayment WHERE id='$id' ORDER BY id ASC;";
					$resultip=mysql_query($show_userip);
					while($row=mysql_fetch_array($resultip))
					{
						$date=date('d-m-Y',strtotime($row['date']));
						$type_fq = $row['type_of_repayment'];
						$day_fq=$row['day_of_repayment'];
					}
		//update user
		
		if(isset($_POST['edit'])){
				$mytype_fq=$_POST['type_fq'];
				$myday_fq=$_POST['day_fq'];
				///transaction
				if(!empty($mytype_fq) && !empty($myday_fq)){
					$sql_insert=mysql_query("UPDATE `no_repayment` SET 
							`day_of_repayment` = '$myday_fq',
							`type_of_repayment` = '$mytype_fq' WHERE `id` =$id");
					echo"<script>alert('Edit Successful!');</script>";
					echo"<script>window.location.href='?pages=edit_fq_list&id=$id';</script>";
				}//end empty	
				else{
					echo"<script>alert('Edit Unsuccessful!Try Again!');</script>";
					}
			}
?>
<!-- start content-outer -->
<h3 class="tit">Edit Repayent Frequency Form :</h3>
		<!-- start id-form -->
        <form name="frmip" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
        <tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="input-text" name="date" id="date" value="<?php echo $date;?>" readonly="readonly"/></td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=payment_fq_list&catch=loop" title="Go to list!">Go to list of Loan Frequency</a></td>
		</tr>
		<tr>
			<th valign="top">Type Of Frequency :</th>
			<td><input type="text" class="input-text" name="type_fq" id="type_fq" autocomplete="off" value="<?php echo $type_fq;?>"/></td>
            <th valign="top">Day Of Frequency :</th>
			<td><input type="text" class="input-text" name="day_fq" id="day_fq" autocomplete="off" value="<?php echo $day_fq;?>"/></td>
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