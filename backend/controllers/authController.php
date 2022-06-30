<?php

session_start();

require 'config/db.php';
require_once 'controllers\emailController.php';
$errors = array();
$email = ""; //variables to display on an error or like 
$firstname = "";
$secondname = "";
$CIN = "";
$country = "";
$city = "";
$adresse = "";
$birthplace = "";
$phone = "";
//if user clicks on a button
//register
if (isset($_POST['register-btn'])) {

   $email = $_POST['email'];
   $firstname = $_POST['firstname'];
   $secondname = $_POST['secondname'];
   $password = $_POST['password'];
   $phone = $_POST['phone'];
   $sexe = $_POST['sexe'];
   $sexe = W_sexe($sexe);
   $birthplace = $_POST['birthplace'];
   $birthday = $_POST['birthday'];
   $country = $_POST['country'];
   $city = $_POST['city'];
   $adresse = $_POST['adresse'];
   $CIN = $_POST['CIN'];
   //validation
   //email
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Email is not a valid email address";
   }
   if (empty($email)) {
      $errors['email'] = "Email required";
   }
   //password
   if (empty($password)) {
      $errors['password'] = "Password required";
   }
   //firstname
   if (empty($firstname)) {
      $errors['firstname'] = "firstname required";
   }
   //secondname
   if (empty($secondname)) {
      $errors['secondname'] = "secondname required";
   }
   //phone////////////////////////////////////////
   if (!strlen($phone) === 10) {
      $errors['phone'] = "the phone number is incorrect";
   }
   // if (filter_var($phone, FILTER_VALIDATE_INT)) {
   //    $errors['phone'] = "The Phone is not valid";
   // }
   //birthplace
   if (empty($birthplace)) {
      $errors['birthplace'] = "birthplace required";
   }
   //birthday
   if (empty($birthday)) {
      $errors['birthday'] = "birthday required";
   }
   //country
   if (empty($country)) {
      $errors['country'] = "country required";
   }
   //city
   if (empty($city)) {
      $errors['city'] = "city required";
   }
   //adresse
   if (empty($adresse)) {
      $errors['adresse'] = "adresse required";
   }
   //CIN
   if (empty($CIN)) {
      $errors['CIN'] = "CIN required";
   }
   //check if an email is already used



   if (empty($errors)) {
      $sql = "SELECT * FROM users where email_u=? or CIN_u=? LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$email, $CIN]);
      $users_ = $stmt->fetchAll();
      //if there is already an account with the same mail or CIN or Combination (first_name,second_name)
      if (empty($users_)) {
         $password = md5($password);
         $token = bin2hex(random_bytes(50));
         $ID_U = rand(3, 100000);
         $sql = "INSERT INTO users (ID_U, token, Email_U, Password_U, CIN_u, FIRST_NAME_u, SECOND_NAME_u, SEXE_u, ADRESSE_u, city_u, COUNTRY_u, BIRTHDAY_u, BIRTH_PLACE_u, PHONE_NUMBER_u) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
         $stmt = $pdo->prepare($sql);
         $stmt->execute([$ID_U, $token, $email, $password, $CIN, $firstname, $secondname, $sexe, $adresse, $city, $country, $birthday, $birthplace, $phone]);
         $_SESSION["email"] = $email;
         $_SESSION["id"] = $user_->ID_U;
         $_SESSION["first_name"] = $user_->FIRST_NAME_u;
         $_SESSION["first_name"] = $user_->SECOND_NAME_u;
         $_SESSION["message"] = "Welcome " . $user_->FIRST_NAME_u . " " . $user_->SECOND_NAME_u . " you are finnaly registered";
         header('location:login.php');
         exit();
      } else {

         //email doesn't exist
         $errors['email_existant'] = "There is already an existing user with the same mail or CIN";
      }
   } else {
      $errors['db_error'] = "Database error";
   }
}

//login
if (isset($_POST['login-btn'])) {

   $email = $_POST['email'];
   $password = $_POST['password'];

   //validation
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Email is not a valid email address";
   }
   if (empty($email)) {
      $errors['email'] = "Email required";
   }
   if (empty($password)) {
      $errors['password'] = "Password required";
   }

   $sql = "SELECT * FROM users where email_u=? LIMIT 1";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$email]);
   $users_ = $stmt->fetchAll();

   if ($results) {

      $_SESSION["email"] = $email;

      //if there is a valide account
      if (!empty($users_)) {
         foreach ($users_ as $user_) {
            if ($password !== $user_->Password_U) {
               //check if the password is correct
               $errors['incorrect_password'] = "PASSWORD INCORRECT";
            } else {
               //password correct and conection 
               $_SESSION["id"] = $user_->ID_U;
               $_SESSION["first_name"] = $user_->FIRST_NAME_u;
               $_SESSION["first_name"] = $user_->SECOND_NAME_u;
               $_SESSION["message"] = "Welcome " . $user_->FIRST_NAME_u . " " . $user_->SECOND_NAME_u;
               header('location: index.php');
               exit();
            }
         }
      } else {
         //email doesn't exist
         $errors['email_inexistant'] = "Wrong Combination";
      }
   } else {
      $errors['db_error'] = "Database error";
   }
}
//logout
if (isset($_GET['logout'])) {
   session_destroy();
   unset($_SESSION["message"]);
   unset($_SESSION["email"]);
   header('location: login.php');
   exit();
}

//if the user clicks on the forgot password 
if (isset($_POST['forgot-password-btn'])) {
   $email = $_POST['email'];

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Email is not a valid email address";
   }
   if (empty($email)) {
      $errors['email'] = "Email required";
   }
   if (empty($errors)) {
      echo $email;
      $sql = "SELECT * FROM users WHERE email_u=? LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$email]);
      $users_ = $stmt->fetchAll();
      if (!empty($users_)) {
         foreach ($users_ as $user_) {
            $token = $user_->token;
            sendPasswordResetLink($email, $token);
            header('location: password_message.php');
         }
      }
   }
}
//if the user resets its password 
if (isset($_POST['reset-password-btn'])) { //nothing in session

   $password = $_POST['password'];
   $passwordConf = $_POST['passwordConf'];
   if (empty($password) || empty($passwordConf)) {
      $errors['password'] = "password required";
   }
   if ($password !== $passwordConf) {
      $errors['password'] = "the two password doesn'T match";
   }
   $password = md5($password); //////////////////////////////////
   $email = $_SESSION["email"];

   $sql = "SELECT * FROM users WHERE email_u=? LIMIT 1";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$email]);
   $users_ = $stmt->fetchAll();


   if (empty($errors)) {
      $sql = "UPDATE users SET Password_U=? where Email_U=?";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$password, $email]);
      if ($results) {
         header('location: login.php');
         exit(0);
      }
   } else {
      $errors['email_inex'] = "Wrong email";
   }
}


function ResetPassword($token)
{
   global $pdo;
   $sql = "SELECT * FROM users WHERE token=? LIMIT 1 ";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$token]);
   $users_ = $stmt->fetchAll();


   if ($results) {
      //if there is an account
      if (!empty($users_)) {
         foreach ($users_ as $user_) {
            $_SESSION["email"] = $user_->Email_U;
            $_SESSION["id"] = $user_->ID_U;
            $_SESSION["first_name"] = $user_->FIRST_NAME_u;
            $_SESSION["first_name"] = $user_->SECOND_NAME_u;
            $_SESSION["message"] = "Welcome " . $user_->FIRST_NAME_u . " " . $user_->SECOND_NAME_u . " The Password changed successfuly";
            header('location: reset_password.php');
            exit();
         }
      }
   } else {
      $errors['db_error'] = "Database error";
   }
}
function W_sexe(String $charac)
{
   if ($charac == 'male') {
      return '0';
   }
   return '1';
}
//ID_U Email_U, Password_U, CIN_u, FIRST_NAME_u, SECOND_NAME_u, SEXE_u, ADRESSE_u, city_u, COUNTRY_u, BIRTHDAY_u, BIRTH_PLACE_u, PHONE_NUMBER_u

   // $password=password_hash($password,PASSWORD_DEFAULT);
   // $token = bin2hex(random_bytes(50));
   // md5;
   // password_verify($password,$users_['password']);