<?php

/* 
 *             2017-2018
 * Author : Silas riacourt <silasdu22@gmail.com>
 * 
 */
$host = "localhost";
$dbname= "ruche";
$user= "root";
$pass= "";

try
{
    $bdd = new PDO("mysql:dbname=$dbname;host=$host", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}
