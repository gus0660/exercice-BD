<?php
session_start();
$title = 'Accueil'; // déclaration du titre de la page
require 'config/db.php';
require 'core/function.php';
include 'pages/partials/head.php'; // Inclusion du fichier d'en-tête

?>
<section class="container text-center">
    <?php include 'pages/partials/menu.php'; ?>

    

        <div class="row justify-content-center m-5">
        
            <div class="col-12 col-md-6 col-lg-4">
                
                <div class="text-center border border-3">
                    <?php 
                    messageSession();
                    logOutUser();
                    ?>
                    <h1 class="m-3">BIENVENUE</h1>
                    
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center m-5">
            <div class="col-6 text-center border border-3 m-2">
                <?php
                displayUsers();
                ?>
            </div>
        </div>
    
</section>
<?php include 'pages/partials/footer.php';?>