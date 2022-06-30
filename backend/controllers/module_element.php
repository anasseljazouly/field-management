<?php
require "../config/constant.php";
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=' . $charset;

$pdo = new PDO($dsn, $user, $password);

if (isset($_POST['load-prof'])) {

   // $form = $_POST["form"];
   // // $seances_chr = strchr($form, "seance");
   // // $info = str_replace($seances_chr, "", $form);
   // //converted info and seances separatly
   // // echo $form;
   // parse_str($form, $form);
   // echo json_encode($form);

   // parse_str($seances_chr, $seances);
   // parse_str($info, $info);
   //here they are being lists


   // $seances = array_filter($seances, 'strlen');
   //here we filter null strings

   // $d = (string)$_POST['date'];
   // $s = (string)$_POST['semester'];
   // $p = (string)$_POST['periode'];

   $query = "SELECT * from teacher as t inner join users as u on t.id_u=u.ID_U where type_user=? ";

   $stmt = $pdo->prepare($query);
   $stmt->execute(["T"]);
   $result = $stmt->fetchAll();
   $result = json_encode($result);
   echo $result;

   exit(0);
}
if (isset($_POST['confirm_btn'])) {
   $form = $_POST["form"];
   // $seances_chr = strchr($form, "seance");
   // $info = str_replace($seances_chr, "", $form);
   //converted info and seances separatly

   parse_str($form, $form);
   // echo json_encode($form);

   // parse_str($seances_chr, $seances);
   // parse_str($info, $info);
   // here they are being lists
   $name = "M" . $form["Code"] . ":" . $form["elemmodulename"] ;
   // periode-elem: "P1"
   // profname: "1"
   $sql = "INSERT INTO elem_module (`id_prof`, `NAME_elem_M`, `year_s`, `semester`, `periode`)
   VALUES (?, ?, ?, ?, ?);";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$form["profname"], $name, $form["year-elem"], $form["semester-elem"], $form["periode-elem"]]);
   echo "success!";
}