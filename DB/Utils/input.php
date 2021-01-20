<?php
/* Attention ce programme ici ne peut pas fonctionner avec PDO à cause des focntions car sinon la fonction mysqli_real_escape_string ne fonctionne pas*/
function inserer($datafilm, $tabact, $dataprod, $datareal)
{
	//Nous précisons que toutes les données insérer sont relatifs au MCD mais surtout au MLD donc cf MLD
	$bdd = connexion(); //On se connecte et on récupère la bdd ultra important
	$datafilm = film($datafilm, $bdd); //Ici on récupère le titre du film qui va nous poermettre de trouver la clé primaire de film
	Acteur($tabact, $datafilm, $bdd);
	Producteur($dataprod, $datafilm, $bdd);
	Realisateur($datareal, $datafilm, $bdd);
	//Suppr($bdd); // Cette fonction ne fonctionne pas
	deconnexion($bdd);
}
function connexion()
{
	// connexion à la base de données
	$db_username = 'sriruangp';
	$db_password = 'DyhYWVGou31H';
	$db_name     = 'sriruangp';
	$db_host     = 'localhost';
	$db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
		or die('Impossible de se connecter');
	return $db;
}
function deconnexion($bdd)
{
	mysqli_close($bdd); // fermer la connexion
}


function film($datafilm, $bdd)
{
	$titreEn = mysqli_real_escape_string($bdd, $datafilm[0]); //Nous "échappons" tous les caractères à problème pour SQL
	$titreFr = mysqli_real_escape_string($bdd, $datafilm[1]);
	$TabGenre = explode(",", $datafilm[2]);
	$synopsis =  mysqli_real_escape_string($bdd, $datafilm[3]);
	$remarque = mysqli_real_escape_string($bdd, $datafilm[4]);
	$datesortie = $datafilm[5];

	$requete = "INSERT INTO Films (TitreFr,Synopsis,Remarque,Year,Titre) VALUES('$titreFr','$synopsis','$remarque','$datesortie','$titreEn')";
	$bdd->query($requete);

	$requete = "INSERT INTO Support(TypeSupport) VALUES('DVD')";
	/*nous insérons les clés étrangères qui sont enfaite les clés primaire de film .
		Car toutes les associations sont relié à film et la clé primaire de l'autre table relié ici Genre .
		Si et uniquement si les données correspondent.*/
	$bdd->query($requete);

	$requete = "INSERT INTO Disponible VALUES((SELECT IdFilms FROM Films WHERE '$titreEn' = Titre),
	(SELECT IdSupport FROM Support WHERE 'DVD' = TypeSupport))";
	/*nous insérons les clés étrangères qui sont enfaite les clés primaire de film .
		Car toutes les associations sont relié à film et la clé primaire de l'autre table relié ici Support .
		Si et uniquement si les données correspondent.*/
	$bdd->query($requete);

	for ($i = 0; $i < count($TabGenre); $i++) { //Ici on traverse tous les genre existant
		$Genre =  mysqli_real_escape_string($bdd, $TabGenre[$i]);

		$requete = "INSERT INTO Genre (Genre) VALUES('$Genre')";
		$bdd->query($requete);
		//Association
		$requete = "INSERT INTO Avoir VALUES((SELECT IdGenre FROM Genre WHERE '$Genre' = Genre),(SELECT IdFilms FROM Films WHERE '$titreEn' = Titre))";
		/*nous insérons les clés étrangères qui sont enfaite les clés primaire de film .
		Car toutes les associations sont relié à film et la clé primaire de l'autre table relié ici Genre .
		Si et uniquement si les données correspondent.*/
		$bdd->query($requete);
	}
	return $titreEn;
}
function Acteur($tabact, $datafilm, $bdd)
{
	$listenom = explode(",", $tabact[0]);
	$listeprenom = explode(",", $tabact[1]);;
	for ($i = 0; $i < count($listenom) - 1; $i++) {
		$nomact = mysqli_real_escape_string($bdd, $listenom[$i]);
		$prenomact = mysqli_real_escape_string($bdd, $listeprenom[$i]);

		$requete = "SELECT count(*) FROM Realisateur WHERE '$nomact' = Nom AND '$prenomact' = Prenom"; //Ici on vérifie les doublon
		$exec_requete = mysqli_query($bdd, $requete); 
		$reponse      = mysqli_fetch_array($exec_requete);
		$count = $reponse['count(*)'];

		if ($count == 0) {//S'il n'as pas de doublons on exécute la requête d'insertion de la table principale
		$requete = "INSERT INTO Acteur (Nom,Prenom) VALUES('$nomact','$prenomact')";
		$bdd->query($requete);
	}
		//Association
		$requete = "INSERT INTO Joue VALUES((SELECT IdFilms FROM Films WHERE '$datafilm' = Titre),
		(SELECT IdActeur FROM Acteur WHERE '$nomact' = Nom AND '$prenomact' = Prenom))"; //Ici c'est l'association Joue qui est relié à Acteur voir MCD
		/*Pour toutes les associations nous insérons les clés étrangères qui sont enfaite les clés primaire de film .
		Car toutes les associations sont relié à film et la clé primaire de l'autre table relié ici Acteur .
		Si et uniquement si les données correspondent.*/
		$bdd->query($requete);
		
	}
}
function Producteur($dataprod, $datafilm, $bdd)
{
	$nomprenom = $dataprod[0];
	$listenom = $nomprenom[0];
	$listeprenom = $nomprenom[1];
	$listenom = explode(",", $listenom);
	$listeprenom = explode(",", $listeprenom);
	$titre = $datafilm;

	for ($i = 0; $i < count($listenom) - 1; $i++) { //Comme nous avons bien concaténer nous avons le même nombre de prénom et de nom 
		$nomprod = mysqli_real_escape_string($bdd, $listenom[$i]);
		$prenomprod = mysqli_real_escape_string($bdd, $listeprenom[$i]);
		$studio = mysqli_real_escape_string($bdd, $dataprod[1]);

		$requete = "INSERT INTO Producteur (Nom,Prenom,NomStudio) VALUES('$nomprod','$prenomprod','$studio')";
		$bdd->query($requete); //Nous insérons le nom , le prénom et le studio

		$requete = "INSERT INTO Produit VALUES((SELECT IdFilms FROM Films WHERE '$titre' = Titre),
		(SELECT IdProducteur FROM Producteur WHERE '$nomprod' = Nom AND '$prenomprod' = Prenom AND NomStudio = '$studio'))"; //Ici c'est l'association Produit qui est relié à Producteur voir MCD
		$bdd->query($requete);
	}
}


function Realisateur($datareal, $datafilm, $bdd)
{
	$listenom = explode(",", $datareal[0]);
	$listeprenom = explode(",", $datareal[1]);
	$titre = $datafilm;

	for ($i = 0; $i < count($listenom) - 1; $i++) {
		$nomreal = mysqli_real_escape_string($bdd, $listenom[$i]);
		$prenomreal = mysqli_real_escape_string($bdd, $listeprenom[$i]);

		$requete = "SELECT count(*) FROM Realisateur WHERE '$nomreal' = Nom AND '$prenomreal' = Prenom"; //Ici on vérifie les doublons
		$exec_requete = mysqli_query($bdd, $requete); 
		$reponse      = mysqli_fetch_array($exec_requete);
		$count = $reponse['count(*)'];

		if ($count == 0) { //S'il n'as pas de doublons on exécute les requêtes d'insertions
			$requete = "INSERT INTO Realisateur (Nom,Prenom) VALUES('$nomreal','$prenomreal')"; //Ici on insère le nom et le prénom du real
			$bdd->query($requete); //Nous insérons le nom et le prénom mais pas sa date de naissance car nous ne l'avons elle sera donc mis en NULL automatiquement
		}
			$requete = "INSERT INTO Realise VALUES((SELECT IdReal FROM Realisateur WHERE '$nomreal' = Nom AND '$prenomreal' = Prenom),
		(SELECT IdFilms FROM Films WHERE '$titre' = Titre))"; //Ici c'est l'association Realise qui est relié à Réalisateur voir MCD
			$bdd->query($requete);
		
	}
}
function Suppr($bdd)
{

	$requete = "DELETE FROM Acteur WHERE Nom = '' AND Prenom = '' "; //Ici c'est censé supprimé les champs vide (ne marche pas)
	$bdd->query($requete);
	//Ici c'est censé supprimé tous les doublons ne marche pas car supprime absolument tout
	/*$requete = "DELETE FROM Acteur LEFT OUTER JOIN (SELECT MIN(IdActeur) as IdActeur, Nom, Prenom 
	FROM table GROUP BY Nom, Prenom) as t1 ON Acteur.IdActeur = t1.IdActeur WHERE t1.IdActeur IS NULL";
	$bdd->query($requete);
	$requete = "DELETE FROM Realisateur LEFT OUTER JOIN (SELECT MIN(IdReal) as IdReal, Nom, Prenom 
	FROM table GROUP BY Nom, Prenom) as t1 ON Realisateur.IdReal = t1.IdReal WHERE t1.IdReal IS NULL";
	$bdd->query($requete);
	$requete = "DELETE FROM Producteur LEFT OUTER JOIN (SELECT MIN(IdProducteur) as IdProducteur, Nom, Prenom 
	FROM table GROUP BY Nom, Prenom) as t1 ON Producteur.IdActeur = t1.IdActeur WHERE t1.IdActeur IS NULL";
	$bdd->query($requete);*/
}
