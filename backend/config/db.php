<?php

   require_once "constant.php";

   // Set DSN
   $dsn = 'mysql:host='.$host.';dbname='. $dbname.';charset='.$charset;
   // $pdo = new PDO ($dsn, $user,$password);

   $pdo = new PDO($dsn, $user, $password);
   $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
