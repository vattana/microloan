<option value="0">--Root--</option>
<?php
include('conn.php');
if($_POST['id'])
{
	
	$id=$_POST['id'];
	$id = substr($id,0,1);
	$str_recom="Select c_code,c_name,c_level from  chartacc_list  where c_is_header=0 and  c_enable =1 and substring(c_refer,1,1)=$id";
	$result_info=mysql_query($str_recom);
	while($row=mysql_fetch_array($result_info))
	{
		$c_name=$row['c_name'];
		$c_code=$row['c_code'];
		$c_level=$row['c_level'];
		echo '<option value="'.$c_code.'">' .$c_name. '</option>';
	}
}

?>



</option>