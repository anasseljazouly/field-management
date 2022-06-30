<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <!--bootstrap-->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <title>element module</title>
</head>

<body>

   <div class="container">
      <div class="row">
         <!-- <div class="col-md-8 offset-md-4 form-div"></div> -->
         <form id="form-elem">
            <div class="row">
               <div class="col">
                  <div class="form-group">
                     <label for="annee-elem" class="annee-elem">annee</label>
                     <select class="form-control annee-elem" id="annee-elem" name="year-elem">
                        <option disabled selected></option>
                        <option value="1A">1A</option>
                        <option value="2A">2A</option>
                        <option value="3A">3A</option>
                     </select>
                  </div>
               </div>
               <div class="col">
                  <div class="form-group">
                     <label for="Semestre-elem" class="Semestre-elem">Semestre</label>
                     <select class="form-control Semestre-elem" id="Semester-elem" name="semester-elem">
                        <option disabled selected></option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                     </select>
                  </div>
               </div>

               <div class="col">
                  <div class="form-group">
                     <label for="Periode">Periode</label>
                     <select class="form-control" id="periode-elem" name="periode-elem">
                        <option disabled selected></option>
                        <option value="P1">P1</option>
                        <option value="P2">P2</option>
                     </select>
                  </div>
               </div>
            </div>
      </div>

      <div class="row">
         <div class="col">

            <label for="Code">Code(x.x.x)</label>
            <input type="text" name="Code" maxlength="5" class="form-control form-control-lg">
         </div>
         <div class="col">
            <label for="modulename">elem Module name</label>
            <input type="text" name="elemmodulename" maxlength="30" class="form-control form-control-lg">
         </div>
         <div class="col">
            <label for="Prof-name">Prof name</label>
            <select class="form-control profname" id="profname" name="profname" pattern="[1-9]{1}.[1-9]{1}.[1-9]{1}"
               title="veuillez respecter le format demande">
               <option disabled selected></option>

            </select>
         </div>

      </div>
      </form>
      <br>
      <div class="form-group col-md-4 offset-md-4">
         <button name="Confirm-btn-elem" id="confirm-btn-elem" class="btn btn-primary btn-block btn-lg">Confirm</button>
      </div>
   </div>

   <script src="../PFA/js/jquery-2.1.4.min.js"></script>
   <script src="../PFA/js/bootstrap.min.js"></script>
   <script src="../PFA/js/ajax-utils.js"></script>
   <!-- <script>
   document.write('<script src="js/script.js?=dev' + Math.floor(Math.random() * 69) + '"\><\/script>');
   </script>
   <script>
   document.write('<link rel="stylesheet" href="css/styles.css?=dev' + Math.floor(Math.random() * 69) + '"\><\/>');
   </script> -->
   <script src="js/script.js"></script>
</body>

</html>