<?php
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
      $date = date("Y-m-d");
      echo 'Bonjour voici les données pour ' . $_GET['date'] . ' H!<br />';
      $req = $bdd->prepare('SELECT date, data_temperature, UNIX_TIMESTAMP(CONCAT_WS(" ", data_date, data_heure)) AS datetime FROM test WHERE DATE(data_date) = :date ORDER BY data_date DESC, data_heure DESC');
      $test2 = strtotime($date);
      $req->bindParam(':date', $_GET['date']);
  }
  else
  {
    echo 'Il faut renseigner une date';
      $req = $bdd->prepare('SELECT date, data_temperature, UNIX_TIMESTAMP(CONCAT_WS(" ", data_date, data_heure)) AS datetime FROM test ORDER BY data_date DESC, data_heure DESC');
  }
      $req->execute();
      if ($donnees = $req->fetch() == 0){
          echo "Aucune donnée pour cette période";
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
<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
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
  <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style>
 </head>  
 <body>
  <div class="page-wrapper">
   <br />
   <h2 align="center"><?php echo $_GET['date'];?></h2>
   <div id="line_chart" style="width: 100%; height: 500px"></div>
    <p>Choisir une date: <input type="text" id="datepicker"></p>
  </div>
 </body>
</html>