<?php

require_once("includes/config.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");
use Slotify\Account;
use Slotify\Constants;

$account = new Account($db);

include("includes/handlers/register-handler.php");
include("includes/handlers/login-handler.php");

function getPostValue($value) {
  if(isset($_POST[$value])) {
    echo $_POST[$value];
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Slotify!</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
</head>
<body>
    <?php echo getPostValue('loginUsername'); ?>
    <div class="background">


      <div class="container">

          <div class="login-container">

              <div class="forms">

                <div class="form-container login-form">
                    <h2>Login to your account:</h2>
                    <form action="register.php" method="post" id="loginForm">
                        <?php echo $account->getError(Constants::$loginFailure)  ?>
                        <div class="form-group">
                            <label for="loginUsername">Username: </label>
                            <input type="text" name="loginUsername" id="loginUsername" required class="form-control" value="<?php getPostValue('loginUsername') ?>">
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Password: </label>
                            <input type="password" name="loginPassword" id="loginPassword" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submitLogin" value="Log In">
                        </div>
                    </form>
                    <div class="hasAccount">
                        <a href="#" class="js--choose-form">Don't have an account yet? Register here.</a>
                    </div>
                  </div>

                  <div class="form-container register-form">
                    <h2>Create your free account:</h2>
                    <form action="register.php" method="post" id="registerForm">
                        <div class="form-group">
                            <?php echo $account->getError(Constants::$usernameLength)   ?>
                            <?php echo $account->getError(Constants::$usernameUnique)  ?>
                            <label for="username">Username: </label>
                            <input type="text" name="username" id="username" class="form-control" value="<?php getPostValue('username') ?>">
                        </div>
                        <div class="form-group">
                            <?php echo $account->getError(Constants::$firstnameLength)   ?>
                            <label for="firstName">First Name: </label>
                            <input type="text" name="firstName" id="firstName" class="form-control" value="<?php getPostValue('firstName') ?>">
                        </div>
                        <div class="form-group">
                            <?php echo $account->getError(Constants::$lastnameLength)   ?>
                            <label for="lastName">Last Name: </label>
                            <input type="text" name="lastName" id="lastName" class="form-control" value="<?php getPostValue('lastName') ?>">
                        </div>
                        <div class="form-group">
                            <?php echo $account->getError(Constants::$emailMatch)   ?>
                            <?php echo $account->getError(Constants::$emailFormat)  ?>
                            <?php echo $account->getError(Constants::$emailUnique)   ?>
                            <label for="email">Email: </label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php getPostValue('email') ?>">
                        </div>
                        <div class="form-group">
                            <label for="email2">Confirm Email: </label>
                            <input type="email" name="email2" id="email2" class="form-control" value="<?php getPostValue('email2') ?>">
                        </div>
                        <div class="form-group">
                            <?php echo $account->getError(Constants::$passwordMatch)  ?>
                            <?php echo $account->getError(Constants::$passwordLength)   ?>
                            <label for="password">Password: </label>
                            <input type="password" name="password" id="password" class="form-control" value="<?php getPostValue('password') ?>">
                        </div>
                        <div class="form-group">
                            <label for="password2">Confirm Password: </label>
                            <input type="password" name="password2" id="password2" class="form-control" value="<?php getPostValue('password2') ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submitNewAccount" value="Create Account">
                        </div>
                    </form>
                    <div class="hasAccount">
                        <a href="#" class="js--choose-form">Already have an account? Login here.</a>
                    </div>
                </div>

              </div>
          </div>

          <div class="login-text">
            <h1>Listen to Great Music, Anywhere</h1>
            <h2>Listen to thousands of songs for free</h2>
            <ul>
              <li><i class="ion-checkmark-round"></i>Discover music you'll fall in love with.</li>
              <li><i class="ion-checkmark-round"></i>Create your own playlists.</li>
              <li><i class="ion-checkmark-round"></i>Follow your favorite artists.</li>
            </ul>
          </div>

          <div class="clearfix"></div>

      </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
    <?php
      if(isset($_POST['submitNewAccount'])) {
        echo "<script>
                $('.login-form').hide();
                $('.register-form').show();
              </script>";
      } else {
        echo "<script>
                $('.login-form').show();
                $('.register-form').hide();
              </script>";
      }
    ?>
</body>
</html>
