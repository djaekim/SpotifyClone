  
		
		<div id="navBarContainer">
               <nav class="navBar">
				   <span role="link" tabindex="0" onclick="openPage('index.php') "class="logo">
				     <img src="assets/icons/logo.png">
				   </span>
				   <div class="group"> <!-- search bar -->
				      <div class="navItem">
						  <span role="link" tabindex="0" onclick="openPage('search.php')" class="navItemLink"> Search
							   <img class="icon" src="assets/icons/search.png">
						  </span>
					  </div>
                      
				   </div>
				   <div class="group"> <!-- item --> 
				      <div class="navItem">
						  <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink"> Browse </span>
					  </div>
					  <div class="navItem">
						  <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink"> yourMusic </span>
					  </div>
					  <div class="navItem">
						  <span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"> <?php echo $userLoggedIn->getFirstAndLastName(); ?> </span>
					  </div>
				   </div>
			   </nav>
		   </div>