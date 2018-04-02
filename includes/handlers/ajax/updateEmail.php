<?php
 include ('../../../config/config.php');
 if (!isset($_POST['username'])){
     echo "ERROR, could not set username";
     exit();
 }
 if (isset($_POST['email']) && $_POST['email'] != '' ){ // this is update email
    
    $username = $_POST['username'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ //this just checks to see if email is valid format
    // if not then
    echo ("email is invalid");
    exit();
    }
    $emailCheck = mysqli_query($con, "SELECT email FROM users WHERE email='$email' AND username!='$username'");
    $row = mysqli_num_rows($emailCheck);
  //  echo ($row); gives back 0
    if (mysqli_num_rows($emailCheck) > 0){
        echo ("email is already in use");
        exit();        
    }
    $updateQuery = mysqli_query($con, "UPDATE users SET email='$email' WHERE username='$username'");   
    echo ("Update successful");

} else{
    echo ("you must provide a username");
}
 


?>