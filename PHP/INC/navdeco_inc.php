<header>
  <nav>
    <ul>
        <li><a class="click" href="index.php">Consultation</a></li>
      <?php
      if ($_SESSION['write'] == '1') { ?>
        <li><a class="click" href="insertfilm.php">Ecriture</a></li>
      <?php
      }
      ?>

      <!-- Attention à l'ordre !! : la premier de la liste est le bloc le plus à droite-->
      <li class="droite">
        <a class="deco" href="?deconnexion=true" id="Login">
          <img src="Images/deco.svg" alt="Deconnection" />
        </a>
      </li>
      <li class="droite" title="Cinephil">
        <a class="click" href="http://cinephil.cinefan.free.fr/fr/1accueil-base-de-donnees-cinema/index.html" target="_blank">BDD de CINEPHIL</a>
      </li>
    </ul>
  </nav>
</header>