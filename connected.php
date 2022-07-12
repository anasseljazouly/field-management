<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ENSIAS</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
    <script>document.write('<link rel="stylesheet" href="css/styles.css?=dev'+ Math.floor(Math.random()*69)+'"\><\/>');
  </script>
  </head>
<body>
      <!-- <a href="snippets/nav-admin.html">dsqfsdf</a> -->
  <header>
    <div id="header-nav" >
      <div id="header-container"   class="container">
        <div id="navbar-header" class="navbar-header">
          <a href="#acceuil" onclick="$dc.loadBienvenu();" class="pull-left visible-md visible-lg">
            <div id="logo-img" alt="Logo image">
            </div>
          </a>
          <div id = "navbar-brand" class="navbar-brand">
            <a href="#acceuil" onclick="$dc.loadBienvenu();"><h1>ENSIAS</h1></a>
            <p>
              <span>Ecole Nationale Supérieure d'Informatique et d'Analyse des Systèmes</span>
            </p>
          </div>
        </div>  
      <div id="buttons" >

        <div id="id-name"></div>

        <a href="index.php" >
        <button type="button" id="deconnect-btn" onclick="$dc.logout();" class="btn btn-secondary btn-sm btn-block">
          Se deconnecter
        </button>
        </a>
      </div>
        <div>
          <!-- <div id="anass-img" class="rounded-circle" alt="anass image"></div> -->
          <img id="anass-img" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="anass-img" class="rounded-circle" 
  width="150">
        </div>
      </div><!-- .container -->
    </div><!-- #header-nav -->
  </header>
  <!-- Navbar -->
  <div id="connected-nav" ></div>

  <div id="main-content2" class="container"></div>

  <footer class="panel-footer">
    <div class="container">
      <div class="row">
        <section id="address" class="col-sm-6"><br>
          <span><span class="glyphicon glyphicon-home"></span> <strong> Addresse:</strong> </span><br>
          Avenue Mohammed Ben Abdallah Regragui, Madinat Al Irfane, BP 713, Agdal Rabat, Maroc
          <a href="https://www.google.com/maps/place/%C3%89cole+Nationale+Sup%C3%A9rieure+d'Informatique+et+d'Analyse+des+Syst%C3%A8mes/@33.9842348,-6.8676459,17z/data=!4m5!3m4!1s0xda76ce7f9462dd1:0x2e9c39cfa1d9e8d7!8m2!3d33.9843118!4d-6.8676019?hl=fr" target="_blank">
          <div id="map-tile">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3308.3230599887574!2d-6.867645930909817!3d33.984234839256125!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda76ce7f9462dd1%3A0x2e9c39cfa1d9e8d7!2s%C3%89cole%20Nationale%20Sup%C3%A9rieure%20d&#39;Informatique%20et%20d&#39;Analyse%20des%20Syst%C3%A8mes!5e0!3m2!1sfr!2sma!4v1623932931535!5m2!1sfr!2sma"
            width="600" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
        </a>
          <hr class="visible-xs">
        </section>
        <section id="testimonials" class="col-sm-6">
        <br>
          <p> <strong>Télécopie :</strong>  <span class="glyphicon glyphicon-earphone"></span> <a href="tel:05 37 68 60 78">05 37 68 60 78</a> <br><br>

            <strong>Secrétariat de direction : </strong>  <span class="glyphicon glyphicon-earphone"></span>
            <a href="tel:06 61 48 10 97"> 06 61 48 10 97 </a><br> <br>
          
            <strong>Secrétariat général : </strong>  <span class="glyphicon glyphicon-earphone"></span> <a href="tel:06 61 34 09 27">06 61 34 09 27</a> <br> <br>
          
             <strong>Service des affaires financières : </strong>  <span class="glyphicon glyphicon-earphone"></span>
             <a href="tel:06 61 44 76 79"> 06 61 44 76 79</a> <br> <br>
          
             <strong>Service des affaires estudiantines : </strong>  <span class="glyphicon glyphicon-earphone"></span>
             <a href="tel:06 62 77 10 17"> 06 62 77 10 17</a> <br>
             <span class="glyphicon glyphicon-globe"></span><a href="mailto:n.mhirich@um5s.net.ma"> n.mhirich@um5s.net.ma
                 </a> <br><br>
          
             <strong> Résidences : </strong>  <span class="glyphicon glyphicon-earphone"></span>
            <a href="tel:06 61 82 89 77"> 06 61 82 89 77 </a>
          </p>
        </section>
      </div>
      <div class="text-center">&copy;AO</div>
    </div>
  </footer>

  <!-- jQuery (Bootstrap JS plugins depend on it) -->
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ajax-utils.js"></script>
  <script src="js/script.js"></script>
  <script>document.write('<script src="js/script.js?=dev'+ Math.floor(Math.random()*69)+'"\><\/script>');
  </script>
<!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
</body>
</html>
