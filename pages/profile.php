<?php
session_start();
// Vérifier si l'utilisateur est déjà connecté en vérifiant s'il existe une variable de session id_utilisateur
if (!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) {
  // L'utilisateur n'est pas connecté, donc redirection vers page connexion
  header("Location: ./connexion.php");
  exit();
}


include_once '../bdd/base_de_donnees.php';
$connexion = ouvrirLaConnexion();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../style.css">
  <title>Profile</title>
</head>

<body>
  <?php include '../menu.php'; ?>
  <?php
  $requete = "SELECT nom, prenom, email, date_de_naissance,genre FROM utilisateurs WHERE id_utilisateur ={$_SESSION['id_utilisateur']}";
  $res = mysqli_query($connexion, $requete);
  // Vérifier si la tâche existe
  if (mysqli_num_rows($res) > 0) {
    // Récupérer les données de la tâche
    $utilisateur = mysqli_fetch_assoc($res);
    $nom = $utilisateur['nom'];
    $prenom = $utilisateur['prenom'];
    $email = $utilisateur['email'];
    $date_de_naissance = $utilisateur['date_de_naissance'];
    $genre = $utilisateur['genre'];
  }

  ?>




  <div class="container">
    <h1>Modifier les informations</h1>
    <form action="./../traitement/profile_traitement.php" method="post">
      <div class="input-label">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required value="<?php echo $nom; ?>">
      </div>
      <div class="input-label">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required value="<?php echo $prenom; ?>">
      </div>
      <div class="input-label">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required value="<?php echo $email; ?>">
      </div>
      <div class="input-label">
        <label for="date_de_naissance">Date de naissance :</label>
        <input type="date" id="date_de_naissance" name="date_de_naissance" required
          value="<?php echo $date_de_naissance; ?>">
      </div>
      <div class="input-genre">
        <label>Genre :</label>

        <input type="radio" id="genre1" name="genre" value="1" <?php if ($genre === '1') echo 'checked'; ?> required>
        <label for="genre1">Homme</label>
        <input type="radio" id="genre2" name="genre" value="2" <?php if ($genre === '2') echo 'checked'; ?>>
        <label for="genre2">Femme</label>


      </div>
      <div class="input-label">
        <input class="button background-vert" type="submit" value="Modifier les informations">
      </div>
    </form>
    <hr>
    <h2>Modifier le mot de passe</h2>
    <form action="./../traitement/profile_modification_mot_de_passe.php" method="post">
      <div class="input-label">
        <label for="mot_de_passe_actuel">Mot de passe actuel :</label>
        <input type="password" id="mot_de_passe_actuel" name="mot_de_passe_actuel" required>
      </div>
      <div class="input-label">
        <label for="nouveau_mot_de_passe">Nouveau mot de passe :</label>
        <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required>
      </div>
      <div class="input-label">
        <label for="confirmation_mot_de_passe">Confirmer le nouveau mot de passe :</label>
        <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>
      </div>
      <div class="input-label">
        <input class="button background-vert" type="submit" value="Modifier le mot de passe">
      </div>
    </form>

    <hr>
    <h2>Supprimer mon compte</h2>
    <form action="./../traitement/supprimer_utilisateur_traitement.php" method="post">
      <div class="input-label">
        <input class="button background-rouge" type="submit" value="Supprimer mon compte">
      </div>
    </form>
  </div>


  </div>
</body>

</html>