<?php
require "../config/db.php";


if ($_SESSION['user']['type_user'] == "S" || $_SESSION['user']['type_user'] == "T") {

   parse_str($_POST['form1'], $form);
   $field = $_SESSION['filiere'];

   //boucler sur les ligne cad les seance
   for ($seance_n = 1; $seance_n <= 4; $seance_n++) {
      $SQL = "SELECT * from seance where name_field=? and week=? and  year_s=? and semester=? and periode=? where seance_n=? order by day_ ASC";
      $stmt->execute([
         $field,
         $form['week'],
         $form["year"],
         $form["semester"],
         $form["periode"],
         $seance_n,
      ]);
      $result = $stmt->fetchAll();

      if (!empty($result)) {
         $j = 1;
         foreach ($x as $result) {
            while ($x['id'] != $j) {
               echo "<td>khawi<td>";
               $j++;
            }
            echo "<td>3amer<td>";
         }
      } else {
         for ($j = 1; $j <= 6; $j++) {
            echo "<td>khawi<td>";
         }
      }
   }
}
// $result=[[id,seance],[id,seance],[id,seance]]