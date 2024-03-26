<?php 
session_start();
require '../core/function.php'; // Inclusion du fichier de fonctions
logedIn(); // Appel de la fonction de connexion
$title = 'ADMIN'; // Déclaration du titre de la page
var_dump($_SESSION['profil']);
die();
// Vérifiez si l'utilisateur est connecté et si son rôle est 'role_admin'
if (!isset($_SESSION['profil']) || !in_array('role_admin', $_SESSION['profil'])){
    header('Location: login.php');
    exit();
}
echo "<h1>Bienvenue sur la page ADMINISTRATION</h1>";



$user = $_SESSION['profil']; // Récupération des données de l'utilisateur
include 'partials/head.php'; // Inclusion du fichier d'en-tête
?>
<section class="container text-center">
  <?php include 'partials/menu.php'; ?>
  <div class="border border-3 m-3">
    <h1 class="d-inline-block border border-3 m-3">Coucou <?= $user['name'] ?></h1>
    <pre class="border border-3 m-3">id user : <?= $user['id'] ?></pre>
    <p class="border border-3 m-3"> <?= $user['email'] ?></p>
    <p>Date d'inscription : <?= isset($user['dateInscription']) ? $user['dateInscription'] : 'Non disponible' ?></p>
    <a href="controllers/logout.php">déconnexion</a>
  </div>

</section>

?>