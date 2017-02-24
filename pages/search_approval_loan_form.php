<script type="text/javascript">
	function focusit() {			
		document.getElementById("from").focus();
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
                document.getElementById("cid").value = selection;
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
	$query = "SELECT cif FROM register where appr='1' and cancel ='0' GROUP BY cif ASC";
        $result = mysql_query($query);
        $counter = 0;
        echo("<script type='text/javascript'>");
        echo("this.nameArray = new Array();");
        if($result) {
            while($row = mysql_fetch_array($result)) {
                echo("this.nameArray[" . $counter . "] = '" . trim($row['cif']) . " ';");
                $counter += 1;
            }
        }
        echo("</script>");
?>
<!-- start content-outer -->
<h3 class="tit">Search Approval Loan :</h3>

		<!-- start id-form -->
        <form name="cust_request" method="post" enctype="multipart/form-data" action="pages/show_approval_list.php" target="_new">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
		<tr>
			<th valign="top">From :</th>
			<td><input type="text" class="input-text" name="from" id="from" autocomplete="off" onblur="doDate(this,'em_Date');"/></td>
            <th valign="top">TO :</th>
			<td><input type="text" class="input-text" name="to" id="to" autocomplete="off" onblur="doDate(this,'em_Date');"/></td>
		</tr>
        <tr>
			<th valign="top">Recommender :</th>
			<td>	
                        <select class="input-text" name="recommender" id="recommender">
                            <option value="0">--Recommender--</option>
                             <?php 
							
								$str_recom="Select recomend_name from register Group by recomend_name asc";
								$sql_recom=mysql_query($str_recom);
								while ($row=mysql_fetch_array($sql_recom))
								{
									$recomend_name=$row['recomend_name'];
									echo '<option value="'.$recomend_name.'">' .$recomend_name. '</option>';
								}
							?>
                        </select>
            </td>
            <th valign="top">CO :</th>
			<td>
            	<select class="input-text" name="co" id="co" onkeypress="return handleEnter(this, event);">
                            <option value="0">--CO--</option>
                           <?php 
							
								$str_co="Select co from register Group by co asc";
								$sql_co=mysql_query($str_co);
								while ($row=mysql_fetch_array($sql_co))
								{
									$co=$row['co'];
									echo '<option value="'.$co.'">' .$co. ' </option>';
								}
							?>
                        </select>
            </td>
		</tr>
        <tr>
		<th valign="top">CID :</th>
		<td>	
		<input type="text" class="input-text" name="cid" id="cid" autocomplete="off" onKeyPress="return handleEnter(this, event);" 
        onKeyUp="doSuggestionBox(this.value);"/>
		</td>
			<th valign="top" align="right">Branch :</th>
			<td>
            	<select class="input-text" name="br" id="br">
                            <option value="0">--Branch--</option>
                           <?php 
							
								$str_br="Select * from br_ip_mgr Group by br_name asc";
								$sql_br=mysql_query($str_br);
								while ($row=mysql_fetch_array($sql_br))
								{
									$br_name=$row['br_name'];
									$br_no=$row['br_no'];
									echo '<option value="'.$br_no.'">' .$br_name. '</option>';
								}
							?>
                        </select>
            </td>
		</tr> 
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
		<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 15%;
						 	margin-top:-24px; background-color: #FFFFFF;float:right; 
							color: #666666; height: 100px; padding-left: 5px;position:absolute;">
                        </div>
		</td>
			<th valign="top" align="right">&nbsp;</th>
			<td>&nbsp;
            	
            </td>
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