<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>User Information List </h1>
	</div>
	<!-- end page-heading -->

				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-check"><a id="toggle-all" ></a> </th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Name</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">User Name</a></th>
					<th class="table-header-repeat line-left"><a href="">Email</a></th>
					<th class="table-header-repeat line-left"><a href="">Status</a></th>
					<th class="table-header-repeat line-left"><a href="">Level</a></th>
                    <th class="table-header-repeat line-left"><a href="">Session Date</a></th>
					<th class="table-header-options line-left"><a href="">Branch</a></th>
                    <th class="table-header-options line-left"><a href="">Actions</a></th>
                    <th background="images/table/table_header_checkbox.gif">
                    	<a href="?pages=insert_user_form&catch=user"><img src="images/table/Add.png" title="Add User" /></a>
                    </th>
				</tr>
				<?php
					$show_user="SELECT * FROM user_info ORDER BY id ASC;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$user_name = $row['user_name'];
						$full_name=$row['name'];
						$level=$row['level'];
						$status=$row['status'];
						$email=$row['email'];
						$branch=$row['branch'];
						$session_date=date('d-m-Y',strtotime($row['session_date']));
						echo"
						<tr>
							<td><input type='checkbox' name='select'></td>
							<td>$full_name</td>
							<td>$user_name</td>
							<td>$email</td>
							<td>$status</td>
							<td>$level</td>
							<td>$session_date</td>
							<td>$branch</td>
							<td class='options-width'>
								<a href='?pages=edit_user_list&id=$id&action=edit' class='icon-1 info-tooltip' 
								title='Edit $full_name' name='edit' onclick='return confirm(\"Are you sure wanna edit $full_name?\");'></a>
								<a href='?pages=show_user_list&id=$id&action=delete' class='icon-2 info-tooltip' 
								title='Delete $full_name' name='delete' onclick='return confirm(\"Are you sure wanna delete $full_name?\");'></a>
								<a href='?pages=show_user_list&id=$id&action=none-active' class='icon-4 info-tooltip' 
								title='None-Active $full_name' name='none-active' 
								onclick='return confirm(\"Are you sure wanna none-active $full_name?\");'></a>
								<a href='?pages=show_user_list&id=$id&action=active' class='icon-5 info-tooltip' 
								title='Active $full_name' name='active' onclick='return confirm(\"Are you sure wanna active $full_name?\");'></a>
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
							$delete=mysql_query("DELETE FROM user_info WHERE id='$myid'");
							echo"<script>alert('Delete Successful!');</script>";
							echo"<script>window.location.href='?pages=show_user_list&catch=user';</script>";
							}
						if($action=='none-active'){
							$none_active=mysql_query("UPDATE user_info SET status='none-active' WHERE id='$myid'");
							echo"<script>alert('$action successful!');</script>";
							echo"<script>window.location.href='?pages=show_user_list&catch=user';</script>";
							}
						if($action=='active'){
							$active=mysql_query("UPDATE user_info SET status='active' WHERE id='$myid'");
							echo"<script>alert('$action successful!');</script>";
							echo"<script>window.location.href='?pages=show_user_list&catch=user';</script>";
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