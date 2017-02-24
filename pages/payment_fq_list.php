<!-- start content-outer ........................................................................................................................START -->
		<h3 class="tit">Repayment Frequency Information </h3>
<!-- end page-heading -->
				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="650" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th> </th>
					<th>No</th>
					<th>Type of Repayment</th>
					<th>Frequency</th>
                    <th>Action</th>
                    <th background="design/table/table_header_checkbox.gif">
                    	<a href="?pages=insert_fq_form&catch=user"><img src="design/table/Add.png" title="Add Frequency"/></a>
                    </th>
				</tr>
				<?php
					$show_user="SELECT * FROM no_repayment ORDER BY id ASC;";
					$result=mysql_query($show_user);
					$i=1;
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$fq=$row['day_of_repayment'];
						$type_fq=$row['type_of_repayment'];
						echo"
						<tr>
							<td><input type='checkbox' name='select'></td>
							<td>$i</td>
							<td>$fq</td>
							<td>$type_fq</td>
							<td class='options-width'>
								<a href='?pages=edit_fq_list&id=$id&action=edit' class='icon-1 info-tooltip' 
								title='Edit $type_fq' name='edit' onclick='return confirm(\"Are you sure wanna edit $type_fq ?\");'> Edit </a> |
								<a href='?pages=payment_fq_list&id=$id&action=delete' class='icon-2 info-tooltip' 
								title='Delete $type_fq' name='delete' onclick='return confirm(\"Are you sure wanna delete $type_fq ?\");'>Delete</a>
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
							$delete=mysql_query("DELETE FROM no_repayment WHERE id='$myid'");
							echo"<script>alert('Delete Successful!');</script>";
							echo"<script>window.location.href='?pages=payment_fq_list&catch=user';</script>";
							}
					}//end isset
					/////////end actions
				?>
				</table>
				<!--  end product-table................................... --> 
				</form>