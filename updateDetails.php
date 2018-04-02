<?php
include ("includes/includedFiles.php");

?>
<div class='userDetails'>
 <div class='container borderbottom'>
   <h2>  EMAIL </h2>
   
   <input type='text' class='email' name='email' placeholder='email' value="<?php echo $userLoggedIn->getEmail(); ?>">
   <span class="message"> </span>
   <button class='button' onclick='updateEmail("email")'>  SAVE </button>

 </div>
 <div class='container'>
     <h2> PASSWORD </h2>
     <input type='password' class='oldpassword' name='password' placeholder='current password'>
     <input type='password' class='newpassword1' name='newpassword1' placeholder='new password'>
     <input type='password' class='newpassword2' name='newpassword2' placeholder='confirmed password'>
     <span class="message"> </span>
     <button class='button' onclick='updatePassword("oldpassword","newpassword1","newpassword2")'>  SAVE </button>
 </div>

</div>
