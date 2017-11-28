<?php
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
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
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
if (isset($_GET['date']))
{
      $date = $_GET['date'];
      $req = $bdd->prepare('SELECT date, data_temperature, UNIX_TIMESTAMP(CONCAT_WS(" ", data_date, data_heure)) AS datetime FROM test WHERE DATE(data_date) = :date ORDER BY data_date DESC, data_heure DESC');
      $test2 = strtotime($date);
      
      $req->bindParam(':date', $_GET['date']);
      $status = "Voici les données du $date";
  }
  else
  {  
      $date = date("Y-m-d");
      header('location:http://localhost/SmartHive/index.php?date='.$date.''); 
      $req = $bdd->prepare('SELECT date, data_temperature, UNIX_TIMESTAMP(CONCAT_WS(" ", data_date, data_heure)) AS datetime FROM test WHERE DATE(data_date) = :date ORDER BY data_date DESC, data_heure DESC');
      $req->bindParam(':date', $date);
      $status = "Voici les données du $date";
  }
      $req->execute();
      if ($donnees = $req->fetch() == 0){
          $date = $_GET['date'];
          $status = "Aucune donnée pour cette période ($date)";
      }
      $req->execute();
      $rows = array();
      $table = array();

      $table['cols'] = array(
          array(
           'label' => 'Date Time', 
           'type' => 'datetime'
          ),
          array(
          'label' => 'Temperature (°C)', 
          'type' => 'number'
          )
      );

    while($row = $req->fetch())
    {
      $sub_array = array();
      $datetime = explode(".", $row["datetime"]);
      $sub_array[] =  array(
        "v" => 'Date(' . $datetime[0] . '000)'
      );
      $sub_array[] =  array(
        "v" => $row["data_temperature"]
      );
      $rows[] =  array(
        "c" => $sub_array
      );
    }
    $table['rows'] = $rows;
    $jsonTable = json_encode($table);

    $req->closeCursor();
?>
<html lang="en">
  <head>
    <title>SmartHive</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
            <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="bootstrap-datepicker.js"></script> </head>
    <style type="text/css">

#dateRangeForm .form-control-feedback {
    top: 0;
    right: -15px;
}
</style>
    <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style> 
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">SmartHive</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">Accueil</a></li>
            <li><a href="table.php">Tableaux</a></li>
            <li class="active"><a href="">Graphique</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <sp    class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Test</li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                </ul>
            </li>
          </ul>
            <ul class="nav navbar-nav navbar-right">
          <li><a href="profil.php"><span class="glyphicon glyphicon-user"></span> <?= $_SESSION['auth']->username; ?></a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Se déonnecter</a></li>
            </ul>
        </div>
      </div>
    </nav>
    <div class="page-wrapper">
    <br></br><br></br>
   <h2 align="center"><?php echo $status;?></h2>
  <!--<form action='http://localhost/SmartHive/traitement.php' method="post">
 <p><input  class="form-control mx-sm-3" type="text" placeholder="Selectionner une date" id="example1" name="date"></input></p>
  <button type="submit" class="btn btn-primary">Rechercher</button>

</form>!-->
<form class="container" id="needs-validation" novalidate>
<div class="row">
  <div class="col-lg-3">
        <label for="validationCustom04">Date</label>
    <div class="input-group">

      <input type="text" class="form-control" name="date" id="example1" placeholder="Sélectionner une date">
      <span class="input-group-btn">
        <button class="btn btn-primary" type="submit">Rechercher</button>
      </span>
    </div>
  </div>
</div>
</form>
   <div id="line_chart" style="width: 100%; height: 500px"></div>
<?php 
if(isset($_POST['date']))
{
  $date_sel = $_POST['date'];
}
else{
  $date_sel = date("Y-m-d");

}
?>
  </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

    var options = {
     title:'Evolution Temperature',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

    chart.draw(data, options);
   }
  </script>
           <script type="text/javascript">
            $(document).ready(function () {
                
                $('#example1').datepicker({
                    autoclose: true,  
                    weekStart: 1,
                    format: "yyyy-mm-dd"
                });  
            
            });
        </script>
  </body>
</html>