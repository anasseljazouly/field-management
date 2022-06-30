<?php require_once 'controllers\authController.php';

if (isset($_SESSION['id'])) {
   header('location:index.php');
   exit(); //redirection
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <!--bootstrap-->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <title>Register</title>
</head>

<body>

   <div class="container">
      <div class="row">
         <div class="col-md-8 offset-md-4 form-div"></div>
         <form action="register.php" method="post" id="form-register">
            <h3 class="text-center">Register</h3>

            <?php if (count($errors) > 0) : ?>
            <div class="alert alert-danger">
               <?php foreach ($errors as $error) : ?>
               <li><?php echo $error; ?></li>
               <?php endforeach ?>
               <?php endif ?>
            </div>


            <div class="form-group">
               <label for="firstname">first name</label>
               <input type="text" name="firstname" maxlength="30" value="<?php echo $firstname; ?>"
                  class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="secondname">second name</label>
               <input type="text" name="secondname" maxlength="30" value="<?php echo $secondname; ?>"
                  class="form-control form-control-lg">
            </div>


            <div class="form-group">
               <label for="email">Email</label>
               <input type="email" name="email" maxlength="100" value="<?php echo $email; ?>"
                  class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" name="password" class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="CIN">CIN</label>
               <input type="text" name="CIN" maxlength="8" value="<?php echo $CIN; ?>"
                  class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <p>Sexe</p>
               <input type="radio" id="male" name="sexe" value="male">
               <label for="male">Male</label><br>
               <input type="radio" id="female" name="sexe" value="female">
               <label for="female">Female</label><br>
            </div>



            <div class="form-group">
               <label for="adresse">Adresse</label>
               <input type="text" maxlength="500" name="adresse" value="<?php echo $adresse; ?>"
                  class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="city">city</label>
               <input type="text" name="city" value="<?php echo $city; ?>" class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="country">country</label>
               <input type="text" name="country" value="<?php echo $country; ?>" class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="birthday">Birthday:</label>
               <input type="date" name="birthday" value="<?php echo $birthday; ?>" class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="birthplace">Birth place</label>
               <input type="text" name="birthplace" value="<?php echo $birthplace; ?>"
                  class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="phone">Enter your phone number:</label>
               <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" value="<?php echo $phone; ?>"
                  class="form-control form-control-lg">
            </div>
            <div class="form-group">
               <p>Type du compte </p>
               <label for="teacher">
                  <input type="radio" id="xd" name="type" value="T">
                  teacher</label><br>
               <label for="student">
                  <input type="radio" id="xd" name="type" value="S">
                  student</label><br>
               <label for="admin">
                  <input type="radio" id="xd" name="type" value="A">
                  admin</label><br>
            </div>
            <div id="for-teacher" class="form-group">
               <label for="cf">chef de filiere ?</label> <br>
               <label for="cf">
                  <input type="radio" id="cf" name="cf" value="yes">
                  yes</label><br>
               <label for="cf">
                  <input type="radio" id="cf" name="cf" value="no">
                  no</label><br>

            </div>
            <div id="for-student" class="form-group">
               <label for="CNE">CNE:</label>
               <input type="text" name="CNE" maxlength=10 class="form-control form-control-lg">

               <label for="field">field</label>
               <input type="text" name="field" class="form-control form-control-lg">


               <label for="annee">Annee</label>
               <select class="form-control annee-elem" id="annee-elem" name="year">
                  <option disabled selected></option>
                  <option value="1A">1A</option>
                  <option value="2A">2A</option>
                  <option value="3A">3A</option>
               </select>


            </div>

            <div class="form-group">
               <button type="submit" name="register-btn" class="btn btn-primary btn-block btn-lg">Register</button>
            </div>

         </form>
      </div>
   </div>

   <script src="../PFA/js/jquery-2.1.4.min.js"></script>
   <script src="../PFA/js/bootstrap.min.js"></script>
   <script src="../PFA/js/ajax-utils.js"></script>
   <!-- <script>
   document.write('<script src="js/script.js?=dev' + Math.floor(Math.random() * 69) + '"\><\/script>');
   </script>
   <script>
   document.write('<link rel="stylesheet" href="css/styles.css?=dev' + Math.floor(Math.random() * 69) + '"\><\/>');
   </script> -->
   <script src="js/script.js"></script>
</body>

</html>