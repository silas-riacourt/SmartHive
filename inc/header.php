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
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
            <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
      <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css" type="text/css" /> 
            <link rel="stylesheet" href="css/ruche.css" type="text/css" /> 
            <link rel="stylesheet" href="css/test.css" type="text/css" /> 
            
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">

      <div class="container-fluid">

        <div class="navbar-header">
<ul class="nav navbar-nav">
          <li><a class="navbar-brand" href="index.php" style="padding:0 0 0 15px;"><img alt="" src="images/bee2.png" width="50px" /></a></li>
<li>
<a href="#menu-toggle" id="menu-toggle">
<span class="custom-icon-bar"></span>
<span class="custom-icon-bar"></span>
<span class="custom-icon-bar"></span>
</a>
</li>
</ul>
<a class="navbar-brand" href="#">SmartHive</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <!-- <li><a href="table.php">Tableaux</a></li> -->
            <!-- <li><a href="index.php">Graphique</a></li> -->
               <!-- <li class="dropdown">
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
                </li>-->
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
<br></br>
</div>
    <div class="container-fluid">
<div id="wrapper" class="">

<div id="sidebar-wrapper">
<ul class="sidebar-nav">
<br></br>
<li class="sidebar-brand">
<a id="menu-toggle" href="#menu-toggle">
Menu
</a>
</li>
<li class="nav-divider"></li>
<li>
<label label-default="" class="tree-toggler nav-header">Statistiques </label>
<ul class="nav  tree active-trial">
<li>
<a href="stats_temperature.php"><span><img alt="" class="sidebar-icon" src="images/final.png" /> Température</span></a>
</li>
<li>
<a href="stats_humidite.php"><span><img alt="" class="sidebar-icon" src="images/final.png" /> Humidité</span></a>
</li>
<li>
<a href="stats_masse.php"><span><img alt="" class="sidebar-icon" src="images/final.png" /> Masse</span></a>
</li>
</ul>
</li>
<li class="nav-divider"></li>
<li>
<label label-default="" class="tree-toggler nav-header">Capteurs </label>
<ul class="nav  tree active-trial">
<li>
<a href="temperature.php"><span><img alt="* " class="sidebar-icon" src="images/final.png" /> Température</span></a>
</li>
<li>
<a href="masse.php"><span><img alt="* " class="sidebar-icon" src="images/final.png" /> Poids</span></a>
</li>
<li>
<a href="humidite.php"><span><img alt="* " class="sidebar-icon" src="images/final.png" /> Humidité</span></a>
</li>
<li>
<a href="gps.php"><span><img alt="* " class="sidebar-icon" src="images/final.png" /> GPS</span></a>
</li>
</ul>
</li>
<li class="nav-divider"></li>
</ul>
</div>
    <br></br><br></br>
    <script src="css/bootstrap/js/jquery.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>

    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>


    <?php if(isset($_SESSION['flash'])): ?>
      <?php foreach($_SESSION['flash'] as $type => $message):?>
        <div class="alert alert-<?= $type; ?>">
          <?= $message; ?>
        </div>
      <?php endforeach; ?>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>