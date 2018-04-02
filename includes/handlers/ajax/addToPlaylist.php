<?php
 include("../../../config/config.php");
 if (isset($_POST['playlistId']) && isset($_POST['songId'])){
     $playlistId = $_POST['playlistId'];
     $songId = $_POST['songId'];
     $orderIdQuery = mysqli_query($con, "SELECT MAX(playlistOrder)+1 as playlistOrder FROM playlistsongs WHERE playlistId='$playlistId'"); 
    
    // $songsquery = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistId='$playlistId'"); 
     $row = mysqli_fetch_array($orderIdQuery);
     $order = $row['playlistOrder'];
     $query = mysqli_query($con, "INSERT into playlistsongs VALUES('','$songId','$playlistId','$order')");

 } else{
     echo ("PlaylistId and songId was not passed into add to playlist.php");
 }


?>