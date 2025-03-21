<?php
session_start();
if (!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) {
	header("Location: ./connexion.php");
	exit();
}

include_once '../bdd/base_de_donnees.php';
$connexion = ouvrirLaConnexion();


// Requête pour récupérer le nombre total de tâches
$requete_total = "SELECT COUNT(*) AS total FROM taches  where id_utilisateur={$_SESSION['id_utilisateur']}";
$res_total = mysqli_query($connexion, $requete_total);
$row_total = mysqli_fetch_assoc($res_total);
$total_taches = $row_total['total'];

// Requête pour récupérer le nombre de tâches avec le statut "À faire"
$requete_a_faire = "SELECT COUNT(*) AS count FROM taches WHERE statut = '1'  and id_utilisateur={$_SESSION['id_utilisateur']}";
$res_a_faire = mysqli_query($connexion, $requete_a_faire);
$row_a_faire = mysqli_fetch_assoc($res_a_faire);
$count_a_faire = $row_a_faire['count'];


// Requête pour récupérer le nombre de tâches avec le statut "En cours"
$requete_en_cours = "SELECT COUNT(*) AS count FROM taches WHERE statut = '2'  and id_utilisateur={$_SESSION['id_utilisateur']}";
$res_en_cours = mysqli_query($connexion, $requete_en_cours);
$row_en_cours = mysqli_fetch_assoc($res_en_cours);
$count_en_cours = $row_en_cours['count'];


// Requête pour récupérer le nombre de tâches avec le statut "Terminé"
$requete_termine = "SELECT COUNT(*) AS count FROM taches WHERE statut = '3'  and id_utilisateur={$_SESSION['id_utilisateur']}";
$res_termine = mysqli_query($connexion, $requete_termine);
$row_termine = mysqli_fetch_assoc($res_termine);
$count_termine = $row_termine['count'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../style.css">
  <title>Dashboard</title>
</head>

<body>
  <?php include '../menu.php'; ?>

  <div class="container-dashboard">
    <h1>Tableau de bord (<?php echo $total_taches; ?> tache(s))</h1>
    <div class="circle-container">


      <div class="container-circle">
        <span class="title">À faire</span>
        <div class="circle a-faire">
          <span class="count"><?php echo $count_a_faire; ?></span>
        </div>
      </div>

      <div class="container-circle">
        <span class="title">En cours</span>
        <div class="circle en-cours">
          <span class="count"><?php echo $count_en_cours; ?></span>
        </div>
      </div>


      <div class="container-circle">
        <span class="title">Terminée(s)</span>
        <div class="circle termine">
          <span class="count"><?php echo $count_termine ?></span>
        </div>
      </div>

    </div>
  </div>
</body>

</html>