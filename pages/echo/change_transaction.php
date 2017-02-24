<?php
header('Content-Type: text/plain; charset=UTF-8');
	include("../conn.php");
	$id= $_POST['id'];
	$field= $_POST['field'];
	$data= $_POST['value'];
	echo $data;	
	if(!empty($data)&&!empty($field) &&!empty($id)){
		 $query=" UPDATE schedule Set $field ='$data' where id ='$id' "; 
				mysql_query($query) or die (mysql_error());
			
	}
?>