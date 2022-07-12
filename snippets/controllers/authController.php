<?php

require '../config/db.php' ;
require_once 'emailController.php';
 //variables to display on an error or like 
//if user clicks on a button
   $errors = array();
   $type = $_POST['type'];
   /*login*/
if($type == "login"){
   $email = $_POST['email'];
   $password = md5($_POST['password']);
   //validation
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Email non valide";
   }
   if (empty($email)) {
      $errors['email'] = "Email necessaire";
   }
   if (empty($password)) {
      $errors['password'] = "Mot de passe necessaire";
   }

   $sql = "SELECT * FROM users where email_u=? LIMIT 1";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$email]);
   $users_ = $stmt->fetchAll();

   if ($results) {

      $_SESSION["email"] = $email;

      $_SESSION["alert-class"] = "alert-success";

      //if there is an account
      if (!empty($users_)) {
         foreach ($users_ as $user_) {
            if ($password !== $user_->Password_U) {
               //check if the password is correct
               $errors['incorrect_password'] = "Mot de passe incorrect";
            } else {
               //password correct and conection successuful
               $_SESSION["user"] = $user_;
               $_SESSION["message"] = "Welcome " . $user_->FIRST_NAME_u . " " . $user_->SECOND_NAME_u;
               echo'connected.php';
            }
         }
      } else {
         //email doesn't exist
         $errors['email_inexistant'] = "Fausse combination";
      }
   } else {
      $errors['db_error'] = "Error dans la base de données";
   }
/*generate div errors login*/
   if(count($errors)>0){
      echo "<div class=\"alert alert-danger\">";
   foreach($errors as $error){
      echo"<li>$error</li>";
   }
   echo"</div>";
   }
 }

/*forgot password*/
if ($type == "forgot-password") {
   $email = $_POST['email'];
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Invalide adresse email";
   }
   if (empty($email)) {
      $errors['email'] = "Email necessaire";
   }
   if (empty($errors)) {
      $sql = "SELECT * FROM users WHERE email_u=? LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$email]);
      $users_ = $stmt->fetchAll();
      if (!empty($users_)) {
         foreach ($users_ as $user_) {
            $token = $user_->token;
            sendPasswordResetLink($email, $token);
            echo 'password_message.html';
         }
      }
      else{
         $errors['email_inex']= "Email doesn't exist";
      }
   }

   if(count($errors)>0){
      echo"<div style=\"padding : 6px;\" class=\"alert alert-danger\">";
      foreach($errors as $error){
         echo"<li>$error</li>";
      }
      echo"</div>";
   }
}

/*show name in connected.php */
if($type == "name"){
   $sql = "SELECT * FROM users WHERE email_u=? LIMIT 1";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$_SESSION["email"]]);
   $users_ = $stmt->fetchAll();
   echo("<span>".strtoupper($_SESSION["user"]->SECOND_NAME_u)."</span>
      <br/><span>".$_SESSION["user"]->FIRST_NAME_u."</span>");
}

/*reset-password-btn*/
if ($type == "reset-password") {
   session_destroy();
   $passworTtoken = $_POST['password_token'];
   
   ResetPassword($passworTtoken);
   $password = $_POST['password'];
   $passwordConf = $_POST['passwordConf'];
   if (empty($password) || empty($passwordConf)) {
      $errors['password'] = "Mot de passe necessaire";
   }
   if ($password !== $passwordConf) {
      $errors['password'] = "Les deux champs ne sont pas identiques";
   }
   $password = md5($password); //////////////////////////////////
   if(isset($_SESSION["email"])){
   $email = $_SESSION["email"];
   
   $sql = "SELECT * FROM users WHERE email_u=? LIMIT 1";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$email]);
   $users_ = $stmt->fetchAll();
   }

   if (empty($errors)) {
      $sql = "UPDATE users SET Password_U=? where Email_U=?";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$password, $email]);
      if ($results) {
         echo'connected.php';
      }
   }

   if(count($errors)>0){
      echo"<div class=\"alert alert-danger\">";
      foreach($errors as $error){
         echo "<li>$error</li>";
      }
      echo '</div>';
   }
}


function ResetPassword($token)
{  session_start();
   global $pdo;
   global $errors;
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

         }
      }
      else {
         $errors['link_error'] = "The link is not real";
      }
   } else {
      $errors['db_error'] = "Database error";
   }
}

/*logout*/
if ($type=="logout") {
   session_destroy();
   unset($_SESSION["message"]);
   unset($_SESSION["email"]);
   echo('index.php');
}

/*profile*/
if ($type == "profile") {

   foreach ($_SESSION["user"] as $value) {
      if ($value == 0) {
         $value = "Masculin";
      }
      if ($value == 1) {
         $value = "Feminin";
      }
      if ($value == "A") {
         $value = "Admin";
      }
      if ($value == "T") {
         $value = "Professeur";
         $sql = "SELECT * FROM teacher WHERE id_u=? LIMIT 1";
         $stmt = $pdo->prepare($sql);
         $results = $stmt->execute([$_SESSION["user"]->ID_U]);
         $profs = $stmt->fetchAll();
      }
      if ($value == "S") {
         $value = "Etudiant";
         $sql = "SELECT * FROM student WHERE id_u=? LIMIT 1";
         $stmt = $pdo->prepare($sql);
         $results = $stmt->execute([$_SESSION["user"]->ID_U]);
         $users_ = $stmt->fetchAll();
      }
      echo ("<span>" . $value . "</span>" . "\n");
   }
   if (!empty($users_)) {
      foreach ($users_ as $user_) {
         echo ("<span>" . $user_->Year_ST . "</span>" . "\n");
         echo ("<span>" . $user_->Feild_ST . "</span>" . "\n");
         $_SESSION["year"] = $user_->Year_ST ;
         $_SESSION["field"] = $user_->Feild_ST;
      }
   }
   else{
      echo ("<span></span>" . "\n");
      echo ("<span></span>" . "\n");
   }
   if (!empty($profs)) {
      foreach ($profs as $prof) {
         if($prof->IS_chef_T == "0"){
            $bool = "Non" ;
            echo ("<span>" . $bool . "</span>" . "\n");
         }
         else{
            $_SESSION["field"] = $prof->FIELD_T;
            echo ("<span>" . $_SESSION["field"] . "</span>" . "\n");
         }
         
      }
   }
   else{
      echo ("<span></span>" . "\n");
   }
}

if ($type == "bib-profile") {
   $sql = "SELECT Bibliographie_T from teacher  where id_u=? ";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$_SESSION["user"]->ID_U]);
   $infos = $stmt->fetchAll();

   foreach($infos as $info){
      foreach($info as $value){
         if(empty($value)){
            echo "<p>Pas d'informations</p>";
         }
         else{
            echo $value."\n" ;
         }
      }
   }
}

if ($type == "edit-bib") {
   $text = $_POST["text"];
   $id_u = $_SESSION["user"]->ID_U; ////////////to be modified
   $sql = "UPDATE teacher set Bibliographie_T=? where id_u=?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$text, $id_u]);
}

/*show chrono*/
if ($type=="chrono") {
   $time=["09:00<br><br>10:40","10:50<br><br>12:30","14:00<br><br>15:40","16:10<br><br>17:50"];
   $colors = ["bg-coral","bg-yellow","bg-green", "bg-orange", "bg-sky", "bg-purple", "bg-pink", "bg-lightred",
    "bg-greenyellow"];
   $form = $_POST["form"]; 
   if($_SESSION["user"]->type_user == "S"){
      if(strlen($form) == 29){
         $field = $_SESSION["field"] ;
         $year = $_SESSION["year"];
         parse_str($form, $form);
         //boucler sur les ligne cad les seance
         for ($seance_n = 1; $seance_n <= 4; $seance_n++) {
            $SQL = "SELECT * from seance s join teacher t on s.id_prof=t.ID_T join users u on t.id_u=u.ID_u join class c on s.CLASS_S=c.ID_class
            where s.name_field=? and s.week=? and  s.year_s=? and s.semestre=? and s.periode=? and s.seance_n=? order by day_ ASC";
            $stmt = $pdo->prepare($SQL);
         //    var_dump($field,
         // $form['week'],
         // $year,
         // $form["semester"],
         // $form["periode"],
         // $seance_n);
            $stmt->execute([
               $field,
               $form['week'],
               $year,
               $form["semester"],
               $form["periode"],
               $seance_n
            ]);
            $result = $stmt->fetchAll();
            // var_dump($result);
            echo "<tr> <td class=\"align-middle\">".$time[$seance_n-1]."</td>";
            if (!empty($result)) {
               $length = count($result);
               for($c=0 ; $c<$length; $c++){
                  $result[$c]=(array)$result[$c];
               }
               $j = 1;    
               $i = 0;
               // var_dump($result[0]["id_matiere"]);
               while ($i<$length) { 
                  while($j<=6){
                  if($result[$i]["day_"] != $j){
                     echo "<td>
                     <span class=\" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white
                     font-size16 xs-font-size13\"></span>
                     <div class=\"margin-10px-top font-size14\"></div>
                     <div class=\"font-size13 text-light-gray\"></div>
                  </td>";
                     $j++;
                  }
                  else{ $name = str_replace(" ","",$result[$i]["NAME_S"]);
                     echo "<td>
                     <span class=\"".$colors[($result[$i]["id_matiere"])%10]." padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white
                     font-size16 xs-font-size13\">".$name."</span>
                     <div class=\"margin-10px-top font-size14\">".$result[$i]["Type_class"]."</div>
                     <div class=\"font-size13 text-light-gray\">".$result[$i]["SECOND_NAME_u"]." ".$result[$i]["FIRST_NAME_u"].
                     "</div></td>";
                     $j++;
                     $i++;
                  }
               } 
            }
         }
            else {
               for ($j = 1; $j <= 6; $j++) {
                  echo "<td>
                  <span class=\" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white
                  font-size16 xs-font-size13\"></span>
                  <div class=\"margin-10px-top font-size14\"></div>
                  <div class=\"font-size13 text-light-gray\"></div>
            </td>";
               }
            }
            echo "</tr>";
         }
      }
      else{
         echo "ntg";
      }
   }
   if($_SESSION["user"]->type_user == "T"){
      // var_dump($_SESSION["user"]->ID_U);
      if(strlen($form) == 29){
         parse_str($form, $form);
         //boucler sur les ligne cad les seance
         for ($seance_n = 1; $seance_n <= 4; $seance_n++) {
            $SQL = "SELECT * from seance s join teacher t on s.id_prof=t.ID_T join users u on t.id_u=u.ID_u join class c on s.CLASS_S=c.ID_class
            where  s.week=? and s.semestre=? and s.periode=? and s.seance_n=? and u.ID_u = ?  order by day_ ASC";
            $stmt = $pdo->prepare($SQL);
            var_dump(
         $form['week'],
         $form["semester"],
         $form["periode"],
         $seance_n,
         $_SESSION["user"]->ID_U);
            $stmt->execute([
               $form['week'],
               $form["semester"],
               $form["periode"],
               $seance_n,
               $_SESSION["user"]->ID_U
            ]);
            $result = $stmt->fetchAll();
            // var_dump($result);
            echo "<tr> <td class=\"align-middle\">".$time[$seance_n-1]."</td>";
            if (!empty($result)) {
               $length = count($result);
               for($c=0 ; $c<$length; $c++){
                  $result[$c]=(array)$result[$c];
               }
               $j = 1;    
               $i = 0;
               // var_dump($result[0]["id_matiere"]);
               while ($i<$length) { 
                  while($j<=6){
                  if($result[$i]["day_"] != $j){
                     echo "<td>
                     <span class=\" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white
                     font-size16 xs-font-size13\"></span>
                     <div class=\"margin-10px-top font-size14\"></div>
                     <div class=\"font-size13 text-light-gray\"></div>
                  </td>";
                     $j++;
                  }
                  else{$name = str_replace(" ","",$result[$i]["NAME_S"]);
                     echo "<td>
                     <span class=\"".$colors[($result[$i]["id_matiere"])%10]." padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white
                     font-size16 xs-font-size13 hoverme\" onclick='\$dc.loadSeance({$result[$i]["ID_S"]});'>".$name."</span>
                     <div class=\"margin-10px-top font-size14\">".$result[$i]["Type_class"]."</div>
                     <div class=\"font-size13 text-light-gray\">".$result[$i]["year_s"]." ".$result[$i]["name_field"].
                     "</div></td>";
                     $j++;
                     $i++;
                  }
               } 
            }
         }
            else {
               for ($j = 1; $j <= 6; $j++) {
                  echo "<td>
                  <span class=\" padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white
                  font-size16 xs-font-size13\"></span>
                  <div class=\"margin-10px-top font-size14\"></div>
                  <div class=\"font-size13 text-light-gray\"></div>
            </td>";
               }
            }
            echo "</tr>";
         }
      }
      else{
         echo "ntg";
      }
   }
}
/*show fields news*/
if ($type=="news") {
   $sql = "SELECT NAME_F from field";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $fields = $stmt->fetchAll();
   echo "<div id=\"home-tiles\" class=\"row\">";
   foreach($fields as $field){
     echo"
     <div class=\"col-md-6 col-sm-6 col-xs-12\">
        <a href=\"#".$field->NAME_F."\" onclick=\"\$dc.loadNewsF(".$field->NAME_F.");\">
            <div id=\"menu-tile\">
               <div id=\"".$field->NAME_F."\"></div>
               <span>".$field->NAME_F."</span>
            </div>
        </a>
      </div>";
   }
   echo"</div><div id=\"container\" style=\"margin-top: 50px;\" >
   <div id=\"retour\" style=\"margin-top: -30px;\">
       <a href=\"#\" onclick=\"\$dc.loadInfos();\" >
       <button type=\"button\" class=\"btn btn-danger\">RETOUR</button>
        </a>
   </div>
 </div>";
}

/*show news in a specific field*/
if ($type=="newsF") {
   $id = $_POST["id"];
   $sql = "SELECT * from news where name_field = ?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id]);
   $news = $stmt->fetchAll();
   echo "<div id=\"home-tiles\" class=\"row\">";
   foreach($news as $new){
      $argument = str_replace(' ', '_', $new->id_n);
     echo"
     <div class=\"col-md-6 col-sm-6 col-xs-12\">
        <a href=\"#".$new->id_n."\" onclick=\"\$dc.loadNewsE(".$argument.");\">
            <div id=\"news-title\" onclick=\"\$dc.removeNewsE(".$argument.");\">
               <span id=\"".$argument."\" class=\"center-vertical\">".$new->id_n."</span>
            </div>
        </a>
      </div>";
   }
   if( isset($_SESSION["user"]) && $_SESSION["user"]->type_user == "T" && isset($_SESSION["field"]) && $_SESSION["field"] == $id){
      echo"</div><div id=\"container\" style=\"margin-top: 50px;\" >
      <div id=\"retour\" style=\"margin-top: -30px;left : 25%\">
          <a href=\"#\" onclick=\"\$dc.loadNews();\" >
          <button type=\"button\" class=\"btn btn-danger\">RETOUR</button>
           </a>
      </div><div id=\"ajouter\" style=\"margin-top: -30px;\">
       <button type=\"button\" onclick=\"\$dc.addNews();\" class=\"btn btn-danger\">AJOUTER</button>
   </div>";
   }
   else{
      echo"</div><div id=\"container\" style=\"margin-top: 50px;\" >
   <div id=\"retour\" style=\"margin-top: -30px;\">
       <a href=\"#\" onclick=\"\$dc.loadNews();\" >
       <button type=\"button\" class=\"btn btn-danger\">RETOUR</button>
        </a>
   </div> ";
   }
   echo "</div>";
}

/*show the new element*/
if ($type=="newsE") {
   $field = $_POST["field"];
   $id = $_POST["id"];
   $sql = "SELECT content from news where name_field = ? and id_n = ?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$field,$id]);
   $texts = $stmt->fetchAll();
   if(isset($_SESSION["user"]) &&  $_SESSION["user"]->type_user == "T" && isset($_SESSION["field"]) && $_SESSION["field"] == $field){
      echo"<p id='iscf'>iscf<p>"."\n";
   }
   foreach($texts as $text){
      echo "<h3 id='title' class='text-center'>$id</h3><br>";
      echo "<div id='text' contentEditable='false'>$text->content</div>" ;
   }

}
/* remove a new element */
if ($type=="removeNews") {
   $id = $_POST["id"];
   $sql = "DELETE from news where id_n = ?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id]);

   echo $_SESSION["field"];
}
/*change a new element */
if ($type=="changeNews") {
   $id = $_POST["id"];
   $text = $_POST["text"];
   $sql = "UPDATE  news  set content = ? where id_n = ?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$text,$id]);
}
/* confirm the addition of a new */
if($type=="confirmAdd"){
   $editor_data = $_POST['content'];
   $editor_data = "<p>".$editor_data."</p>";
   parse_str($_POST['title'], $form);
   $title = $form['title'];
   $field = $_SESSION["field"];
   $sql = "INSERT INTO news(id_n,content,name_field)VALUES(?,?,?)";
   $stmt = $pdo->prepare($sql);
   $stmt->execute( [$title, $editor_data, $field]);
   echo $field ;
}

/* load prof */
if ($type=="prof") {
   $sql = "SELECT * from users where type_user = 'T' ";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $profs = $stmt->fetchAll();
   echo"<div class='main-body'>
   <div class='row gutters-sm'>";
   foreach($profs as $prof){
      echo"<div class='col-md-4 mb-3' style='height:220px;'>
        <div class='card' id='prof-title' onclick='\$dc.loadBib(".(string)$prof->ID_U.");'>
          <div class='card-body'>
              <img src='https://bootdey.com/img/Content/avatar/avatar7.png' alt='Admin' class='rounded-circle' 
              width='150'>        
          </div>
          <span value='$prof->ID_U'>$prof->FIRST_NAME_u &nbsp; $prof->SECOND_NAME_u</span>
        </div>
      </div>";
   }
   echo"</div>
   </div>";
}

if ($type=="bib") {
   $id = $_POST["id"];
   $sql = "SELECT FIRST_NAME_u ,SECOND_NAME_u  from users  where ID_U=? ";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id]);
   $infos = $stmt->fetchAll();

   foreach($infos as $info){
      foreach($info as $value){
         echo $value."\n" ;
      }
   }

   $sql = "SELECT Bibliographie_T from teacher  where id_u=? ";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id]);
   $infos = $stmt->fetchAll();

   foreach($infos as $info){
      foreach($info as $value){
         if(empty($value)){
            echo "<p>Pas d'informations</p>";
         }
         else{
            echo $value."\n" ;
         }
      }
   }
}


if ($type=="nav") {
   if($_SESSION["user"]->type_user == "S"){
      echo "student";
   }
   elseif($_SESSION["user"]->type_user == "A"){
      echo "admin" ;
   }
   elseif($_SESSION["user"]->type_user == "T"){
      $sql = "SELECT IS_chef_T from teacher  where id_u=? ";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$_SESSION["user"]->ID_U]);
      $cfs = $stmt->fetchAll();
      foreach($cfs as $cf){
         if($cf->IS_chef_T == "0"){
            echo "no";
         }
         else{
            echo "yes";
         }
      }
   }
}

if ($type == "createCompte") {
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
   $type_u = $_POST['type_u'];

    //validation
   //email
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Adresse email non valide";
   }
   if (empty($email)) {
      $errors['email'] = "Email necessaire";
   }
   //password
   if (empty($password)) {
      $errors['password'] = "Mot de passe necessaire";
   }
   //firstname
   if (empty($firstname)) {
      $errors['firstname'] = "Prenom necessaire";
   }
   //secondname
   if (empty($secondname)) {
      $errors['secondname'] = "Nom necessaire";
   }
   //phone////////////////////////////////////////
   if (!strlen($phone) === 10) {
      $errors['phone'] = "Le numero de telephone est incorrect";
   }
   // if (filter_var($phone, FILTER_VALIDATE_INT)) {
   //    $errors['phone'] = "The Phone is not valid";
   // }
   //birthplace
   if (empty($birthplace)) {
      $errors['birthplace'] = "Lieu de naissance necessaire";
   }
   //birthday
   if (empty($birthday)) {
      $errors['birthday'] = "Jour de naissance necessaire";
   }
   //country
   if (empty($country)) {
      $errors['country'] = "Pays necessaire";
   }
   //city
   if (empty($city)) {
      $errors['city'] = "Ville necessaire";
   }
   //adresse
   if (empty($adresse)) {
      $errors['adresse'] = "Adresse necessaire";
   }
   //CIN
   if (empty($CIN)) {
      $errors['CIN'] = "CIN necessaire";
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
         $stmt->execute([NULL, $token, $email, $password, $CIN, $firstname, $secondname, $sexe, $adresse, $city, $country, $birthday, $birthplace, $phone, $type_u]);
         // $_SESSION["user"] = $form;

         $sql = "SELECT ID_U FROM users where email_u=? or CIN_u=? LIMIT 1";
         $stmt = $pdo->prepare($sql);
         $results = $stmt->execute([$email, $CIN]);
         $users_ = $stmt->fetchAll();

         $ID_U = $users_[0]->ID_U;


      if ($type_u == "T") {
            // $chef = $_POST["cf"];
            // $chef = W_chef($chef);
            $sql = "INSERT INTO teacher (ID_T, id_u) VALUES (?, ?);";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([NULL, $ID_U]);
         } elseif ($type_u == "S") {
            $CNE_ST = $_POST["CNE"];
            $years = $_POST["year"];
            $field = $_POST["field"];

            $sql = "INSERT INTO student (ID_ST, CNE_ST, Year_ST,Feild_ST,id_u) VALUES (?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([NULL, $CNE_ST, $years, $field, $ID_U]);
         } else {
            $sql = "INSERT INTO admin (id_u) 
            VALUES (?);";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$ID_U]);
         }
         echo "createCompte";
      } else {
         //email doesn't exist
         $errors['email_existant'] = "L'adresse email / CIN existe deja";
      }
   } else {
      $errors['db_error'] = "Erreur dans la base de donnees";
   }
   if (count($errors) > 0){
      echo" <div class='alert alert-danger'>";
       foreach ($errors as $error){
         echo"<li>$error</li>";
        }
     echo" </div>" ;
   }
}
if($type=="chooseTeacher"){
   $sql = 'SELECT ID_T, CONCAT(FIRST_NAME_u , " ",SECOND_NAME_u) AS name from teacher as t inner join users as u on t.id_u=u.id_u WHERE FIELD_T is NULL';
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $profs = $stmt->fetchAll();
   $profs = json_encode($profs);
   echo $profs;
}
if($type=="chooseModule"){
   $sql = 'SELECT NAME_M from module';
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $modules = $stmt->fetchAll();
   $modules = json_encode($modules);
   echo $modules;
}

if($type=="chooseField"){
   $sql = "SELECT NAME_F FROM field ";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $fields = $stmt->fetchAll();
   foreach($fields as $field){
      echo "$field->NAME_F\n";
   }     
}
if($type=="chooseField2"){
   $sql = "SELECT * FROM field ";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $fields = $stmt->fetchAll();
   $fields = json_encode($fields);
   echo $fields;  
}

if ($type == "createF") {
   parse_str($_POST['form'], $form);

   if ($form["field_name"] == "") {
      $errors['field_name_empty'] = "Le nom de la filiere est necessaire";
   }
   if (!isset($form["prof"])) {
      $errors['field_prof_empty'] = "Un chef de filiere est necessaire";
   }
   $sql = "SELECT * from field where name_f=? LIMIT 1";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$form["field_name"]]);
   $results = $stmt->fetchAll();
   if (!empty($results)) {
      $errors['field_name_exist'] = "Cette filiere existe deja";
   }
   if (empty($errors)) {
      $sql = 'UPDATE teacher set IS_chef_T=1,FIELD_T=? where id_T=?';
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$form["field_name"],$form["prof"]]);

      $sql = "INSERT into field(NAME_F,CHEF_F) values(?,?)";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$form["field_name"], $form["prof"]]);
   } 
      if(count($errors)>0){
         echo "<div class=\"alert alert-danger\">";
      foreach($errors as $error){
         echo"<li>$error</li>";
      }
      echo"</div>";
      }
}
/* modify a field */
if ($type == "modifyF") {
   parse_str($_POST['form'], $form);

   if (!isset($form["field"])) {
      $errors['field_name_empty'] = "Choisissez une filiere";
   }
   if (!isset($form["prof2"])) {
      $errors['field_prof_empty'] = "Choisissez un chef de filiere";
   }
   if (empty($errors)) {
      $sql = 'UPDATE teacher set IS_chef_T=0,FIELD_T=NULL where FIELD_T=?';
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$form["field"]]);
      
      $sql = 'UPDATE teacher set IS_chef_T=1,FIELD_T=? where id_T=?';
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$form["field"],$form["prof2"]]);

      $sql = 'UPDATE field set CHEF_F=? where NAME_F=?';
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$form["prof2"],$form["field"]]);
      
   } 
      if(count($errors)>0){
         echo "<div class=\"alert alert-danger\">";
      foreach($errors as $error){
         echo"<li>$error</li>";
      }
      echo"</div>";
      }
}

/*choose teacher in EM*/
if($type=="chooseTeacherAll"){
   $sql = 'SELECT ID_T, CONCAT(FIRST_NAME_u , " ",SECOND_NAME_u) AS name from teacher as t inner join users as u on t.id_u=u.ID_U ';
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $profs = $stmt->fetchAll();
   $profs = json_encode($profs);
   echo $profs;
}
/* create EM*/
if ($type == "createEM") {
   $form = $_POST["form"];
   parse_str($form, $form);
   $errors =[];

   if(!isset($form["year-elem"])){
      $errors["year"]="Choisissez une annee .";
   }
   if(!isset($form["semester-elem"])){
      $errors["semester"]="Choisissez un semestre .";
   }
   if(!isset($form["periode-elem"])){
      $errors["periode"]="Choisissez une periode .";
   }
   if(!isset($form["Code"])){
      $errors["elem"]="Choisissez un module .";
   }
   if($form["elemmodulename"]==""){
      $errors["elemmodulename"]="Entrez un nom de l'element du module .";
   }
   if(!isset($form["profname"])){
      $errors["prof"]="Choisissez un prof .";
   }
   
   if(empty($errors)){
      $sql = 'SELECT ID_T, CONCAT(FIRST_NAME_u , " ",SECOND_NAME_u) AS name from teacher as t inner join users as u on t.id_u=u.ID_U where t.ID_T=? ';
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$form["profname"]]);
      $profs = $stmt->fetchAll();
      foreach($profs as $prof){
         $name = $prof->name ;
      }
      
      $name = $form["Code"] . ":" . $form["elemmodulename"] . ":" . $name;

      $sql = 'SELECT NAME_elem_M  from elem_module where (NAME_elem_M=? and year_s=? and semester!=?) or (NAME_elem_M=? and year_s=? and semester=? and periode=?)';
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$name,$form["year-elem"],$form["semester-elem"],$name,$form["year-elem"],$form["semester-elem"],$form["periode-elem"]]);
      $elem = $stmt->fetchAll();
      if(!empty($elem)){
         $errors["elem"]="Impossible d'avoir le meme elment de module pour la meme annee dans deux semestres differents / cet element de module existe deja .";
      }
      if(empty($errors)){
      $sql = "INSERT INTO elem_module (`id_prof`, `NAME_elem_M`, `year_s`, `semester`, `periode`)
      VALUES (?, ?, ?, ?, ?);";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$form["profname"], $name, $form["year-elem"], $form["semester-elem"], $form["periode-elem"]]);
      }
   }
   if(count($errors)>0){
      echo "<div class=\"alert alert-danger\">";
   foreach($errors as $error){
      echo"<li>$error</li>";
   }
   echo"</div>";
   }
}
/*create module*/
if ($type == "createM") {
   $form = $_POST["form"];
   $errors = [];
   parse_str($form, $form);
   $sql = 'SELECT * from module where NAME_M=?';
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$form["mName"]]);
   $modules = $stmt->fetchAll();
   foreach($modules as $module){
      $errors["existe"]="element de module existant";
      echo "<div style='padding : 6px;' class='alert alert-danger'><li>Ce module existe</li></div>";
   }
   if(empty($errors)){
      $sql = 'INSERT into module(NAME_M) values (?)';
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$form["mName"]]);
      $modules = $stmt->fetchAll();
      echo "good";
   }
}
/* create class */
if ($type == "createClass") {
   $form = $_POST["form"];
   parse_str($form, $form);

   $errors = [];
   if($form["className"]==""){
      $errors["name"]="Entrez un nom de classe";
   }
   if($form["capacity"]==""){
      $errors["capacitye"]="Entrez la capacite de la classe";
   }
   
   if(empty($errors)){
      $name= strtoupper($form["className"]);
   $sql = 'SELECT * from class where Type_class=?';
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$name]);
   $modules = $stmt->fetchAll();
   foreach($modules as $module){
      $errors["existe"]="Classe existante";
   }
}
   if(empty($errors)){
   $name= strtoupper($form["className"]);
      $sql = 'INSERT into class(Type_class,Capacity_class) values (?,?)';
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$name,$form["capacity"]]);
      $modules = $stmt->fetchAll();
   }
   if(count($errors)>0){
      echo "<div class=\"alert alert-danger\">";
   foreach($errors as $error){
      echo"<li>$error</li>";
   }
   echo"</div>";
   }

}

function W_sexe(String $charac)
{
   if ($charac == 'male') {
      return '0';
   }
   return '1';
}

function W_chef(String $charac){
   if ($charac == 'no') {
      return '0';
   }
   return '1';
}

/* suppression */
if ($type=="suppression") {
   $sql = "SELECT * from users order by type_user";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $users = $stmt->fetchAll();
   echo"<div class='main-body'><div id='errors'></div>
   <div class='row gutters-sm'>";
   foreach($users as $user){
      if($user->type_user == "T"){
         $user->type_user = "Professeur";
      }
      elseif($user->type_user == "S")
      {
         $user->type_user = "Etudiant";
      }
      elseif($user->type_user == "A")
      {
         $user->type_user = "Admin";
      }
      echo"<div class='col-md-4 mb-3' value='no' id='$user->FIRST_NAME_u$user->ID_U' style='height:250px;'>
        <div class='card ' id='user-title' onclick='\$dc.clicked($user->FIRST_NAME_u$user->ID_U);'>
          <div class='card-body'>
              <img src='https://bootdey.com/img/Content/avatar/avatar7.png' alt='Admin' class='rounded-circle' 
              width='150'>        
          </div>
          <span id='".$user->FIRST_NAME_u.$user->ID_U."2' value='$user->ID_U'>$user->FIRST_NAME_u &nbsp; $user->SECOND_NAME_u
          <p class='text-muted font-size-sm' >$user->type_user</p>
          </span>
        </div>
      </div>";
   }
   echo"</div>
   </div><div id=\"container\" style=\"margin-top: 55px;\" >
   <div id=\"retour\" style=\"margin-top: -30px;\">
       <a href=\"#\" onclick=\"\$dc.loadRemove();\" >
       <button type=\"button\" class=\"btn btn-danger\">Supprimer</button>
        </a>
   </div>
 </div>";
}

if ($type=="getremove") {
   $sql = "SELECT * from users order by type_user";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $users = $stmt->fetchAll();
   foreach($users as $user){
      echo ($user->FIRST_NAME_u.$user->ID_U."\n") ;
   }
}

if ($type=="remove") {
   $ids = $_POST["elements"];
   $errors=[];
   if($ids[0]!="ntg"){
      for($i=0;$i<count($ids);$i++){
         $sql = "SELECT * from users as u join teacher as t on u.ID_U=t.id_u where u.ID_U=? and t.IS_chef_T='1'";
         $stmt = $pdo->prepare($sql);
         $results = $stmt->execute([$ids[$i]]);
         $users = $stmt->fetchAll();
         foreach($users as $user){
               $errors[$i]="Le professeur ".$user->FIRST_NAME_u." ".$user->SECOND_NAME_u." est le chef de la filiere ".$user->FIELD_T." , affectez un autre professeur à cette filiere dans la barre creation/filiere puis réssayer ";
         }
         if(empty($errors)){
            $sql = " DELETE from student where id_u=?";
            $stmt = $pdo->prepare($sql);
            $results = $stmt->execute([$ids[$i]]);

            $sql = " DELETE e,t,s from elem_module as e join teacher as t on e.id_prof=t.ID_T join seance as s on e.id_prof=s.id_prof where t.id_u=?";
            $stmt = $pdo->prepare($sql);
            $results = $stmt->execute([$ids[$i]]);

            $sql = " DELETE t,s from teacher as t join seance as s on e.id_prof=s.id_prof where t.id_u=?";
            $stmt = $pdo->prepare($sql);
            $results = $stmt->execute([$ids[$i]]);

            $sql = " DELETE from teacher  where id_u=?";
            $stmt = $pdo->prepare($sql);
            $results = $stmt->execute([$ids[$i]]);

            $sql = " DELETE from users where ID_U=?";
            $stmt = $pdo->prepare($sql);
            $results = $stmt->execute([$ids[$i]]);
         }
      }
   }
   if(count($errors)>0){
      echo "<div class=\"alert alert-danger\">";
   foreach($errors as $error){
      echo"<li>$error</li>";
   }
   echo"</div>";
   }
}

if (isset($_POST["changeseance"])) {
   // $year_s = $_POST["year"];
   // $semester = $_POST["semester"];
   // $periode = $_POST["periode"];
   parse_str($_POST['form1'], $form);

   $SQL = "SELECT * from elem_module WHERE year_s=? and semester=? and periode=?";
   $stmt = $pdo->prepare($SQL);
   $stmt->execute([
      $form["year"],
      $form["semester"],
      $form["periode"]
   ]);

   $result = $stmt->fetchAll();
   $result = json_encode($result);
   echo $result;

}
//class
if (isset($_POST["changeclass"])) {
   // parse_str($_POST['form1'], $form);

   $SQL = "SELECT * from class";
   $stmt = $pdo->prepare($SQL);
   $stmt->execute();

   $result = $stmt->fetchAll();
   $result = json_encode($result);
   echo $result;

}

if (isset($_POST['confirm_btn'])) {

   $form = $_POST["form"];
   $seances_chr = strchr($form, "seance");
   $info = str_replace($seances_chr, "", $form);
   //converted info and seances separatly

   parse_str($seances_chr, $seances);
   parse_str($info, $info);
   //here they are being lists


   $seances = array_filter($seances, 'strlen');
   //here we filter null strings
   
   $id_field = $_POST["field"];
   $week = $info["week"];
   $day = $info["day"];
   $year_s = $info["year"];
   $semestre = $info["semester"];
   $periode = $info["periode"];
   $id_field = $_SESSION["field"];


   $periodi = 1;

      $query = "DELETE from seance where week=? and day_=? and name_field=? and year_s=? and semestre = ? and  periode=? ";

      $stmt = $pdo->prepare($query);
      $result = $stmt->execute([
         $week, $day, $id_field, $year_s, $semestre, $periode
      ]);


   $ID_S = "NULL";
   $id_matiere = "";
   $id_prof = "";
   $NAME_S = "";
   $id_matiere = "";
   $CLASS_S = "";
   $seance_n = "";

   foreach ($seances as $seance => $val) {
      if (preg_match("/seance/i", $seance)) {

         $id_matiere = "NULL"; //
         $seance_n = substr($seance, 6);

         $id_prof = $val;

         $query = "SELECT * FROM elem_module where id_prof=? limit 1";
         $stmt = $pdo->prepare($query);
         $stmt->execute([$id_prof]);
         $elem_module = $stmt->fetchAll();
         foreach($elem_module as $x)
         {
            $NAME_S = $x->NAME_elem_M ;
            $id_matiere = $x->id_matiere ;
         }
         $fst = strrpos($NAME_S,":");
         $NAME_S = substr($NAME_S,0,$fst);
      } elseif (preg_match("/class/i", $seance)) {

         $CLASS_S = $val;
         $periodi = 1;
            $query = "INSERT into seance ( `NAME_S`, `id_prof`, `week`, `day_`, `CLASS_S`, `seance_n`, `name_field`, `year_s`, `semestre`, `periode`,`id_matiere`) values (?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $pdo->prepare($query);


            $result = $stmt->execute(
               [
                  $NAME_S,
                  $id_prof,
                  $week,
                  $day,
                  $CLASS_S,
                  $seance_n,
                  $id_field, 
                  $year_s,
                  $semestre,
                  $periode,
                  $id_matiere
               ]
            );
      }
   }

}

if (isset($_POST['semester'])) {
   parse_str($_POST['form1'], $form);
   $d = (string)$form['day'];
   $s = (string)$form['semester'];
   $p = (string)$form['periode'];

   $query = "SELECT * from seance where week=? and day_=? and semestre = ? and periode=?";

   $stmt = $pdo->prepare($query);
   $stmt->execute([$form['week'], $form['day'], $s, $p]);
   $result = $stmt->fetchAll();
   $result = json_encode($result);
   echo $result;
}
/* interface to send request of seance */
if($type == "showReprogrammation" ){
   $id_s = $_POST["id"] ;
   $sql = "SELECT * from seance WHERE id_s=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_s]);
   $seances = $stmt->fetchAll();
   foreach($seances as $sean){
      echo $sean->week."\n" ;
      echo $sean->day_."\n";
      echo $sean->seance_n."\n";
   }
}
/* show time colored */
if($type == "showTime" ){
   $id_s = $_POST["id"] ;
   parse_str($_POST['form'], $form);
   $sql = "SELECT * from seance WHERE id_s=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_s]);
   $seances = $stmt->fetchAll();
   foreach($seances as $sean){
      $field = $sean->name_field;
      $year = $sean->year_s;
      $semestre = $sean->semestre;
      $periode = $sean->periode;
   }
   
   $sql = "SELECT * from seance WHERE week=? and day_=? and name_field=? and year_s=? and semestre=? and periode=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$form["week"], $form["day"],$field,$year , $semestre, $periode]);
   $result=$stmt->fetchAll();

   $result = json_encode($result);
   echo $result;
}

/* send request */
if($type == "sendRequest" ){
   $id_s = $_POST["id"] ;
   parse_str($_POST['form'], $form);
   if(isset($form['week']) && isset($form['day']) && isset($form['heure'])){
   $sql = "INSERT into request ( `id_s`, `week_r`, `day_r`, `seance_n_r` ,`type`) values (?,?,?,?,?)" ;
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_s , $form["week"], $form["day"],$form['heure'] , "R"]);
   }
   else{
   $sql = "INSERT into request ( `id_s`,`type`) values (?,?)";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_s ,"A"]);
   }
}
/* show request for CF */
if($type == "loadRequest" ){
   $sql = " SELECT * from request as r join seance as s on r.id_s=s.ID_S join elem_module as e on s.id_matiere = e.id_matiere where s.name_field=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$_SESSION["field"]]);
   $result=$stmt->fetchAll();

   $result = json_encode($result);
   echo $result;
}
/*refuse request */
if($type == "refuseRequest" ){
   $id_req = $_POST["id"] ;
   $sql = " DELETE from request where ID_req=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_req]);
}
/* show class */
if($type == "showClass" ){
   $sql = " SELECT * from class";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute();
   $result=$stmt->fetchAll();

   $result = json_encode($result);
   echo $result;
}
/* color red and disabled class */
if($type == "colorClass" ){
   $id_req = $_POST["id"];
   $sql = " SELECT * from request where ID_req=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_req]);
   $request=$stmt->fetchAll();
   foreach($request as $req){
      $day=$req->day_r;
      $week=$req->week_r;
      $hour=$req->seance_n_r;
      $id_s=$req->id_s;
   }

   $sql = " SELECT * from seance where day_=? and week=? and seance_n=? and ID_S!=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$day,$week,$hour,$id_s]);
   $result=$stmt->fetchAll();

   $result = json_encode($result);
   echo $result;
}
/*accept class */
if($type == "acceptRequest" ){
   $id_req = $_POST["id"] ;
   parse_str($_POST['form'], $form);
   $time = [
      "09:00 -> 10:40",
      "10:50 -> 12:30",
      "14:00 -> 15:40",
      "16:10 -> 17:50",
    ];
    $jour = ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];

   $sql = " SELECT * from request as r join seance as s on r.id_s=s.ID_S where ID_req=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_req]);
   $request=$stmt->fetchAll();
   foreach($request as $req){
      $id_s=$req->id_s;
      $day=$req->day_r;
      $week=$req->week_r;
      $hour=$req->seance_n_r;
      $t_req = $req->type;
      $name=$req->NAME_S;
      $day_s=$req->day_;
      $week_s=$req->week;
      $hour_s=$req->seance_n;
      $periode=$req->periode;
      $semestre=$req->semestre;
   }
   $name=str_replace(":"," ",$name);
   
   $name2 = "REPROGRAMMATION ".$name." ".$semestre." ".$periode;
   $content = "<p>La seance ". $name ." qui a ete programmé pour le ".$jour[$day_s-1]." dans la semaine ".$week_s." à ".$time[$hour_s-1]." est reportée 
      pour le".$jour[$day-1]." dans la semaine ".$week." à ".$time[$hour-1]."</p>";
      $sql = " INSERT into news set id_n=?,content=?,name_field=?";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$name2,$content,$_SESSION["field"]]);

   $sql = " UPDATE seance set week=?,day_=?,seance_n=?,CLASS_S=? where ID_S=? ";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$week,$day,$hour,$form["class"],$id_s]);

   $sql = " DELETE from request where ID_req=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_req]);
}
/* delete request */
if($type == "acceptRequestD" ){
   $id_req = $_POST["id"] ;
   $time = [
      "09:00 -> 10:40",
      "10:50 -> 12:30",
      "14:00 -> 15:40",
      "16:10 -> 17:50",
    ];
    $jour = ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];

   $sql = " SELECT * from request as r join seance as s on r.id_s=s.ID_S where ID_req=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_req]);
   $request=$stmt->fetchAll();
   foreach($request as $req){
      $id_s=$req->id_s;
      $t_req = $req->type;
      $name=$req->NAME_S;
      $day_s=$req->day_;
      $week_s=$req->week;
      $hour_s=$req->seance_n;
      $periode=$req->periode;
      $semestre=$req->semestre;
   }

   $name=str_replace(":"," ",$name);
      $name2 = "ANNULATION ".$name." ".$semestre." ".$periode;
      $content = "<p>La seance ". $name ." qui a ete programmé pour le ".$jour[$day_s-1]." dans la semaine ".$week_s." à ".$time[$hour_s-1]." est annulee .</p>";
      $sql = " INSERT into news set id_n=?,content=?,name_field=?";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$name2,$content,$_SESSION["field"]]);

      $sql = " DELETE from seance where ID_S=?";
      $stmt = $pdo->prepare($sql);
      $results = $stmt->execute([$id_s]);

   $sql = " DELETE from request where ID_req=?";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([$id_req]);
}
