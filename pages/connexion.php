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
  <title>Connexion</title>
</head>

<body>
  <?php include_once './../menu.php'; ?>
  <div class="container">
    <h1>Connexion</h1>
    <img src="./../images/connexion.png" alt="" class="avatar">
    <form action="./../traitement/connexion_traitement.php" method="post">
      <div class="input-label">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-label">
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
      </div>
      <div class="input-label">
        <input class="button background-vert" type="submit" value="Se connecter">
      </div>
    </form>
    <p>Vous n'avez pas de compte? <a href="./inscription.php">S'inscrire</a> </p>

  </div>
</body>

</html>