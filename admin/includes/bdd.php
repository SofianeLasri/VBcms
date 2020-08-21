<?php
include 'config.php';
try {
    $bddConn = new PDO("mysql:host=$bddHost;dbname=$bddName", $bddUser, $bddMdp); //Test de la connexion
    $bddConn = null;
} catch (PDOException $e) { 
	$bddError = true;
	print "Erreur !: " . $e->getMessage() . "<br/>";
	die();
}
if (!isset($bddError)){
	$bdd = new PDO("mysql:host=$bddHost;dbname=$bddName", $bddUser, $bddMdp);
	$bdd->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	$bdd->query("SET NAMES 'utf8'");
}
?>