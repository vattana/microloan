<script type="text/javascript">
	function focusit() {			
		document.getElementById("type_fq").focus();
		}
	window.onload = focusit;
</script>
<?php
	/*$check = mysql_query("SELECT * FROM loan_config;");
	$mycheck=mysql_num_rows($check);
	if($mycheck>='3'){
		echo"<script>alert('The Configurations limited is Done !');</script>";
		echo"<script>window.location.href='?pages=loan_config_list&catch=user';</script>";
		mysql_close();
		}*/
	if(isset($_POST['submit'])){
			$date=date('Y-m-d',strtotime($_POST['date']));
			$type_fq=$_POST['type_fq'];
			$day_fq=$_POST['day_fq'];
			if(!empty($day_fq)){
				$insert_user=mysql_query("
					INSERT INTO `no_repayment` (`id`, `date`, `day_of_repayment`, `type_of_repayment`) 
					VALUES (NULL, '$date', '$day_fq', '$type_fq');
					");
					echo"<script>alert('Insert Successful!');</script>";
					echo"<script>window.location.href='?pages=insert_fq_form&catch=user';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Insert Unsuccessful! Try Again!');</script>";
					}
		}
?>
<!-- start content-outer -->
<h3 class="tit">Add New Frequency Setting :</h3>
		<!-- start id-form -->
        <form name="frmip" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
        <tr>
			<th valign="top">Date :</th>
			<td><input type="text" class="input-text" name="date" id="date" value="<?php echo date('d-m-Y');?>" readonly="readonly"/></td>
            <th valign="top">&nbsp;</th>
			<td><a href="?pages=payment_fq_list&catch=loop" title="Go to list!">Go to list of Frequency</a></td>
		</tr>
		<tr>
			<th valign="top">Type of Frequency :</th>
			<td><input type="text" class="input-text" name="type_fq" id="type_fq" autocomplete="off"/></td>
            <th valign="top">Day Of Frequency :</th>
			<td><input type="text" class="input-text" name="day_fq" id="day_fq" autocomplete="off"/></td>
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
			<input type="submit" value="submit" class="form-submit" name="submit"/>
			<input type="reset" value="reset" class="form-reset"  />
		</td>
		<td></td>
	</tr>
	</table>
    </form>