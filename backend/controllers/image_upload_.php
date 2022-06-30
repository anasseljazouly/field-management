<?php
require_once "../config/db.php";

if (isset($_POST['file'])) {

   $name = $_POST['name'];

   $fullpath = 'C:/xampp/htdocs/backend/backend/uploads/' . $name;
   // echo $fullpath;
   $id_u = $_SESSION['user'];
   $sql = "INSERT into user_image (id_im,id_u,image_u) values (?,?,load_file(?))";
   $stmt = $pdo->prepare($sql);
   $results = $stmt->execute([NULL, $id_u, $fullpath]);
   // echo "everything is good";
}; 
 // var_dump($_POST);
   // var_dump($_POST);

   // $file = json_decode($_POST["ar"]);
   // var_dump($file);
// $file2 = json_encode($file);
   // $sql = "SELECT * from image_test ";
   // $stmt = $pdo->prepare($sql);
   // $stmt->execute();
   // $results = $stmt->fetchAll();
   // $blob = $results[0]->image_u;
   // $results = $stmt->execute([file_get_contents($_FILES['upload']['tmp_name'])]);
   // echo $file2;

   // echo '<img src="data:image/png;base64,' . base64_encode($blob) . '"/>';
   // $sql = "INSERT into image_test (image_u) values (?)";
   // $stmt = $pdo->prepare($sql);
   // $results = $stmt->execute([file_get_contents($_FILES['upload']['tmp_name'])]);

   // echo "sucess";