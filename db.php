<?php

require 'secret.php';

// Essaie d'établir la connexion à la base de données
try {

    // Crée un nouvel objet PDO pour la connection
    $bdd = new PDO("mysql:host=$dbHost;dbname=$dbName", "$dbUser", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}

// Capture les exeptions si la connection échoue
catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}
?>