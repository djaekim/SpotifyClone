<?php
 class Account{
      private $errorArray;
      private $con;
      public function __construct($con){
          $this->errorArray = array();
          $this->con = $con;

      }
     
      public function Register($username,$firstname,$lastname,$email ,$email2,$password1, $password2){ // this registers account..
          $this->usernameValidate($username); // this instances of class has this function
          $this->passwordsValidate($password1, $password2);
          $this->firstnameValidate($firstname);
          $this->lastnameValidate($lastname);
          $this->emailsValidate($email , $email2);
          if (empty($this->errorArray) == true){
             return $this->insertUserDetails($username,$firstname,$lastname,$email, $password1);
          } 
          else {
             return false;
          }
        
      } 
      public function Login($username, $pass){
         $pass = md5($pass);
         $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username' AND password='$pass'");
         if (mysqli_num_rows($query) == 1){
             
             return true;
         } else{
             array_push($this->errorArray, Constants::$LoginFail);
             return false;
         }
        
      }
      private function insertUserDetails($un, $fn, $ln, $em, $pass){
          $encrypted = md5($pass);
          $profile = "assets/images/profile-pics/head_alizarin.png";
          $date = date("Y-m-d");
          $result = mysqli_query($this->con, "INSERT INTO users VALUES ('','$un','$fn','$ln','$em','$encrypted','$date','$profile')");
          return $result; 

    
      }
      //public if call outside of current class
      public function getError($error){
          if(!in_array($error, $this->errorArray)){ // can't find error
              $error = "";
          } 
          return "<span class='errorMessage'>$error</span>";
      }

      private function usernameValidate($user){
          if (strlen($user) > 25 || strlen($user) < 5 ){
             array_push($this->errorArray, Constants::$userName);
             return;
          }
          $checkUserNameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$user'");
          if(mysqli_num_rows($checkUserNameQuery) != 0){
             array_push($this->errorArray, Constants::$usernameTaken);
             return;
          }

      }
      private function passwordsValidate($pass1, $pass2){
          if ($pass1 != $pass2){
             array_push($this->errorArray, Constants::$passwordsDoNotMatch); //why use :: ??
             return;
          }
          if (preg_match('/[^A-Za-z0-9]/',$pass1)){ // ^ = not ,  / / = 
             array_push($this->errorArray, Constants::$passwordsDoNotAlphaNumeric);
             return;
          }
           if (strlen($pass1) > 30 || strlen($pass1) < 5 ){
             array_push($this->errorArray, Constants::$passwordsCharacters);
             return;
          }
          
          
        
      }
      private function firstnameValidate($first){
          if (strlen($first) > 25 || strlen($first) < 2 ){
             array_push($this->errorArray, Constants::$FirstName);
             return;
          }
          
      }
      private  function lastnameValidate($last){
          if (strlen($last) > 25 || strlen($last) < 2 ){
             array_push($this->errorArray, Constants::$LastName);
             return;
          }
      }
      private function emailsValidate($em1, $em2){ 
         if ($em1 != $em2){
             array_push($this->errorArray, Constants::$EmailsDoNotMatch);
             return;
          }
         if(!filter_var($em1, FILTER_VALIDATE_EMAIL)){
             array_push($this->errorArray,Constants::$EmailsInvalid);
             return;
         }
          $checkEmailQuery = mysqli_query($this->con,"SELECT email FROM users WHERE email='$em1'");
          if(mysqli_num_rows($checkEmailQuery) != 0){
             array_push($this->errorArray, Constants::$emailTaken);
             return;
          }
         
      }
 }

?>