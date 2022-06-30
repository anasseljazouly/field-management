<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <title>Document</title>
</head>

<body>
   <form action="test2.php" enctype="multipart/form-data" method="post">
      <input id="fileinput" type="file" name="upload" accept=".png,.gif,.jpg,.jpeg" required>
      <button id="btn-conf" value="Upload">submit</button>


   </form>

   <script>
   $(document).ready(function() {
      $("#btn-conf").on("click", function(e) {


         e.preventDefault();
         const selectedFile = document.getElementById('fileinput').files[0];
         // var file = $('#fileinput').prop('files')[0];
         // var fd = new FormData();
         // fd.append('theFile', file);
         // // "fd": fd,

         console.log(selectedFile);
         $.post(
            "./test2.php", {
               "file": "yes",
               // "xd": fd,
               ar: JSON.stringify({
                  selectedFile: selectedFile
               }),
               path: selectedFile.webkitRelativePath
            },
            function(data) {
               // data = JSON.parse(data);
               console.log(data);
               console.log("yes");


            }
         );
      });


      // $(function() {
      //    $('#fileinput').change(function() {
      //       var props = $('#fileinput').prop('fileinput'),
      //          file = props[0]
      //       alert(file.name)
      //       alert(file.size)
      //       alert(file.type)
      //    })
      // })
   });
   </script>
</body>

</html>