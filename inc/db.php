/* 
    Author : Silas riacourt <silasdu22@gmail.com>
*/ 
<?php
$host = "localhost";
$dbname= "web1";
$pdo = new PDO("mysql:dbname=$dbname;host=$host", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
