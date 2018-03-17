<?php
require_once("includes/config.php");
require_once("includes/classes/User.php");
use Slotify\User;   

if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
    echo "<script>userLoggedIn = '{$userLoggedIn}'</script>";
} else {
    header("Location: register.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Slotify</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>   
</head>

<body>
  
    <div class="main-container">  
       
       <div class="top-container">
            <?php include("includes/navBarContainer.php") ?>           
           
           <div class="mainViewContainer">
               
               <div class="mainContent">