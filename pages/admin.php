<?php 
session_start();
require '../config/db.php';
require '../core/function.php';
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
  </div>
  <div class="border border-3 m-3">
    <h2>Les utilisateurs enregistés</h2>
    <div class="row justify-content-center m-5">
            <div class="col-12 text-center border border-3 m-1">
                <p><?= displayUsersAdmin() ?></p>
            </div>
        </div>
  </div>

</section>
<?php include '../pages/partials/footer.php';?>