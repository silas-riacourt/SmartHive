<?php

/* 
 *             2017-2018
 * Author : Silas riacourt <silasdu22@gmail.com>
 * 
 */
  require 'inc/functions.php';
  logged_only();
date_default_timezone_set('Europe/Paris');
require 'inc/db.php';
?>
<style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
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
<script src="inc/function.js"></script>
</head>
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