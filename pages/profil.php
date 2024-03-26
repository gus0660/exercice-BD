<?php
  session_start(); // Démarrage de la session
  $title = 'Profil'; // Déclaration du titre de la page
  require '../core/function.php'; // Inclusion du fichier de fonctions
  logedIn(); // Appel de la fonction de connexion
  $user = $_SESSION['profil']; // Récupération des données de l'utilisateur
  include 'partials/head.php'; // Inclusion du fichier d'en-tête
 ?>
<section class="container text-center">
  <?php include 'partials/menu.php'; ?>
  <h1>Coucou <?= $user['name'] ?> et <?php echo $user['name'] ?></h1>
    <pre>id user : <?= $user['id']?></pre>
    <p> <?= $user['email'] ?></p>
    <p> password crypté : <br><?= $user['password'] ?></p>
    <a href="controllers/logout.php">déconnexion</a>
</section>
    
<?php
  include 'partials/footer.php'; // Inclusion du fichier de pied de page