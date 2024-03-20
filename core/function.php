<?php
function logedIn(){
    if(!isset($_SESSION['profil'])){
        header('Location: index.php');
        exit;
      }
}
function displayUsers(){
  global $bdd;
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
}