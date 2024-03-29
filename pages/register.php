<?php
session_start(); // Démarrage de la session
$title = 'Inscription'; // Déclaration du titre de la page
require '../core/function.php'; // Inclusion du fichier de fonctions
include 'partials/head.php'; // Inclusion du fichier d'en-tête
?>
<div class="container text-center">
    <?php include 'partials/menu.php'; ?>
    <h1 class="mt-3 text-center">Formulaire d'inscription</h1>

    <div class="col-6 m-auto border border-3 rounded p-3">
        <?php messageSession(); ?>
        <form method="POST" action="controllers/addUser.php">
            <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" name="name" id="name" class="form-control border-4">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control border-4">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control border-4">
            </div>

            <input type="submit" name="submit" class="btn btn-primary">
        </form>
    </div>
</div>

<?php
include 'partials/footer.php';
