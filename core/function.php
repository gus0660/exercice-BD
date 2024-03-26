<?php

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
function logedIn(){
  if (!isset($_SESSION['profil'])) {
    header('Location: index.php');
    exit;
  }
}
function logOutUser(){
  if (isset($_GET['logout']) && $_GET['logout'] == 'success'){ // Vérification de la déconnexion
    $message = "<div class='alert alert-success col-6 m-auto p-3 my-3'>Vous etes bien déconnecté</div>"; // Message de déconnexion
  }
  if (isset($message)) {
    echo "$message";
  }
}
function messageSession(){
  if (isset($_SESSION['message'])) { // Vérification de l'existence du message de la session
    echo "<h5>" . $_SESSION['message'] . "</h5>"; // Affichage du message de la session
    unset($_SESSION['message']); // Suppression du message de la session
  }
}
function getUserByEmail($email){
  global $bdd;
  try {
    $sql = "SELECT * FROM liste_utilisateurs WHERE email = :email";
    $req = $bdd->prepare($sql);
    $req->bindParam(':email', $email);
    $req->execute();
    $user = $req->fetch();
    return $user;
  } catch (PDOException $e) {
    echo $e->getMessage();
    return null;
  }
}
function createUser($name, $email, $password){
  global $bdd;
  $hashPass = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO liste_utilisateurs (Nom, email, password) VALUES ('$name', '$email', '$password')";
  $req = $bdd->prepare($sql);
  $req->bindParam(':Nom', $name);
  $req->bindParam(':email', $email);
  $req->bindParam(':password', $hashPass);
  if ($bdd->execute($sql)) {
    return $bdd->lastInsertId();
  }
  return false;
}
function validateUserExist($email) {
  global $bdd;
  $sql = "SELECT COUNT(*) FROM liste_utilisateurs WHERE email = :email";
  $req = $bdd->prepare($sql);
  $req->bindParam(':email', $email);
  $req->execute();
  if ($req->fetchColumn() > 0) {
    return $_SESSION['flash']['danger'] = "Cet email est déjà utilisé.";
  }
  return null;
}
function validatNotImpty($fiel, $fieldName){
  if (empty($fiel)) {
    return "Le champ $fieldName ne peut pas être vide!";
  }
}
function validateUserName($name){
  global $bdd;
  // Vérifie si le nom d'utilisateur correspond à l'expression régulière spécifiée
    // L'expression régulière '/^[a-zA-Z]{4,30}$/' signifie :
    // ^ : le début de la chaîne de caractères
    // [a-zA-Z] : n'importe quelle lettre minuscule ou majuscule (sans chiffres ni caractères spéciaux)
    // {4,30} : la longueur du nom doit être d'au moins 4 caractères et de maximum 30 caractères
    // $ : la fin de la chaîne de caractères
  if (!preg_match('/^[a-zA-Z]{4,30}$/', $name)) {
    // Si le nom ne correspond pas, retourne un message d'erreur
    return "Le nom de l'utilisateur doit être composé de 4 à 30 lettres et sans chiffres ou caractères spéciaux!";
  }
  // Préparation de la requête pour vérifier si le nom existe déjà dans la base de données
  $stmt = $bdd->prepare("SELECT COUNT(*) FROM users WHERE username = :name");
  $stmt->bindParam(':name', $name);
  $stmt->execute();

  // Récupération du résultat de la requête
  $count = $stmt->fetchColumn();

  // Vérification si le nom d'utilisateur existe déjà
  if ($count > 0) {
      return "Le nom existe déjà.";
  }
  // Si le nom est valide, retourne null
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