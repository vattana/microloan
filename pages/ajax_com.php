<option value="0">--ជ្រើសរើសឃុំ--</option>
<?php
include('conn.php');
if($_POST['id'])
{
$id=$_POST['id'];

$sql=mysql_query("select id,commune from adr_commune where district_id='$id' order by id ASC");

while($row=mysql_fetch_array($sql))
{
$id=$row['id'];
$data=trim($row['commune']);
echo '<option value="'.$id.'">'.$data.'</option>';

}
}
//echo "<script>alert ($id)
?>
</option>