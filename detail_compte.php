<?php
	session_start();

	echo "hello world</br>";
	echo $_GET["compte"]."</br>";
	$moncompte_id = $_GET["compte"];
	$params = $_GET['compte'];
	echo "Vos opérations liés au compte</br>";
		
	// On va afficher toutes les opérations lié à ce compte
	$mysqli = mysqli_connect("localhost", "root", "root", "compte_client");
	$cart = array();
	
    if(!$mysqli){
        echo "Erreur de connexion à la base de données.";
    } else {
		$Requete = mysqli_query($mysqli,"SELECT * FROM operation o LEFT JOIN tag_operation tp on tp.id_operation = o.id_op WHERE o.id_compte_client = ".$moncompte_id);
		if(mysqli_num_rows($Requete) == 0) {
			
        } else {
			while($donnees = $Requete->fetch_array(MYSQL_ASSOC)){			
					echo "<li>" . $donnees['libelle_op'] . " || " . $donnees['date_op'] . " || " . $donnees['montant_op'] . " EUR </li>";
					array_push($cart, $donnees['id_type_operation']);
				}
		}
	}
	
	echo "</br>";
	echo "Vision site marchand </br>";
	
	// On va se connecter sur la base de données contenant les informations d'achats du client
	$mysqli = mysqli_connect("localhost", "root", "root", "site_vente");
	
	if(!$mysqli){
        echo "Erreur de connexion à la base de données.";
    } else {
		for ($j = 0; $j < sizeof($cart); $j++)
		{
			$new = mysqli_query($mysqli,"SELECT * FROM produit where id_type_produit = '".$cart[$j]."'");
			if(mysqli_num_rows($new) == 0) { 
				echo "Aucun achat trouvé par rapport à l'utilisateur.";
			} else {
				// on ouvre la session avec $_SESSION:
				// on récupére les informtations lier au panier 
				$i = 0;
				while($donnees = $new->fetch_array(MYSQL_ASSOC))
				{
					print_r($donnees);
					echo "</br>";
					$i++;
				}
			}
		}
		
	}
