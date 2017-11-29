 <?php
/* 
    Author : Silas riacourt <silasdu22@gmail.com>
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
<?php require 'inc/header.php'; ?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
            <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
			<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
			<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
			<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
  
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
           
 <?php require 'inc/footer.php'; ?>
 <script>  
 $(document).ready(function() {
    $('#temperature_data').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/French.json"
        }
    } );
} );
 </script>  