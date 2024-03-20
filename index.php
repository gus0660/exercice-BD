<?php
session_start();
require 'config/db.php';
$title = 'Accueil'; // déclaration du titre de la page
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>alert('Inscription réussie');</script>";
}
if (isset($_GET['logout']) && $_GET['logout'] == 'success') { // Vérification de la déconnexion
    $message = "Vous avez été déconnecté avec succès."; // Message de déconnexion
}
include 'pages/partials/head.php'; // Inclusion du fichier d'en-tête



?>
<?php if (isset($message)) {
    echo "<h5>$message</h5>";
} ?> <!-- Affichage du message de déconnexion -->
<section class="container">
    <?php include 'pages/partials/menu.php'; 
    if (isset($_SESSION['message'])) { // Vérification de l'existence du message de la session
        echo "<h5>" . $_SESSION['message'] . "</h5>"; // Affichage du message de la session
        unset($_SESSION['message']); // Suppression du message de la session
    }
    ?>
    <form class="m-5" action="controllers/addUser.php" method="POST">

        <div class="row justify-content-center">
        
            <div class="col-12 col-md-6 col-lg-4">
                
                <div class="form-group text-center">
                    
                    <h1 class="m-3">ADMINISTRATION BASE DE DONNEES</h1>
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
                <!-- <input class="btn btn-danger" type="submit" name="clearDB" value="Vider la base de données" onclick="return confirmDelete();"> -->
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <?php
                // Prépare une requête SQL pour récupérer toutes les entrées de la table
                $sql = "SELECT * FROM liste_utilisateurs";
                $req = $bdd->prepare($sql);

                // Exécute la requête
                $req->execute();

                // Récupère tous les utilisateurs en tant qu'array
                $users = $req->fetchAll();

                // Parcourt et affiche le nom de chaque utilisateur
                foreach ($users as $user) {
                    echo "<p class='user-name'>" . htmlspecialchars($user['Nom']) . "</p>";
                }
                ?>
            </div>
        </div>
    </form>
</section>
<?php include 'pages/partials/footer.php';?>