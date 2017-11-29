/* 
    Author : Silas riacourt <silasdu22@gmail.com>
*/ 
<?php
session_start();
setcookie('remember', NULL, -1);
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous êtes maintenant déconnecté';
header('Location: login.php');