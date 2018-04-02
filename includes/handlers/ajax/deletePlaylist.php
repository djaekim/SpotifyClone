<?php
 include("../../../config/config.php");
 if (isset($_POST['playlistId'])){
     $playlistId = $_POST['playlistId'];
     $playlistquery = mysqli_query($con, "DELETE FROM playlists WHERE id='$playlistId'"); 
     $songsquery = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistId='$playlistId'"); 
     
 } else{
     echo ("PlaylistId was not passed into delete playlist.php");
 }


?>