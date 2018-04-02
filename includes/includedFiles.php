<?php
// check if request sent by ajax ..

if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])){ // if sent wth ajax this code is executed
    include ("config/config.php");
    include ("includes/classes/User.php");
    include ("includes/classes/Artist.php");
    include ("includes/classes/Album.php");
    include ("includes/classes/Song.php");
    include ("includes/classes/Playlist.php");

    if (isset($_GET['userLoggedIn'])){
        //echo ($_GET['userLoggedIn']); //gives undefined
        $userLoggedIn = new User($con, $_GET['userLoggedIn']);
    //    echo ($userLoggedIn->getUsername()); gives undefined
    } else{
        echo ('username variable was not passed into the page. Check the openPage Js function');
        exit();
    }
} else{
    include ("includes/header.php");
    include ("includes/footer.php");
    $url = $_SERVER['REQUEST_URI'];
    echo "<script> openPage('$url') </script>";
    exit();
}

?>