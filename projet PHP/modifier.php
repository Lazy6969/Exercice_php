<?php
    // Connexion à la base
	$base = new mysqli('localhost', 'root', '', 'base_test_php');
	if ($base->connect_error) {
	    die("Erreur de connexion : " . $base->connect_error);
	}

 
    if (isset($_POST['envoyer'])) {

        $id=$_GET["id"];
        $new_nom=$_POST["new_nom"];
        $new_prenom=$_POST["new_prenom"];
	
	    // Requête préparée pour éviter les failles SQL
        $sql="UPDATE nom_table SET Nom = ?,Prenom = ? WHERE id = $id";
        $stmt=$base->prepare($sql);
        $stmt->bind_param("ss",$new_nom,$new_prenom);

        //TESTE R2USSI
        if($stmt->execute()){
            echo"Modification réussi ! <a href='projet PHP/front2.php?id=$val'<button>RETOUR</button></a>";
        }else{
            echo"Erreur de la modification";
        }
        header("Location:front2.php");
	    exit();
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css.css">
</head>
<body><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<center>
    <div id=div1>
	        <h1>CHANGEMENT D'INFORMATIONS</h1>
       <form method="post" id="autorisation">
       <table>
                <tr>
                    <td><label>Nouveau nom :</label></td>
                    <td><input type="text" name="new_nom" placeholder="Entrer le nouveau nom..." ><br><br></td>
                </tr>
                <tr>
                    <td><label>Nouveau prénom :</label></td>                 
                    <td><input type="text" name="new_prenom" placeholder="Entrer le nouveau prénom..." ><br><br></td>
                </tr>
            </table>
	                   
            <button name="envoyer" onclick="tyty()">CHANGER</button>
			
	            <button type="reset">EFFACER</button>
	        </form>

			<script type="text/javascript">
				function tyty(){
								const mo=document.getElementById("autorisation");            
								const a=mo.elements[0].value; 
								const v=mo.elements[1].value;
								confirm(a+" "+v+" a été modifier avec succès");

								}
			</script>
    </div>
</center>
</body>
</html>