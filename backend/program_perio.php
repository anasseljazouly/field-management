<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <!--bootstrap-->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <title>PROGRAMM PERIODIQUE</title>

</head>

<body>


   <h2 id="sp">Filiere :</h2>
   <h2 id="field">GL</h2>
   <!-- <?php //echo $_SESSION["field"]; 
         ?> -->

   <form id="form1">
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label for="week">Semaine:</label>
               <select class="form-control week" id="week" name="week">
                  <option disabled></option>
                  <?php for ($x = 1; $x <= 6; $x++) : ?>
                  <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                  <?php endfor ?>
               </select>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label for="day">Jour</label>
               <select class="form-control day" id="day" name="day">
                  <option disabled></option>
                  <option value="1" selected>Lundi</option>
                  <option value="2">Mardi</option>
                  <option value="3">Mercredi</option>
                  <option value="4">Jeudi</option>
                  <option value="5">Vendredi</option>
                  <option value="6">Samedi</option>
               </select>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label for="year" class="year">annee</label>
               <select class="form-control year" id="year" name="year">
                  <option disabled></option>
                  <option value="1A" selected>1A</option>
                  <option value="2A">2A</option>
                  <option value="3A">3A</option>
               </select>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label for="semester" class="semester">Semestre</label>
               <select class="form-control semester" id="semester" name="semester">
                  <option disabled></option>
                  <option value="S1" selected>S1</option>
                  <option value="S2">S2</option>
               </select>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label for="periode">Periode</label>
               <select class="form-control" id="periode" name="periode">
                  <option disabled></option>
                  <option value="P1" selected>P1</option>
                  <option value="P2">P2</option>
               </select>
            </div>
         </div>
      </div>
      <div class="form-group">

         <input type="checkbox" id="perio" name="perio" value="yes">
         <label for="perio">Periodique ? (se repete le long de la periode d'un semestre donne)</label>
      </div>
   </form>

   <form id="form2">
      <div class="form-group" id="seance-class">
         <form action="program_perio.php">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="matiere">09:00 -> 10:40</label>
                     <select class="form-control" id="matiere" name="seance1">
                        <option selected></option>
                     </select>
                  </div>
               </div>
               <div class="col">
                  <div class="form-group">
                     <label for="salle">Salle</label>
                     <select class="form-control add" id="salle" name="class1">
                        <option id="c1" selected></option>
                     </select>
                  </div>
               </div>
            </div>
      </div>
      <div class="form-group" id="seance-class">
         <form action="program_perio.php">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="matiere">10:50 -> 12:30</label>
                     <select class="form-control" id="matiere" name="seance2">
                        <option selected></option>
                     </select>
                  </div>
               </div>
               <div class="col">
                  <div class="form-group">
                     <label for="salle">Salle</label>
                     <select class="form-control add" id="salle" name="class2">
                        <option id="c1" selected></option>
                     </select>
                  </div>
               </div>
            </div>
      </div>
      <div class="form-group" id="seance-class">
         <form action="program_perio.php">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="matiere">14:00 -> 15:40</label>
                     <select class="form-control" id="matiere" name="seance3">
                        <option selected></option>
                     </select>
                  </div>
               </div>
               <div class="col">
                  <div class="form-group">
                     <label for="salle">Salle</label>
                     <select class="form-control add" id="salle" name="class3">
                        <option id="c1" selected></option>
                     </select>
                  </div>
               </div>
            </div>
      </div>
      <div class="form-group" id="seance-class">
         <form action="program_perio.php">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="matiere">16:10 -> 17:50</label>
                     <select class="form-control" id="matiere" name="seance4">
                        <option selected></option>
                     </select>
                  </div>
               </div>
               <div class="col">
                  <div class="form-group">
                     <label for="salle">Salle</label>
                     <select class="form-control add" id="salle" name="class4">
                        <option id="c1" selected></option>
                     </select>
                  </div>
               </div>
            </div>
      </div>

   </form>


   <div class="form-group">
      <button name="Confirm-btn" id="confirm-btn" class="btn btn-primary btn-block btn-lg">Confirm</button>
   </div>

   <script src="../PFA/js/jquery-2.1.4.min.js"></script>
   <script src="../PFA/js/bootstrap.min.js"></script>
   <script src="../PFA/js/ajax-utils.js"></script>
   <!-- <script src="js/script.js"></script> -->
   <script>
   document.write('<script src="js/script.js?=dev' + Math.floor(Math.random() * 69) + '"\><\/script>');
   </script>
   <script>
   document.write('<link rel="stylesheet" href="css/styles.css?=dev' + Math.floor(Math.random() * 69) + '"\><\/>');
   </script>

</body>


</html>