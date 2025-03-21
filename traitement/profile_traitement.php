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
    isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['date_de_naissance']) && isset($_POST['genre'])  &&
    !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['date_de_naissance']) && !empty($_POST['genre'])
) {


    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $date_de_naissance = $_POST['date_de_naissance'];
    $genre = $_POST['genre'];


    $id_utilisateur = $_SESSION['id_utilisateur'];



    $requete = "UPDATE utilisateurs SET 
        nom='$nom', 
        prenom='$prenom', 
        email='$email', 
        date_de_naissance='$date_de_naissance', 
        genre='$genre' WHERE id_utilisateur=$id_utilisateur";

    mysqli_query($connexion, $requete);
    $erreur_sql = mysqli_error($connexion);
    if ($erreur_sql) {
        echo "Erreur lors de l'insertion dans la base de données : " . $erreur_sql;
    } else {
        header("Location: ./../pages/profile.php");
    }
} else {

    // Certains champs sont manquants, afficher un message d'erreur
    echo "Tous les champs sont requis";
}

FermerConnexion($connexion);
?>