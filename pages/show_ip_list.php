<!-- start content-outer ........................................................................................................................START -->
		<h3 class="tit">User IP List </h3>
	<!-- end page-heading -->

				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="900" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th></th>
					<th>Branch No</a>	</th>
					<th>Branch Name</a></th>
					<th>User Name</a></th>
					<th>IP</a></th>
					<th>Pisition</a></th>
                    <th>Action</a></th>
                    <th background="design/table/table_header_checkbox.gif">
                    	<a href="?pages=insert_ip_form&catch=user"><img src="design/table/Add.png" title="Add User" /></a>
                    </th>
				</tr>
				<?php
					$show_user="SELECT * FROM br_ip_mgr ORDER BY id ASC;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$br_no = $row['br_no'];
						$br_name=$row['br_name'];
						$user_name=$row['usr_name'];
						$ip=$row['set_ip'];
						$position=$row['position'];
		
						echo"
						<tr>
							<td><input type='checkbox' name='select'></td>
							<td>$br_no</td>
							<td>$br_name</td>
							<td>$user_name</td>
							<td>$ip</td>
							<td>$position</td>
							<td class='options-width'>
								<a href='?pages=edit_ip_list&id=$id&action=edit' class='icon-1 info-tooltip' 
								title='Edit $full_name' name='edit' onclick='return confirm(\"Are you sure wanna edit $user_name ?\");'> Edit </a>|
								<a href='?pages=show_ip_list&id=$id&action=delete' class='icon-2 info-tooltip' 
								title='Delete $user_name' name='delete' onclick='return confirm(\"Are you sure wanna delete $user_name
 ?\");'> Delete</a>
							</td>
							<td>&nbsp;</td>
						</tr>
						
						";
					}
					////////do actions
						$myid=$_GET['id'];
						$action=$_GET['action'];
					if(isset($_GET['action'])){
						if($action=='delete'){
							$delete=mysql_query("DELETE FROM br_ip_mgr WHERE id='$myid'");
							echo"<script>alert('Delete Successful!');</script>";
							echo"<script>window.location.href='?pages=show_ip_list&catch=user';</script>";
							}
					}//end isset
					/////////end actions
				?>
				</table>
				<!--  end product-table................................... --> 
				</form>
			</div>
			<!--  end content-table  -->
			
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->