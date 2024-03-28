<?php 
session_start();
require '../core/function.php'; // Inclusion du fichier de fonctions
logedIn(); // Appel de la fonction de connexion
$title = 'ADMIN'; // Déclaration du titre de la page
$user = $_SESSION['profil']; // Récupération des données de l'utilisateur
include 'partials/head.php'; // Inclusion du fichier d'en-tête
?>

<section class="container text-center col-6">
  <h1>Bienvenue sur la page ADMINISTRATION</h1>
  <?php include 'partials/menu.php'; ?>
  <div class="border border-3 m-3">
    <h1 class="d-inline-block border border-3 m-3">Bonjours <?= $user['name'] ?></h1>
    <pre class="border border-3 m-3">id user : <?= $user['id'] ?></pre>
    <p class="border border-3 m-3"> <?= $user['email'] ?></p>
    <p>Date d'inscription : <?= isset($user['dateInscription']) ? $user['dateInscription'] : 'Non disponible' ?></p>
    <a href="controllers/logout.php">déconnexion</a>
  </div>

</section>

?>