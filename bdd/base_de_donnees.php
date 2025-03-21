<?php
mysqli_report(MYSQLI_REPORT_ERROR); 

function ouvrirLaConnexion()
{
    $serveur = "localhost"; // ou 127.0.0.1
    $utilisateur = "root";
    $mot_de_passe = "";
    $nom_base_de_donnees = "projet_l1";

    $connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees);
    if (!$connexion) {
        die("La connexion a échoué : " . mysqli_connect_error());
    }
    
    return $connexion;
}

function FermerConnexion($conn)
{
    $conn->close();
}

?>