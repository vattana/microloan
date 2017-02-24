<!-- start content-outer ........................................................................................................................START -->
<script type="text/javascript">
	function focusit() {			
		document.getElementById("code").focus();
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
                document.getElementById("code").value = selection;
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
		$query = "SELECT * FROM staff_list ORDER BY id ASC";
			$result = mysql_query($query);
			$counter = 0;
			echo("<script type='text/javascript'>");
			echo("this.nameArray = new Array();");
			if($result) {
				while($row = mysql_fetch_array($result)) {
					echo("this.nameArray[" . $counter . "] = '" . trim($row['s_id']) . " ';");
					$counter += 1;
				}
			}
			echo("</script>");
?>

		<h3 class="tit">Staff Information List </h3>
	
    <!-- start id-form -->
    	
        <form name="sch" method="post" enctype="multipart/form-data" action="">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="400" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'" class="nostyle">
         <tr>
		<th valign="top">Code :</th>
		<td>	
		<input type="text" class="inp-form" name="code" id="code" autocomplete="off" 
        onKeyPress="return handleEnter(this, event);" onKeyUp="doSuggestionBox(this.value);"/>
		</td>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
        </tr>
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
				<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 15%;
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
    </center>
	<!-- end id-form  -->
	<!-- end page-heading -->
				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th ><a id="toggle-all" > </th>
                    <th >No</th>
					<th >Code	</th>
					<th >ឈ្មោះ</th>
					<th >Name</th>
					<th >Position</th>
                    <th >Sex</th>
					<th >Phone</th>
                    <th >Date Of Birth</th>
                    <th >Salary</th>
                    <th >Address</th>
                    <th >Actions</th>
                    <th background="design/table/table_header_checkbox.gif">
                    	<a href="?pages=insert_staff_form&catch=user"><img src="design/table/Add.png" title="Add Staff" /></a>
                    </th>
				</tr>
				<?php
					$code=$_POST['code'];
					if(isset($_POST['search'])){
						$show_user="SELECT * FROM staff_list WHERE s_id='$code' ORDER BY s_id ASC;";
					}
					else{
						$show_user="SELECT * FROM staff_list ORDER BY s_id ASC;";
						}
					$result=mysql_query($show_user);
					$myrows=mysql_num_rows($result);
					if($myrows=='0'){
						echo"<script>alert('$myrows Records Found,Try again!!');</script>";
						echo"<script>window.location.href='?pages=search_staff_list&catch=user';</script>";
						}
					$i=1;
					while($row=mysql_fetch_array($result))
					{
						$id=$row['id'];
						$s_id = $row['s_id'];
						$s_kh_name=$row['s_name_kh'];
						$s_name=$row['s_name'];
						$s_posi=$row['s_position'];
						$s_posi_kh=$row['s_kh_position'];
						$s_sex=$row['s_sex'];
						$s_phone=$row['s_phone'];
						$s_dob=date('d-m-Y',strtotime($row['s_dob']));
						$s_salary=$row['s_salary'];
						$s_pob=$row['s_pob'];
						
						echo"
						<tr>
							<td><input type='checkbox' name='select'></td>
							<td>$i</td>
							<td>$s_id</td>
							<td>$s_kh_name</td>
							<td>$s_name</td>
							<td>$s_posi</td>
							<td>$s_sex</td>
							<td>$s_phone</td>
							<td>$s_dob</td>
							<td>$s_salary</td>
							<td>$s_pob</td>
							<td class='options-width'>
								<a href='?pages=edit_staff_list&id=$id&action=edit' class='icon-1 info-tooltip' 
								title='Edit $full_name' name='edit' onclick='return confirm(\"Are you sure wanna edit $s_name?\");'>Edit </a>|
								
								<a href='?pages=search_staff_list&id=$id&action=delete' class='icon-2 info-tooltip' 
								title='Delete $full_name' name='delete' onclick='return confirm(\"Are you sure wanna delete $s_name?\");'>Delete</a> 
								
							</td>
							<td>&nbsp;</td>
						</tr>
						
						";
						$i++;
					}
					////////do actions
						$myid=$_GET['id'];
						$action=$_GET['action'];
					if(isset($_GET['action'])){
						if($action=='delete'){
							$delete=mysql_query("DELETE FROM staff_list WHERE id='$myid'");
							echo"<script>alert('Delete Successful!');</script>";
							echo"<script>window.location.href='?pages=search_staff_list&catch=user';</script>";
							}
					}//end isset
					/////////end actions
				?>
				</table>
				<!--  end product-table................................... --> 
				</form>