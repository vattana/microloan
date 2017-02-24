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
	$query = "SELECT cif FROM register where appr='0' and cancel ='0' GROUP BY cif ASC";
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
<div id="content-outer">
<!-- start content -->
<div id="content">
<div id="page-heading"><h1>Find Customer to Approve or Cancel :</h1></div>

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table" 
 onclick="document.getElementById('divSuggestions').style.visibility='hidden'">
<tr>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>	
		<!--  start step-holder -->
		<div id="step-holder">
			<div class="step-no">2</div>
			<div class="step-dark-left">Approve and Detail</div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no">3</div>
			<div class="step-dark-left">Loan & Disburse</div>
			<div class="step-dark-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
		<!-- start id-form -->
        <form name="cust_request" method="post" enctype="multipart/form-data" action="pages/show_register_list.php" target="_new">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%">
		<tr>
			<th valign="top">Registerd From :</th>
			<td><input type="text" class="inp-form" name="from" id="from" autocomplete="off" onblur="doDate(this,'em_Date');"/></td>
            <th valign="top">TO :</th>
			<td><input type="text" class="inp-form" name="to" id="to" autocomplete="off" onblur="doDate(this,'em_Date');"/></td>
		</tr>
        <tr>
			<th valign="top">Recommender :</th>
			<td>	
                        <select class="styledselect_form_1" name="recommender" id="recommender">
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
            	<select class="styledselect_form_1" name="co" id="co" onkeypress="return handleEnter(this, event);">
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
		<input type="text" class="inp-form" name="cid" id="cid" autocomplete="off" onKeyPress="return handleEnter(this, event);" 
        onKeyUp="doSuggestionBox(this.value);"/>
		</td>
			<th valign="top" align="right">Branch :</th>
			<td>
            	<select class="styledselect_form_1" name="br" id="br">
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
	<!-- end id-form  -->
	</td>
	<td>
	<!--  start related-activities -->
	<?php
		include("pages/right_menu.php");
	?>
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
</div>
<!--  end content-table-inner  -->
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
<!--  end content-outer -->