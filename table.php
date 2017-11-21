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
         		<li class="active"><a href="#">Tableaux</a></li>
         		<li><a href="index.php">Graphique</a></li>
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
           <div class="container">  
                <h3 align="center">Tableau temperature</h3>  
                <br></br>
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