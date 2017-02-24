<script type="text/javascript">
	function focusit() {			
		document.getElementById("desc").focus();
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

<?php
	$user = $_SESSION['usr'];
	//check max id
	if(isset($_POST['save'])){	
		$pro=$_POST['province'];
		$dist=$_POST['district'];
		$com=$_POST['commune'];
		$display=$_POST['desc'];
		//
		if(($pro=='0') && ($dist=='0') && ($com=='0') && (!empty($display))){
			$insertPro=mysql_query("INSERT INTO `province` (
											`id` ,
											`province` ,
											`en_province`
											)
											VALUES (
											NULL , '$display', '-'
											);
											");
					echo"<script>alert('You have added a Province!');</script>";
					echo"<script>window.location.href='index.php?pages=addressList&session=restore';</script>";
			}
			//
		//
		if(($pro!='0') && ($dist=='0') && ($com=='0') && (!empty($display))){
			$insertPro=mysql_query("INSERT INTO `district` (
													`id` ,
													`district` ,
													`province_id` ,
													`en_district`
													)
													VALUES (
													NULL , '$display', '$pro', '-'
													);
											");
					echo"<script>alert('You have added a District!');</script>";
					echo"<script>window.location.href='index.php?pages=addressList&session=restore';</script>";
			}
			//
			//
		if(($pro!='0') && ($dist!='0') && ($com=='0') && (!empty($display))){
			$insertPro=mysql_query("INSERT INTO `adr_commune` (
														`id` ,
														`commune` ,
														`district_id` ,
														`en_commune`
														)
														VALUES (
														NULL , '$display', '$dist', '-'
														);
											");
					echo"<script>alert('You have added a Commune!');</script>";
					echo"<script>window.location.href='index.php?pages=addressList&session=restore';</script>";
			}
			//
				//
		if(($pro!='0') && ($dist!='0') && ($com!='0') && (!empty($display))){
			$insertPro=mysql_query("INSERT INTO `village` (
														`id` ,
														`commune_id` ,
														`village` ,
														`en_village`
														)
														VALUES (
														NULL , '$com', '$display', '-'
														);
											");
					echo"<script>alert('You have added a Village!');</script>";
					echo"<script>window.location.href='index.php?pages=addressList&session=restore';</script>";
			}
			//
		echo"<script>alert('Please Check then try again!');</script>";	
		echo"<script>window.location.href='index.php?pages=addressList&session=restore';</script>";
	}//end isset
?>

<h3 class="tit">Address Management Form :</h3>

		<!-- start id-form -->
        <form name="adr" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0" width="700" class="nostyle">
		
            	<!-- address start -->
       
                	<tr>
                    	<td>      ខេត្ត/ក្រុង :	
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
                       			 ស្រុក/ខ័ណ្ឌ :
									<select name="district" class="district" id="district" onkeypress="return handleEnter(this, event);">
										<option value="0">--ជ្រើសរើសស្រុក--</option>
									</select>
								
                        </td>
                        <td>	
                      			 ឃុំ/សង្កាត់ :
									<select name="commune" class="commune" id="commune" onkeypress="return handleEnter(this, event);">
										<option value="0">--ជ្រើសរើសឃុំ--</option>
									</select>
								
                        </td>
                       
                   	</tr>
                   
                    <tr>
                    
                    	<td colspan="4">
                        	ឈ្មោះទីកន្លែង :
                        	<input type="text" name="desc" id="desc" size="50" class="input-text" style="font-family:khmer OS; size:10pt" 
                            size="16" autocomplete="off"/>
                        </td>
                    </tr>
                    <tr>
                    
                    	<td colspan="4">
                        	 <input type="submit" value="Add" class="input-text" name="save"
                              onclick="return confirm('Are you sure wanna save?');"/>
							<input type="reset" value="Reset" class="input-text"  />
                        </td>
                    </tr>
                </table>
    </form>