/*------------------------------------Table Principale--------------------------------------------*/
    INSERT INTO Films (Synopsis,Remarque,Year,Titre) VALUES('$synopsis','$remarque','$datesortie','$titre');
    INSERT INTO Genre (Genre) VALUES('$Genre');
    INSERT INTO Acteur (Nom,Prenom,DateNaissance,) VALUES('$nomact','$prenomact','$DateNaissanceAct');
    INSERT INTO Realisateur (Nom,Prenom,DateNaissance,) VALUES('$nomreal','$prenomreal','$DateNaissanceReal');
    INSERT INTO Producteur (Nom,Prenom,NomStudio) VALUES('$nomprod','$prenomprod','$studio');
    INSERT INTO Support(TypeSupport) VALUES('$typesupport')



/*------------------------------------Association--------------------------------------------*/
	INSERT INTO Joue VALUES((SELECT IdFilms FROM Acteur WHERE '$nomfilm' = Titre),
	(SELECT IdActeur FROM Acteur WHERE '$nomact' = Nom AND '$prenomact' = Prenom AND '$DateNaissanceAct' = DateNaissance));

    INSERT INTO Disponible VALUES((SELECT IdFilms FROM Films WHERE '$titreEn' = Titre),
	(SELECT IdSupport FROM Support WHERE '$typesupport' = TypeSupport))

    INSERT INTO Realise VALUES((SELECT IdReal FROM Realisateur WHERE '$nomreal' = Nom AND '$DateNaissanceReal' = DateNaissance),
	(SELECT IdFilms FROM Films WHERE '$nomfilm' = Titre));

    INSERT INTO Produit VALUES((SELECT IdFilms FROM Films WHERE '$titre' = Titre),
		(SELECT IdProducteur FROM Producteur WHERE '$nomprod' = Nom AND '$prenomprod' = Prenom));

    INSERT INTO Avoir VALUES((SELECT IdGenre FROM Genre WHERE '$Genre' = Genre),(SELECT IdFilms FROM Films WHERE '$nomfilm' = Titre));

   /* INSERT INTO Inserer VALUES((SELECT Id FROM Admin WHERE Login = $username),(SELECT IdFilms FROM Films WHERE '$nomfilm' = Titre),'$dateinsert');*/