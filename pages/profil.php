<?php
session_start(); // Démarrage de la session
$title = 'Profil'; // Déclaration du titre de la page
require '../core/function.php'; // Inclusion du fichier de fonctions
logedIn(); // Appel de la fonction de connexion
$user = $_SESSION['profil']; // Récupération des données de l'utilisateur
// var_dump($_SESSION['profil']);
// die();
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

<?php
include 'partials/footer.php'; // Inclusion du fichier de pied de page