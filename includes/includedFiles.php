<?php
use Slotify\User; 

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    require_once("includes/config.php");
    require_once("includes/classes/User.php");
       
	if(isset($_GET['userLoggedIn'])) {
		$userLoggedIn = new User($db, $_GET['userLoggedIn']);
	}
	else {

		exit();
	}
    
} else {
    include("includes/header.php");
    include("includes/footer.php");
    
    $url = $_SERVER['REQUEST_URI'];
	echo "<script>openPage('$url')</script>";
	exit();
}