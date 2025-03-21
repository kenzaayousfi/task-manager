<?php
session_start();
if (!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) {
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
  <title>Liste taches</title>
</head>

<body>
  <?php include '../menu.php';

  $mot_cle = "";
  $statut = "";
  $tri = "";
  $requete = "SELECT id_tache,titre ,description, date_fin, statut FROM taches where id_utilisateur={$_SESSION['id_utilisateur']}";

  if (isset($_GET['mot_cle']) && !empty($_GET['mot_cle'])) {
    $mot_cle = $_GET['mot_cle'];
    // Ajouter la condition de recherche dans le titre et la description
    $requete .= " AND (titre LIKE '%$mot_cle%' OR description LIKE '%$mot_cle%')";
  }
  // Filtrer par statut si spécifié
  if (isset($_GET['statut']) && !empty($_GET['statut'])) {
    $statut = $_GET['statut'];
    $requete .= " AND statut='$statut'";
  }

  if (isset($_GET['expire'])) {
    $requete .= " AND statut != '3'
    AND (date_fin <= DATE_ADD(CURDATE(), INTERVAL 1 DAY) OR date_fin <= CURDATE())";
  }

  // Trier par date si spécifié
  if (isset($_GET['tri']) && $_GET['tri'] === 'date_fin') {
    $tri = $_GET['tri'];

    $requete .= " ORDER BY date_fin";
  } elseif (isset($_GET['tri']) && $_GET['tri'] === 'statut') {
    $tri = $_GET['tri'];

    // Trier par statut si spécifié
    $requete .= " ORDER BY statut";
  } elseif (isset($_GET['tri']) && $_GET['tri'] === 'id_tache') {
    $tri = $_GET['tri'];

    // Trier par statut si spécifié
    $requete .= " ORDER BY id_tache";
  }



  $res = mysqli_query($connexion, $requete);
  ?>

  <div class="page-liste_tache">
    <h1>Liste de taches</h1>
    <h2> <a class="button background-vert" href="./tache.php">créer une nouvelle tache</a>
    </h2>

    <?php
    $requete_alerte = "SELECT id_tache, titre, description, date_fin, statut 
      FROM taches 
      WHERE 
       id_utilisateur={$_SESSION['id_utilisateur']}
      AND statut != '3'
      AND (date_fin <= DATE_ADD(CURDATE(), INTERVAL 1 DAY) OR date_fin <= CURDATE())";

    $result_alerte = mysqli_query($connexion, $requete_alerte);
    // Vérification s'il y a des résultats
    if ($result_alerte->num_rows > 0) {
    ?>
    <div class="alert">
      <span>Attention : Certaines tâches ne sont pas terminées et arrivent (ou sont déjà arrivées) à leur date de fin.
        Pensez à les faire !</span>
      <a href="?expire=true">voir ces taches </a>
    </div>


    <?php } ?>


    <form class="formulaire_filtre" method="GET">
      <div class="container_input">
        <div class="input-label">
          <label for="recherche">Recherche :</label>
          <input placeholder="Rechercher dans le titre ou description" type="text" id="recherche" name="mot_cle"
            value="<?php echo $mot_cle ?>">
        </div>
        <div class="input-label"> <label for="statut">Statut :</label>
          <select id="statut" name="statut">
            <option value="">Tous</option>
            <option value="1" <?php echo ($statut === '1') ? 'selected' : ''; ?>>À faire
            </option>
            <option value="2" <?php echo ($statut === '2') ? 'selected' : ''; ?>>En cours
            </option>
            <option value="3" <?php echo ($statut === '3') ? 'selected' : ''; ?>>Terminé
            </option>
          </select>
        </div>

        <div class="input-label"> <label for="tri">Trier par :</label>
          <select id="tri" name="tri">
            <option value="id_tache" <?php echo ($tri === 'id_tache') ? 'selected' : ''; ?>>id tache</option>
            <option value="date_fin" <?php echo ($tri === 'date_fin') ? 'selected' : ''; ?>>Date</option>
            <option value="statut" <?php echo ($tri === 'statut') ? 'selected' : ''; ?>>Statut</option>

          </select>
        </div>
      </div>
      <div class="actions_filtre">
        <a class="button background-bleu" href="?">Reset</a>
        <button type="submit" class="button background-vert">Rechercher</button>
      </div>
    </form>


    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Titre</th>
          <th>Date Limite</th>
          <th>statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Récupération et affichage des résultats ligne par ligne
        while ($tache = mysqli_fetch_array($res)) {
        ?>
        <tr>
          <td><?php echo $tache['id_tache']; ?></td>
          <td><?php echo $tache['titre']; ?></td>
          <td><?php echo $tache['date_fin']; ?></td>
          <td>
            <?php
              // Affichage du statut en fonction de la valeur dans la base de données
              switch ($tache['statut']) {
                case '1':
                  echo "A faire";
                  break;
                case '2':
                  echo "En cours";
                  break;
                case '3':
                  echo "Terminé";
                  break;
                default:
                  echo "Statut inconnu";
              }
              ?>
          </td>
          <td class="actions">
            <a class="button background-bleu"
              href="./tache.php?id_tache=<?php echo $tache['id_tache']; ?>">Afficher/modifier</a>

            <a class="button background-rouge"
              href="./../traitement/supprimer_tache_traitement.php?id_tache=<?php echo $tache['id_tache']; ?>">Supprimer</a>
          </td>
        </tr>
        <?php
        }
        ?>




      </tbody>
    </table>
  </div>

  <?php FermerConnexion($connexion); ?>
</body>

</html>