<p>Bonjour !</p>

<p>DATE CHOISIE  <?php echo $_POST['date']; ?> !</p>
<?php      
  header('location:http://localhost/SmartHive/index.php?date='.$_POST['date']);   
?>