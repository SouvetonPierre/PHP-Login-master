<?php
session_start(); // à mettre tout en haut du fichier .php, cette fonction propre à PHP servira à maintenir la $_SESSION

print_r($_SESSION['data']);

echo "</br>";
echo "</br>";	

$url = "https://api.fixer.io/latest";
$json = json_decode(file_get_contents($url), true);
$price = $json["rates"]["USD"];
echo $price;
echo "</br>";

// Info Bitcoin / Dollar
echo "BTCUSD</br>";
$url = "https://api.bitfinex.com/v1/ticker/BTCUSD";
$json = json_decode(file_get_contents($url), true);
$price_btcusd = $json["last_price"];
echo $price_btcusd;
	
echo "</br>";

// Info Bitcoin / Euro	
echo "BTCEUR</br>";
$url = "https://api.bitfinex.com/v1/ticker/BTCEUR";
$json = json_decode(file_get_contents($url), true);
$price_btceur = $json["last_price"];
echo $price_btceur;

echo "</br>";

// Info Ethereum / Dollar	
echo "ETHUSD</br>";
$url = "https://api.bitfinex.com/v1/ticker/ETHUSD";
$json = json_decode(file_get_contents($url), true);
$price_ethusd = $json["last_price"];
echo $price_ethusd;

echo "</br>";

// Info Ethereum / Euro	
echo "ETHEUR</br>";
$price_etheur = $price_ethusd / $price;
echo $price_etheur;

echo "</br>";

$id_cc = $_SESSION['data']['id_cc'];
echo "</br>";

    //on vérifie que la connexion s'effectue correctement:
$mysqli = mysqli_connect("localhost", "root", "root", "compte_client");

	// On affiche dans un premier temps tous les comptes non cryptocurrencies
	echo "Mes comptes</br>";
    if(!$mysqli){
        echo "Erreur de connexion à la base de données.";
    } else {
		$Requete = mysqli_query($mysqli,"SELECT * FROM compte c LEFT JOIN monnaie m on m.id_monnaie = c.id_monnaie WHERE id_compte_bc = '".$id_cc."' AND id_type_compte <> 2");
		if(mysqli_num_rows($Requete) == 0) {
            echo "Aucun compte trouvé par rapport à l'utilisateur.";
        } else {
            // on ouvre la session avec $_SESSION:
			$i = 0;
			while($donnees = $Requete->fetch_array(MYSQL_ASSOC))
			{
				// on va afficher les informations comptes 
				echo "<li><a href=detail_compte.php?compte=".$donnees['id_compte'].">"
				.$donnees['libelle_bc']."</a> || ".$donnees['solde_compte']." || "
				.$donnees['libelle_monnaie']."</li></br>";
			}
        }
	}
	
	// On affiche dans un premier temps tous les comptes non cryptocurrencies
    echo "Mes comptes crypto-monnaies</br>";
	if(!$mysqli){
        echo "Erreur de connexion à la base de données.";
    } else {
		$Requete = mysqli_query($mysqli,"SELECT * FROM compte c LEFT JOIN monnaie m on m.id_monnaie = c.id_monnaie WHERE id_compte_bc = '".$id_cc."' AND id_type_compte = 2");
		if(mysqli_num_rows($Requete) == 0) {
            echo "Aucun compte trouvé par rapport à l'utilisateur.";
        } else {
            // on ouvre la session avec $_SESSION:
			$i = 0;
			while($donnees = $Requete->fetch_array(MYSQL_ASSOC))
			{
				// on va afficher les informations comptes 
				echo "<li><a href=detail_compte.php?compte=".$donnees['id_compte'].">".$donnees['libelle_bc']."</a> || ".$donnees['solde_compte']." || ".$donnees['libelle_monnaie']."</li></br>";
			}
        }
	}

	


