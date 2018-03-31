<?php
/*
* 
    Author : Silas riacourt <silasdu22@gmail.com>
*
*/ 
  require 'inc/functions.php';
  logged_only();
date_default_timezone_set('Europe/Paris');
try
{
  $bdd = new PDO('mysql:host=localhost;dbname=ruche;charset=utf8', 'root', '');
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}
if(isset($_POST['alert_id'])){
    $update = $bdd->prepare('UPDATE alert SET alert_status=1 WHERE alert_id = :id');
    $update->bindValue('id',$_POST['alert_id']);
    $update->execute();
}
      $req = $bdd->prepare('SELECT * FROM temperature ORDER BY data_id DESC LIMIT 1');
      $req->execute();
                          while($row = $req->fetch()) 
                          {  

                                    $temperature_data_id = $row["data_id"];
                                    $temperature_data_date = $row["data_date"];
                                    $temperature_data_heure = $row["data_heure"];
                                    $temperature_data_temperature = $row["data_temperature"];


                          }
      $date_temperature = date_parse($temperature_data_date);
      $req = $bdd->prepare('SELECT * FROM humidity ORDER BY data_id DESC LIMIT 1');
      $req->execute();
                          while($row = $req->fetch()) 
                          {  

                                    $humidity_data_id = $row["data_id"];
                                    $humidity_data_date = $row["data_date"];
                                    $humidity_data_heure = $row["data_heure"];
                                    $humidity_data_humidity = $row["data_humidity"];

         

                          }
    $date_humidity = date_parse($humidity_data_date);
      $req = $bdd->prepare('SELECT * FROM alert WHERE alert_status != 1  ORDER BY alert_id ');
      $req->execute();
      $count = 0;
                          while($row = $req->fetch()) 
                          {  
                                    $alert_text= $row["alert_text"];
                                    $alert_date = $row["alert_date"];
                                    $alert_heure = $row["alert_heure"];
                                    $alert_id = $row["alert_id"];
                                    $alert_lat = $row["alert_latitude"];
                                    $alert_lng = $row["alert_longitude"];
                                    $count++;

                          }
      $req->execute();
?>
</style>
    <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style>
  <link rel="stylesheet" href="css/dashboard.css" type="text/css" /> 
  <?php require 'inc/header.php'; ?>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
  <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="bootstrap-datepicker.js"></script> </head>
    <div class="page-wrapper">
    </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="container"> 
            <center><p class="h3 font-weight-bold">Tableau de bord</p></center>
        </div>
      </div>
    </div>
<script>


var latlng = "<?php echo $alert_lat; ?>, <?php echo $alert_lng; ?>";
var url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + latlng + "&sensor=false";
$.getJSON(url, function (data) {
        var adress = data.results[0].formatted_address;
        document.getElementById("dev").innerHTML = adress;
});
</script>
<div class="container">
<?php
     //$a_adress = echo "<script> document.write(adress); </script>";
      if ($row = $req->fetch() == 0){//Alors aucune alerte
        echo '
          <div class="alert alert-info">
            <i class="glyphicon glyphicon-info-sign"></i><strong>Info:</strong> Vous n\'avez aucune nouvelle alerte!
          </div>
        ';
      }
      else{
        echo '
          <div class="alert alert-info">
            <i class="glyphicon glyphicon-info-sign"></i><strong> Info:</strong> Vous avez <strong>(' . $count . ')</strong> nouvelle(s) alerte<strong>!</strong>
          </div>
          <form action="" method="post">
            <div class="alert alert-danger">
              <i class="glyphicon glyphicon-exclamation-sign"></i><strong> ALERTE:</strong> ' . $alert_text . ' a proximiter de <strong id="dev"></strong> le <strong>' . $alert_date . '</strong> à <strong>' . $alert_heure . ' !</strong>
              <input type="hidden" name="alert_id" value="' . $alert_id . '"/>
              <button href="gps.php" type="submit" class="btn btn-danger">ok!</button>
            </div>
          </form>
        ';
      }
?>
  <div class="row">
    <div class="col-md-4">
      <div class="dash-box dash-box-color-1">
        <div class="dash-box-icon">
          <i class="glyphicon glyphicon-cloud"></i>
        </div>
        <div class="dash-box-body">
          <span class="dash-box-count"><?php echo $temperature_data_temperature;?>°C</span>
          <span class="dash-box-title">Température (le <?php echo $date_temperature['day'];?>-<?php echo $date_temperature['month']?>-<?php echo $date_temperature['year']?> à <?php echo $temperature_data_heure;?>)</span>
        </div>
        
        <div class="dash-box-action">
          <a href="temperature.php" class="button">Détails</a>
        </div>        
      </div>
    </div>
    <div class="col-md-4">
      <div class="dash-box dash-box-color-2">
        <div class="dash-box-icon">
          <i class="glyphicon glyphicon-oil"></i>
        </div>
        <div class="dash-box-body">
          <span class="dash-box-count">--,-- Kg</span>
          <span class="dash-box-title">Masse</span>
        </div>
        
        <div class="dash-box-action">
          <a href="humidite.php" class="button">Détails</a>
        </div>        
      </div>
    </div>
    <div class="col-md-4">
      <div class="dash-box dash-box-color-3">
        <div class="dash-box-icon">
          <i class="glyphicon glyphicon-tint"></i>
        </div>
        <div class="dash-box-body">
          <span class="dash-box-count"><?php echo $humidity_data_humidity;?>%</span>
          <span class="dash-box-title">Humidité (le <?php echo $date_humidity['day'];?>-<?php echo $date_humidity['month']?>-<?php echo $date_humidity['year']?> à <?php echo $humidity_data_heure;?>)</span>
        </div>
        
        <div class="dash-box-action">
          <a href="temperature.php" class="button">Détails</a>
        </div>        
      </div>
    </div>
  </div>
</div>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANFCjBuEsUO1o49ZVkXdukdZ2OLUfnajg">
    </script>
 <?php require 'inc/footer.php'; ?>