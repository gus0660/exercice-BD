<?php
session_start(); // Démarre la session pour pouvoir utiliser $_SESSION
if (isset($_POST['name'])) {
    $username = $_POST['name']; // Récupération du nom d'utilisateur
    require_once('db.php'); // Connexion à la base de données
    // Vérification de l'existence du nom dans la base de données
    $sql = "SELECT COUNT(*) FROM username WHERE `name` = :name"; // Requête SQL pour compter le nombre de noms identiques
    $stmt = $pdo->prepare($sql); // Préparation de la requête
    $stmt->bindParam(':name', $username); // Liaison de la variable $username à la requête
    $stmt->execute(); // Exécution de la requête
    $nameCount = $stmt->fetchColumn(); // Récupération du résultat

    if ($nameCount == 0) {
        // Le nom n'existe pas, donc on peut l'insérer
        $sql = "INSERT INTO username (`name`) VALUES (:name)"; // Requête SQL pour insérer un nouveau nom
        $stmt = $pdo->prepare($sql); // Préparation de la requête
        $stmt->bindParam(':name', $username); // Liaison de la variable $username à la requête
        $stmt->execute(); // Exécution de la requête
        
        $_SESSION['message'] = "Nouvel utilisateur ajouté."; // Message à afficher sur la page d'accueil
        header('Location: index.php'); // Redirigez l'utilisateur vers la page d'accueil
        exit; // Assurez-vous de terminer le script après la redirection

    } else {
        $_SESSION['message'] = "Le nom existe déjà dans la base de données."; // Message à afficher sur la page d'accueil
        header('Location: index.php'); // Redirigez l'utilisateur vers la page d'accueil
        exit; // Assurez-vous de terminer le script après la redirection
    }
    
} else {
    $_SESSION['message'] = "Veuillez entrer votre nom dans la liste."; // Message à afficher sur la page d'accueil
    header('Location: index.php'); // Redirigez l'utilisateur vers la page d'accueil
    exit; // Assurez-vous de terminer le script après la redirection
}