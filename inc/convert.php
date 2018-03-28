<?php
#BUT    : récupérer les données en BDD afin de les exporter au format XML
#		: - connection à la BDD - récupération de la table entière (période sélectionable)
#		: - utiliser la fonction DOM de php pour exporter les données en un fichier XML
#		: - création d'un fichier XML

require("bdd.php");
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=gps;charset=utf8', 'root', '');
	}
	catch(Exception $e)
	{	
        die('Erreur : '.$e->getMessage());
	}

	$req = $bdd->prepare('SELECT * FROM coords WHERE 1');
	$req->execute();
	if ($donnees = $req->fetch() == 0){
		$status = "erreur aucune donnée";
		}
	else{
		$status = "données recupéres avec succès";
		}
	$req->execute();   




header("Content-type: text/xml");



while ($row = $req->fetch()){

  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("capteur_id",$row['capteur_id']);
  $newnode->setAttribute("date", $row['datetime']);
  $newnode->setAttribute("lat", $row['latitude']);
  $newnode->setAttribute("lng", $row['longitude']);
  $newnode->setAttribute("alt", $row['altitude']);
}

echo $dom->saveXML();

?>

