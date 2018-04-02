<?php
include ("../../../config/config.php");
$songId;
if (isset($_POST['songId'])){
 $songId = $_POST['songId'];
}
$query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");
$result = mysqli_fetch_array($query);
echo json_encode($result);
?>