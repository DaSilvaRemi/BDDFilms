<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Fiche <?php $choix ?></title>
	<link rel="stylesheet" href="css/principale.css">
	<link rel="stylesheet" href="css/styletab.css">
</head>

<body>
	<?php
	require "PHP/INC/verifread_inc.php";
	?>

	<?php
	$nom = $_POST['nom'];
	$prenom = "";
	$datenaissance = "";
	$datesortie = "";

	if (!empty($_POST['prenom'])) {
		$prenom = $_POST['prenom'];
	}

	if (!empty($_POST['datenaissance'])) {
		$datenaissance = $_POST['datenaissance'];
	} else if (!empty($_POST['datesortie'])) {
		$datesortie = $_POST['datesortie'];
	}
	?>
	<section>
		<center><h2>Résultats Recherche</h2></center>
		<table>
			<?php
			/* ---------------------------------------------------DB----------------------------------------------------- */
			require "PHP/INC/connexiondb_inc.php";
			require "PHP/INC/securite_inc.php";

			$db = connexion();
			clesession();

			$choix = $_POST['choix'];
			if ($choix == 'Producteur') {
				if (empty($prenom)) {
					$query = $db->prepare("SELECT IdProducteur,Nom,Prenom,NomStudio FROM Producteur WHERE Nom LIKE :nom");
					$query->bindValue(":nom", "%$nom");
				} else {
					$query = $db->prepare("SELECT IdProducteur,Nom,Prenom,NomStudio FROM Producteur WHERE Nom LIKE :nom AND Prenom LIKE :prenom ");
					$query->bindValue(":nom", "%$nom");
					$query->bindValue(":prenom", "%$prenom");
				} ?>
				<tr>
					<td>Nom</td>
					<td>Prénom</td>
					<td>Nom Studio</td>
					<td></td>
				</tr>
				<?php
				$query->execute();
				while ($result = $query->fetch(PDO::FETCH_BOTH)) { ?>
					<tr>
						<td><?php echo ($result[1]); ?></td>
						<td><?php echo ($result[2]); ?></td>
						<td><?php echo ($result[3]); ?></td>
						<td><?php echo ('<a href="fichecomp.php?id=' . $result[0] . '&&choix=' . $choix . ' "> Voir tous ses films </a>'); ?></td>
					</tr>
				<?php }
			} else if ($choix == 'Film') {
				if (!empty($datesortie)) {
					$query = $db->prepare("SELECT Films.IdFilms,Films.Titre,Films.Year,Realisateur.Nom FROM Realise
                    INNER JOIN Films ON Realise.IdFilms = Films.IdFilms
					INNER JOIN Realisateur ON Realise.IdReal = Realisateur.IdRealisateur
					WHERE Films.Titre LIKE :nom AND Films.Year = :datesortie
                    GROUP BY Films.IdFilms,Films.Titre,Films.Year,Realisateur.nom");
					$query->bindValue(":nom", "$nom%");
					$query->bindValue(":datesortie", $datesortie);
					$query->execute();
				} else {
					$query = $db->prepare("SELECT Films.IdFilms,Films.Titre,Films.Year,Realisateur.Nom FROM Realise
                    INNER JOIN Films ON Realise.IdFilms = Films.IdFilms
					INNER JOIN Realisateur ON Realise.IdReal = Realisateur.IdReal
					WHERE Films.Titre LIKE :nom
                    GROUP BY Films.IdFilms,Films.Titre,Films.Year,Realisateur.nom");
					$query->bindValue(":nom", "$nom%");
					$query->execute();
				} ?>
				<tr>
					<td>Titre</td>
					<td>Nom Réalisateur</td>
					<td>Année de sortie</td>
				</tr>
				<?php
				while ($result = $query->fetch(PDO::FETCH_BOTH)) { ?>
					<tr>
						<td>
							<?php echo ('<a href="fichecomp.php?id=' . $result[0] . '&&choix=' . $choix . ' "> ' . $result[1] . ' </a>'); ?>
						</td>
						<td><?php echo ($result[3]); ?></td>
						<td><?php echo ($result[2]); ?></td>
					</tr>
				<?php } 
		 } else {
				if (empty($prenom) && empty($datenaissance)) {
					$query = $db->prepare("SELECT * FROM $choix WHERE Nom LIKE :nom");
					$query->bindValue(":nom", "$nom%");
					$query->execute();
				} else if (!empty($prenom) && empty($datenaissance)) {
					$query = $db->prepare("SELECT * FROM $choix WHERE Nom LIKE :nom AND Prenom LIKE :prenom");
					$query->bindValue(":nom", "$nom%");
					$query->bindValue(":prenom", "$prenom%");
					$query->execute();
				} else {
					$query = $db->prepare("SELECT * FROM $choix WHERE Nom LIKE :nom 
                    AND Prenom LIKE :prenom AND DateNaissance = :datenaissance");
					$query->bindValue(":nom", "$nom%");
					$query->bindValue(":prenom", "$prenom%");
					$query->bindValue(":datenaissance", $datenaissance);
					$query->execute();
				}
			?>
				<tr>
					<td>Nom</td>
					<td>Prénom</td>
					<td>Date Naissance</td>
					<td></td>
				</tr>
				<?php
				while ($result = $query->fetch(PDO::FETCH_BOTH)) { ?>
					<tr>
						<td><?php echo ($result[1]); ?></td>
						<td><?php echo ($result[2]); ?></td>
						<td><?php echo ($result[3]); ?></td>
						<td><?php echo ('<a href="fichecomp.php?id=' . $result[0] . '&&choix=' . $choix . ' "> Voir tous ses films </a>'); ?></td>
					</tr>
			<?php }
			}
			$query->closeCursor();
			deconnexion($db);
			?>
		</table>
	</section>
</body>

</html>