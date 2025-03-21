<?php
include_once '../bdd/base_de_donnees.php';
$connexion = ouvrirLaConnexion();

if (
    isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_de_naissance']) && isset($_POST['genre']) && isset($_POST['email']) && isset($_POST['mot_de_passe']) &&
    !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['date_de_naissance']) && !empty($_POST['genre']) && !empty($_POST['email']) && !empty($_POST['mot_de_passe'])
) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_de_naissance = $_POST['date_de_naissance'];
    $genre = $_POST['genre'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];


    $requete = "INSERT INTO utilisateurs (nom, prenom, date_de_naissance, genre, email, mot_de_passe) VALUES ('$nom', '$prenom', '$date_de_naissance', '$genre', '$email', '$mot_de_passe')";
    mysqli_query($connexion, $requete);
    $erreur_sql = mysqli_error($connexion);
    if ($erreur_sql) {
        echo "Erreur lors de l'insertion dans la base de données : " . $erreur_sql;
    } else {
        echo "Données insérées avec succès.";
        //rediriger vers la page de connexion
        header("Location: ./../pages/connexion.php");
    }
} else {
    // erreur certains champs sont manquants, 
    echo "Tous les champs sont requis.";
}


FermerConnexion($connexion);
?>