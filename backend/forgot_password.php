<?php require_once 'controllers\authController.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <!--bootstrap-->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <title>Forgot Password</title>
</head>
<body>
 
   <div class="container">
      <div class="row">
         <div class="col-md-8 offset-md-4 form-div"></div>
         <form action="forgot_password.php" method="post">
            <h3 class="text-center">Password recovery</h3>
            
            <p>Please enter your email adress and we will assist you in recovering your password.</p>

            <?php if(count($errors)>0):?>
            <div class="alert alert-danger">
            <?php foreach($errors as $error):?>
               <li><?php echo $error;?></li>
            <?php endforeach?>
            <?php endif?>
            </div>


            <div class="form-group">

               <label >Email</label>
               <input type="email" name="email" class="form-control form-control-lg">
            </div>


            <div class="form-group">
               <button type="submit" name="forgot-password-btn"  class="btn btn-primary btn-block btn-lg"> Recover your password</button>
            </div>
         </form>        
         </div>
 
   </div>
</body>
</html> 
