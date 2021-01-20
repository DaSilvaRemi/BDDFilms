<?php
function clesession()
{
    $_SESSION['clesecu'] = nbrandom();
}

function verifcle($choix)
{
    if (empty($_SESSION['clesecu'])) { // Vérification si l'utilisateur est bien passé par fichespe.php ou par liste.php
        header("location: info.php?choix=$choix");
    } else {
        unset($_SESSION['clesecu']);
    }
}

function nbrandom() //Génération d'un nombre aléatoire de 12 charactère
{
    $nb = "";
    for ($i = 0; $i < 12; $i++) {
        $nb = $nb . rand(0, 9);
    }
    return $nb;
}
