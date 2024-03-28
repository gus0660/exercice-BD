<?php
session_start();
require '../config/db.php';
require '../core/function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // var_dump($_SERVER['REQUEST_METHOD']);
    // die();
    $userId = $_POST['id'] ?? null;
    if ($userId) {
        deleteUser($userId);
    }
}

header('Location: ../admin'); // Rediriger vers la page admin après la suppression
exit();
