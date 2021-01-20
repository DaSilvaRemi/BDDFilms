<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Insert</title>
</head>

<body>
	<h2>Page d'insertion Automatisées</h2>

	<?php

	$nompage = "Filmpart.csv"; //On ouvre le fichier CSV
	/* Nous précisons que nous avons un fichier CSV uniquement avec les informations qu'on trouve utile cf MCD et CSV*/
	$monfichier = fopen($nompage, 'r+');

	require "input.php";
	$x = 0;
	while ($x == 0) {

		$data = fgetcsv($monfichier, 2500); // On lit chaque ligne formatée en CSV ayant 2500 char maxi

		if (empty($data)) {
			break;
		} else {
			$tab = $data; //Nous mettons data dans tab car c'est un tableau

			/* -------------------------------------------------------Film--------------------------------------------- */

			//Titre Original
			$Titre = $tab[0];

			if (!empty($tab[1])) {
				$TitreFr = $tab[1];
			} else {
				$TitreFr = "";
			}
			/*-------------------------------Genre-------------------------*/


			$Genre = "";
			if (!empty($tab[5])) {	//On vérifie que les données de genre ne sont pas vide
				$tabGenre = explode(" ", $tab[5]); //On sépare les différents genre

				for ($i = 0; $i < count($tabGenre); $i++) {

					$Genre = $Genre . $tabGenre[$i] . ","; //On concatène la données pour quelle soit prète à être envoyé
				}
			} else {
				$Genre = "Aucun,";
			}

			/*-------------------------------Scénario-------------------------*/
			if (!empty($tab[9])) {
				$tabscenario = explode("+", $tab[9]); //Ici on sérare les différents auteurs du scenario
				$scenario = "";

				if (count($tabscenario) > 1) {
					for ($i = 0; $i < count($tabscenario) - 1; $i++) {
						$scenario = $scenario . " " . $tabscenario[$i] . "," . $tabscenario[$i + 1]; //On concatène la données pour quelle soit prète à être envoyé
					}
				} else {
					$scenario = $tabscenario[0];
				}
			} else {
				$scenario = "";
			}
			/*-------------------------------Remarque-------------------------*/
			if (!empty($tab[8])) {
				$Note = $tab[8];
			} else {
				$Note = "";
			}

			/*-------------------------------Année-------------------------*/
			$AnneePays = explode("/", $tab[3]);
			$Annee = $AnneePays[0]; //Ici on récupère l'année en ne gardant pas le nombre de fois vue
			/*---------------------Cocaténation Data---------------------------*/
			$datafilm = array($Titre, $TitreFr, $Genre, $scenario, $Note, $Annee); //Ici on fait un tableau des différentes données d'un film pour être plus simple à envoyé

			/* -------------------------------------------------------Producteurs--------------------------------------------- */
			if (!empty($tab[4])) {
				if (strpos($tab[4], "/") == FALSE) { //Ici on vérifie que sur le champ producteur il a bien un / pour séparer 
					$tab[4] = "/" . $tab[4]; //Sinon on n'en met un
				}

				$Prod = explode("/", $tab[4]);

				$nomstudio = $Prod[1]; //Nom Studio

				$listenom = "";
				$listeprenom = "";

				if (strpos($nomstudio, "(") != FALSE) { //Ici on vérifie ci il ya des producteurs ou non caractériser par un ()

					$tabprod = explode("(", $nomstudio); //On sépare les producteurs du nom du studio
					$nomstudio = $tabprod[0];
					unset($tabprod[0]); //On éfface le nom du studio

					$tabprod = explode("+", $tabprod[1]); //Ici on sépare les différents producteurs

					$i = count($tabprod) - 1;
					$mem = explode(")", $tabprod[$i]); //Ici on efface la deuxième )
					$tabprod[$i] = $mem[0] . " " . $mem[1]; //Puis on concatène les noms
					$j = 0;

					for ($i = 0; $i < count($tabprod); $i++) {
						$dataprod = explode(" ", $tabprod[$i]);

						/* Nous avons remarqué que à partir du deuxième producteurs il y'avait des espace après le séparateurs alors que le premier n'en as pas*/
						if ($j == 0) { //Nous récupérons le premier producteur
							$listenom = $listenom . $dataprod[1] . ",";
							$listeprenom = $listeprenom . $dataprod[0] . ",";
						} else if (!empty($dataprod[2]) || !empty($dataprod[1])) { //Ici on vérifie qu'il y'a un 2ème producteur $dataprod[0] correspond à l'espace
							$listenom = $listenom . $dataprod[2] . ",";  //Ici c'est de la concaténation des noms
							$listeprenom = $listeprenom . $dataprod[1] . ","; //Ici c'est de la concaténation des prénoms
						} else {
							$listenom = $listenom . "";
							$listeprenom = $listeprenom . "";
						}
						$j++;
					}
				} else {
					$listenom = "Aucun"; //Si nous n'avons pas de producteurs nous mettons au moins un nom pour les identifier
					$listeprenom = "";
				}
			} else {
				$nomstudio = "Aucun"; //Si nous n'avons pas de nom de studio nous mettons au moins un nom pour l'identifier'
			}
			/*---------------------Cocaténation Data---------------------------*/
			$tableprod = array($listenom, $listeprenom);  //Nous créons un tableau spécialement pour les noms et prénoms
			$dataprod = array($tableprod, $nomstudio); //Comme pour film nous créons un tableau avec les différentes données

			/*--------------------------------------------------------Réal----------------------------------------------*/

			//Pareil que producteurs
			$tabReal = explode("+", $tab[2]);
			$listenom = "";
			$listeprenom = "";
			$j = 0;

			for ($i = 0; $i < count($tabReal); $i++) {
				$datareal = explode(" ", $tabReal[$i]);

				if ($j == 0) {
					$listenom = $listenom . $datareal[0] . ",";
					$listeprenom = $listeprenom . $datareal[1] . ",";
				} else if (!empty($datareal[2]) || !empty($datareal[1])) {
					$listenom = $listenom . $datareal[2] . ",";
					$listeprenom = $listeprenom . $datareal[1] . ",";
				} else {
					$listenom = $listenom . "";
					$listeprenom = $listeprenom . "";
				}
				$j = 1;
			}

			/*---------------------Cocaténation Data---------------------------*/
			$tabReal = array($listenom, $listeprenom);
			$datareal = $tabReal; //Toujhours de la concaténations

			/* -------------------------------------------------------Acteurs--------------------------------------------- */
			$listenom = "";
			$listeprenom = "";
			if (!empty($tab[6]) || !empty($tab[7])) {
				$Acteurs = $tab[6] . $tab[7]; //Ici on concatène les acteurs et actrices

				//Identique à producteurs et à réalisateurs
				$tabact = explode(",", $Acteurs);
				$j = 0;

				for ($i = 0; $i < count($tabact); $i++) {
					$dataact = explode(" ", $tabact[$i]);

					if ($j == 0) {
						$listenom = $listenom . $dataact[1] . ",";
						$listeprenom = $listeprenom . $dataact[0] . ",";
					} else if (!empty($dataact[2]) || !empty($dataact[1])) {
						$listenom = $listenom . $dataact[2] . ",";
						$listeprenom = $listeprenom . $dataact[1] . ",";
					} else {
						$listenom = $listenom . "";
						$listeprenom = $listeprenom . "";
					}
					$j = 1;
				}
			} else {
				$listenom = "Aucun";
				$listeprenom = "Aucun";
				$tabact = array($listenom, $listeprenom);
			}
			$tabact = array($listenom, $listeprenom);
			/* -------------------------------Envoie de données------------------------------------- */
			inserer($datafilm, $tabact, $dataprod, $datareal); //On envoie toutes nos données concaténer à inserer
		}
	}
	echo ("Données Insérer !!!");
	fclose($monfichier);



	?>
</body>

</html>