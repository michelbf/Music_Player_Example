<?php


    //**Functions to Sanitize the inputs**//
    function sanitizeNoSpaces($input) {
        $input = strip_tags($input);
        $input = strtolower($input);
        $input = str_replace(" ","",$input);
        return $input;
    }

    function sanitize($input) {
        $input = strip_tags($input);
        $input = ucfirst(strtolower($input));
        return $input;
    }

    function sanitizePwd($input) {
        $input = strip_tags($input);
        return $input;
    }





    if(isset($_POST['submitNewAccount'])) {
        $username = sanitizeNoSpaces($_POST['username']);
        $firstname = sanitize($_POST['firstName']);
        $lastname = sanitize($_POST['lastName']);
        $email = sanitizeNoSpaces($_POST['email']);
        $email2 = sanitizeNoSpaces($_POST['email2']);
        $password = sanitizePwd($_POST['password']);
        $password2 = sanitizePwd($_POST['password2']);

        $registerAccount = $account->register($username, $firstname, $lastname, $email, $email2, $password, $password2);
        if ($registerAccount == true) {
          $_SESSION['userLoggedIn'] = $username;
          header("Location: index.php");
        }
    }

?>
