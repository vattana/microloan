<!-- start content-outer ........................................................................................................................START -->
<script type="text/javascript">
	function focusit() {			
		document.getElementById("gid").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>

<!-- suggestion cif -->
	<script type="text/javascript">
				var nameArray = null;
	</script>
	 <script type="text/javascript">
            function doSuggestionBox(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestions').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestions').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestions(text);
                }
            }
            function outClick() {
                document.getElementById('divSuggestions').style.visibility = 'hidden';
            }
            function doSelection(text) {
                var selection = text;
                document.getElementById('divSuggestions').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("gid").value = selection;
            }
            function changeBG(obj) {
                element = document.getElementById(obj);
                oldColor = element.style.backgroundColor;
                if (oldColor == "white" || oldColor == "") {
                    element.style.background = "blue";
                    element.style.color = "white";
                    element.style.cursor = "pointer";
                } else {
                    element.style.background = "white";
                    element.style.color = "#333333";
                    element.style.cursor = "pointer";
                }
            }
            function doSuggestions(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBG(this.id);' onMouseOut='changeBG(this.id);' onclick='doSelection(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClick();
                }
                document.getElementById('divSuggestions').innerHTML = code;
                document.getElementById('divSuggestions').style.overflow='auto';
            }
        </script>
<style type="text/css">
            <!--
            div.suggestions {
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                border: 1px solid #999999;
                text-align: left;
				z-index:0;
            }
            -->
</style>
<!-- end suggestion cif -->
<?php
		$query = "SELECT * FROM gid ORDER BY id ASC";
			$result = mysql_query($query);
			$counter = 0;
			echo("<script type='text/javascript'>");
			echo("this.nameArray = new Array();");
			if($result) {
				while($row = mysql_fetch_array($result)) {
					echo("this.nameArray[" . $counter . "] = '" . trim($row['g_id']) . " ';");
					$counter += 1;
				}
			}
			echo("</script>");
?>
		<h3 class="tit">Search Group ID List </h3>
    <!-- start id-form -->
    	
        <form name="gidList" method="post" enctype="multipart/form-data" action="">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="400" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'" class="nostyle">
         <tr>
		<th valign="top">Group ID :</th>
		<td>	
		<input type="text" class="input-text" name="gid" id="gid" autocomplete="off" 
        onKeyPress="return handleEnter(this, event);" onKeyUp="doSuggestionBox(this.value);"/>
		</td>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
        </tr>
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
				<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 13%;
						 	margin-top:-24px; background-color: #FFFFFF;float:right; color: #666666; 
                            height: 100px; padding-left: 5px;position:absolute;">
                </div>
		</td>
			<th>&nbsp;</th>
			<td>&nbsp;
            	
            </td>
		</tr> 

		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="search" class="form-submit" name="search" id="print_sch"/>
                <input type="reset" value="reset" class="form-reset"  />
            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>
	<!-- end id-form  -->
    </center>
	<!-- end page-heading -->

				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="1100" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th><a id="toggle-all" > </th>
					<th>Entry Date	</th>
					<th>Group ID</th>
					<th>Group Member</th>
					<th>Created By</th>
					<th>Branch</th>
                    <th>Active Member</th>
                    <th class="table-header-options line-left">Actions</th>
                    
				</tr>
				<?php
				
							if(isset($_POST['search'])){
								$mygid=$_POST['gid'];
								$show_user="SELECT * FROM gid where g_id='$mygid' ORDER BY id ASC;";
							}
							else{
								$show_user="SELECT * FROM gid ORDER BY id ASC;";
								}
								$result=mysql_query($show_user);
								$myrow=mysql_num_rows($result);
								if($myrow=='0'){
										echo"<script>alert('$myrow Records Found,Try again!!');</script>";
										echo"<script>window.location.href='?pages=search_gid_list&catch=user';</script>";	
										}
								while($row=mysql_fetch_array($result))
								{
									$id=$row['id'];
									$gid = $row['g_id'];
									$g_member=$row['g_member'];
									$branch=$row['entry_at'];
									$entry_by=$row['entry_by'];
									$date=date('d-m-Y',strtotime($row['entry_date']));
									//check number of members
										$result_loan_member = mysql_query("SELECT * FROM loan_process where group_id ='$gid'");
										$loan_rows = mysql_num_rows($result_loan_member);
									///
									echo"
									<tr>
										<td><input type='checkbox' name='select'></td>
										<td>$date</td>
										<td>$gid</td>
										<td>$g_member</td>
										<td>$entry_by</td>
										<td>$branch</td>
										";
									if($loan_rows!='0'){
									echo"
										<td>
											<a href='pages/show_loan_member_list.php?gid=$gid&catch=enc&ses=$id&br=$branch' 
											title='View Members' target='_blank'>View $loan_rows members</a>
										</td>
										";
									}else {
										echo"
										<td title='No Member yet!'>
											$loan_rows members
										</td>
										";
										}
									echo"
										<td class='options-width'>
											<a href='?pages=edit_gid_list&id=$id&action=edit&catch=user' class='icon-1 info-tooltip' 
											title='Edit $full_name' name='edit' onclick='return confirm(\"Are you sure wanna edit $gid?\");'>
											Edit </a>  | 
											
											<a href='?pages=search_gid_list&id=$id&action=delete&mygid=$gid&catch=user' 
											class='icon-2 info-tooltip' title='Delete $full_name' name='delete' 
											onclick='return confirm(\"Are you sure wanna delete $gid?\");'>Delete</a>   | 
											
											<a href='?pages=group_loanForm&gid=$gid&catch=enc' 
											class='icon-4 info-tooltip' title='Add member to $gid' name='delete' 
											onclick='return confirm(\"Are you sure wanna Add member to  $gid?\");'>Add Member</a>
										</td>
								
									</tr>
									
									";
								}
						
					
								////////do actions
									$myid=$_GET['id'];
									$action=$_GET['action'];
									$mygid=$_GET['mygid'];
									if(isset($_GET['catch'])){
										if($action=='delete'){
											//catch member
												$show_mem="SELECT * FROM loan_process WHERE group_id='$mygid';";
												$result1=mysql_query($show_mem);
												$myrow1=mysql_num_rows($result1);
											//
											if($myrow1=='0'){//if no member
													$delete=mysql_query("DELETE FROM gid WHERE id='$myid'");
													echo"<script>alert('Delete Successful!');</script>";
												}
												else{
												echo"<script>alert('This Group ID contain member you can not delete this group ID!!');</script>";
													}
												echo"<script>window.location.href='?pages=search_gid_list&catch=user';</script>";	
											}
										}//end isset
					/////////end actions
				?>
				</table>
				<!--  end product-table................................... --> 
				</form>
			