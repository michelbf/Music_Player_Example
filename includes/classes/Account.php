<?php

namespace Slotify; 
    use PDO;

    class Account {

        private $errorArray;
        private $db;

        public function __construct($db) {
            $this->errorArray = array();
            $this->db = $db;
        }

        public function getError($errorMsg) {
          if(!in_array($errorMsg, $this->errorArray)) {
            return "";
          }
          return "<span class='errorMessage'>$errorMsg</span>";
        }

        public function login($username, $password) {
          $query = $this->db->prepare("SELECT * FROM users WHERE username = ?");
          $query->execute([$username]);
          $user = $query->fetch();

          if($user && password_verify($password, $user["password"])) {
            return true;
          } else {
            array_push($this->errorArray, Constants::$loginFailure);
            return false;
          }

        }

        public function register($username, $firstName, $lastName, $email, $email2, $password, $password2) {
            $this->validateUsername($username);
            $this->validateFirstname($firstName);
            $this->validateLastname($lastName);
            $this->validateEmail($email, $email2);
            $this->validatePassword($password, $password2);

            if(empty($this->errorArray)) {
                //insert values into db:
                return $this->addUserDetails($username, $firstName, $lastName, $email, $password);

            } else {
                return false;
            }

        }

        private function addUserDetails($username, $firstName, $lastName, $email, $password) {
            $password_hash = password_hash($password,PASSWORD_DEFAULT);
            $profile_pic = "assets/images/profile-pics/profile.jpg";
            $query = $this->db->prepare("INSERT INTO users(username, firstname, lastname, email, password, profilePic, signupDate)
                                         VALUES(:un, :fn, :ln, :em, :ph, :pp, now())");
            $result = $query->execute(array(':un' => $username, ':fn' => $firstName,
                                           ':ln' => $lastName, ':em' => $email,
                                           ':ph' => $password_hash, ':pp' => $profile_pic));
            return $result;
        }



        //**Functions to Validate the inputs**//
        private function validateUsername($input_text) {

            if(strlen($input_text) < 5 || strlen($input_text) > 25) {
                array_push($this->errorArray, Constants::$usernameLength);
                return;
            }

            $checkUsernameQuery = $this->db->prepare("SELECT * FROM users WHERE username = ?");
            $checkUsernameQuery->execute(array($input_text));
            $rowcount =  $checkUsernameQuery->rowCount();
            if($rowcount <> 0) {
                array_push($this->errorArray, Constants::$usernameUnique);
                return;
            }

        }

        private function validateFirstname($input_text) {

            if(strlen($input_text) < 2   || strlen($input_text) > 25) {
                array_push($this->errorArray, Constants::$firstnameLength);
                return;
            }

        }

        private function validateLastname($input_text) {

            if(strlen($input_text) < 2 || strlen($input_text) > 25) {
                array_push($this->errorArray, Constants::$lastnameLength);
                return;
            }

        }

        private function validateEmail($input1, $input2) {

            if($input1 != $input2) {
                array_push($this->errorArray, Constants::$emailMatch);
                return;
            }

            if(!filter_var($input1,FILTER_VALIDATE_EMAIL)) {
                array_push($this->errorArray, Constants::$emailFormat);
                return;
            }


            $checkEmailQuery = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $checkEmailQuery->execute(array($input1));
            $rowcount =  $checkEmailQuery->rowCount();
            if($rowcount <> 0) {
                array_push($this->errorArray, Constants::$emailUnique);
                return;
            }

        }

        private function validatePassword($input1, $input2) {

            if($input1 != $input2) {
                array_push($this->errorArray, Constants::$passwordMatch);
                return;
            }

            if(strlen($input1) < 3 || strlen($input1) > 200) {
                array_push($this->errorArray, Constants::$passwordLength);
                return;
            }



        }

    }
