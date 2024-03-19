<?php
session_start();
require_once '../config/db.php';
// Vérifie si le formulaire à été soumis
if (isset($_POST['submit'])) {

    // Stocke la valeur entrée par l'utilisateur dans une variable
    if (!empty($_POST['nameInput']) && !empty($_POST['emailInput']) && !empty($_POST['passInput'])) {
        $nameInput = $_POST['nameInput'];
        $emailInput = $_POST['emailInput'];
        $passInput = password_hash($_POST['passInput'], PASSWORD_DEFAULT);
    } else {
        // echo "<script>alert('Veuillez remplir tous les champs');</script>";
        header("Location: index.php");
        exit;
    }
    require 'db.php';
    $qstmt = $bdd->prepare("SELECT COUNT(*) FROM liste_utilisateurs WHERE nom = :nameInput");
    $qstmt->bindParam(':nameInput', $nameInput);
    $qstmt->execute();
    
    $result = $qstmt->fetch();
    if ($result['COUNT(*)'] > 0) {
        echo "<script>alert('Nom déjà utilisé');</script>";
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
        
    }
    header("Location: index.php?success=1");
}
