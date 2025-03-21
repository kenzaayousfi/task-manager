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

    $id_utilisateur = $_SESSION['id_utilisateur'];
    $requete_supprimer_utlisateur = "DELETE FROM utilisateurs WHERE id_utilisateur = $id_utilisateur";
    $requete_supprimer_tache = "DELETE FROM taches WHERE id_utilisateur = $id_utilisateur";


    mysqli_query($connexion, $requete_supprimer_utlisateur);
    mysqli_query($connexion, $requete_supprimer_tache);
    $erreur_sql = mysqli_error($connexion);
    if ($erreur_sql) {
        echo "Erreur lors de la suppression dans la base de données : " . $erreur_sql;
    } else {
        // Supprimez toutes les variables de session
        $_SESSION = array();

        // Détruisez la session
        session_destroy();
        header("Location: ./../pages/connexion.php");
    }

FermerConnexion($connexion);
?>