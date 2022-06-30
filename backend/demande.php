<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <!--bootstrap-->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <title>Reprogrammation</title>

</head>

<body>




   <form id="form-demande">
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
         <label for="heure">heure</label>
         <select class="form-control" id="heure" name="heure">
            <option disabled></option>
            <option value="1" selected>09:00 -> 10:40</option>
            <option value="2">10:50 -> 12:30</option>
            <option value="2">14:00 -> 15:40</option>
            <option value="2">16:10 -> 17:50</option>
         </select>
      </div>
      <div class="form-group">

         <label for="message">Message ou proposition du jour(facultatif)</label>
         <input type="text" name="message" class="form-control form-control-lg">
      </div>
      <div class="form-group">
         <button name="confirm-demande-btn" id="confirm-demande-btn" class="btn btn-primary btn-block btn-lg">Demande
            de
            reporogrammation</button>
      </div>
   </form>






   <script src="../PFA/js/jquery-2.1.4.min.js"></script>
   <script src="../PFA/js/bootstrap.min.js"></script>
   <script src="../PFA/js/ajax-utils.js"></script>
   <script src="js/script.js"></script>
   <!-- <script>
         document.write('<script src="js/script.js?=dev' + Math.floor(Math.random() * 69) + '"\><\/script>');
         </script>
         <script>
         document.write('<link rel="stylesheet" href="css/styles.css?=dev' + Math.floor(Math.random() * 69) +
            '"\><\/>');
         </script> -->

</body>


</html>