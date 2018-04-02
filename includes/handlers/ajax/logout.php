<?php
session_start(); // if we don't have session start that is nothing for it to destroy
session_destroy(); // session is how we keep track of if userr it logged in or not
?>