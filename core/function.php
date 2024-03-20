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
function messageSession(){
  global $_SESSION;
  if (isset($_SESSION['message'])) { // Vérification de l'existence du message de la session
    echo "<h5>" . $_SESSION['message'] . "</h5>"; // Affichage du message de la session
    unset($_SESSION['message']); // Suppression du message de la session
}
}