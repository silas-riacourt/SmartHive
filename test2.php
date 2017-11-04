  <html>
  <head>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Heure', 'témpérature'],
          ['12', 17],
          ['13', 19],
          ['14', 22],
          ['15', 22],
          ['16', 23],
          ['17', 25],
          ['18', 21],
          ['19', 19],
          ['20', 16],
        ]);

var options = {
      title: 'Company Performance',
      curveType: 'function',
        hAxis: {
          title: 'Heure'
        },
        vAxis: {
          title: 'Temp'
        },
        legend: { 
          position: 'bottom' 
        }
      };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
  </script>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM temperature";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Jour: " . $row["jour"]. " - heure: " . $row["heure"]. " -Température: " . $row["temp"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
</head>
<body>
   <div id="curve_chart" style="width: 900px; height: 500px"></div>
</body>
</html>

