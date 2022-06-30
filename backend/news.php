<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <title>News</title>
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
   <h2>news</h2>

   <form action="" method="post" id="form-news">
      <div id="title">
         <label for="title">Title</label>
         <input type="text" name="title" id="title" class="form-control form-control-lg">
      </div>
      <br><br>
   </form>
   <div id="editor"></div>

   <p><input type="button" id="submit" value="Submit"></p>

   <script>
   let editor;

   ClassicEditor
      .create(document.querySelector('#editor'))
      .then(newEditor => {
         editor = newEditor;
      })
      .catch(error => {
         console.error(error);
      });

   $(document).on('click', '#submit', function(event) {
      event.preventDefault();
      const editorData = editor.getData();
      var title = $("#form-news").serialize();
      console.log(title);
      $.post('controllers/news.php', {
         title: title,
         content: editorData
      }, function(data) {
         console.log(data);

      })
   });
   </script>
</body>

</html>