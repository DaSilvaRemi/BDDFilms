<?php
//Nous précisons que ce sont les même requetes à quelque données pret que le fichier input dans DB/SQL/Utilis permettant d'insérer toute la DB.

/* ------------------------------------------------------------DB------------------------------------------------------------ */

if (
	isset($_POST['datafilm']) && isset($_POST['datareal1']) && isset($_POST['nomstudio']) && isset($_POST['dataprod']) &&
	isset($_POST['nomacteur1']) && isset($_POST['prenomacteur1']) && isset($_POST['dateact1'])
) {
	include "../INC/connexiondb_inc.php";
	$db = connexion();
	/* -----------------------------------------------------------Données--------------------------------------------------------- */

	$datafilm = explode(",", $_POST['datafilm']);
	$datareal = explode(",", $_POST['datareal1']);
	$dataprod = explode(",", $_POST['dataprod']);

	/* ----------------------------Film--------------------------------------------------------- */
	$titre = $datafilm[0]; //On échappe les caractère
	$titreFr = $datafilm[1];
	$Genre = $datafilm[2];
	$synopsis = $datafilm[3];
	$remarque = $datafilm[4];
	$duree = $datafilm[5];
	$annee = $datafilm[6];
	$support = $datafilm[7];
	/* ----------------------------Réals--------------------------------------------------------- */
	//Réal 1
	$nomreal = $datareal[0];
	$prenomreal = $datareal[1];
	$DateNaissanceReal = $datareal[2];

	/* ----------------------------Producteur--------------------------------------------------------- */
	$nomprod = $dataprod[0];
	$prenomprod = $dataprod[1];
	$nomstudio = $_POST['nomstudio'];

	/* ----------------------------Acteurs--------------------------------------------------------- */
	//Nom Acteur
	$nomact = $_POST['nomacteur1'];
	$prenomact = $_POST['prenomacteur1'];
	$DateNaissanceAct = $_POST['dateact1'];

	/* ----------------------------Admin--------------------------------------------------------- */
	$dateinsert = date("Y-m-d H:i:s"); //On historise les insertions

	/*------------------------------------Table Principale--------------------------------------------*/
	$query = $db->prepare("INSERT INTO Films (Synopsis,Remarque,Duree,Year,Titre) VALUES(:titreFr,:synopsis,:remarque,:duree,:annee,:titre); ");
	$query->bindValue(":titrefr", $titrefr); //On définit la valeur de la variable titrefr sur l'argument :titrefr
	$query->bindValue(":synopsis", $synopsis);
	$query->bindValue(":remarque", $remarque);
	$query->bindValue(":duree", $duree);
	$query->bindValue(":annee", $annee);
	$query->bindValue(":titre", $titre);
	$query->execute(); //On éxécute la requête qui va automatiquement échapper les charactère de chaque paramètre

	$query = $db->prepare("INSERT INTO Genre (Genre) VALUES(:Genre)"); //On prépare la DB à éxécuter une requpete
	$query->bindValue(":Genre", $Genre);
	$query->execute(); //

	$query = $db->prepare("INSERT INTO Acteur (Nom,Prenom,DateNaissance) VALUES(:nomact,:prenomact,':DateNaissanceAct');");
	$query->bindValue(":nomact", $nomact);
	$query->bindValue(":prenomact", $prenomact);
	$query->bindValue(":DateNaissanceAct", $DateNaissanceAct);
	$query->execute();

	$query = $db->prepare("INSERT INTO Realisateur (Nom,Prenom,DateNaissance) VALUES(:nomreal,:prenomreal,':DateNaissanceReal');");
	$query->bindValue(":nomreal", $nomreal);
	$query->bindValue(":prenomreal", $prenomreal);
	$query->bindValue(":DateNaissanceReal", $DateNaissanceReal);
	$query->execute();

	$query = $db->prepare("INSERT INTO Producteur (Nom,Prenom,NomStudio) VALUES(:nomprod,:prenomprod,:nomstudio);");
	$query->bindValue(":nomprod", $nomprod);
	$query->bindValue(":prenomprod", $prenomprod);
	$query->bindValue(":nomstudio", $nomstudio);
	$query->execute();

	$query = $db->prepare("INSERT INTO Support (TypeSupport) VALUES(:support); ");
	$query->bindValue(":support", $support);
	$query->execute();



	/*------------------------------------Association--------------------------------------------*/
	$query = $db->prepare("INSERT INTO Joue VALUES((SELECT IdFilms FROM Films WHERE :titre = Titre),
	(SELECT IdActeur FROM Acteur WHERE :nomact = Nom AND :prenomact = Prenom AND :DateNaissanceAct = DateNaissance)); ");
	$query->bindValue(":titre", $titre);
	$query->bindValue(":nomact", $nomact);
	$query->bindValue(":prenomact", $prenomact);
	$query->bindValue(":DateNaissanceAct", $DateNaissanceAct);
	$query->execute();

	$query = $db->prepare("INSERT INTO Realise VALUES(
	(SELECT IdReal FROM Realisateur WHERE :nomreal = Nom AND :prenomreal = Prenom AND :DateNaissanceReal = DateNaissance),
	(SELECT IdFilms FROM Films WHERE $titre = Titre)); ");
	$query->bindValue(":nomreal", $nomreal);
	$query->bindValue(":prenomreal", $prenomreal);
	$query->bindValue(":DateNaissanceReal", $DateNaissanceReal);
	$query->execute();

	$query = $db->prepare("INSERT INTO Produit VALUES((SELECT IdFilms FROM Films WHERE $titre = Titre),
	(SELECT IdProducteur FROM Producteur WHERE $nomprod = Nom AND $prenomprod = Prenom)); ");
	$query->bindValue(":nomreal", $nomreal);
	$query->bindValue(":prenomreal", $prenomreal);
	$query->bindValue(":DateNaissanceReal", $DateNaissanceReal);
	$query->execute();

	$query = $db->prepare("INSERT INTO Avoir VALUES((SELECT IdGenre FROM Genre WHERE :Genre = Genre),(SELECT IdFilms FROM Films WHERE :titre = Titre)); ");
	$query->bindValue(":Genre", $Genre);
	$query->bindValue(":titre", $titre);
	$query->execute();

	$query = $db->prepare("INSERT INTO Disponible VALUES((SELECT IdFilms FROM Films WHERE :titre = Titre),
	(SELECT IdSupport FROM Support WHERE :support = TypeSupport)); ");
	$query->bindValue(":titre", $titre);
	$query->bindValue(":support", $support);
	$query->execute();

	session_start(); //démarrage de la session

	$query = $db->prepare("INSERT INTO Inserer VALUES((SELECT IdAdmin FROM Admin WHERE Login = :user),
	(SELECT IdFilms FROM Films WHERE $titre = Titre),'$dateinsert'); ");
	$query->bindValue(":user", $_SESSION['user']);
	$query->execute();

	/*------------------------------------Deuxième Acteur ou Réalisateur --------------------------------------------*/

	if (!empty($_POST['nomacteur2']) && !empty($_POST['prenomacteur2']) && !empty($_POST['dateact2'])) {

		$nomact = $_POST['nomacteur2'];
		$prenomact = $_POST['prenomacteur2'];
		$DateNaissanceAct = $_POST['dateact2'];

		/*-----------------------Table PP-----------------------------------*/
		$query = $db->prepare("INSERT INTO Acteur (Nom,Prenom,DateNaissance) VALUES(:nomact,:prenomact,:DateNaissanceAct)");
		$query->bindValue(":nomact", $nomact);
		$query->bindValue(":prenomact", $prenomact);
		$query->bindValue(":DateNaissanceAct", $DateNaissanceAct);
		$query->execute();

		/*-----------------------Association-----------------------------------*/
		$query = $db->prepare("INSERT INTO Joue VALUES((SELECT IdFilms FROM Acteur WHERE :titre = Titre),
		(SELECT IdActeur FROM Acteur WHERE :nomact = Nom AND :prenomact = Prenom AND :DateNaissanceAct = DateNaissance))");
		$query->bindValue(":titre", $titre);
		$query->bindValue(":nomact", $nomact);
		$query->bindValue(":prenomact", $prenomact);
		$query->bindValue(":DateNaissanceAct", $DateNaissanceAct);
		$query->execute();
	}

	if (isset($_POST['datareal2'])) {

		$datareal2 = $_POST['datareal2'];
		$nomreal = $datareal2[0];
		$prenomreal = $datareal2[1];
		$DateNaissanceReal = $datareal2[2];

		/*-----------------------Table PP-----------------------------------*/
		$query = $db->prepare("INSERT INTO Realisateur (Nom,Prenom,DateNaissance) VALUES($nomreal,$prenomreal,'$DateNaissanceReal'); ");
		$query->execute();

		/*-----------------------Association-----------------------------------*/
		$query = $db->prepare("INSERT INTO Realise VALUES(
		(SELECT IdReal FROM Realisateur WHERE :nomreal = Nom AND :prenomreal = Prenom AND :DateNaissanceReal = DateNaissance),
		(SELECT IdFilms FROM Films WHERE $titre = Titre)); ");
		$query->bindValue(":nomreal", $nomreal);
		$query->bindValue(":prenomreal", $prenomreal);
		$query->bindValue(":DateNaissanceReal", $DateNaissanceReal);
		$query->execute();
	}

	if (isset($_POST['dateprod2'])) {

		$dataprod2 = explode(",", $_POST['dateprod2']);
		$nomprod2 = $dataprod2[0];
		$prenomprod2 = $dataprod2[1];
		$nomstudio = $_POST['nomstudio'];

		/*-----------------------Table PP-----------------------------------*/
		$query = $db->prepare("INSERT INTO Producteur (Nom,Prenom,NomStudio) VALUES(:nomprod,:prenomprod,:nomstudio); ");
		$query->bindValue(":nomprod", $nomprod);
		$query->bindValue(":prenomprod", $prenomprod);
		$query->bindValue(":nomstudio", $nomstudio);
		$query->execute();

		/*-----------------------Association-----------------------------------*/
		$query = $db->prepare("INSERT INTO Produit VALUES((SELECT IdFilms FROM Films WHERE :titre = Titre),
		(SELECT IdProducteur FROM Producteur WHERE :nomprod = Nom AND :prenomprod = Prenom)); ");
		$query->bindValue(":titre", $titre);
		$query->bindValue(":nomprod", $nomprod);
		$query->bindValue(":prenomprod", $prenomprod);
		$query->execute();
	}

	$query->closeCursor(); //Fermetrure de l'envoie des requêtes
	deconnexion($db);
	header('Location: ../insertfilm.php?data=1');
} else {
	header('Location: ../insertfilm.php');;
}
