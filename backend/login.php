<?php require_once 'controllers\authController.php';?>

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
       
         <form action="login.php" method="post">
            <h3 class="text-center">Log in</h3>

            <?php if(count($errors)>0):?>
            <div class="alert alert-danger">
            <?php foreach($errors as $error):?>
               <li><?php echo $error;?></li>
            <?php endforeach?>
            <?php endif?>
            </div>


            <div class="form-group">

               <label for="email">Email</label>
               <input type="email" name="email" value="<?php echo $email;?>" class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" name="password"  class="form-control form-control-lg">
            </div>

            <div class="form-group">
               <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-lg">Log In</button>
            </div>
            <p class="text-center"><a href="forgot_password.php">Forgot Password ?</a>
            </p>
         </form>        
         </div>
 
   </div>
</body>
</html> 
