<?php
require "../config/db.php";


if (isset($_POST["form"])) {
   parse_str($_POST['form'], $form);

   $message = "Demande de reprogrammation de la seance ayant comme coordonnee :<br> semaine :" . $form['week'] . "<br> jour :" . $form['day'] . "<br> Annee :" . $form['year'] . "<br> Semestre :" . $form['semester'] . "<br> Periode :" . $form['periode'] . "<br> heure :" . $form['heure'] . "<br><br>Message personalise :" . $form['message'];
   $SQL = "INSERT into request values(?,?)";
   $stmt = $pdo->prepare($SQL);
   $stmt->execute([
      NULL, $message
   ]);
}