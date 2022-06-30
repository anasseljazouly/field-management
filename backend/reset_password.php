<?php require_once 'controllers\authController.php';
if(isset($_GET['password-token'])){
   $passworTtoken = $_GET['password-token'];
   ResetPassword($passworTtoken);
   //redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <!--bootstrap-->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <title>Reset Password</title>
</head>
<body>
 
   <div class="container">
      <div class="row">
         <div class="col-md-8 offset-md-4 form-div"></div>
         <form action="reset_password.php" method="post">
            <h3 class="text-center">Reset your password</h3>

            <?php if(count($errors)>0):?>
            <div class="alert alert-danger">
            <?php foreach($errors as $error):?>
               <li><?php echo $error;?></li>
            <?php endforeach?>
            <?php endif?>
            </div>


            
            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" name="password"  class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="password">Confirm Password</label>
               <input type="password" name="passwordConf"  class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <button type="submit" name="reset-password-btn" class="btn btn-primary btn-block btn-lg">Reset Password</button>
            </div>
         </form>        
         </div>
 
   </div>
</body>
</html> 
