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



if (
    isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['date_fin']) && isset($_POST['statut'])  &&
    !empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['date_fin']) && !empty($_POST['statut'])
) {



    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_fin = $_POST['date_fin'];
    $statut = $_POST['statut'];

    if (isset($_POST['id_tache']) && !empty($_POST['id_tache'])) {
        // update : modifier la tache
        $id_tache = $_POST['id_tache'];

        $requete = "UPDATE taches SET titre='$titre', description='$description', date_fin='$date_fin', statut='$statut' WHERE id_tache=$id_tache";
    } else {
        // INSERT : ajouter nouvelle tache 
        $id_utilisateur = $_SESSION['id_utilisateur'];
        $requete = "INSERT INTO taches (id_utilisateur, titre, description, date_fin, statut) VALUES ('$id_utilisateur','$titre', '$description', '$date_fin', '$statut')";
    }
    mysqli_query($connexion, $requete);
    $erreur_sql = mysqli_error($connexion);
    if ($erreur_sql) {
        echo "Erreur lors de l'insertion dans la base de données : " . $erreur_sql;
    } else {
        header("Location: ./../pages/liste_tache.php");
    }
} else {

    // Certains champs sont manquants, afficher un message d'erreur
    echo "Tous les champs sont requis.kk";
}

FermerConnexion($connexion);
?>