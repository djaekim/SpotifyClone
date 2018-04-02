<?php 
  
  ob_start(); // turns up output buffering
              // when php loads it sends data to server in piecees 
              // but waits for all data until it sends it
  session_start();
  
  $con = mysqli_connect("shareddb1c.hosting.stackcp.net","spotify-3138b88c","uranium1","spotify-3138b88c");
  if (mysqli_connect_errno()){
      echo "Failed  to connect: ". mysqli_connect_errno();
  }
?>