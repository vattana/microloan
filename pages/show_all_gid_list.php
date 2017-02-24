<?php
    session_start();
    if(empty($_SESSION['usr'])) header('login.php');
	include("module.php");	
	include("conn.php");
?>
<html>
<link rel="stylesheet" type="text/css" href="../css/screen.css" media="all">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<title>Group ID List - OLMS</title>
<style type="text/css">
	p, li, td	{font:normal 12px/12px Arial;}
		table	{border:0;border-collapse:collapse;}
		td		{padding:3px; padding-left:10px; text-align:left}
		tr.odd	{background:#FFF;}
		tr.highlight	{background:#CCC;}
		tr.selected		{background:#FFF;color:#096;}
</style>
<script type="text/javascript">

function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}

function addClass(element,value) {
  if (!element.className) {
    element.className = value;
  } else {
    newClassName = element.className;
    newClassName+= " ";
    newClassName+= value;
    element.className = newClassName;
  }
}


function stripeTables() {
	var tbodies = document.getElementsByTagName("tbody");
	for (var i=0; i<tbodies.length; i++) {
		var odd = true;
		var rows = tbodies[i].getElementsByTagName("tr");
		for (var j=0; j<rows.length; j++) {
			if (odd == false) {
				odd = true;
			} else {
				addClass(rows[j],"odd");
				odd = false;
			}
		}
	}
}

function lockRow() {
	var tbodies = document.getElementsByTagName("tbody");
	for (var j=0; j<tbodies.length; j++) {
		var rows = tbodies[j].getElementsByTagName("tr");
		for (var i=0; i<rows.length; i++) {
			rows[i].oldClassName = rows[i].className
			rows[i].onclick = function() {
				if (this.className.indexOf("selected") != -1) {
					this.className = this.oldClassName;
				} else {
					addClass(this,"selected");
				}
			}
		}
	}
}

addLoadEvent(stripeTables);
addLoadEvent(lockRow);
</script>
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">
	<center>
	<!--  start page-heading -->
	<div id="page-heading">
		<h1><u>All Group ID List</u></h1>
	</div>

    </center>
	<!-- end page-heading -->

				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="1200" cellpadding="0" cellspacing="0" id="product-table" class="nostyle">
				<tr style="background:#03F; color:#FFFFFF">
					<th ><a id="toggle-all" > </th>
					<th >Date	</th>
					<th>Group ID</th>
					<th>Group Member</th>
					<th>Created By</th>
					<th>Branch</th>
                    <th>Active Member</th>
                    <th>Actions</th>
				</tr>
				<?php
								
								////
									$bgcolor="#f1f1f1";
								$page_name="show_all_gid_list.php"; //  If you use this code with a different page ( or file ) name then change this 
			
								////// starting of drop down to select number of records per page /////
								
								@$limit=$_GET['limit']; // Read the limit value from query string. 
								if(strlen($limit) > 0 and !is_numeric($limit)){
								echo "Data Error";
								exit;
								}
								
								// If there is a selection or value of limit then the list box should show that value , so we have to lock that options //
								// Based on the value of limit we will assign selected value to the respective option//
								switch($limit)
								{
								case 100:
								$select100="selected";
								$select10="";
								$select5="";
								$select20="";
								$select30="";
								$select50="";
								$select200="";
								$select500="";
								break;
								
								case 200:
								$select200="selected";
								$select100="";
								$select10="";
								$select5="";
								$select20="";
								$select30="";
								$select50="";
								$select500="";
								break;
								
								case 5:
								$select5="selected";
								$select100="";
								$select10="";
								$select200="";
								$select20="";
								$select30="";
								$select50="";
								$select500="";
								break;
								
								case 10:
								$select10="selected";
								$select100="";
								$select5="";
								$select200="";
								$select20="";
								$select30="";
								$select50="";
								$select500="";
								break;
								
								case 20:
								$select20="selected";
								$select5="";
								$select200="";
								$select10="";
								$select30="";
								$select50="";
								$select100="";
								$select500="";
								break;
								
								case 30:
								$select30="selected";
								$select5="";
								$select100="";
								$select200="";
								$select10="";
								$select20="";
								$select50="";
								$select500="";
								break;
								
								case 500:
								$select30="";
								$select5="";
								$select100="";
								$select200="";
								$select10="";
								$select20="";
								$select50="";
								$select500="selected";
								break;
								
								default:
								$select50="selected";
								$select5="";
								$select10="";
								$select20="";
								$select200="";
								$select30="";
								$select100="";
								$select500="";
								break;
								
								}
								
								$start=$_GET['start'];
								if(strlen($start) > 0 and !is_numeric($start)){
								echo "Data Error";
								exit;
								}
								
								echo "<div id='search'>View Records per page: <form method=get action=$page_name>
								<select name=limit id='search'>
								<option value=5 $select5>5 Records</option>
								<option value=10 $select10>10 Records</option>
								<option value=20 $select20>20 Records</option>
								<option value=30 $select30>30 Records</option>
								<option value=50 $select50>50 Records</option>
								<option value=100 $select100>100 Records</option>
								<option value=200 $select200>200 Records</option>
								<option value=500 $select500>500 Records</option>
								</select>
								<input type=submit value=GO name=go></div>";	
							$eu = ($start - 0); 
					
							if(!$limit > 0 ){ // if limit value is not available then let us use a default value
								$limit = 10;    // No of records to be shown per page by default.
							}                             
							$this1 = $eu + $limit; 
							$back = $eu - $limit; 
							$next = $eu + $limit; 
							
							
							/////////////// WE have to find out the number of records in our table. We will use this to break the pages///////
							$query2=" SELECT * FROM gid";
							$result2=mysql_query($query2);
							echo mysql_error();
							$nume=mysql_num_rows($result2);
							/////// The variable nume above will store the total number of records in the table////
							////////////// Now let us start executing the query with variables $eu and $limit 
								$query=" SELECT * FROM gid order by id desc limit $eu, $limit ";
								$result=mysql_query($query);
								echo mysql_error();
								/////
								
								////
								$myrow=mysql_num_rows($result);
								if($myrow=='0'){
										echo"<script>alert('$myrow Records Found!!');</script>";
										}
								$ii=1;
								while($row = mysql_fetch_array($result,MYSQL_ASSOC))
								{
								if($bgcolor=='#f1f1f1'){$bgcolor='#ffffff';}
								else{$bgcolor='#f1f1f1';}
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
										<td bgcolor=$bgcolor>$ii</td>
										<td bgcolor=$bgcolor>$date</td>
										<td bgcolor=$bgcolor>$gid</td>
										<td bgcolor=$bgcolor>$g_member</td>
										<td bgcolor=$bgcolor>$entry_by</td>
										<td bgcolor=$bgcolor>$branch</td>
										";
									if($loan_rows!='0'){
									echo"
										<td bgcolor=$bgcolor>
											<a href='show_loan_member_list.php?gid=$gid&catch=enc&ses=$id&br=$branch' 
											title='View Members' target='_blank'>View $loan_rows members</a> |
										</td>
										";
									}else {
										echo"
										<td title='No Member yet!' bgcolor=$bgcolor>
											$loan_rows members
										</td>
										";
										}
									echo"
										<td class='options-width' bgcolor=$bgcolor>
											<a href='?pages=search_gid_list&id=$id&action=delete&mygid=$gid&catch=user' 
											class='icon-2 info-tooltip' 
											title='Delete $full_name' name='delete' 
											onclick='return confirm(\"Are you sure wanna delete $gid?\");'>Delete</a>
										</td>
								
									</tr>
									
									";
									$ii++;
								}
								
								////////
								
								
							/////////////// Start the buttom links with Prev and next link with page numbers /////////////////
							echo "<table align = 'center' width='30%'><tr><td  align='left' width='10%'>";
							//// if our variable $back is equal to 0 or more then only we will display the link to move back ////////
							if($back >=0) { 
							print "<a href='$page_name?start=$back&limit=$limit'><font face='Verdana' size='2'>PREV</font></a>"; 
							} 
							//////////////// Let us display the page links at  center. We will not display the current page as a link ///////////
							echo "</td><td align=center width='10%'>";
							$i=0;
							$l=1;
							for($i=0;$i < $nume;$i=$i+$limit){
							if($i <> $eu){
							echo " <a href='$page_name?start=$i&limit=$limit'><font face='Verdana' size='2'>$l</font></a> ";
							}
							else { echo "<font face='Verdana' size='2' color=red>$l</font>";}   
							$l=$l+1;
							}
							
							
							echo "</td><td  align='right' width='10%'>";
							///////////// If we are not in the last page then Next link will be displayed. Here we check that /////
							if($this1 < $nume) { 
							print "<a href='$page_name?start=$next&limit=$limit'><font face='Verdana' size='2'>NEXT</font></a>";} 
							echo "</td></tr></table>";
							$myrec =$nume-1;
							echo "<p id='search'> Your selecting is :  ".$limit." / ".$nume."  records  </p>";
							
							////////do actions
									$myid=$_GET['id'];
									$action=$_GET['action'];
									$mygid=$_GET['mygid'];
								if(isset($_GET['action'])){
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
											echo"<script>window.location.href='show_all_gid_list.php';</script>";	
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