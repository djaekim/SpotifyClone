<?php
 class Constants{
     public static $passwordsDoNotMatch = "<span style='color:red'>Your passwords don't match</span> <br>"; // static means don't need to create instasnce of the class 
     public static $passwordsDoNotAlphaNumeric = "<span style='color:red'>Your passwords should only contain numbers and letters</span> <br>";
     public static $passwordsCharacters = "<span style='color:red'>Password Must be 5 - 30 characters long</span> <br>";
     public static $EmailsInvalid  = "<span style='color:red'>Email is invalid </span><br>";
     public static $EmailsDoNotMatch = "<span style='color:red'>Your emails don't match </span><br>";
     public static $LastName = "<span style='color:red'>Firstname Must be 5 - 25 characters long</span> <br>";
     public static $FirstName = "<span style='color:red'>Lastname Must be 5 - 25 characters long</span> <br>";
     public static $userName = "<span style='color:red'>Username Must be 5 - 25 characters long </span><br>";
     public static $usernameTaken = "<span style='color:red'> This username already exists </span><br> ";
     public static $emailTaken = "<span style='color:red'> This email already exists </span> <br>";
     public static $LoginFail = "<span style='color:red'> Login Failed </span> <br>";
 }
?>