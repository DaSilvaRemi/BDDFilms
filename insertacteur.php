<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/principale.css">
    <link rel="stylesheet" href="css/styleform.css">
    <title>Insérer</title>
</head>

<body>
    <?php include "PHP/INC/verifwrite_inc.php"; ?>

    <?php
    $datafilm = $_POST['datafilm'];
    $datareal1 = $_POST['datareal1'];
    $dataprod = $_POST['nomprod'] . "," . $_POST['prenomprod'];
    $nomstudio = $_POST['nomstudio'];
    ?>

    <section id="Connexion">
        <form action="PHP/Script/input.php" method="POST" enctype="multipart/form-data">

            <h1>Ajouts Acteurs</h1>
            <label for="nomacteur1">Nom de l'acteur principal : <span style="color: red">*</span></label><br />
            <input type="text" name="nomacteur1" id="nomacteur1" placeholder="Entrer le nom de l'acteur principal" minlength="2" maxlength="60" size="25" required /><br />
            <label for="prenomacteur1">Prénom de l'acteur principal : <span style="color: red">*</span></label><br />
            <input type="text" name="prenomacteur1" id="prenomacteur1" placeholder="Entrer le prénom de l'acteur principal" minlength="2" maxlength="60" size="25" required /><br />
            <label for="dateact1">Date naissance acteur principal : <span style="color: red">*</span></label><br />
            <input type="date" name="dateact1" id="dateact1" required>

            <label for="nomacteur2">Nom de l'acteur secondaire : </label><br />
            <input type="text" name="nomacteur2" id="nomacteur2" placeholder="Entrer le nom de l'acteur secondaire" minlength="2" maxlength="60" size="25" /><br />
            <label for="prenomacteur2">Prénom de l'acteur secondaire : </label><br />
            <input type="text" name="prenomacteur2" id="prenomacteur2" placeholder="Entrer le prénom de l'acteur secondaire" minlength="2" maxlength="60" size="25" /><br />
            <label for="dateact2">Date naissance acteur principal : </label><br />
            <input type="date" name="dateact2" id="dateact2">

            <input type="hidden" name="datafilm" value="<?php echo ($datafilm); ?>">
            <input type="hidden" name="datareal1" value="<?php echo ($datareal1); ?>">
            <input type="hidden" name="dataprod" value="<?php echo ($dataprod); ?>">
            <input type="hidden" name="nomstudio" value="<?php echo ($nomstudio); ?>">

            <?php
            if (isset($_POST['datareal2'])) {
                $datareal2 = $_POST['datareal2'];
            ?>
                <input type="hidden" name="datareal2" value="<?php echo ($datareal2); ?>">
            <?php
            }
            ?>
            <?php
            if (isset($_POST['nomprod2']) && $_POST['prenomprod2']) {
                $dataprod2 = $_POST['nomprod2'] . "," . $_POST['prenomprod2'];
            ?>
                <input type="hidden" name="dataprod2" value="<?php echo ($dataprod2); ?>">
            <?php
            }
            ?>

            <input type="submit" value="Envoyer" />
            <h4>Tous les champs avec <span style="color: red">*</span> sont obligatoires</h4>
        </form>
    </section>
</body>

</html>