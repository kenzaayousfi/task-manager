<?php
session_start();
// Vérifier si l'utilisateur est déjà connecté en vérifiant s'il existe une variable de session id_utilisateur
if (!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) {
  // L'utilisateur n' est pas connecté, rediriger vers la page de connexion
  header("Location: ./../pages/connexion.php");
  exit();
}
include_once './../bdd/base_de_donnees.php';
$connexion = ouvrirLaConnexion();



if (
  isset($_POST['mot_de_passe_actuel']) && isset($_POST['nouveau_mot_de_passe']) && isset($_POST['confirmation_mot_de_passe'])   &&
  !empty($_POST['mot_de_passe_actuel']) && !empty($_POST['nouveau_mot_de_passe']) && !empty($_POST['confirmation_mot_de_passe'])
) {


  $mot_de_passe_actuel = $_POST['mot_de_passe_actuel'];
  $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];
  $confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'];



  $id_utilisateur = $_SESSION['id_utilisateur'];

  if ($nouveau_mot_de_passe != $confirmation_mot_de_passe) {
    echo "le nouveau mot de passe est different de la confimation";
    exit();
  }

  $requete = "SELECT mot_de_passe FROM utilisateurs WHERE id_utilisateur = $id_utilisateur";


  $res = mysqli_query($connexion, $requete);
  $utilisateur = mysqli_fetch_assoc($res);
  $mot_de_passe_bdd = $utilisateur['mot_de_passe'];

  if ($mot_de_passe_bdd != $mot_de_passe_actuel) {
    // afficher un message d'erreur si le mot de passe actuel est incorrect
    echo "le mot de passe actuel est incorrect";
    exit();
  }

  $requete_update = "UPDATE utilisateurs SET mot_de_passe = '$nouveau_mot_de_passe' WHERE id_utilisateur = $id_utilisateur";


  mysqli_query($connexion, $requete_update);
  $erreur_sql = mysqli_error($connexion);
  if ($erreur_sql) {
    echo "Erreur lors de la mise à jour dans la base de données : " . $erreur_sql;
  } else {
    header("Location: ./../pages/profile.php");
  }
} else {

  echo "Tous les champs sont requis";
}

FermerConnexion($connexion);
?>