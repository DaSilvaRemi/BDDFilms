<?php
if (!empty($_POST['user']) && !empty($_POST['mdp'])) {
   include "../INC/connexiondb_inc.php";
   $db = connexion();

   $query = $db->prepare("SELECT count(*) FROM Admin WHERE Login = :user AND Mp = :mdp");
   $query->bindValue(":user", $_POST['user']);
   $query->bindValue(":mdp", $_POST['mdp']);
   $query->execute();
   $result = $query->fetch();
   $count = $result['count(*)'];
   if ($count != 0) // nom d'utilisateur et mot de passe correctes
   {
      session_start();
      $query = $db->prepare("SELECT Ecriture FROM Admin WHERE Login = :user");
      $query->bindValue(":user",$_POST['user']);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_BOTH);

      if ($result[0] == 1) {
         $_SESSION['user'] = $_POST['user'];
         $_SESSION['write'] = $result[0];

         $query->closeCursor();
         deconnexion($db);
         header('Location: ../../index.php');
      } else {
         $query->closeCursor();
         deconnexion($db);
         header('Location: ../../login.php?erreur=3');
      }
   } else {
      deconnexion($db);
      header('Location: ../../login.php?erreur=1');
   }
} else {
   header('Location: ../../login.php');
}
