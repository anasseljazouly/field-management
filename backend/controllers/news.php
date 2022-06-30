<?php
require_once "../config/db.php";

if (isset($_POST['content'])) {
   $editor_data = $_POST['content'];
   parse_str($_POST['title'], $form);
   var_dump($form);
   $title = $form['title'];
   echo $title;
   $field = "GL"; //$_SESSION["field"];////////////to be modified
   $sql = "INSERT INTO news(id_n,title,content,id_field)VALUES(?,?,?,?)";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([NULL, $title, $editor_data, $field]);
}