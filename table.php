 <?php
 try
{
  $bdd = new PDO('mysql:host=localhost;dbname=test2;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
      $result = $bdd->prepare('SELECT * FROM test ORDER BY data_date ASC');
      $result->execute();
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Tableaux</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      </head>  
      <body>  
           <br /><br />  
           <div class="container">  
                <h3 align="center">Tableau temperature</h3>  
                <br />  
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
      </body>  
 </html>  
 <script>  
 $(document).ready(function() {
    $('#temperature_data').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"
        }
    } );
} );
 </script>  