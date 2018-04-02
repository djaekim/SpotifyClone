<?php
include ("../../../config/config.php");
$albumId;
if (isset($_POST['albumId'])){
 $albumId = $_POST['albumId'];
}
$query = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");
$result = mysqli_fetch_array($query);
echo json_encode($result);
?>