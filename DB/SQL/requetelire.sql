/* -------------------------------Fiche complète------------------------------------ */

/*Fiche v acteur */
SELECT Nom,Prenom,DateNaissance FROM Acteur WHERE Nom = '$nomact' AND Prenom = '$prenomact' AND DateNaissance = '$dateact';
/*Fiche v real */
SELECT Nom,Prenom,DateNaissance FROM Realisateur WHERE Nom = '$nomreal' AND Prenom = '$prenomreal' AND DateNaissance = '$datereal';
/*Fiche v Producteur */
SELECT Nom,Prenom,NomStudio FROM Producteur WHERE Nom = '$nomprod' AND Prenom = '$prenomprod';

/*Fiche Films */
SELECT Films.Titre,Films.Synopsis,Films.Remarque,Films.Year,Support.TypeSupport FROM Disponible INNER JOIN Films ON Disponible.IdFilms = Films.IdFilms
INNER JOIN Support ON Disponible.IdSupport = Support.IdSupport WHERE Films.Titre LIKE '%$nom%' AND Films.Year = '$datesortie'
GROUP BY Films.Titre,Films.Synopsis,Films.Remarque,Films.Year;

/* --------------------------------Liste----------------------------------- */

/* Liste Film Real */
SELECT Realisateur.Nom,Realisateur.Prenom,Films.Titre,Films.Year FROM Realise 
INNER JOIN Realisateur ON Realisateur.IdReal = Realise.IdReal 
INNER JOIN Films ON Films.IdFilms = Realise.IdFilms 
WHERE Realisateur.Nom LIKE '%$nomreal%' AND Realisateur.Prenom LIKE '%$prenomreal%';

/* Liste Film Producteur */
SELECT Producteur.Nom,Producteur.Prenom,Films.Titre,Films.Year FROM Produit 
INNER JOIN Producteur ON Producteur.IdProducteur = Produit.IdProducteur 
INNER JOIN Films ON Films.IdFilms = Produit.IdFilms 
WHERE Producteur.Nom LIKE '%$nomprod%' AND Producteur.Prenom LIKE '$%prenomprod%'AND Producteur.nom LIKE '%$nomstudio%'
GROUP BY Producteur.Nom,Producteur.Prenom,Films.Titre,Films.Year;

/* Liste Film Studio */
SELECT Producteur.NomStudio,Films.Titre,Films.Year FROM Produit 
INNER JOIN Producteur ON Producteur.IdProducteur = Produit.IdProducteur 
INNER JOIN Films ON Films.IdFilms = Produit.IdFilms WHERE Producteur.NomStudio LIKE '%$nomstudio%';

/* Liste Film Acteur*/
SELECT Acteur.Nom,Acteur.Prenom,Films.Titre,Films.Year FROM Joue 
INNER JOIN Acteur ON Acteur.IdActeur = Joue.IdActeur 
INNER JOIN Films ON Films.IdFilms = Joue.IdFilms WHERE Acteur.Nom LIKE '%$nomact%' AND Acteur.Prenom LIKE '%$prenomact%' 
GROUP BY Acteur.Nom,Acteur.Prenom,Films.Titre,Films.Year;

/* Liste Film  2 Acteur*/
SELECT Acteur.Nom,Acteur.Prenom,Films.Titre,Films.Year FROM Joue 
INNER JOIN Acteur ON Acteur.IdActeur = Joue.IdActeur 
INNER JOIN Films ON Films.IdFilms = Joue.IdFilms 
WHERE (Acteur.Nom LIKE '%$nomact%' AND Acteur.Prenom LIKE '%$prenomact%') OR (Acteur.Nom LIKE '%$nomact2%' AND Acteur.Prenom LIKE '%$prenomact2%)'
GROUP BY Acteur.Nom,Acteur.Prenom,Films.Titre,Films.Year;

/* Liste Film entre deux dates*/
SELECT Films.Titre,Films.Year FROM Films WHERE Year >= '$date1' AND Year <= '$date2';

/* Liste Film entre deux dates avec Genre du film*/
SELECT Films.Titre,Films.Year FROM Avoir INNER JOIN Films ON Films.IdFilms = Avoir.IdFilms
INNER JOIN Genre ON Genre.IdGenre = Avoir.IdGenre
WHERE Year >= '$date1' AND Year <= '$date2' AND Genre.Genre = '$Genre';

/* --------------------------------Afficher les dernière informations insérer----------------------------------- */

SELECT Films.Titre,Inserer.Date FROM Inserer 
INNER JOIN Films ON Films.IdFilms = Inserer.IdFilms
INNER JOIN Admin ON Admin.IdAdmin = Inserer.IdAdmin
GROUP BY Films.Titre,Inserer.Date ORDER BY Inserer.Date DESC;
