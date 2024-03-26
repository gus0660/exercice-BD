<?php
session_start(); // Démarrage de la session
$title = 'Connexion'; // Déclaration du titre de la page
require '../core/function.php'; // Inclusion du fichier de fonctions
include 'partials/head.php';

?>
<section class="container text-center">
    <?php include 'partials/menu.php'; ?>
    <div class="row m-5">
        <h1 class="mt-3 text-center">Formulaire de connexion</h1>
        <div class="col-6 m-auto border border-4 rounded p-3">
            <?php messageSession(); ?>
            <form method="POST" action="controllers/logUser.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <input type="submit" name="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</section>

<?php
include 'partials/footer.php';
?>