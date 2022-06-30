<?php
require_once "../config/db.php";

if (isset($_POST['content'])) {
   $editor_data = $_POST['content'];

   $id_T = $_SESSION["id_u"]; ////////////to be modified
   $sql = "UPDATE teacher set Bibliographie_T=? where id_u=?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$editor_data, $id_T]);
}
 // echo $editor_data;
   // Create connection
   // parse_str($_POST['title'], $form);
   // var_dump($form);
   // $title = $form['title'];
   // echo $title;
   // $field = "GL"; //$_SESSION["field"];