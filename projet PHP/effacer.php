<?php
    // Connexion à la base
	$base = new mysqli('localhost', 'root', '', 'base_test_php');
	if ($base->connect_error) {
	    die("Erreur de connexion : " . $base->connect_error);
	}
    $nom_ok=$_GET["id"];

    // Requête préparée pour éviter les failles SQL
    $stmt = $base->prepare("DELETE FROM nom_table WHERE id=$nom_ok");
    $stmt->execute();
    header("Location:front2.php");
    $stmt->close();
?>