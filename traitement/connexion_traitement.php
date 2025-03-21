<?php
session_start();
include_once '../bdd/base_de_donnees.php';
$connexion = ouvrirLaConnexion();


if (
    isset($_POST['email']) && isset($_POST['mot_de_passe']) && !empty($_POST['email']) && !empty($_POST['mot_de_passe'])
) {

    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $requete = "SELECT id_utilisateur FROM utilisateurs WHERE email = '$email' AND mot_de_passe = '$mot_de_passe'";
    $res = mysqli_query($connexion, $requete);


    if (mysqli_num_rows($res) > 0) {
        // Récupérer l'utilisateur
        $utilisateur = mysqli_fetch_assoc($res);
        // Récupérer l'id de l'utilisateur
        $id_utilisateur = $utilisateur['id_utilisateur'];

        // Créer la variable de session id_utilisateur
        $_SESSION['id_utilisateur'] = $id_utilisateur;

        // Rediriger vers la page d'accueil 
        header("Location: ./../pages/liste_tache.php");

        exit();
    } else {
        echo "L'utilisateur n'existe pas";
        // header("Location: ./../pages/connexion.php");
        exit();
    }
} else {
    echo "Tous les champs sont requis.";
}
FermerConnexion($connexion);
?>