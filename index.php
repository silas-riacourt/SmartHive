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
 <?php require 'inc/header.php'; ?>
       <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
            <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="bootstrap-datepicker.js"></script> </head>
    <div class="page-wrapper">
   <h2 align="center"><?php echo $status;?></h2>
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
   <div id="line_chart" style="width: 100%; height: 480px"></div>
<?php 
if(isset($_POST['date']))
{
  $date_sel = $_POST['date'];
}
else{
  $date_sel = date("Y-m-d");

}
?>

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
     chartArea:{width:'95%', height:'65%'},
     colors: ['#ebbc14']
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
 <?php require 'inc/footer.php'; ?>