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
  <title>Tache</title>
</head>

<body>
  <?php
  include '../menu.php';

  $id_tache = null;
  $titre = null;
  $description = null;
  $date_fin = null;
  $statut = null;

  if (isset($_GET['id_tache'])  && !empty($_GET['id_tache'])) {

    $requete = "SELECT id_tache, titre, description, date_fin, statut FROM taches WHERE id_tache ={$_GET['id_tache']} and id_utilisateur={$_SESSION['id_utilisateur']}";
    $res = mysqli_query($connexion, $requete);
    echo mysqli_num_rows($res);
    // Vérifier si la tâche existe
    if (mysqli_num_rows($res) > 0) {
      // Récupérer les données de la tâche
      $tache = mysqli_fetch_assoc($res);
      $id_tache = $tache['id_tache'];
      $titre = $tache['titre'];
      $description = $tache['description'];
      $date_fin = $tache['date_fin'];
      $statut = $tache['statut'];
    }
  }

  ?>

  <div class="container">
    <h1>Ajouter/Modifier une Tâche </h1>
    <form action="./../traitement/tache_traitement.php" method="post">
      <input type="hidden" id="id_tache" name="id_tache" value="<?php echo $id_tache; ?>">
      <div class="input-label">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?php echo $titre; ?>" required>
      </div>
      <div class="input-label">
        <label for="description">Description :</label>
        <textarea id="description" name="description" rows="4" required><?php echo $description; ?></textarea>
      </div>
      <div class="input-label">
        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin" value="<?php echo $date_fin; ?>" required>
      </div>
      <div class="input-label">
        <label for="statut">Statut :</label>
        <select id="statut" name="statut">
          <option value="1">---</option>
          <option value="1" <?php if ($statut == 1) echo "selected"; ?>>À faire</option>
          <option value="2" <?php if ($statut == 2) echo "selected"; ?>>En cours</option>
          <option value="3" <?php if ($statut == 3) echo "selected"; ?>>Terminé</option>
        </select>
      </div>
      <div class="input-label">
        <input class="button background-vert" type="submit" value="Enregistrer">

      </div>
      <?php if ($id_tache) { ?>
      <div class="input-label">
        <a class="button background-rouge" style="display:block; text-align:center;"
          href="./../traitement/supprimer_tache_traitement.php?id_tache=<?php echo $tache['id_tache']; ?>">Supprimer</a>
      </div>
      <?php } ?>

    </form>
  </div>

  <?php FermerConnexion($connexion); ?>
</body>

</html>