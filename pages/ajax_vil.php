<option value="0">--ជ្រើសរើសភូមិ--</option>
<?php
include('conn.php');
if($_POST['id'])
{
$id=$_POST['id'];

$sql=mysql_query("select id,village from village where commune_id='$id' order by id ASC");

while($row=mysql_fetch_array($sql))
{
$id=$row['id'];
$data=trim($row['village']);
echo '<option value="'.$id.'">'.$data.'</option>';

}
}
//echo "<script>alert ($id)
?>
</option>