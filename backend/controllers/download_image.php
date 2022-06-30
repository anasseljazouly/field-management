<?php
require_once "../config/db.php";
/* use this echo '<img src="data:image/png;base64,' . base64_encode($_SESSION[image]) . '"/>'; */


if (isset($_SESSION['user'])) {

   $id_u = $_SESSION['user']->ID_U;

   // $name = $_POST['name'];
   $sql = "SELECT * from user_image where id_u ";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$id_u]);
   $results = $stmt->fetchAll();
   $blob = $results[0]->image_u;
   $_SESSION['image'] = $blob;
   // echo "everything is good";
};

   // $fullpath = 'C:/xampp/htdocs/backend/backend/uploads/' . $name;
   // echo $fullpath;


   // $sql = "INSERT into user_image (id_im,id_u,image_u) values (?,?,load_file(?))";
   // $stmt = $pdo->prepare($sql);
   // $results = $stmt->execute([NULL, $id_u, $fullpath]);