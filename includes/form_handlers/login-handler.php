 <?php
  if (isset($_POST["loginButton"])){
      $username = $_POST['loginUsername'];
      $password = $_POST['loginPass'];
      $result = $account->Login($username, $password);
      if ($result == true){
          $_SESSION['userLoggedIn'] = $username;
          header("Location: index.php");
      } 

  }  
  
     
?>