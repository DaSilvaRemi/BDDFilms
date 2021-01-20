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
	require "PHP/INC/securite_inc.php";
	?>

	<?php
	if (!empty($_GET['id']) && !empty($_GET['choix'])) {
		$choix =  $_GET['choix'];
		$id = $_GET['id'];
		verifcle($choix);
	} else {
		header("location: index.php");
	}
	?>
	<section>

		<?php
		/* ---------------------------------------------------DB----------------------------------------------------- */
		require "PHP/INC/connexiondb_inc.php";
		$db = connexion();
		if ($choix == 'Film') {

			$query = $db->prepare("SELECT Films.Titre,Films.TitreFr,Films.Synopsis,Films.Remarque,Films.Duree,Films.Year,Genre.Genre,Support.TypeSupport 
      FROM Films INNER JOIN Avoir ON Avoir.IdFilms = Films.IdFilms 
      INNER JOIN Genre ON Avoir.IdGenre = Genre.IdGenre 
      INNER JOIN Disponible ON Disponible.IdFilms = Films.IdFilms 
      INNER JOIN Support ON Disponible.IdSupport = Support.IdSupport 
      WHERE Films.IdFilms = :id
      GROUP BY Films.Titre,Films.TitreFr,Films.Synopsis,Films.Remarque,Films.Duree,Films.Year,Genre.Genre,Support.TypeSupport");
			$query->bindValue(":id", $id);

		?>
			<table>
				<tr>
					<td>Titre</td>
					<td>Titre Français</td>
					<td>Scénariste(s)</td>
					<td>Remarque</td>
					<td>Durée</td>
					<td>Année de sortie</td>
					<td>Genre</td>
					<td>Support</td>
				</tr>
				<?php
				$Genre = "";
				$query->execute();
				while ($result = $query->fetch(PDO::FETCH_BOTH)) {
					$Genre = "$Genre/" . $result[6];
				}
				$query->execute();
				$result = $query->fetch(PDO::FETCH_BOTH) ?>
				<tr>
					<td><?php echo ($result[0]); ?></td>
					<td><?php echo ($result[1]); ?></td>
					<td><?php echo ($result[2]); ?></td>
					<td><?php echo ($result[3]); ?></td>
					<td><?php echo ($result[4]); ?></td>
					<td><?php echo ($result[5]); ?></td>
					<td><?php echo ($Genre); ?></td>
					<td><?php echo ($result[7]); ?></td>
				</tr>
			</table>
			<?php
			$query->closeCursor();
			$query = $db->prepare("SELECT Realisateur.Nom,Realisateur.Prenom FROM Realise 
			INNER JOIN Films ON Realise.IdFilms = Films.IdFilms
			INNER JOIN Realisateur ON Realise.IdReal = Realisateur.IdReal
			WHERE Films.IdFilms = :id
			GROUP BY Realisateur.Nom,Realisateur.Prenom");
			$query->bindValue(":id", $id);
			?>
			<table>
				<tr>
					<th>Réalisateur(s) du Film</th>
					<th>Acteur(s) du Film</th>
					<th>Producteur(s) du Film</th>
				</tr>

				<tr>
					<td>
						<select size="10">
							<option value="">Nom-Prénom</option>
							<?php
							$query->execute();
							while ($result = $query->fetch(PDO::FETCH_BOTH)) { ?>
								<option value=""> <?php echo ($result[0] . "-" . $result[1]); ?></option>
							<?php } ?>
						</select>
					</td>

					<?php
					$query->closeCursor();
					$query = $db->prepare("SELECT Acteur.Nom,Acteur.Prenom FROM Joue 
					INNER JOIN Films ON Joue.IdFilms = Films.IdFilms
					INNER JOIN Acteur ON Joue.IdActeur = Acteur.IdActeur
					WHERE Films.IdFilms = :id
					GROUP BY Acteur.Nom,Acteur.Prenom");
					$query->bindValue(":id", $id);
					?>

					<td>
						<select size="10">
							<option value="">Nom-Prénom</option>
							<?php
							$query->execute();
							while ($result = $query->fetch(PDO::FETCH_BOTH)) { ?>
								<option><?php echo ($result[0] . " " . $result[1]); ?></option>r>
							<?php } ?>
						</select>
					</td>

					<?php
					$query->closeCursor();
					$query = $db->prepare("SELECT Producteur.Nom,Producteur.Prenom,Producteur.NomStudio FROM Produit 
					INNER JOIN Films ON Produit.IdFilms = Films.IdFilms
					INNER JOIN Producteur ON Produit.IdProducteur = Producteur.IdProducteur
					WHERE Films.IdFilms = :id
					GROUP BY Producteur.Nom,Producteur.Prenom,Producteur.NomStudio");
					$query->bindValue(":id", $id);
					?>
					<td>
						<select id="select3" size="10">
							<option value="">Nom-Prénom</option>
							<?php
							$query->execute();
							while ($result = $query->fetch(PDO::FETCH_BOTH)) { ?>
								<option><?php echo ($result[0] . "-" . $result[1]); ?></option>r>
							<?php } ?>
						</select>
					</td>
				</tr>
			</table>
		<?php
			$query->closeCursor();
		} else if ($choix == 'Producteur') {
			clesession();

			$query = $db->prepare("SELECT Films.IdFilms,Films.Titre,Films.TitreFr,Films.Year,Producteur.Nom,Producteur.Prenom FROM Films 
                INNER JOIN Produit ON Films.IdFilms = Produit.IdFilms
                INNER JOIN Producteur ON Produit.IdProducteur = Producteur.IdProducteur
                WHERE Producteur.IdProducteur = :id
                GROUP BY Films.IdFilms,Films.Titre,Films.TitreFr,Films.Year,Producteur.Nom,Producteur.Prenom");
			$query->bindValue(":id", $id);
			$query->execute();
			$result = $query->fetch();

			echo ("<center><h3>" . $result['Nom'] . "-" . $result['Prenom'] . " à produit</h3></center><br/>");
		?>
			<table>
				<tr>
					<td>Titre</td>
					<td>TitreFr</td>
					<td>Année de Sortie</td>
				</tr>
				<?php
				$query->execute();
				while ($result = $query->fetch()) { ?>
					<tr>
						<td><?php echo ('<a href="?id=' . $result['IdFilms'] . '&&choix=Film"> ' . $result['Titre'] . ' </a>'); ?></td>
						<td><?php echo ($result['TitreFr']); ?></td>
						<td><?php echo ($result['Year']); ?></td>
					</tr>
				<?php } ?>
			</table>
		<?php } else if ($choix == 'Realisateur') {
			clesession();

			$query = $db->prepare("SELECT Films.IdFilms,Films.Titre,Films.TitreFr,Films.Year,Realisateur.Nom,Realisateur.Prenom FROM Films  
                INNER JOIN Realise ON Films.IdFilms = Realise.IdFilms
                INNER JOIN Realisateur ON Realise.IdReal = Realisateur.IdReal
                WHERE Realisateur.IdReal = :id
                GROUP BY Films.IdFilms,Films.Titre,Films.TitreFr,Films.Year,Realisateur.Nom,Realisateur.Prenom");
			$query->bindValue(":id", $id);
			$query->execute();
			$result = $query->fetch();

			echo ("<center><h3>" . $result['Nom'] . " " . $result['Prenom'] . " à réalisé</h3></center><br/>");
		?>
			<table>
				<tr>
					<td>Titre</td>
					<td>Titre Français</td>
					<td>Année de sortie</td>
				</tr>
				<?php
				$query->execute();
				while ($result = $query->fetch()) { ?>
					<tr>
						<td><?php echo ('<a href="?id=' . $result['IdFilms'] . '&&choix=Film"> ' . $result['Titre'] . ' </a>'); ?></td>
						<td><?php echo ($result['TitreFr']); ?></td>
						<td><?php echo ($result['Year']); ?></td>
					</tr>
				<?php } ?>
			</table>
		<?php } else if ($choix == 'Acteur') {
			clesession();

			$query = $db->prepare("SELECT Films.IdFilms,Films.Titre,Films.TitreFr,Films.Year,Acteur.Nom,Acteur.Prenom FROM Films 
				INNER JOIN Joue ON Films.IdFilms = Joue.IdFilms
				INNER JOIN Acteur ON Joue.IdActeur = Acteur.IdActeur
				WHERE Acteur.IdActeur = :id
				GROUP BY Films.IdFilms,Films.Titre,Films.TitreFr,Films.Year,Acteur.Nom,Acteur.Prenom");
			$query->bindValue(":id", $id);
			$query->execute();
			$result = $query->fetch();

			echo ("<center><h3>" . $result['Nom'] . " " . $result['Prenom'] . " à joué dans</h3></center><br/>");
		?>
			<table>
				<tr>
					<td>Titre</td>
					<td>Titre Français</td>
					<td>Année de sortie</td>
				</tr>
				<?php
				$query->execute();
				while ($result = $query->fetch()) { ?>
					<tr>
						<td><?php echo ('<a href="?id=' . $result['IdFilms'] . '&&choix=Film"> ' . $result['Titre'] . ' </a>'); ?></td>
						<td><?php echo ($result['TitreFr']); ?></td>
						<td><?php echo ($result['Year']); ?></td>
					</tr>
				<?php } ?>
			</table>
		<?php } else {
			deconnexion($db);
			header("location: index.php");
		}
		$query->closeCursor();
		deconnexion($db);
		?>
		</table>
	</section>
</body>

</html>