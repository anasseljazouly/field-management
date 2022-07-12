<?php
//for sending email to someone who forgotten their password
require_once '../config/constant.php';

function sendPasswordResetLink($user_email,$token)
{
   $headers = "MIME-Version: 1.0" . "\n";
   $headers .= "Content-type:text/html;charset=UTF-8" . "\n";
   // Create a message
   $body='<!DOCTYPE html>
   <html lang="en">
   
   <head>
      <meta charset="UTF-8">
   
      <title>Verification d email</title>
   </head>
   
   <body>
      <div class="wrapper">
         <p>Renitialisation du mot de passe</p><a 
         href="http://localhost/PFA/snippets/reset_password.html?password-token='.$token.'">Clicker ici</a>
      </div>
   </body>
   
   </html>';

   //the subject
   $sub = "Renitialisation du mot de passe";
   //send email
   mail($user_email,$sub,$body,$headers);
}
?>