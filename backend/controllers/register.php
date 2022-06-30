<?php

require '../config/db.php';
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
if (isset($_POST['register_form'])) {


   $form = $_POST["form"];

   parse_str($form, $form);
   echo json_encode($form);
   // {"firstname":"","secondname":"","email":"","password":"","CIN":"","adresse":"","city":"","country":"","birthday":"","birthplace":"","phone":"","type":"student","CNE":"sssssss","field":"sssssss","year":"2A"}

   $email = $form['email'];
   $firstname = $form['firstname'];
   $secondname = $form['secondname'];
   $password = $form['password'];
   $phone = $form['phone'];
   $sexe = $form['sexe'];
   $sexe = W_sexe($sexe);
   $birthplace = $form['birthplace'];
   $birthday = $form['birthday'];
   $country = $form['country'];
   $city = $form['city'];
   $adresse = $form['adresse'];
   $CIN = $form['CIN'];
   $type = $form['type'];
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
         $sql = "INSERT INTO users (ID_U, token, Email_U, Password_U, CIN_u, FIRST_NAME_u, SECOND_NAME_u, SEXE_u, ADRESSE_u, city_u, COUNTRY_u, BIRTHDAY_u, BIRTH_PLACE_u, PHONE_NUMBER_u,type_user) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
         $stmt = $pdo->prepare($sql);
         $stmt->execute([NULL, $token, $email, $password, $CIN, $firstname, $secondname, $sexe, $adresse, $city, $country, $birthday, $birthplace, $phone, $type]);
         $_SESSION["user"] = $form;

         $sql = "SELECT ID_U FROM users where email_u=? or CIN_u=? LIMIT 1";
         $stmt = $pdo->prepare($sql);
         $results = $stmt->execute([$email, $CIN]);
         $users_ = $stmt->fetchAll();

         $ID_U = $users_[0]->ID_U;


         if ($type == "T") {
            $chef = $form["cf"];

            $sql = "INSERT INTO teacher (ID_T, IS_chef_T, id_u) 
      VALUES (?, ?, ?);";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([NULL, $chef, $ID_U]);
         } elseif ($type == "S") {
            $CNE_ST = $form["CNE"];
            $years = $form["year"];
            $field = $form["field"];

            $sql = "INSERT INTO student (ID_ST, CNE_ST, Year_ST,Feild_ST,id_u) VALUES (?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([NULL, $CNE_ST, $years, $field, $ID_U]);
         } else {
            $sql = "INSERT INTO admin (ID_A, id_u) 
            VALUES (?, ?);";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([NULL, $ID_U]);
         }
         // $_SESSION["email"] = $email;
         // $_SESSION["id"] = $user_->ID_U;
         // $_SESSION["first_name"] = $user_->FIRST_NAME_u;
         // $_SESSION["first_name"] = $user_->SECOND_NAME_u;
         // $_SESSION["message"] = "Welcome " . $user_->FIRST_NAME_u . " " . $user_->SECOND_NAME_u . " you are finnaly registered";

         // header('location:login.php');
         exit();
      } else {

         //email doesn't exist
         $errors['email_existant'] = "There is already an existing user with the same mail or CIN";
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