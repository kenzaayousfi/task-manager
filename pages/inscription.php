<?php
session_start();
if (isset($_SESSION['id_utilisateur']) && !empty($_SESSION['id_utilisateur'])) {
    header("Location: ./liste_tache.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../style.css">
  <title>Inscription</title>
</head>

<body>
  <?php include '../menu.php'; ?>
  <div class="container">
    <h1>Inscription</h1>
    <form action="./../traitement/inscription_traitement.php" method="post">
      <div class="input-label inline">
        <div>
          <label for="nom">Nom :</label>
          <input type="text" id="nom" name="nom" required>
        </div>
        <div>
          <label for="prenom">Prénom :</label>
          <input type="text" id="prenom" name="prenom" required>
        </div>
      </div>
      <div class="input-label">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-label">
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
      </div>
      <div class="input-label">
        <label for="genre">Genre :</label>
        <select id="genre" name="genre">
          <option value="1" selected>Homme</option>
          <option value="2">Femme</option>
        </select>
      </div>
      <div class="input-label">
        <label for="date_de_naissance">Date de naissance :</label>
        <input type="date" id="date_de_naissance" name="date_de_naissance" required>
      </div>
      <div class="input-label">
        <input class="button background-vert" type="submit" value="S'inscrire">
      </div>
    </form>

    <p>Vous avez déjà in compte? <a href="./connexion.php">Se connecter</a> </p>
  </div>
</body>

</html>