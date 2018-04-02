<?php
include ("../../../config/config.php");
$songId;
if (isset($_POST['songId'])){
 $songId = $_POST['songId'];
}
$query = mysqli_query($con, "UPDATE songs SET plays = plays + 1 WHERE id='$songId'");
$result = mysqli_fetch_array($query);
echo json_encode($result); // to send it  back to js you have to encode it

?>