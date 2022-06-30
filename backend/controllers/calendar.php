<?php
require "../config/constant.php";
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=' . $charset;

$pdo = new PDO($dsn, $user, $password);
// seance
if (isset($_POST["changeseance"])) {
   // $year_s = $_POST["year"];
   // $semester = $_POST["semester"];
   // $periode = $_POST["periode"];
   parse_str($_POST['form1'], $form);

   $SQL = "SELECT * from elem_module WHERE year_s=? and semester=? and periode=?";
   $stmt = $pdo->prepare($SQL);
   $stmt->execute([
      $form["year"],
      $form["semester"],
      $form["periode"]
   ]);

   $result = $stmt->fetchAll();
   $result = json_encode($result);
   echo $result;
   exit(0);
}
//class
if (isset($_POST["changeclass"])) {
   // parse_str($_POST['form1'], $form);

   $SQL = "SELECT * from class";
   $stmt = $pdo->prepare($SQL);
   $stmt->execute();

   $result = $stmt->fetchAll();
   $result = json_encode($result);
   echo $result;
   exit(0);
}
if (isset($_POST['confirm_btn'])) {


   $form = $_POST["form"];
   $seances_chr = strchr($form, "seance");
   $info = str_replace($seances_chr, "", $form);
   //converted info and seances separatly

   parse_str($seances_chr, $seances);
   parse_str($info, $info);
   //here they are being lists


   $seances = array_filter($seances, 'strlen');
   //here we filter null strings
   var_dump($info);
   $id_field = $_POST["field"];
   $week = $info["week"];
   $day = $info["day"];
   $year_s = $info["year"];
   $semestre = $info["semester"];
   $periode = $info["periode"];

   //prendre l'id de la filiere
   $field_name = "SELECT ID_F from field WHERE NAME_F=? limit 1";
   $stmt = $pdo->prepare($field_name);
   $stmt->execute([$id_field]);
   $id_fieldquery = $stmt->fetchAll();


   $id_field = $id_fieldquery[0]["ID_F"];

   $periodi = 1;
   if ($info['perio'] === "yes") {
      $periodi = 6;

      for ($x = 1; $x <= $periodi; $x++) {

         $query = "DELETE from seance where week=? and day_=? and name_field=? and year_s=? and semestre = ? and  periode=? ";

         $stmt = $pdo->prepare($query);
         $result = $stmt->execute([
            $x, $day, $id_field, $year_s, $semestre, $periode
         ]);
      }
   } else {

      $query = "DELETE from seance where week=? and day_=? and name_field=? and year_s=? and semestre = ? and  periode=? ";

      $stmt = $pdo->prepare($query);
      $result = $stmt->execute([
         $week, $day, $id_field, $year_s, $semestre, $periode
      ]);
   }


   $ID_S = "NULL";
   $id_matiere = "";
   $id_prof = "";
   $NAME_S = "";

   $CLASS_S = "";
   $seance_n = "";

   foreach ($seances as $seance => $val) {
      if (preg_match("/seance/i", $seance)) {

         $id_matiere = "NULL"; //
         $seance_n = substr($seance, 6);

         $id_prof = $val;

         $query = "SELECT * FROM elem_module where id_prof=? limit 1";
         $stmt = $pdo->prepare($query);
         $stmt->execute([$id_prof]);
         $elem_module = $stmt->fetchAll();
         $NAME_S = $elem_module[0]["NAME_elem_M"];
      } elseif (preg_match("/class/i", $seance)) {

         $CLASS_S = $val;
         $periodi = 1;
         if ($info['perio'] == "yes") {
            $periodi = 6;
            for ($x = 1; $x <= $periodi; $x++) {
               $query = "INSERT into seance values (?,?,?,?,?,?,?,?,?,?,?,?)";

               $stmt = $pdo->prepare($query);


               $result = $stmt->execute(
                  [
                     $ID_S,
                     $NAME_S,
                     $id_prof,
                     $x,
                     $day,
                     $CLASS_S,
                     $seance_n,
                     $id_field, //
                     $year_s,
                     $semestre,
                     $periode,
                     "NULL"
                  ]
               );
            }
         } else {
            $query = "INSERT into seance values (?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $pdo->prepare($query);


            $result = $stmt->execute(
               [
                  $ID_S,
                  $NAME_S,
                  $id_prof,
                  $week,
                  $day,
                  $CLASS_S,
                  $seance_n,
                  $id_field, //
                  $year_s,
                  $semestre,
                  $periode,
                  "NULL"
               ]
            );
         }
      }
   }
   exit(0);
}

if (isset($_POST['semester'])) {
   parse_str($_POST['form1'], $form);
   $d = (string)$form['day'];
   $s = (string)$form['semester'];
   $p = (string)$form['periode'];

   $query = "SELECT * from seance where week=? and day_=? and semestre = ? and periode=?";

   $stmt = $pdo->prepare($query);
   $stmt->execute([$form['week'], $form['day'], $s, $p]);
   $result = $stmt->fetchAll();
   $result = json_encode($result);
   echo $result;
   exit(0);
}
  
//json_encode parse_str

// } 
   // $results = json_encode($results);
   // echo  $results;
 //@D la date dyal lyoum
   //    les matire et les classe :
   //    li lprof li kay9erihom a l'instant D ki9eri une autre matiere==disabled 
   // SELECT matire ,class from seance where @D=start_date_s and 



   // select class from seance where @d=start_date_s;
   //    prof kay9eri une autre matiere f le meme instant 
   //    for (kola id de ){

   //    }
   // "SELECT id_prof,start_date_s,end_date_s from seance where @D=start_date";
   // $results = array();
   // $post_date = $_POST["date"];

   // for ($i = 0; $i < 10; $i++) {
   // $date_m = $post_date . " 9:00:00";
   // echo $date_m;
   // $query = "SELECT id_matiere from elem_module as e ,seance where e.id_prof in (select id_prof from seance where ?=start_date_s) ";
   

// $cars=json_encode($cars);