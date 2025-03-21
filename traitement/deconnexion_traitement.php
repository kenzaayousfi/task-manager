<?php
// Démarrez la session
session_start();

// Supprimez toutes les variables de session
$_SESSION = array();

// Détruisez la session
session_destroy();

// Redirigez l'utilisateur vers la page de connexion
header("Location: ./../pages/connexion.php");
exit();
?>