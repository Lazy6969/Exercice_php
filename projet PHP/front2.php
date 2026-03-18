<?php
	// Connexion à la base
	$base = new mysqli('localhost', 'root', '', 'base_test_php');
	if ($base->connect_error) {
	    die("Erreur de connexion : " . $base->connect_error);
	}
	

	// Insertion des données
	if (isset($_POST['envoyer'])) {
	    $nom = $_POST['nom'];
	    $prenom = $_POST['prenom'];
	
	    // Requête préparée pour éviter les failles SQL
	    $stmt = $base->prepare("INSERT INTO nom_table (Nom, Prenom) VALUES (?, ?)");
	    $stmt->bind_param("ss", $nom, $prenom);
	    $stmt->execute();
	    $stmt->close();
	
	    // Redirection pour éviter la duplication après actualisation
	    header("Location: " . $_SERVER['PHP_SELF']);
	    exit();
	}
	

	// Recherche
	$recherche = "";
	if (isset($_GET['search'])) {
	    $recherche = $_GET['search'];
    $stmt = $base->prepare("SELECT * FROM nom_table WHERE Nom LIKE ? OR Prenom LIKE ? OR Id LIKE ? ");
	    $like = "%" . $recherche . "%";
		$nbre=$recherche;

	    $stmt->bind_param("ssi", $like, $like,$nbre);
    $stmt->execute();
	    $donnee = $stmt->get_result();
	} else {
	    $donnee = $base->query("SELECT * FROM nom_table");
	}

	
	// Recherche tous
	if (isset($_GET['afficher'])) {	
		$donnee = $base->query("SELECT * FROM nom_table");
	}

?>
	<!DOCTYPE html>
	<html lang="fr">
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Formulaire PHP</title>
		<link rel="stylesheet" href="css.css">

	</head>
	<body>
	<center>
    <div id=div1>
	        <h1>Formulaire test PHP</h1>
       <form method="post" id="autorisation">
       <table>
                <tr>
                    <td><label>Nom :</label></td>
                    <td><input type="text" name="nom" placeholder="Entrer votre nom..." required><br><br></td>
                </tr>
                <tr>
                    <td><label>Prénom :</label></td>                 
                    <td><input type="text" name="prenom" placeholder="Entrer votre prénom..." required><br><br></td>
                </tr>
            </table>
	                   
            <button name="envoyer" onclick="tyty()">ENVOYER</button>
			
	            <button type="reset">EFFACER</button>
	        </form>

			<script type="text/javascript">
				function tyty(){
								const mo=document.getElementById("autorisation");            
								const a=mo.elements[0].value; 
								const v=mo.elements[1].value;
								confirm(a+" "+v+" a été ajouté avec succès");

								}
			</script>
    </div>
	<br>
	
	    <!-- Barre de recherche -->
	    <form method="get">
        <input type="text" name="search" style="width:530px;height:60px" placeholder="Rechercher..." value="<?= htmlspecialchars($recherche) ?>" >
        <button type="submit">RECHERCHER</button>
	    </form>
		<form method="get">
		<button type="submit">AFFICHER TOUS</button>
		</form>
	<br>
        <div id="div2">
			<table>
					<tr>
						<th class='td2'>Client(s)</th>
						<th class='td2'>Id</th>
						<th class='td2'>Nom</th>
						<th class='td2'>Prénom</th>
						<th class='td2'>Effacer</th>
					</tr>
				
				<?php
				$i=0;			
				$e=1;	
					while ($ligne = $donnee->fetch_assoc()) {
						$i++;
					echo "<tr>
								<td class='td3'> <center>Client numéro " .$e++. "</center></td>
								<td class='td1'> <center>USER-" . $ligne['Id'] . "/ISSTM</center></td>
								<td class='td1'> <center>" . htmlspecialchars($ligne['Nom']) . "</center></td>
								<td class='td1'> <center>" . htmlspecialchars($ligne['Prenom']) . "</center></td>
								<td class='td1'><center> 
									<a href='effacer.php?id=".$ligne['Id']."'><button>Effacer</button></a> 
									<a href='modifier.php?id=".$ligne['Id']."'><button>Modifier</button></a>
												</center>
								</td>
						   </tr>";
				
					}
					if($i==0){
						echo"<h3>Aucune donnée enregister dans la base</h3>";
					}else{
						echo"<h4>Nombre d'information(s) : ".$i."</h4>";
					}
				?>    
			</table>
    	</div>
	</center>
	</body>
	</html>