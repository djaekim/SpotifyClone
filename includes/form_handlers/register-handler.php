<?php
  
  function sanitizeFormUsername($input){
     $input = strip_tags($input);
     $input = str_replace(" ","",$input); // 2 single quotes - replace space with 
     return $input;
  }
  function sanitizeFormString($input){
     $input = strip_tags($input);
     $input = str_replace(" ","",$input); // 2 single quotes - replace space with 
     $input = ucfirst(strtolower($input));
     return $input;
  }
  function sanitizeFormPassword($input){
     $input = strip_tags($input);
     return $input;
  }
  
  if (isset($_POST["registerButton"])){

      $username = sanitizeFormUsername($_POST['registerUsername']);
      $firstname = sanitizeFormString($_POST['firstName']);     
      $lastname = sanitizeFormString( $_POST['lastName']);
      $email =  sanitizeFormString($_POST['email']);
      $email2 =  sanitizeFormString($_POST['email2']);
      $password = sanitizeFormPassword($_POST['registerPass']);
      $password2 = sanitizeFormPassword($_POST['registerPass2']);
      $successful = $account->Register($username,$firstname, $lastname,$email,$email2, $password ,$password2);          
      if ($successful == true){
          $_SESSION['userLoggedIn'] = $username;
          header("Location:index.php");
      }
  }



?>