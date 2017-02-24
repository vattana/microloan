<script language = "Javascript">
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
                document.getElementById("acc").value = selection;
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
		function focusit() {			
				document.getElementById("fullname").focus();
				}
			window.onload = focusit;
/**
 * DHTML email validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */
 function doselect(){
	document.getElementById("acc").value='';	
	document.getElementById("name").value='';
	if(document.getElementById("r").checked==true){
		document.getElementById("acc").readOnly=true;
		document.getElementById("r").value= "Header";
				document.getElementById("name").readOnly=false;
						document.getElementById("rd").readOnly=false;
	}	 
	else
	{
		document.getElementById("name").readOnly=true;
		document.getElementById("r").value= "Account";
		document.getElementById("acc").readOnly=false;
				document.getElementById("rd").readOnly=true;
	}
	//return alert(document.getElementById("r").value);
 }
function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail Address")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail Address")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail Address")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail Address")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail Address")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail Address!")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail Address!")
		    return false
		 }

 		 return true					
	}

function ValidateForm(){
	var emailID=document.frmuser.email
	var btnNew=document.frmuser.addnew
	
	if ((emailID.value==null)||(emailID.value=="")){
		alert("Please Enter your Email Address!")
		emailID.focus()
		return false
	}
	if (echeck(emailID.value)==false){
		emailID.value=""
		emailID.focus()
		return false
	}
	return true
 }
 ///////////
 function clearForm(){
	 document.getElementById("fullname").value="";
	 document.getElementById("user_name").value="";
	 document.getElementById("password").value="";
	 document.getElementById("email").value="";
	 document.getElementById("session_date").value="";
	 document.getElementById("fullname").focus(); 
	  return false;
	 }
</script>
<style type="text/css">

		tr.odd	{background:#FFF;}
		tr.highlight	{background:#CCC;}
		tr.selected		{background:#FFF;color:#090;}
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
<?php
		$query = "SELECT * FROM chartacc_list where c_is_header=0 and c_enable=1";
			$result = mysql_query($query);
			$counter = 0;
			
			echo("<script type='text/javascript'>");
			echo("this.nameArray = new Array();");
			if($result) {
				while($row = mysql_fetch_array($result)) {
					echo("this.nameArray[" . $counter . "] = '" . trim($row['c_code']) . " ';");
					$counter += 1;
				}
			}
			echo("</script>");
?>
<?php
	if(isset($_POST['delete'])){//delete
		$myid=$_GET['id'];
		$r=trim($_POST['r']);
			if ($r=="Header"){
				$ri = 1;	
			}
			else{
				$ri=0;	
			}
			
		if(!empty($myid)){
			if ($ri==1){
		
			
				$delete=mysql_query("delete from gl_caption WHERE ca_id='$myid' and ca_isbl=0");
			}
			else{
				$delete=mysql_query("delete from gllink WHERE `id` ='$myid' and isbl=0");
			}
			echo"<script>alert('Deleted Successfull!!');</script>";
			echo"<script>window.location.href='?pages=prepareincomestatement&catch=rollback';</script>";
		}
	}
	if(isset($_POST['update'])){//update
		$myid=$_GET['id'];
		if(!empty($myid)){
			$name=trim($_POST['name']);
			$main=trim($_POST['main']);
			$acc=trim($_POST['acc']);
			$r=trim($_POST['r']);
			$rd=trim($_POST['rd']);
			
			if ($r=="Header"){
				$ri = 1;	
			}
			else{
				$ri=0;	
			}
			
			if ($rd=="Debit"){
				$rdi = 1;	
			}
			else{
				$rdi=0;	
			}
			
			
			list($main, $id,$indexs) =
    			split(",", $main, 3);
			if ($main=="Root"){
				$id=0;	
				//$main='';
				$display_info="SELECT indexs FROM gl_caption WHERE ca_master='$main' and ca_isbl  =0  order by indexs desc limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
					$indexs=$row['indexs']+1;
				}
				
			}
			else
			{
				$id=$id;	
				$indexs=$indexs;
			}
			
			//Get Info again
			$display_info="SELECT * FROM gl_caption WHERE ca_id='$myid' and   ca_isbl  =0 limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$getca_master=$row['ca_master'];
						$getindexs=$row['indexs'];
					}
					if($main=='Root'){
						$main=$getca_master;
						$indexs=$getindexs;
					}
			if ($ri==1){
				if(!empty($name)){
					
					$insert_user=mysql_query("UPDATE `gl_caption` SET `ca_name` = '$name',
									`ca_level` = '$rd',
									`ca_master` = '$main',
									`indexs` = '$indexs'
									 WHERE `ca_id` ='$myid' and ca_isbl=0;");
						echo"<script>alert('Update Successful!');</script>";
						echo"<script>window.location.href='?pages=prepareincomestatement&catch=rollback';</script>";
					
					}//end empty
					else{
						echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
						}
			}
			else{
				if(!empty($acc)){
					
					$insert_user=mysql_query("UPDATE `gllink` SET `ca_id` = '$id',
									`gl_code` = '$acc'
									 WHERE `id` ='$myid' and isbl=0;");
						echo"<script>alert('Update Successful!');</script>";
						echo"<script>window.location.href='?pages=prepareincomestatement&catch=rollback';</script>";
					
					}//end empty
					else{
						echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
						}
			}
		}
	}
	if(isset($_GET['action'])=='edit'){//view edit
				$myid=trim($_GET['id']);
				$level = trim($_GET['level']);
				$display_info="SELECT * FROM gl_caption WHERE  ca_id ='$myid' and  ca_isbl =0 and ca_level='$level' limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$dca_name=trim($row['ca_name']);
						$dca_master=trim($row['ca_master']);
						$isheader=1;
					}
					if($dca_master==''){
					
						$display_info="SELECT * FROM gllink WHERE  id ='$myid' and  isbl =0 limit 0,1";
						$result_info=mysql_query($display_info) or die (mysql_error());
						$active_num=mysql_num_rows($result_info);
						while($row=mysql_fetch_array($result_info)){
							$dglcode=trim($row['gl_code']);
													$isheader=0;
						}
					}
		
	}
	if(isset($_POST['submit'])){
			$name=trim($_POST['name']);
			$main=trim($_POST['main']);
			$acc=trim($_POST['acc']);
			$r=trim($_POST['r']);
			$rd=trim($_POST['rd']);
			//$indexs=trim($_POST['ind']);
			
			
			if ($r=="Header"){
				$ri = 1;	
			}
			else{
				$ri=0;	
			}
			
			/*if ($rd=="1"){
				$rdi = 1;	
			}
			else{
				$rdi=0;	
			}*/
			
			
			list($main, $id,$indexs) =
    			split(",", $main, 3);
			if ($main=="Root"){
				$id=0;	
				//$main='';
				$display_info="SELECT indexs FROM gl_caption WHERE ca_master='$main' and ca_isbl  =0 order by indexs desc limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
					$indexs=$row['indexs']+1;
				}
				
			}
			else
			{
				$id=$id;	
				$indexs=$indexs;
			}
			if ($ri==1){
				if(!empty($name)){
					$insert_user=mysql_query("
						INSERT INTO `gl_caption` (
								`ca_name` ,
								`ca_level` ,
								`ca_master` ,
								`ca_id` ,
								`ca_isbl`,
								`indexs`
								)
								VALUES (
							'$name', '$rd', '$main', Null, '0','$indexs');
						") or die(mysql_error);
						echo"<script>alert('Saved Successful!');</script>";
						echo"<script>window.location.href='?pages=prepareincomestatement&catch=rollback';</script>";
				}
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
				}
				
			}
			else{
			
				if(!empty($acc)){
					$insert_user=mysql_query("
					INSERT INTO `gllink` (
							`ca_id` ,
							`gl_code` ,
							`isbl`
							)
							VALUES (
							'$id', '$acc','0');
					") or die(mysql_error);
					echo"<script>alert('Saved Successful!');</script>";
					echo"<script>window.location.href='?pages=prepareincomestatement&catch=rollback';</script>";
				}
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
				}
			}
		//end empty	
			
		}
?>
<!-- Form -->
			<h3 class="tit">Prepare Income statement Form :</h3>
            <fieldset>
				<legend>Account</legend>
                   <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
                <table border="1" cellpadding="0" cellspacing="0" width="100%" class="nostyle" onclick="document.getElementById('divSuggestions').style.visibility='hidden'">
                <tr>
                    <td></td>
                    <td style="width:100px;" colspan="2">
                    	<fieldset style="width:69%">
                        	<legend>Please select header or account</legend>
                            <?php
								
							 	if ($isheader==1){
									 echo "<input type='radio' value='Header' name='r' id='r' checked='checked' onclick='doselect()'/>&nbsp;&nbsp;Header&nbsp;";
									
								}
								else{
									echo "<input type='radio' value='Header' name='r' id='r' onclick='doselect()'/>&nbsp;&nbsp;Header&nbsp;";
								}
							
								if ($isheader==0){
									 echo "<input type='radio' value='Account' name='r' id='r' checked='checked' onclick='doselect()'/>&nbsp;&nbsp;Account&nbsp;";
									
								}
								else{
									echo "<input type='radio' value='Account' name='r' id='r' onclick='doselect()'/>&nbsp;&nbsp;Account&nbsp;";
								}
							?>
                            
                    	</fieldset>
                    </td>
          
                </tr>
                <tr>
                    <td></td>
                    <td>Name :&nbsp;&nbsp;<input type="text" size="24" class="input-text" onclick="doselect()" name="name" id="name"  
                    autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo trim($dca_name);
							 }
							 else{
								 echo '';
								 }
								?>"/></td>
              
 					<td>Main :&nbsp;&nbsp;<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dca_master;
							 }
							 else{
								 echo '';
								 }
								?>
                                <select class="input-text" name="main">
                                    <option value="Root" selected="selected">--Root--</option>
                                     <?php 
                                    
                                        $str_recom="select ca_name,ca_id,indexs from gl_caption where ca_isbl=0";
                                        $sql_recom=mysql_query($str_recom);
                                        while ($row=mysql_fetch_array($sql_recom))
                                        {
                                            $c_name=trim($row['ca_name']);
											$c_id =trim($row['ca_id']);
											$c_index = trim($row['indexs']);
                                            echo '<option value="'.$c_name.','.$c_id.','.$c_index.'">'.$c_name.'</option>';
											
                                        }
                                    ?>
                                  </select>
                    </td>
           
                    <td>Account :&nbsp;&nbsp;<input type="text" onclick="doselect()" size="30" class="input-text" readonly="readonly" name="acc" id="acc" onKeyUp="doSuggestionBox(this.value);" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $dglcode;
							 }
							 else{
								$m = $_GET['pb'];
								
								if($m==''){
									echo $max;	
								}
								else{
									echo $m;	
								}
								
							}
								?>"/>
                    </td>     
                </tr>
               <tr>
               <td colspan="4">	
				<div class="suggestions" id="divSuggestions" style="visibility:hidden; width: 15%;
						 	margin-top:-6px; background-color: #FFFFFF;float:right; color: #666666;  margin-left:550px;
                            height: 100px; padding-left: 7px;position:absolute;">
                </div>
               
				</td>
               </tr>
                      <tr>
                <td></td>
                    <td style="width:100px;" colspan="2">
                    	<fieldset style="width:69%">
                        	<legend>Please select level</legend>
                             <?php
								
							 	if ($disdebit==0){
									 echo "<input type='radio' value='1' name='rd' id='rd' checked='checked'/>&nbsp;&nbsp;1&nbsp;";
								}
								else{
									echo "<input type='radio' value='1' name='rd' id='rd' />&nbsp;&nbsp;1&nbsp;";
								}
							
								if ($disdebit==1){
									 echo "<input type='radio' value='2' name='rd' id='rd' checked='checked'/>&nbsp;&nbsp;2&nbsp;";
								}
								else{
									echo "<input type='radio' value='2' name='rd' id='rd' />&nbsp;&nbsp;2&nbsp;";
								}
								if ($disdebit==1){
									 echo "<input type='radio' value='3' name='rd' id='rd' checked='checked'/>&nbsp;&nbsp;3&nbsp;";
								}
								else{
									echo "<input type='radio' value='3' name='rd' id='rd' />&nbsp;&nbsp;3&nbsp;";
								}
								if ($disdebit==1){
									 echo "<input type='radio' value='4' name='rd' id='rd' checked='checked'/>&nbsp;&nbsp;4&nbsp;";
								}
								else{
									echo "<input type='radio' value='4' name='rd' id='rd' />&nbsp;&nbsp;4&nbsp;";
								}
								if ($disdebit==1){
									 echo "<input type='radio' value='5' name='rd' id='rd' checked='checked'/>&nbsp;&nbsp;5&nbsp;";
								}
								else{
									echo "<input type='radio' value='5' name='rd' id='rd' />&nbsp;&nbsp;5&nbsp;";
								}
								
							?>
                   
                    	</fieldset>
                    </td>
                </tr>
                    <tr>
                            <td colspan="3" class="t-right">
                            <?php if(isset($_GET['action'])!='edit'){
								echo'
                                <input type="submit" class="input-submit" value="Add" name="submit" 
                                onclick="return confirm(\'Are you sure wanna save ?\')"/>';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Add" name="submit" disabled="disabled">';
								}
                            ?>
                             <?php if(isset($_GET['action'])==' '){
								echo'
                                <input type="submit" class="input-submit" value="Delete" name="delete" 
                                onclick="return confirm(\'Are you sure wanna delete ?\')"/>';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Delete" name="delete" disabled="disabled">';
								}
                            ?>
                             <?php if(isset($_GET['action'])==' '){
								echo'
                                <input type="submit" class="input-submit" value="Update" name="update" 
                                onclick="return confirm(\'Are you sure wanna update ?\')"/>';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Update" name="update" disabled="disabled">';
								}
                            ?>
                           
                                <input type="reset" class="input-submit" value="Reset" />
                               </td>
                            </tr>
                        </table>
                    </fieldset>
                    </form>
<!-- Table (TABLE) -->
			
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
                <thead>
				<tr>
                	<th>Name</th>
                    <th>Amount</th>
                    <th>Level</th>
                    <th>Type</th>
                    <th>Actions</th>
                    <th><a href="?pages=prepareincomestatement&clear" title="Add Prepare Income Statement"><img src="design/Add.png" border="0"/></a></th>
				</tr>
                </thead>
				<?php
					$show_user="select ca_name , ca_level ,ca_id from gl_caption where ca_isbl  =0 order by  indexs;";
					$result=mysql_query($show_user);
					while($row=mysql_fetch_array($result))
					{
						$amount1=0;
						$id=$row['ca_id'];
						$c_name=$row['ca_name'];
						$level=$row['ca_level'];
						$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount from gllink g , chartacc_list c , account a   where a.branch='$get_br' and isbl  =0 and ca_id='$id' and g.gl_code=a.c_code and g.gl_code=c.c_code group by gl_code,c.c_name,id,isbl order by gl_code;";
							$result_acc=mysql_query($show_acc);
							while($row=mysql_fetch_array($result_acc))
							{
								$amount1 = $row['amount'];
							}
						if ($level==1){
			
							
						echo"<tbody>
						<tr>
							<td>$c_name</td>
							<td>$amount1</td>
							<td>$level</td>
							<td>Balance Sheet Caption</td>
							<td><a href='?pages=prepareincomestatement&id=$id&action=edit&catch=done&level=$level' title='Edit User' name='edit'>Edit</a></td>
							<td>&nbsp;</td>
						
							
						</tr>";
							$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount from (gllink g left join account a on g.gl_code=a.c_code) inner join chartacc_list c on g.gl_code=c.c_code   where  isbl  =0 and ca_id='$id'  group by gl_code,c.c_name,id,isbl order by gl_code;";
							$result_acc=mysql_query($show_acc);
							while($row=mysql_fetch_array($result_acc))
							{
								
								$id=$row['id'];
								$c_name1=$row['c_name'];
								$level='0';
								$amount = $row['amount'];
								echo"<tbody>
								<tr>
								<td>$c_name1</td>
								<td>$amount</td>
								<td>$level</td>
								<td>Account</td>
								<td><a href='?pages=prepareincomestatement&id=$id&action=edit&catch=done&level=$level' title='Edit User' name='edit'>Edit</a></td>
								<td>&nbsp;</td>
						
								";	
							}
						}
						else{
							$str="";
							for ($i==0;$i<$level-1;$i++){
								$str=$str."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}
							$i=0;
								
							echo"
							<td>$str $c_name</td>
							<td>$amount1</td>
							<td>$level</td>
							<td>Balance Sheet Caption</td>
							<td><a href='?pages=prepareincomestatement&id=$id&action=edit&catch=done&level=$level' title='Edit User' name='edit'>Edit</a></td>
							<td>&nbsp;</td>
						</tr>";	
						$show_acc="select gl_code , c.c_name,id,sum(c_debit+c_credit) amount from (gllink g left join account a on g.gl_code=a.c_code) inner join chartacc_list c on g.gl_code=c.c_code   where  isbl  =0 and ca_id='$id'   group by gl_code,c.c_name,id,isbl order by gl_code;";
							$result_acc=mysql_query($show_acc);
							while($row=mysql_fetch_array($result_acc))
							{
								//$str=$str."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								$accstr=$str."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								$id=$row['id'];
								$c_name1=$row['c_name'];
								$level='0';
								$amount = $row['amount'];
								echo"<tbody>
								<tr>
								<td>$accstr $c_name1</td>
								<td>$amount</td>
								<td>$level</td>
								<td>Account</td>
								<td><a href='?pages=prepareincomestatement&id=$id&action=edit&catch=done&level=$level' title='Edit User' name='edit'>Edit</a></td>
								<td>&nbsp;</td>
						
								";	
							}
						}
						echo "</tr>";
						
					}
					
				?>
                	<tr class="bg">
                    	<td colspan="10">&nbsp;</td>
                    </tr>
                    </tbody>
				</table>
				<!--  end product-table..... -->