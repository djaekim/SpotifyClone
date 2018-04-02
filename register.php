<?php
include('config/config.php');
include("includes/classes/Constants.php");

include("includes/classes/Account.php");
$account = new Account($con);

include("includes/form_handlers/register-handler.php");
include("includes/form_handlers/login-handler.php");




?>

<html>
<head>
 <link rel="stylesheet" type="text/css" href="assets/css/style.css">
 <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <link href="https://fonts.googleapis.com/css?family=Trocchi" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<style>
 *{
   font-family: 'Montserrat', sans-serif;
    letter-spacing: 2px;

 }
 .submit,
 button{
   border: none;
    /* color: azure; */
    background-color: grey;
    border-radius: 3px;
        width: 100px;
    padding: 5px 2px;
 }
 input{
       border-radius: 3px;
       color: black !important;
 }
 .heading_span{
    color: azure;
  
    font-size: 45px;
    font-family: 'Trocchi', serif;
    border-bottom: 1px solid azure;
   

 }
 .heading{
      width: 100%;
    text-align: center;
    margin-top: 20px;

    padding-bottom: 11px;
 }
</style>
</head>
<body style="background-image: url(assets/images/artwork/register.jpg);
    background-size: cover;">
    <?php 
     if (isset($_POST["registerButton"])){
         echo '
         <script> 
           $(document).ready(function(){
              $("#loginForm").hide();
              $("#registerForm").show();
              $(".login span").show();
              $(".register span").hide();

           });
         </script>
         
         ';
     }

    ?>
  <div class="heading" style=' margin-top: 20px;'>
        <span class='heading_span'> SPOTIFY CLONE
          <p style="color:#596161; font-size:14px"> Get great musics </p>
        </span>
  </div>
  <div id="inputContainer">
    <form autocomplete="new-password" id="loginForm" action="register.php" method="POST"> <!-- submit data to another page .. action = where to send it to -->
     <h2> Login to your account </h2>
     <p> 
         <?php echo $account->getError(Constants::$LoginFail) ?>
         <label for="loginUsername"> Username </label>
         <input id="loginUsername" name="loginUsername" type="text"  required>
     </p>
     <p> 
         <label for="loginPass"> Password </label> <!-- for matches 'id' -->
          <input id="loginPass" name="loginPass" type="password" autocomplete="new-password" required>
     </p>
     
    
    <button type="submit" name="loginButton"> Login </button>
    </form>
    <div class='register'>
       <span style="color:azure; cursor:pointer"> Press to register</span>
    </div>

    <!-- register -->
    <form id="registerForm" style='display:none' action="register.php" method="POST"> <!-- submit data to another page .. action = where to send it to -->
     <h2> Register account </h2>
     <p> 
         <?php echo $account->getError(Constants::$userName) ?>
         <?php echo $account->getError(Constants::$usernameTaken) ?>
         
         <label for="registerUsername"> Username </label>
         <input id="registerUsername" name="registerUsername" type="text" autocomplete="off" required>
        
     </p>
     <p> 
      <?php echo $account->getError(Constants::$FirstName) ?>
         <label for="firstName"> firstName </label> <!-- for matches 'id' -->
         <input id="firstName" name="firstName" type="text" autocomplete="off" required>
        
     </p>
      <p>  <?php echo $account->getError(Constants::$LastName) ?>
         <label for="lastName"> lastName </label> <!-- for matches 'id' -->
          <input id="lastName" name="lastName" type="text" autocomplete="off" required>
         
     </p>
     <p> 
       <?php echo $account->getError( Constants::$EmailsDoNotMatch) ?>
       <?php echo $account->getError(Constants::$EmailsInvalid) ?>
       <?php echo $account->getError(Constants::$emailTaken) ?>
         <label for="email"> email</label> <!-- for matches 'id' -->
          <input id="email" name="email" type="email"  required>
        
     </p>
     <p> 
         <label for="email2"> confirm email </label> <!-- for matches 'id' -->
          <input id="email2" name="email2" type="email"  required>
         
     </p>
     <p> 
          <?php echo $account->getError(Constants::$passwordsDoNotMatch) ?>
          <?php echo $account->getError(Constants::$passwordsDoNotAlphaNumeric) ?>
           <?php echo $account->getError(Constants::$passwordsCharacters)  ?>
         <label for="registerPass"> Password </label> <!-- for matches 'id' -->
          <input id="registerPass" name="registerPass" type="password" autocomplete="off" required>
         
     </p>
      <p> 
         <label for="registerPass2"> confirm Password </label> <!-- for matches 'id' -->
          <input id="registerPass2" name="registerPass2" type="password" autocomplete="off" required>
         
     </p>
    
    <input class='submit' type="submit" name="registerButton" value="Register"> </input>
    </form>
     <div class='login'>
       <span style="color:azure; cursor:pointer; display:none"> Press to login </span>
    </div>


  </div>
</body>
<script>
 $('.register span').click(function(){
   $('#loginForm').slideUp(1000);
   $('#registerForm').slideDown(1000);
   $('.login span').slideDown(1000);
    $('.register span').slideUp(400);
 })
 $('.login span').click(function(){
   $('#loginForm').slideDown(1000);
   $('#registerForm').slideUp(1000);
   $('.login span').slideUp(1000);
    $('.register span').slideDown(400);
 })

</script>
</html>
