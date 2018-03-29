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
  $bdd = new PDO('mysql:host=localhost;dbname=ruche;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$result = $bdd->prepare('SELECT * FROM temperature ORDER BY data_date ASC');
$result->execute();
if (isset($_GET['date']))
{
      $date = $_GET['date'];
      $req = $bdd->prepare('SELECT data_temperature, UNIX_TIMESTAMP(CONCAT_WS(" ", data_date, data_heure)) AS datetime FROM temperature WHERE DATE(data_date) = :date ORDER BY data_date DESC, data_heure DESC');
      $test2 = strtotime($date);
      
      $req->bindParam(':date', $_GET['date']);
      $status = "Voici les données du $date";
  }
  else
  {  
      $date = date("Y-m-d");
      header('location:http://localhost/SmartHive/stats_temperature.php?date='.$date.''); 
      $req = $bdd->prepare('SELECT data_temperature, UNIX_TIMESTAMP(CONCAT_WS(" ", data_date, data_heure)) AS datetime FROM temperature WHERE DATE(data_date) = :date ORDER BY data_date DESC, data_heure DESC');
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
<?php require 'inc/header.php'; ?>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
    <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">            
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
    <script src="bootstrap-datepicker.js"></script> </head>
    <div class="page-wrapper">
    <h2 align="center"><?php echo $status;?></h2>
  <form class="container" id="needs-validation" novalidate>
    </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
              <p class="h4 font-weight-bold">Graphique temperature</p>
            </div>
            <div class="col-sm-4">
              <div class="input-group">
                <input type="text" class="form-control" name="date" id="example1" placeholder="Sélectionner une date">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit">Rechercher</button>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
<div class="container">
  <div id="line_chart" style="width: 100%; height: 480px"></div></div>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="container"> 
            <p class="h3 font-weight-bold">Tableau temperature</p>
        </div>
      </div>
    </div>
          <div class="container">
                <div class="table-responsive">  
                     <table id="temperature_data" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                    <td>Date</td>  
                                    <td>Heure</td>  
                                    <td>Temperature</td>  
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = $result->fetch()) 
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["data_date"].'</td>  
                                    <td>'.$row["data_heure"].'</td>  
                                    <td>'.$row["data_temperature"].'</td>  
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>
              </div>
            </div>
          </div>
           </div><br></br><br>
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
         <script>  
 $(document).ready(function() {
    $('#temperature_data').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"
        }
    } );
} );
 </script>  
 <?php require 'inc/footer.php'; ?>