<?php

require __DIR__ . '/../vendor/autoload.php'; // Inclusion de l'autoloader de Composer


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

// Essaie d'établir la connexion à la base de données
try {

    // Crée un nouvel objet PDO pour la connection
    $bdd = new PDO("mysql:host=$dbHost;dbname=$dbName", "$dbUser", "$dbPass", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}

// Capture les exeptions si la connection échoue
catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}
?>