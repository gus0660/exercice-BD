<?php
session_start();
$title = 'Accueil'; // déclaration du titre de la page
require 'config/db.php';
require 'core/function.php';
include 'pages/partials/head.php'; // Inclusion du fichier d'en-tête

?>
<section class="container justify-content-center">
    <?php include 'pages/partials/menu.php'; ?>

    <form class="m-5" action="controllers/addUser.php" method="POST">

        <div class="row justify-content-center">
        
            <div class="col-12 col-md-6 col-lg-4">
                
                <div class="form-group text-center">
                    <?php 
                    messageSession();
                    logOutUser();
                    ?>
                    <h1 class="m-3">BIENVENUE</h1>
                    <label for="nameInput">Nom</label>
                    <input type="text" class="form-control m-2 border border-4" id="nameInput" name="nameInput" placeholder="Entrez votre Nom">
                    <label for="emailInput">email</label>
                    <input type="email" class="form-control m-2 border border-4" id="emailInput" name="emailInput" placeholder="Entrez votre Email">
                    <label for="passInput">Password</label>
                    <input type="password" class="form-control m-2 border border-4" id="passInput" name="passInput" placeholder="Entrez votre Mot de Passe">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <input class="btn btn-primary" type="submit" name="submit">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <?php
                displayUsers();
                ?>
            </div>
        </div>
    </form>
</section>
<?php include 'pages/partials/footer.php';?>