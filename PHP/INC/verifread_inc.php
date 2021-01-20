<?php
session_start();
if (empty($_SESSION['user'])) { //On vérifie si un utilisateur est connecté
	include "navco_inc.php";
} else {
	include "navdeco_inc.php";
	if (isset($_GET['deconnexion'])) {
		if ($_GET['deconnexion'] == true) {
			session_unset();
			header("location:login.php");
		}
	} else if ($_SESSION['user'] !== "") {
		$user = $_SESSION['user'];
	}
}
