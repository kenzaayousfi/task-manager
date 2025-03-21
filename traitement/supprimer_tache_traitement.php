<?php

session_start();
// Vérifier si l'utilisateur est déjà connecté en vérifiant s'il existe une variable de session id_utilisateur
if (!isset($_SESSION['id_utilisateur']) || empty($_SESSION['id_utilisateur'])) {
  // L'utilisateur n' est pas connecté, rediriger vers la page de connexion
  header("Location: ./../pages/connexion.php");
    exit();
}

include_once '../bdd/base_de_donnees.php';
$connexion = ouvrirLaConnexion();
if (isset($_GET['id_tache']) &&!empty($_GET['id_tache'])) {
    $id_tache = $_GET['id_tache'];
    $id_utilisateur = $_SESSION['id_utilisateur'];
    $requete = "DELETE FROM taches WHERE id_tache = $id_tache and id_utilisateur=$id_utilisateur";

    mysqli_query($connexion, $requete);
    $erreur_sql = mysqli_error($connexion);
    if ($erreur_sql) {
        echo "Erreur lors de l'insertion dans la base de données : " . $erreur_sql;
    } else {
        header("Location: ./../pages/liste_tache.php");
    }
} else {

    echo "Tous les champs sont requis";
}

FermerConnexion($connexion);
?>