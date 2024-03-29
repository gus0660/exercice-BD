<?php
session_start();
require_once '../config/db.php';
require_once '../core/function.php';
// Vérifie si le formulaire à été soumis
if (isset($_POST['submit'])) {
    $nameError = validateNotEmpty($_POST['name'], 'Nom') ?: validateUserName($_POST['name']);
    $emailError = validateNotEmpty($_POST['email'], 'email') ?: validateEmail($_POST['email']);
    $passwordError = validateNotEmpty($_POST['password'], 'Password') ?: validatePassword($_POST['password']);
    if ($nameError || $emailError || $passwordError) {
        $_SESSION['flash']['danger'] = $nameError ?: ($emailError ?: $passwordError);
        header('location: ../register');
        exit();
    }
    $userExistError = validateUserExist($_POST['email']);
    if ($userExistError) {
        $_SESSION['flash']['danger'] = $userExistError;
        header('location: ../register');
        exit();
    }
    $user = createUser($_POST['name'], $_POST['email'], $_POST['password']);
    $userId = $user['id'];
    $sql = 'SELECT nom FROM liste_utilisateurs_roles JOIN role ON  id_role = id WHERE id_utilisateur = :iduser';
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':iduser', $userId);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if ($user) {
        $_SESSION['profil'] = ['name' => $_POST['name'], 'email' => $_POST['email'], 'dateInscription' => $user['dateInscription'], 'id' => $userId, 'roleLevel' => $result];
        $_SESSION['flash']['success'] = 'Votre compte a bien été créé' . ' !';
        header('location: ../profil');
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'Une erreur est survenue lors de la création du compte';
        header('location: ../register');
        exit();
    }
}
