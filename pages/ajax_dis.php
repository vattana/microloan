<option value="0">--ជ្រើសរើសស្រុក--</option>
<?php
include('conn.php');
if($_POST['id'])
{
$id=$_POST['id'];

$sql=mysql_query("select id,district from district where province_id='$id' order by id ASC");
while($row=mysql_fetch_array($sql))
{
$id=$row['id'];
$data=trim($row['district']);
echo '<option value="'.$id.'">'.$data.'</option>';

}
}
//echo "<script>alert ($id)
?>
</option>