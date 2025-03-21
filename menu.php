<ul class="menu">
  <li class="realise_par"><span>YASSA & YOUSFI</span></li>
  <?php
  if (!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) { ?>
  <li><a href="./connexion.php">Connexion</a></li>

  <li><a href="./inscription.php">Inscription</a></li>
  <?php  } else { ?>
  <li><a href="./liste_tache.php">Accueil</a></li>
  <li><a href="./dashboard.php">Tableau de Bord</a></li>
  <li><a href="./profile.php">Profile</a></li>
  <li><a href="./../traitement/deconnexion_traitement.php">Déconnexion</a></li>
  <?php   }
  ?>
</ul>