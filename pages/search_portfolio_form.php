<script type="text/javascript">
	function focusit() {			
		document.getElementById("from").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<!-- start adres -->
<script type="text/javascript">
$(document).ready(function()
{
$(".province").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "pages/ajax_dis.php",
data: dataString,
cache: false,
success: function(html)
{
$(".district").html(html);
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
url: "pages/ajax_com.php",
data: dataString,
cache: false,
success: function(html)
{
$(".commune").html(html);
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
                document.getElementById("lid").value = selection;
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
	$query = "SELECT ld FROM loan_process where dis ='1' GROUP BY ld ASC";
        $result = mysql_query($query);
        $counter = 0;
        echo("<script type='text/javascript'>");
        echo("this.nameArray = new Array();");
        if($result) {
            while($row = mysql_fetch_array($result)) {
                echo("this.nameArray[" . $counter . "] = '" . trim($row['ld']) . " ';");
                $counter += 1;
            }
        }
        echo("</script>");
?>
<h3 class="tit">Search Porfolio Form :</h3>
		<!-- start id-form -->
        <form name="protfolio" method="post" enctype="multipart/form-data" action="pages/show_portfolio_list.php" target="_new">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" class="nostyle">
		<tr>
			<th valign="top">From :</th>
			<td><input type="text" class="input-text" name="from" id="from" autocomplete="off" onblur="doDate(this,'em_Date');"/></td>
            <th valign="top">TO :</th>
			<td><input type="text" class="input-text" name="to" id="to" autocomplete="off" onblur="doDate(this,'em_Date');"/></td>
		</tr>
       <tr>
			<th valign="top">អាសយដ្ឋាន :</th>
			<td colspan="3">
            	<!-- address start -->
                <table hspace="10" class="nostyle">
                	<tr>
                    	<td>
                        		
									<select name="province" class="province" id="province" onkeypress="return handleEnter(this, event);">
											<option value="0">--ជ្រើសរើសខេត្ត/ក្រុង--</option>
												<?php
												
												$sql=mysql_query("select id,province from province");
												while($row=mysql_fetch_array($sql))
												{
												$id=$row['id'];
												$data=$row['province'];
												echo '<option value="'.$id.'">'.$data.'</option>';
												}
											?>
											</select>
								
                        </td>
                        <td>	
                       			 
									<select name="district" class="district" id="district" onkeypress="return handleEnter(this, event);">
										<option value="0">--ជ្រើសរើសស្រុក--</option>
									</select>
								
                        </td>
                        <td>	
                      			 
									<select name="commune" class="commune" id="commune" onkeypress="return handleEnter(this, event);">
										<option value="0">--ជ្រើសរើសឃុំ--</option>
									</select>
								
                        </td>
                        <td>	
                       			
									<select name="village" class="village" id="village" onkeypress="return handleEnter(this, event);">
										<option value="0">--ជ្រើសរើសភូមិ--</option>
									</select>
								
                        </td>
                   	</tr>
                </table>
                <!-- end Loan Pro -->
            </td>
		</tr>
        <tr>
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
            <th valign="top">Currency</th>
            <td>	
             <select class="input-text" name="cur" id="cur" onkeypress="return handleEnter(this, event);">
                                <option value="0">--Choose Currency--</option>
                                 <?php 
                                    $str="Select * from currency_type group by types desc";
                                    $sql=mysql_query($str);
                                    while ($row=mysql_fetch_array($sql))
                                    {
                                        $types=$row['types'];
                                        $desc=$row['descript'];
                                        echo '<option value="'.$types.'">'.$types.'</option>';
                                    }
                                 ?>
                            </select>
            </td>
		</tr> 
	  	<tr>
		<th>&nbsp;</th>
		<td valign="top">
			<input type="submit" value="submit" class="input-text" name="submit"/>
			<input type="reset" value="reset" class="input-text"  />
		</td>
		<td></td>
	</tr>
	</table>
    </form>