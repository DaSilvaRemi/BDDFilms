<?php
function connexion(){

require "constbdd_inc.php";
$dblogin = choix(1); //0 = Machinepersonelle ; 1 = btsio.org

try {
    $bdd = new PDO('mysql:host='.$dblogin[0].';dbname=' . $dblogin[1], $dblogin[2], $dblogin[3], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
return $bdd;

}

function deconnexion($bdd){
    unset($bdd);
}

?>
