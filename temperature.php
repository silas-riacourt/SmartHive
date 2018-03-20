
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
  $bdd = new PDO('mysql:host=localhost;dbname=test2;charset=utf8', 'root', '')
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}
      $result = $bdd->prepare('SELECT * FROM test ORDER BY data_id DESC LIMIT 1');
      $result->execute();
                          while($row = $result->fetch()) 
                          {  

                                    $data_id = $row["data_id"];
                                    $data_date = $row["data_date"];
                                    $data_heure = $row["data_heure"];
                                    $data_temperature = $row["data_temperature"];

         

                          }  
require 'inc/header.php';
?>
        <div class="container">
            <div class="container-fluid">
           			 <?php $date = date_parse($data_date);?>	
            		<h1>Dernière témpérature : <?php echo $data_temperature;?>°C enregistrer à <?php echo $data_heure;?> Le <?php echo $date['day'];?>-<?php echo $date['month']?>-<?php echo $date['year']?>
            			
            		</h1>
            </div>



        </div>
*-