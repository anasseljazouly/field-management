<!--/*
      //for sending email to someone who forgotten their password
      // require_once 'vendor_files\vendor\autoload.php';
      // require_once 'config/constant.php';
      // // Create the Transport
      // $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
      //    ->setUsername(EMAIL)
      //    ->setPassword(PASSWORD);


      // // Create the Mailer using your created Transport
      // $mailer = new Swift_Mailer($transport);


      // function sendPasswordResetLink($user_email, $token)
      // { // Create a message
   //       global $mailer;

   //       $body = '<!DOCTYPE html>
   // <html lang="en">
   
   // <head>
   //    <meta charset="UTF-8">
   
   //    <title>Verify email</title>
   // </head>
   
   // <body>
   //    <div class="wrapper">
   //       <p>thanks bla bla bla</p><a href="http://localhost/Test/test/reset_password.php?password-token=' . $token . '">Verify bla blo blo </a>
   //    </div>
   // </body>
   
   // </html>';
   //       $message = (new Swift_Message('Verify your email'))
   //          ->setFrom(EMAIL)
   //          ->setTo($user_email)
   //          ->setBody($body, 'text/html');
   //       // Send the message
   //       $result = $mailer->send($message);
      }