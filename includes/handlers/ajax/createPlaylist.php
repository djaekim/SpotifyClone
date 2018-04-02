<?php
 include("../../../config/config.php");
 if (isset($_POST['name']) && isset($_POST['username'])){
     $username = $_POST['username'];
     $name = $_POST['name'];
     $date = date('Y-m-d');
     $query = mysqli_query($con, "INSERT into playlists VALUES ('','$name','$username', '$date') ");
     
 } else{
     echo ("NAME or username parameter not passed into file");
 }

?>