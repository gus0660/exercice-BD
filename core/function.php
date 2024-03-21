<?php
function logedIn(){
  if (!isset($_SESSION['profil'])) {
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
  if (isset($_SESSION['message'])) { // Vérification de l'existence du message de la session
    echo "<h5>" . $_SESSION['message'] . "</h5>"; // Affichage du message de la session
    unset($_SESSION['message']); // Suppression du message de la session
  }
}
function validatNotImpty($fiel, $fieldName){
  if (empty($fiel)) {
    return "Le champ $fieldName ne peut pas être vide!";
  }
}
function validateUserName($name){
  // Vérifie si le nom d'utilisateur correspond à l'expression régulière spécifiée
    // L'expression régulière '/^[a-zA-Z]{4,30}$/' signifie :
    // ^ : le début de la chaîne de caractères
    // [a-zA-Z] : n'importe quelle lettre minuscule ou majuscule (sans chiffres ni caractères spéciaux)
    // {4,30} : la longueur du nom doit être d'au moins 4 caractères et de maximum 30 caractères
    // $ : la fin de la chaîne de caractères
  if (!preg_match('/^[a-zA-Z]{4,30}$/', $name)) {
    return "Le nom de l'utilisateur doit être composé de 4 à 30 lettres et sans chiffres ou caractères spéciaux!";
  }
  return null;
}
function validateEmail($email) {
  global $bdd;
  // Expression régulière pour valider le format de l'email
  $emailRegex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';

  // Vérifie si l'email correspond au format de l'expression régulière
  if (!preg_match($emailRegex, $email)) {
      return null;
  }

  // Préparation de la requête pour vérifier si l'email existe déjà dans la base de données
  $stmt = $bdd->prepare("SELECT COUNT(*) FROM liste_utilisateurs WHERE email = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();

  // Récupération du résultat
  $result = $stmt->fetchColumn();

  // Vérifie si l'email existe déjà
  if ($result > 0) {
      return null;
  }
}
function validatePassword($password){
  if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{4,30}$/', $password)){
 return "Le mot de passe doit être composé de 4 à 30 lettres et des chiffres!";
  }
  return null;
}
function logOutUser(){
  if (isset($_GET['logout']) && $_GET['logout'] == 'success'){ // Vérification de la déconnexion
    $message = "Vous avez été déconnecté avec succès."; // Message de déconnexion
  }
  if (isset($message)) {
    echo "<h5>$message</h5>";
  }
}
