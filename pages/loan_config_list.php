<!-- start content-outer ........................................................................................................................START -->
		<h3 class="tit">Loan Configuration Information </h3>
	<!-- end page-heading -->
				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="700" cellpadding="0" cellspacing="0" id="product-table" style="nostyle">
				<tr>
					<th></th>
					<th>No</th>
					<th>Properties</th>
					<th>Settings</th>
                    <th>Action</th>
                    <th background="design/table/table_header_checkbox.gif">
                    	<a href="?pages=insert_loancon_form&catch=user"><img src="design/table/Add.png" title="Add Configuration" /></a>
                    </th>
				</tr>
				<?php
					$show_user="SELECT * FROM loan_config ORDER BY id ASC;";
					$result=mysql_query($show_user);
					$i=1;
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$property=$row['property'];
						$setting=$row['setting'];
						echo"
						<tr>
							<td><input type='checkbox' name='select'></td>
							<td>$i</td>
							<td>$property</td>
							<td>$setting</td>
							<td class='options-width'>
								<a href='?pages=edit_loancon_list&id=$id&action=edit' class='icon-1 info-tooltip' 
								title='Edit $property' name='edit' onclick='return confirm(\"Are you sure wanna edit $property ?\");'>Edit</a> |
								<a href='?pages=loan_config_list&id=$id&action=delete' class='icon-2 info-tooltip' 
								title='Delete $property' name='delete' onclick='return confirm(\"Are you sure wanna delete $property ?\");'>Delete</a>
							</td>
							<td>&nbsp;</td>
						</tr>
						
						";
						$i+=1;
					}
					
					////////do actions
						$myid=$_GET['id'];
						$action=$_GET['action'];
					if(isset($_GET['action'])){
						if($action=='delete'){
							$delete=mysql_query("DELETE FROM loan_config WHERE id='$myid'");
							echo"<script>alert('Delete Successful!');</script>";
							echo"<script>window.location.href='?pages=loan_config_list&catch=user';</script>";
							}
					}//end isset
					/////////end actions
				?>
				</table>
				<!--  end product-table................................... --> 
				</form>