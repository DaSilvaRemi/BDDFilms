<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location:login.php');
} else if (!empty($_SESSION['user']) && empty($_SESSION['write'])) {
    session_unset();
    header('Location:login.php?erreur=3');
} else if (isset($_GET['deconnexion'])) {
    if ($_GET['deconnexion'] == true) {
        session_unset();
        header("location:login.php");
    }
} else {
   include "navdeco_inc.php";
}
