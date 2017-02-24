<script type="text/javascript">
	function focusit() {			
		document.getElementById("gmember").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<?php
	//////////////////get max gid
				$query_maxid = "SELECT max(code) as max_id FROM gid"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['max_id'];
						$convert = intval($max);
						$max += 1;
						$mymax=$max;
						if (strlen($max)==1){ 
							$max='G0000'.$max;
						}
						else if((strlen($max)==2)){
							$max='G000'.$max;
						}
						else if((strlen($max)==3)){
							$max='G00'.$max;
						}
						else if((strlen($max)==4)){
							$max='G0'.$max;
						}
						else {
							$max = 'G'.$max ;
						}
					}
					///end check max id-----
					///check branch no------------
					$br_ip = $_SERVER['REMOTE_ADDR'];
					$br_sql="Select * from br_ip_mgr where set_ip ='$br_ip'";
					$result_br=mysql_query($br_sql) or die (mysql_error());
						while($row = mysql_fetch_array($result_br))
								{
									$get_ip=$row['set_ip'];
									$get_br=$row['br_no'];	 
								}
					//end check branch no------	
					//insert 
						if(isset($_POST['submit'])){// post isset
							$date=date('Y-m-d',strtotime($_POST['date']));
							$gid=$_POST['gid'];
							$gmember=$_POST['gmember'];
							$entry_by=$_POST['entry_by'];
								if(!empty($gmember)){//insert query
									$sql_gid=mysql_query("
										INSERT INTO `gid` (
													`id` ,
													`code` ,
													`g_id` ,
													`g_member` ,
													`entry_date` ,
													`entry_at` ,
													`entry_by`
													)
													VALUES (
													NULL , '$mymax', '$max', '$gmember', '$date', '$get_br', '$entry_by'
													);
									");
									echo"<script>alert('Insert Successful!');</script>";
									echo"<script>window.location.href='index.php?pages=group_loanForm&gid=$max&catch=enc'</script>";
								}//insert query
								else{//role back
									echo"<script>alert('try again!');</script>";
									}
							}//end isset
					////	
?>
<h3 class="tit">Group Loan Information :</h3>
		<!-- start id-form -->
        <form name="cust_request" method="post" enctype="multipart/form-data">
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
            value="<? echo date('d-m-Y'); ?>" readonly="readonly"/></td>
            <th valign="top">Group ID :</th>
			<td><input type="text" class="input-text" name="gid" id="gid" autocomplete="off" value="<? echo $max; ?>" readonly="readonly"/></td>
		</tr>
        <tr>
			<th valign="top">Group Members :</th>
			<td><input type="text" class="input-text" name="gmember" id="gmember" autocomplete="off" onblur="doDate(this,'em_Date');"/></td>
            <th valign="top">Entry By :</th>
			<td><input type="text" class="input-text" name="entry_by" id="entry_by" value="<? echo $_SESSION['usr']; ?>" readonly="readonly" 
            style="font-family:khmer OS; size:10pt" size="16"/></td>
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
	