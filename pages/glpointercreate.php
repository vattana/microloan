
	<script type="text/javascript">
				var nameArray = null;
	</script>
<script language = "Javascript">
			function doSuggestionBoxpc(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestionspc').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestionspc').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestionspc(text);
                }
            }
			function outClickpc() {
                document.getElementById('divSuggestionspc').style.visibility = 'hidden';
            }
            function doSelectionpc(text) {
                var selection = text;
                document.getElementById('divSuggestionspc').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("pc").value = selection;
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
            function doSuggestionspc(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBG(this.id);' onMouseOut='changeBG(this.id);' onclick='doSelectionpc(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClickpc();
                }
                document.getElementById('divSuggestionspc').innerHTML = code;
                document.getElementById('divSuggestionspc').style.overflow='auto';
            }
			//--------------------------------------
			function doSuggestionBoxpd(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestionspd').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestionspd').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestionspd(text);
                }
            }
			   function changeBGpd(obj) {
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
			function outClickpd() {
                document.getElementById('divSuggestionspd').style.visibility = 'hidden';
            }
            function doSelectionpd(text){
                var selection = text;
                document.getElementById('divSuggestionspd').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("pd").value = selection;
            }
   
            function doSuggestionspd(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBGpd(this.id);' onMouseOut='changeBGpd(this.id);' onclick='doSelectionpd(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClickpd();
                }
                document.getElementById('divSuggestionspd').innerHTML = code;
                document.getElementById('divSuggestionspd').style.overflow='auto';
            }
			
			//--------------------------------------
			function doSuggestionBoxic(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestionsic').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestionsic').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestionsic(text);
                }
            }
			 function changeBGic(obj) {
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
			function outClickic() {
                document.getElementById('divSuggestionsic').style.visibility = 'hidden';
            }
            function doSelectionic(text){
                var selection = text;
                document.getElementById('divSuggestionsic').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("ic").value = selection;
            }
   
            function doSuggestionsic(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBGic(this.id);' onMouseOut='changeBGic(this.id);' onclick='doSelectionic(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClickic();
                }
                document.getElementById('divSuggestionsic').innerHTML = code;
                document.getElementById('divSuggestionsic').style.overflow='auto';
            }
			//--------------------------------------
			function doSuggestionBoxid(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestionsid').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestionsid').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestionsid(text);
                }
            }
			 function changeBGid(obj) {
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
			function outClickid() {
                document.getElementById('divSuggestionsid').style.visibility = 'hidden';
            }
            function doSelectionid(text){
                var selection = text;
                document.getElementById('divSuggestionsid').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("id").value = selection;
            }
   
            function doSuggestionsid(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBGid(this.id);' onMouseOut='changeBGid(this.id);' onclick='doSelectionid(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClickid();
                }
                document.getElementById('divSuggestionsid').innerHTML = code;
                document.getElementById('divSuggestionsid').style.overflow='auto';
            }
			//--------------------------------------
			function doSuggestionBoxpid(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestionspid').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestionspid').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestionspid(text);
                }
            }
			function changeBGpid(obj) {
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
			function outClickpid() {
                document.getElementById('divSuggestionspid').style.visibility = 'hidden';
            }
            function doSelectionpid(text){
                var selection = text;
                document.getElementById('divSuggestionspid').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("pid").value = selection;
            }
   
            function doSuggestionspid(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBGpid(this.id);' onMouseOut='changeBGpid(this.id);' onclick='doSelectionpid(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClickpid();
                }
                document.getElementById('divSuggestionspid').innerHTML = code;
                document.getElementById('divSuggestionspid').style.overflow='auto';
            }
			//--------------------------------------
			function doSuggestionBoxpic(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestionspic').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestionspic').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestionspic(text);
                }
            }
			function changeBGpic(obj) {
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
			function outClickpic() {
                document.getElementById('divSuggestionspic').style.visibility = 'hidden';
            }
            function doSelectionpic(text){
                var selection = text;
                document.getElementById('divSuggestionspic').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("pic").value = selection;
            }
   
            function doSuggestionspic(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBGpic(this.id);' onMouseOut='changeBGpic(this.id);' onclick='doSelectionpic(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClickpic();
                }
                document.getElementById('divSuggestionspic').innerHTML = code;
                document.getElementById('divSuggestionspic').style.overflow='auto';
            }
		function focusit() {			
				document.getElementById("fullname").focus();
				}
			window.onload = focusit;
			
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
			
/**
 * DHTML email validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */
 </script>
<!-- start adres -->
<script type="text/javascript">
$(document).ready(function()
{
$(".macc").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "pages/ajax_sub.php",
data: dataString,
cache: false,
success: function(html)
{
$(".sub").html(html);
} 
});

});
});
///////////////
$(document).ready(function()
{
$(".district").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "pages/ajax_cur.php",
data: dataString,
cache: false,
success: function(html)
{
$(".communce").html(html);
} 
});

});
});
//////////////////////
$(document).ready(function()
{
$(".commune").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "pages/ajax_vil.php",
data: dataString,
cache: false,
success: function(html)
{
$(".village").html(html);
} 
});

});
});
//////////
</script>
<!-- end adr --> 

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
include("pages/module.php");

	if(isset($_POST['delete'])){//delete
		$myid=$_GET['id'];
		if(!empty($myid)){
			$delete=mysql_query("update chartacc_list set  c_enable =0 WHERE c_id='$myid'");
			echo"<script>alert('Deleted Successfull!!');</script>";
			echo"<script>window.location.href='?pages=chartofacc&catch=rollback';</script>";
		}
	}
	if(isset($_POST['back'])){//delete

			echo"<script>window.location.href='?pages=glpointerform&catch=repay';</script>";
	}
	if(isset($_POST['update'])){//update
		$myid=$_GET['id'];
		if(!empty($myid)){
			$code=trim($_POST['code']);
			$name=trim($_POST['name']);
			$desc=trim($_POST['desc']);
			$leve=trim($_POST['level']);
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
			
			
			list($leve, $level) =
    			split(",", $leve, 2);
			if ($leve=="Root"){
				$level=0;	
			}
			else
			{
				$level=$level+1;	
			}
			//Get Info again
			$display_info="SELECT * FROM chartacc_list WHERE c_id='$myid' and  c_enable =1 limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$getc_refer=$row['c_refer'];
						$getlevel=$row['c_level'];
					}
					if($leve=='Root'){
						$leve=$getc_refer;
						$level=$getlevel;	
					}
			if(!empty($code)&& !empty($name)){
				$insert_user=mysql_query("UPDATE `chartacc_list` SET `c_code` = '$code',
								`c_name` = '$name',
								`c_refer` = '$leve',
								`c_level` = '$level',
								`c_des` = '$desc',
								`c_is_header` = '$ri',
								`c_is_debit` = '$rdi' WHERE `c_id` ='$myid';");
					echo"<script>alert('Update Successful!');</script>";
					echo"<script>window.location.href='?pages=chartofacc&catch=rollback';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Update Unsuccessful! Try Again!');</script>";
					}
		}
	}
	if(isset($_GET['action'])=='edit'){//view edit
				$myid=trim($_GET['code']);
				$display_info="SELECT * FROM glp_acc WHERE glcode='$myid' ";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						if ($row['desc']=='Principal'){
							$pc=$row['credit'];
							$pd=$row['debit'];	
						}
						if ($row['desc']=='Interest Receivable'){
							$ic=$row['credit'];
							$id=$row['debit'];	
						}
						if ($row['desc']=='Penalty Interest'){
							$pic=$row['credit'];
							$pid=$row['debit'];	
						}
						
					}
		/*echo"<script>alert('$dFName !');</script>";*/
	}
	if(isset($_POST['new'])){
		$max= $_POST['pb'];
		$ifhave=0;
		$query_ifhave = "SELECT * FROM account where a_notran='$max'"; 
		$result_ifhave = mysql_query($query_ifhave) or die(mysql_error());
		// Print out result
		while($row = mysql_fetch_array($result_ifhave)){
			$ifhave=1;
			$amt=$amt + $row['c_credit']+$row['c_debit'];
			$desc=$row['c_des'];
		}
		if ($ifhave==0){
			///////////Auto Number
					$query_maxid = "SELECT max(acc_id) as maxCode FROM auto_acc"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['maxCode'];
						$convert = intval($max);
						$max_org = $row['maxCode'];
						$max += 1;
						if (strlen($max)==1){ 
							$max='0000'.$max;
						}
						else if((strlen($max)==2)){
							$max='000'.$max;
						}
						else if((strlen($max)==3)){
							$max='00'.$max;
						}
						else if((strlen($max)==4)){
							$max='0'.$max;
						}
						else {
							$max = $max ;
						}
					}
			////////// End Number
			$insert_user=mysql_query("
					INSERT INTO `auto_acc` (
							`acc_id`
							)
							VALUES (
						'$max');
					") or die(mysql_error);
		}
		else{
			echo"<script>window.location.href='?pages=postbatch&catch=rollback&pb=$max&amount=$amt&desc=$desc';</script>";	
		}
	}
	if(isset($_POST['save'])){
			//include("pages/module.php");
			$max = $_POST['pb'];
			$desc = $_POST['desc'];
			$display_info="SELECT sum(c_credit) credit, sum(c_debit) debit FROM  account WHERE a_notran ='$max' group by a_notran limit 0,1";
				$result_info=mysql_query($display_info) or die (mysql_error());
				$active_num=mysql_num_rows($result_info);
					while($row=mysql_fetch_array($result_info)){
						$sum_credit1=$row['credit'];
						$sum_debit1=$row['debit'];
					}
					
			if($sum_credit1==$sum_debit1)	{
				$update_user=mysql_query("
					update account set issave=1,c_des='$desc' where a_notran='$max' ;
					") or die(mysql_error);
					echo"<script>alert('Saved Successful!');</script>";
					echo"<script>window.location.href='?pages=postbatch&catch=rollback&action=edit';</script>";
			}
			else
			{
				echo "<script>alert('Credit must be the same debit');</script>";
				echo "<script>alert('Saved Unsuccessful! Try Again!');</script>";	
			}
	}
	if(isset($_POST['submit'])){
			
			
			//$date=trim(date('Y-m-d',strtotime($_POST['date'])));
			//$session_date=trim(date('Y-m-d',strtotime($_POST['session_date'])));
			//$times=date('H:i:s');
			$user = $_SESSION['usr'];
			$myid=trim($_GET['code']);
			$name=trim($_GET['name']);
			$date=date('d-m-Y');
			$pc=trim($_POST['pc']);
			$pd=trim($_POST['pd']);
			$ic=trim($_POST['ic']);
			$id=trim($_POST['id']);
			$pic=trim($_POST['pic']);
			$pid=trim($_POST['pid']);
				if(!empty($code)){
						$insert_user=mysql_query("
					delete from glp_acc where glcode='$myid';
					") or die(mysql_error);
				$insert_user=mysql_query("
					INSERT INTO `glp_acc` (
							`glcode` ,
							`id` ,
							`credit` ,
							`debit` ,
							`desc` ,
							`post_by`
							)
							VALUES (
						'$myid', null, '$pc', '$pd', 'Principal',  '$user');
					") or die(mysql_error);
					
					$insert_user=mysql_query("
					INSERT INTO `glp_acc` (
							`glcode` ,
							`id` ,
							`credit` ,
							`debit` ,
							`desc` ,
						
							`post_by`
							)
							VALUES (
						'$myid', null, '$ic', '$id', 'Interest Receivable',  '$user');
					") or die(mysql_error);
					$insert_user=mysql_query("
					INSERT INTO `glp_acc` (
							`glcode` ,
							`id` ,
							`credit` ,
							`debit` ,
							`desc` ,
							
							`post_by`
							)
							VALUES (
						'$myid', null, '$pic', '$pid', 'Penalty Interest',  '$user');
					") or die(mysql_error);
					/*if ($max==$max_org+1){
						echo "<script>alert('$max,$max_org+1');</script>";
						$insert_user=mysql_query("
					INSERT INTO `auto_acc` (
							`acc_id`
							)
							VALUES (
						'$max');
					") or die(mysql_error);
												
					}*/
					/*echo"<script>alert('Saved Successful!');</script>";*/
					echo"<script>window.location.href='?pages=glpointercreate&catch=rollback&action=edit&code=$myid&name=$name';</script>";
				
				}//end empty
				else{
					echo"<script>alert('Saved Unsuccessful! Try Again!');</script>";
				}
			}
			
		
?>
<!-- Form -->
			<h3 class="tit">GL Link Pointer Form :</h3>
            <fieldset>
				<legend>Account</legend>
                   <form name="frmuser" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm()">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="nostyle" onclick="document.getElementById('divSuggestions').style.visibility='hidden'" >
                <tr>
                    <td>&nbsp;</td>
                	<td>Code : <?php
						$code =  $_GET['code'];
						$name = $_GET['name'];
					echo $code . ', ' . $name	 	 ;
					?> </td>

                </tr>
                  <tr><td width="400"></td>
                	<td ><fieldset><legend>Principal A/C :</legend>
                    &nbsp;Credit :&nbsp;<input type="text" size="25" class="input-text" name="pc"  onKeyUp="doSuggestionBoxpc(this.value);" id="pc" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $pc;
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
                                
                                 &nbsp;Debit :&nbsp;<input type="text" size="25" class="input-text" name="pd"  onKeyUp="doSuggestionBoxpd(this.value);" id="pd" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $pd;
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
                                </fieldset>
                      </td>
                                
                                <td ><fieldset><legend>Interest Receivable A/C :</legend>
                    &nbsp;Credit :&nbsp;<input type="text" size="25" class="input-text" name="ic"  onKeyUp="doSuggestionBoxic(this.value);" id="ic" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $ic;
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
                                
                                 &nbsp;Debit :&nbsp;<input type="text" size="25" class="input-text" name="id"  onKeyUp="doSuggestionBoxid(this.value);" id="id" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $id;
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
                                </fieldset></td>
                                <td ><fieldset><legend>Penalty Interest Receivable :</legend>
                    &nbsp;Credit :&nbsp;<input type="text" size="30" class="input-text" name="pic"  onKeyUp="doSuggestionBoxpic(this.value);" id="pic" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $pic;
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
                                
                                 &nbsp;Debit :&nbsp;<input type="text" size="30" class="input-text" name="pid"  onKeyUp="doSuggestionBoxpid(this.value);" id="pid" autocomplete="off" value="<?php
							 if(isset($_GET['action'])=='edit'){
							 	echo $pid;
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
                                </fieldset></td><td width="400"></td>
                </tr>
                 <tr>
                 <th valign="top">&nbsp;</th>
		<td>	
				<div class="suggestions" id="divSuggestionspc" style="visibility: hidden; width: 15%;
						 	margin-top:-67px; background-color: #FFFFFF;float:right; color: #666666;  margin-left:10px;
                            height: 100px; padding-left: 7px;position:absolute;">
                </div>
               
		</td>
        <td>
        		 <div class="suggestions" id="divSuggestionspd" style="visibility: hidden; width: 15%;
						 	margin-top:-25px; background-color: #FFFFFF;float:right; color: #666666;  margin-left:-260px;
                            height: 100px; padding-left: 7px;position:absolute;">
                </div>
        </td> 
         <td>
        		 <div class="suggestions" id="divSuggestionsic" style="visibility: hidden; width: 15%;
						 	margin-top:-67px; background-color: #FFFFFF;float:right; color: #666666;  margin-left:-260px;
                            height: 100px; padding-left: 7px;position:absolute;">
                </div>
        </td>
                       
                        <td>
        		 <div class="suggestions" id="divSuggestionsid" style="visibility: hidden; width: 15%;
						 	margin-top:-25px; background-color: #FFFFFF;float:right; color: #666666;  margin-left:-532px;
                            height: 100px; padding-left: 7px;position:absolute;">
                </div>
        </td>
         <td>
        		 <div class="suggestions" id="divSuggestionspic" style="visibility: hidden; width: 15%;
						 	margin-top:-67px; background-color: #FFFFFF;float:right; color: #666666;  margin-left:-645px;
                            height: 100px; padding-left: 7px;position:absolute;">
                </div>
        </td>
                       
                        <td>
        		 <div class="suggestions" id="divSuggestionspid" style="visibility: hidden; width: 15%;
						 	margin-top:-25px; background-color: #FFFFFF;float:right; color: #666666;  margin-left:-655px;
                            height: 100px; padding-left: 7px;position:absolute;">
                </div>
        </td>
                        </tr>
               
               
                    <tr>
                            <td colspan="3"  class="t-right">
                            <?php if(isset($_GET['action'])!='edit'){
								echo'
                                <input type="submit" class="input-submit" value="Confirm" name="submit" 
                                onclick="return confirm(\'Are you sure wanna save ?\')"/>';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Confirm" name="submit">';
							}
                            ?>
                           
                           
            
                               
                            <?php if(isset($_GET['action'])!='edit'){
								echo'
                                <input type="submit" class="input-submit" value="Back" name="back" 
                                />';
							}
							else{
								echo '<input type="submit" class="input-submit" value="Back" name="back">';
							}
                            ?>
                           </td>		
                            </tr>
                        </table>
                    </fieldset>
                    </form>
