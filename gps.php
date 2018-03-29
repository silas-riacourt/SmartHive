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

<div class="container">
<?php
    $alert_r = 1;
    if($alert_r == 1){
      $alert_message = "Les mots de passes ne correspondent pas";
      echo '
<div class="alert alert-info">
  <strong>Info!</strong> Vous avez (1) nouvelle alerte.
</div>
<div class="alert alert-danger">
  <strong>ALERTE!</strong> La ruche à été déplacer le 29/03/2018 à 19h23 !
</div>
      ';
    }else{
      echo '
<div class="alert alert-info">
  <strong>Info!</strong> Vous navez aucune noubelle alerte.
</div>
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
          <span class="dash-box-count">17°C</span>
          <span class="dash-box-title">Température</span>
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
          <span class="dash-box-count">75%</span>
          <span class="dash-box-title">Humidité</span>
        </div>
        
        <div class="dash-box-action">
          <a href="temperature.php" class="button">Détails</a>
        </div>        
      </div>
    </div>
  </div>
</div>
 <?php require 'inc/footer.php'; ?>