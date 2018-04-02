<?php
include ("../../../config/config.php");
$artistId;
if (isset($_POST['artistId'])){
 $artistId = $_POST['artistId'];
}
$query = mysqli_query($con, "SELECT * FROM artist WHERE id='$artistId'");
$result = mysqli_fetch_array($query);
echo json_encode($result);
?>