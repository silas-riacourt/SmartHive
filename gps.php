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
 <?php require 'inc/header.php'; ?>
       <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
            <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="bootstrap-datepicker.js"></script> </head>
    <div class="page-wrapper">
      </div>

 <?php require 'inc/footer.php'; ?>