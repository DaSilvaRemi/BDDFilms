#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Films
#------------------------------------------------------------

CREATE TABLE Films(
        IdFilms  Int  Auto_increment  NOT NULL ,
        TitreFr  Varchar (70) NOT NULL ,
        Synopsis Longtext ,
        Remarque Longtext ,
        Duree    Int ,
        Year     Year ,
        Titre    Varchar (70) NOT NULL
	,CONSTRAINT Films_AK UNIQUE (Titre)
	,CONSTRAINT Films_PK PRIMARY KEY (IdFilms)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Acteur
#------------------------------------------------------------

CREATE TABLE Acteur(
        IdActeur      Int  Auto_increment  NOT NULL ,
        Nom           Varchar (60) ,
        Prenom        Varchar (60) ,
        DateNaissance Date
	,CONSTRAINT Acteur_PK PRIMARY KEY (IdActeur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Realisateur
#------------------------------------------------------------

CREATE TABLE Realisateur(
        IdReal        Int  Auto_increment  NOT NULL ,
        Nom           Varchar (60) ,
        Prenom        Varchar (60) ,
        DateNaissance Date
	,CONSTRAINT Realisateur_PK PRIMARY KEY (IdReal)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Admin
#------------------------------------------------------------

CREATE TABLE Admin(
        IdAdmin  Int  Auto_increment  NOT NULL ,
        Mp       Varchar (13) NOT NULL ,
        Nom      Varchar (60) ,
        Prenom   Varchar (60) ,
        Lecture  TinyINT NOT NULL ,
        Ecriture TinyINT NOT NULL ,
        Login    Varchar (13) NOT NULL
	,CONSTRAINT Admin_AK UNIQUE (Login)
	,CONSTRAINT Admin_PK PRIMARY KEY (IdAdmin)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Genre
#------------------------------------------------------------

CREATE TABLE Genre(
        IdGenre Int  Auto_increment  NOT NULL ,
        Genre   Varchar (60) NOT NULL
	,CONSTRAINT Genre_AK UNIQUE (Genre)
	,CONSTRAINT Genre_PK PRIMARY KEY (IdGenre)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Producteur
#------------------------------------------------------------

CREATE TABLE Producteur(
        IdProducteur Int  Auto_increment  NOT NULL ,
        Nom          Varchar (60) ,
        Prenom       Varchar (60) ,
        NomStudio    Varchar (60) NOT NULL
	,CONSTRAINT Producteur_PK PRIMARY KEY (IdProducteur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Support
#------------------------------------------------------------

CREATE TABLE Support(
        IdSupport   Int  Auto_increment  NOT NULL ,
        TypeSupport Varchar (40) NOT NULL
	,CONSTRAINT Support_AK UNIQUE (TypeSupport)
	,CONSTRAINT Support_PK PRIMARY KEY (IdSupport)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Joue
#------------------------------------------------------------

CREATE TABLE Joue(
        IdFilms  Int NOT NULL ,
        IdActeur Int NOT NULL
	,CONSTRAINT Joue_PK PRIMARY KEY (IdFilms,IdActeur)

	,CONSTRAINT Joue_Films_FK FOREIGN KEY (IdFilms) REFERENCES Films(IdFilms)
	,CONSTRAINT Joue_Acteur0_FK FOREIGN KEY (IdActeur) REFERENCES Acteur(IdActeur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Realise
#------------------------------------------------------------

CREATE TABLE Realise(
        IdReal  Int NOT NULL ,
        IdFilms Int NOT NULL
	,CONSTRAINT Realise_PK PRIMARY KEY (IdReal,IdFilms)

	,CONSTRAINT Realise_Realisateur_FK FOREIGN KEY (IdReal) REFERENCES Realisateur(IdReal)
	,CONSTRAINT Realise_Films0_FK FOREIGN KEY (IdFilms) REFERENCES Films(IdFilms)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Avoir
#------------------------------------------------------------

CREATE TABLE Avoir(
        IdGenre Int NOT NULL ,
        IdFilms Int NOT NULL
	,CONSTRAINT Avoir_PK PRIMARY KEY (IdGenre,IdFilms)

	,CONSTRAINT Avoir_Genre_FK FOREIGN KEY (IdGenre) REFERENCES Genre(IdGenre)
	,CONSTRAINT Avoir_Films0_FK FOREIGN KEY (IdFilms) REFERENCES Films(IdFilms)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Produit
#------------------------------------------------------------

CREATE TABLE Produit(
        IdFilms      Int NOT NULL ,
        IdProducteur Int NOT NULL
	,CONSTRAINT Produit_PK PRIMARY KEY (IdFilms,IdProducteur)

	,CONSTRAINT Produit_Films_FK FOREIGN KEY (IdFilms) REFERENCES Films(IdFilms)
	,CONSTRAINT Produit_Producteur0_FK FOREIGN KEY (IdProducteur) REFERENCES Producteur(IdProducteur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Inserer
#------------------------------------------------------------

CREATE TABLE Inserer(
        IdAdmin Int NOT NULL ,
        IdFilms Int NOT NULL ,
        Date    Datetime NOT NULL
	,CONSTRAINT Inserer_PK PRIMARY KEY (IdAdmin,IdFilms)

	,CONSTRAINT Inserer_Admin_FK FOREIGN KEY (IdAdmin) REFERENCES Admin(IdAdmin)
	,CONSTRAINT Inserer_Films0_FK FOREIGN KEY (IdFilms) REFERENCES Films(IdFilms)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Disponible
#------------------------------------------------------------

CREATE TABLE Disponible(
        IdFilms   Int NOT NULL ,
        IdSupport Int NOT NULL
	,CONSTRAINT Disponible_PK PRIMARY KEY (IdFilms,IdSupport)

	,CONSTRAINT Disponible_Films_FK FOREIGN KEY (IdFilms) REFERENCES Films(IdFilms)
	,CONSTRAINT Disponible_Support0_FK FOREIGN KEY (IdSupport) REFERENCES Support(IdSupport)
)ENGINE=InnoDB;

