<?php

  if(session_status() == PHP_SESSION_NONE){

  session_start();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>SmartHive</title>
      <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
            <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">

      <div class="container-fluid">

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
            <li><a href="login.php">Accueil</a></li>
            <li><a href="table.php">Tableaux</a></li>
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
            <?php if(isset($_SESSION['auth'])): ?>
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Se déonnecter</a></li>
            <?php else: ?>
              <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> S'inscrire</a></li>
              <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a></li>
             <?php endif; ?>
            </ul>
        </div>
      </div>
    </nav>

    <div class="container">

    <br></br><br></br>

    <?php if(isset($_SESSION['flash'])): ?>
      <?php foreach($_SESSION['flash'] as $type => $message):?>
        <div class="alert alert-<?= $type; ?>">
          <?= $message; ?>
        </div>
      <?php endforeach; ?>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>