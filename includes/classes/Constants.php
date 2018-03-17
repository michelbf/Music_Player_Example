<?php
namespace Slotify; 

  class Constants {

    //**ERROR MESSAGES**//
    public static $usernameLength = "The username must be between 5 and 25 characters long.";
    public static $usernameUnique = "This username already exists on the database.";
    public static $lastnameLength = "Your last name must be between 2 and 25 characters long.";
    public static $firstnameLength = "Your first name must be between 2 and 25 characters long.";
    public static $emailMatch = "The emails do not match.";
    public static $emailFormat = "Incorrect format for email.";
    public static $emailUnique = "This email already exists on the database.";
    public static $passwordMatch = "The passwords do not match.";
    public static $passwordLength = "Your password must be between 3 and 200 characters long.";
    public static $loginFailure = "Incorrect username/password.";


  }

