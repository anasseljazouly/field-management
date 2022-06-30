<?php
if (isset($_FILES['attachments'])) {
   $msg = "";
   var_dump($_FILES);
   $targetFile = "uploads/" . basename($_FILES['attachments']['name'][0]);
   if (file_exists($targetFile))
      $msg = array("status" => 0, "msg" => "File already exists!");
   else if (move_uploaded_file($_FILES['attachments']['tmp_name'][0], $targetFile))
      $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => $targetFile);

   // exit(json_encode($msg));
}
?>
<html>

<head>
   <title>jQuery File Upload Script</title>
   <style type="text/css">
   #dropZone {
      border: 3px dashed #0088cc;
      padding: 50px;
      width: 500px;
      margin-top: 20px;
   }

   #files {
      border: 1px dotted #0088cc;
      padding: 20px;
      width: 200px;
      display: none;
   }

   #error {
      color: red;
   }
   </style>
</head>

<body>
   <center>
      <br><br>
      <form action="image_upload_.php" enctype="multipart/form-data" method="post">

         <div id="dropZone">
            <h1>Drag & Drop Files...</h1>
            <input type="file" id="fileupload" name="attachments[]" multiple>
         </div>
      </form>
      <h1 id="error"></h1><br><br>
      <h1 id="progress"></h1><br><br>
      <div id="files"></div>
      <button id="btn-conf" value="Upload">submit</button>
   </center>

   <script src="http://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
   <script src="js_plugin_for_image/vendor/jquery.ui.widget.js" type="text/javascript"></script>
   <script src="js_plugin_for_image/jquery.iframe-transport.js" type="text/javascript"></script>
   <script src="js_plugin_for_image/jquery.fileupload.js" type="text/javascript"></script>
   <script type="text/javascript">
   var name = "";
   $(function() {
      var files = $("#files");

      $("#fileupload").fileupload({
         url: 'image_upload.php',
         dropZone: '#dropZone',
         dataType: 'json',
         autoUpload: false
      }).on('fileuploadadd', function(e, data) {
         var fileTypeAllowed = /.\.(gif|jpg|png|jpeg)$/i;
         var fileName = data.originalFiles[0]['name'];
         name = fileName;
         var fileSize = data.originalFiles[0]['size'];

         if (!fileTypeAllowed.test(fileName))
            $("#error").html('Only images are allowed!');
         else if (fileSize > 500000)
            $("#error").html('Your file is too big! Max allowed size is: 500KB');
         else {
            $("#error").html("");
            data.submit();
         }
      }).on('fileuploaddone', function(e, data) {
         var status = data.jqXHR.responseJSON.status;
         var msg = data.jqXHR.responseJSON.msg;
         console.log(data);
         if (status == 1) {
            var path = data.jqXHR.responseJSON.path;
            $("#files").fadeIn().append('<p><img style="width: 100px; height: 100px;" src="' + path +
               '" /></p>');
         } else
            $("#error").html(msg);
      })
   });
   $(document).ready(function() {
      $("#btn-conf").on("click", function(e) {
         // console.log("yes");
         e.preventDefault();
         // const selectedFile = document.getElementById('fileupload').files[0];
         // var file = $('#fileinput').prop('files')[0];
         // var fd = new FormData();
         // fd.append('theFile', file);
         // // "fd": fd,

         console.log(name);
         if (name != "") {
            $.post(
               "controllers/image_upload_.php", {
                  "file": "yes",
                  name: name,
               },
               function(data) {
                  console.log(data);
                  console.log("yes");
               }
            );
         } else {
            alert("pls enter file before submiting");
         }
      });
   });
   </script>
</body>

</html>