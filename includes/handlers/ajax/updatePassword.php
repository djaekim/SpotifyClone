<?php
 include ('../../../config/config.php');
 if (!isset($_POST['username'])){
     echo "ERROR, could not set username";
     exit();
 }
 if (!isset($_POST['oldpassword']) || !isset($_POST['newpassword1']) || !isset($_POST['newpassword2'])){
     echo ("NOT all passwords have been set"); // parameter values aren't correct 
     exit();
 }
 if ($_POST['oldpassword'] == '' || $_POST['newpassword1'] == '' || $_POST['newpassword2'] == '' ){ // this is update email
     echo ("please fill in all fields");  
     exit();
 } 
 $username = $_POST['username'];
 $oldpassword  = $_POST['oldpassword'];
 $newpassword1 = $_POST['newpassword1']; 
 $newpassword2  = $_POST['newpassword2'];
 
 
 $oldpassword  = md5($oldpassword);
 $passCheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$oldpassword' ");
 if(mysqli_num_rows($passCheck) != 1){
     echo ('password is incorrect');
     exit();
 }
 if ($newpassword1 != $newpassword2){
     echo ('new password does not match');
     exit();
 }
 if (preg_match('/[^A-Za-z0-9]/', $newpassword1)){ // iff password that entered does not match this format
    echo  ('your password must only contain letters or numbers');
    exit();
 }
 if (strlen($newpassword1) > 30 || strlen($newpassword1) < 5){
     echo ('your password must be 5 and 30 characters');
     exit();
 }
 $newmd5 = md5($newpassword1);
 $query = mysqli_query($con, "UPDATE users SET password='$newmd5' WHERE username='$username'");
 echo ("update successsful");
?>
