<?php
session_start();
require_once '../config/db.php';
// Vérifie si le formulaire à été soumis
if (isset($_POST['submit'])) {


    // Vérification que les champs 'nameInput', 'emailInput' et 'passInput' ne sont pas vides
    if (!empty($_POST['nameInput']) && !empty($_POST['emailInput']) && !empty($_POST['passInput'])) {
    // Création d'une variable($nameInput) qui vient du post de nameInput.
        $nameInput = $_POST['nameInput']; // Stockage du nom

        $emailInput = filter_var($_POST['emailInput'], FILTER_VALIDATE_EMAIL); // Validation et stockage de l'email
        $passInput = password_hash($_POST['passInput'], PASSWORD_DEFAULT); // Hachage et stockage du mot de passe
        
    } else {
        // Enregistrement d'un message et redirection si tous les champs ne sont pas remplis
        $_SESSION['message'] = "Veuillez remplir tous les champs!";
        header("Location: ../index.php");
        exit;
    }
    // Connexion à la base de données (répétition, pourrait être supprimée si déjà connecté)
    require '../config/db.php';
    // Préparation de la requête pour vérifier si l'email est déjà utilisé
    $qstmt = $bdd->prepare("SELECT COUNT(*) FROM liste_utilisateurs WHERE email = :emailInput");
    $qstmt->bindParam(':emailInput', $emailInput); // Liaison de l'email à la requête
    $qstmt->execute();
    
    $result = $qstmt->fetch();
    if ($result['COUNT(*)'] > 0) {
        $_SESSION['message'] = "Email déjà utilisé!";
        header("Location:../index.php");
        exit;
    } else {
        // Prépare la requète SQL pour insérer le nom dans la base de donnée
        $sql = "INSERT INTO liste_utilisateurs (Nom, email, password) VALUES (:nom, :email, :password)";
        $req = $bdd->prepare($sql);

        // lie le paramètre nom à la valeur entrée par l'utilisateur
        $req->bindValue(':nom', $nameInput);
        // lie le paramètre email à la valeur entrée par l'utilisateur
        $req->bindValue(':email', $emailInput);
        // lie le paramètre password à la valeur entrée par l'utilisateur
        $req->bindValue(':password', $passInput);

        // Exécute la requête
        $req->execute();
        $idUser = $bdd->lastInsertId();
        $_SESSION['message'] = "Vous êtes bien inscrit !";
        $_SESSION['profil'] = ['name' => $nameInput, 'email' => $emailInput, 'password' => $passInput, 'id' => $idUser];
        header("Location: ../profil");
        exit();
    }
}

// if (isset($_POST['submit'])){
//         $nameError = validatNotImpty($_POST['nameInput'], 'Nom') ?: validateUserName($_POST['nameInput']);
//         $emailError = validatNotImpty($_POST['emailInput'], 'email') ?: validateEmail($_POST['emailInput']);
//         $passwordError = validatNotImpty($_POST['passInput'], 'Password')?: validatePassword($_POST['passInput']);
//     }