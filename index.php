<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/principale.css">
    <link rel="stylesheet" href="css/styleform.css">
    <title>Consultation</title>
</head>

<body>
    <?php
    require "PHP/INC/verifread_inc.php";
    ?>

    <section>
        <h3>Les données originales de cette base de données viennent de la
            <a href="http://cinephil.cinefan.free.fr/fr/1accueil-base-de-donnees-cinema/index.html">BDD de CINEPHIL</a> .
            Nous avons évidemment utiliser uniquement les données qu'on trouvait nécessaire. Nous remercions CINEPHIL d'avoir créer cette BDD.
        </h3><br>
    </section>

    <section id="Visualisation">
        <form>
            <h1>Choisissez sur quoi trier</h1>
            <a href="info.php?choix=Film"><input type="button" value="Fiche Films"></a>
            <a href="info.php?choix=Acteur"><input type="button" value="Fiche Acteur"></a>
            <a href="info.php?choix=Real"><input type="button" value="Fiche Réalisateur"></a>
            <a href="info.php?choix=Prod"><input type="button" value="Fiche Producteur"></a>
            <a href="info.php?choix=listActeur"><input type="button" value="Liste de tous les films joué par 2 acteurs :"></a>
            <a href="info.php?choix=listProd"><input type="button" value="Liste de tous les films produit par un producteur ou/et un studio :"></a>
            <a href="info.php?choix=listGenreDate"><input type="button" value="Liste de tous les films entre deux dates et/ou d'un genre précis :"></a>
        </form>
    </section>


</body>

</html>