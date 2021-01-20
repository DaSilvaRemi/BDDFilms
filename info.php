<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/principale.css">
	<link rel="stylesheet" href="css/styleform.css">
	<title>Information</title>
</head>

<body>
	<?php
	require "PHP/INC/verifread_inc.php";
	?>
	<?php if (empty($_GET['choix'])) {
		header("location: index.php");
	} else if ($_GET['choix'] == 'Acteur') {
		$choix = 'Acteur';
	} else if ($_GET['choix'] == 'Real') {
		$choix = 'Realisateur';
	} else if ($_GET['choix'] == 'Prod') {
		$choix = 'Producteur';
	} else if ($_GET['choix'] == 'Film') {
		$choix = 'Film';
	} else if ($_GET['choix'] == 'listActeur') {
		$choix = 'Liste Acteur Film';
	} else if ($_GET['choix'] == 'listProd') {
		$choix = 'Liste Producteur Film';
	} else if ($_GET['choix'] == 'listGenreDate') {
		$choix = 'Liste Film';
	} else {
		header("location: index.php");
	}

	if ($choix == 'Acteur' || $choix == 'Realisateur' || $choix == 'Producteur' || $choix == 'Film') {
	?>
		<section id="Connexion">
			<form action="fichespe.php" method="post">
				<h1>Fiche <?php echo $choix; ?></h1>
				<label for="nom">Nom <?php echo $choix; ?> : <span style="color: red">*</span></label><br />
				<input type="text" name="nom" id="nom" placeholder="Entrer son nom" minlength="2" maxlength="60" size="25" required /><br />
				<?php if ($choix != 'Film') { ?>
					<label for="prenom">Prénom <?php echo $choix; ?> : </label><br />
					<input type="text" name="prenom" id="prenom" placeholder="Entrer son prénom" minlength="2" maxlength="60" size="25" /><br />
				<?php } ?>
				<?php if ($choix != 'Producteur' && $choix != 'Film') { ?>
					<label for="datenaissance">Date de naissance : </label><br />
					<input type="date" name="datenaissance" id="datenaissance">
				<?php  }
				if ($choix == 'Film') { ?>
					<label for="datesortie">Date de sortie : </label><br />
					<input type="number" name="datesortie" id="datesortie" placeholder="Entrer la date de sortie" min="1900" max="2100" size="4">
				<?php }
				?>
				<input type="hidden" name="choix" value="<?php echo $choix; ?>">
				<input type="submit" value="Envoyer">
			</form>
		</section>
	<?php } ?>

	<?php if ($choix == 'Liste Acteur Film' || $choix == 'Liste Producteur Film' || $choix == 'Liste Film') { ?>
		<section id="Connexion">
			<form action="liste.php" method="post">
				<h1><?php echo $choix; ?></h1>
				<?php if ($choix == 'Liste Acteur Film') { ?>
					<label for="nom">Nom : <span style="color: red">*</span></label><br />
					<input type="text" name="nom" id="nom" placeholder="Entrer son nom" minlength="2" maxlength="60" size="25" required /><br />
				<?php } elseif ($choix == 'Liste Producteur Film') { ?>
					<label for="nom">Nom : </label><br />
					<input type="text" name="nom" id="nom" placeholder="Entrer son nom" minlength="2" maxlength="60" size="25" /><br />
				<?php	}
				if ($choix != 'Liste Film') { ?>
					<label for="nomstudio">Prénom : </label><br />
					<input type="text" name="prenom" id="prenom" placeholder="Entrer son prénom" minlength="2" maxlength="60" size="25" /><br />
				<?php }
				if ($choix == 'Liste Producteur Film') {
				?>
					<label for="nomstudio">Nom Studio : </label><br />
					<input type="text" name="nomstudio" id="nomstudio" placeholder="Entrer le nom du studio" minlength="1" maxlength="60" size="25">

					<h3>Entrer au minimum soit le nom du studio, soit le nom du producteur</h3>
				<?php  }
				if ($choix == 'Liste Acteur Film') { ?>
					<label for="nom2">Nom 2ème Acteur : <span style="color: red">*</span></label><br />
					<input type="text" name="nom2" id="nom2" placeholder="Entrer son nom" minlength="2" maxlength="60" size="25" required/><br />
					<label for="prenom2">Prénom 2ème Acteur : </label><br />
					<input type="text" name="prenom2" id="prenom2" placeholder="Entrer son prénom" minlength="2" maxlength="60" size="25" /><br />
				<?php } elseif ($choix == 'Liste Film') { ?>

					<label for="date1">1ère Date : </label>
					<input type="number" name="date1" id="date1" placeholder="Entrer la 1ère année" min="1900" max="2099" size="4">

					<label for="date2">2ème Date : </label><br />
					<input type="number" name="date2" id="date2" placeholder="Entrer la 2ème année" min="1901" max="2100" size="4">

					<label for="Genre">Genre du Film : </label><br />
					<select name="Genre" id="Genre">
						<option value="0">Rien Séléctionner</option>
						<?php
						require "PHP/INC/connexiondb_inc.php";
						$db = connexion();
						$requete = "SELECT Genre FROM Genre";
						$reponse = $db->query($requete);
						while ($result = $reponse->fetch(PDO::FETCH_BOTH)) { ?>

							<option value="<?php echo($result[0]); ?>"><?php echo ($result[0]); ?></option>
						<?php	}
						$reponse->closeCursor(); //Fermetrure de l'envoie des requêtes
						deconnexion($db); // fermer la connexion
						?>
					</select>
					<h3>Veuillez entrer au minimum soit un genre soit les deux dates</h3>
				<?php }
				?>
				<input type="hidden" name="choix" value="<?php echo $choix; ?>">
				<input type="submit" value="Envoyer">
			</form>
		</section>
	<?php }	?>
</body>

</html>