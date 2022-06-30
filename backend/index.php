<?php 
require 'controllers\authController.php';


if(!isset($_SESSION['id'])){
   header('location:login.php');
   exit();//redirection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <!--bootstrap-->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <title>Log in</title>
</head>
<body>
 
   <div class="container">
      <div class="row">
         <div class="col-md-8 offset-md-4 form-div"></div>
            <div class="alert alert-sucess">
            <h3>You are logged in !
               <?php 
      
            echo $_SESSION["message"]; ?>
            <a href="index.php?logout=1" class="logout"><h3>Logout</h3></a></h3>
            </div>
            
         </div>
 
   </div>
</body>
</html>
