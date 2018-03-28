<?php
/*
* 
    Author : Silas riacourt <silasdu22@gmail.com>
*
*/ 
  require 'inc/functions.php';
  logged_only();
  if(!empty($_POST)){

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
      $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas";
    }else{
      $user_id = $_SESSION['auth']->id;
      $password= password_hash($_POST['password'], PASSWORD_BCRYPT);
      require_once 'inc/db.php';
      $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$password,$user_id]);
      $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour!";
    }

}
date_default_timezone_set('Europe/Paris');
try
{
  $bdd = new PDO('mysql:host=localhost;dbname=test2;charset=utf8', 'root', '');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
?>
</style>
    <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style> 
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <script src="inc/function.js"></script>
    <title>mysql+maps</title>
    <style>
      #map {
        height: 100%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
<?php require 'inc/header.php'; ?>
    <h2 align="center">Où se trouve votre ruche n°286235 ?</h2>
  <body>
      <h3 id="dev"></h3>
    <div id="map"></div>
  
    <script>
      var customLabel = {
        1: {
          label: '1'
        },
        2: {
          label: '2'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(48.1843903, -2.762291),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;
          downloadUrl('http://localhost/SmartHive/inc/convert.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var date = markerElem.getAttribute('date');
              var capteur = markerElem.getAttribute('capteur_id');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));
        //création boite qui contient les infos sur le point
        //div & test
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = "RUCHE n°286235"
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));
              var text = document.createElement('text');
              text.textContent = date
              infowincontent.appendChild(text);
              var icon = customLabel[capteur] || {};
              //Affichage des markers
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
                                document.getElementById("dev").innerHTML = point;
              //évenement pour détection le click sur le marker et afficher les infos sur celui-ci
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }
      doNothing();
      
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANFCjBuEsUO1o49ZVkXdukdZ2OLUfnajg&callback=initMap">
    </script>
  </body>
</html>

 <?php require 'inc/footer.php'; ?>