<?php

function displayUsers()
{
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
};
function displayUsersAdmin()
{
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
    echo "<p class='user-name'>" . htmlspecialchars($user['Nom']);
    echo "<form action='delete_user.php' method='post'>
              <input type='hidden' name='id' value='" . $user['id'] . "'>
              <button type='submit' class='ms-3 btn btn-danger'>Supprimer</button>
          </form></p>";
  }
}

function logedIn()
{
  if (!isset($_SESSION['profil'])) {
    $_SESSION['flash']['danger'] = "Ce serait mieux d'être connecté pour accéder à cette page, non !?";
    header('Location: index.php');
    exit;
  }
  $currentPage = basename($_SERVER['PHP_SELF']);

  if ($currentPage === 'admin.php' && !in_array('role_admin', $_SESSION['profil']['roleLevel'])) {
    $_SESSION['flash']['danger'] = "désolé, mais vous n'avez pas les droits pour accéder à cette page";
    header('Location: index.php');
    exit;
  }
}

function logOutUser()
{
  if (isset($_GET['logout']) && $_GET['logout'] == 'success') { // Vérification de la déconnexion
    $message = "<div class='alert alert-success col-6 m-auto p-3 my-3'>Vous etes bien déconnecté</div>"; // Message de déconnexion
  }
  if (isset($message)) {
    echo "$message";
  }
}
function messageSession()
{
  if (isset($_SESSION['flash']['danger'])) { // Vérification de l'existence du message de la session
    echo "<h5>" . $_SESSION['flash']['danger'] . "</h5>"; // Affichage du message de la session
    unset($_SESSION['flash']['danger']); // Suppression du message de la session
  } elseif (isset($_SESSION['flash']['success'])) { // Vérification de  
    echo "<h5>" . $_SESSION['flash']['success'] . "</h5>"; // Affichage du message de la session
    unset($_SESSION['flash']['success']); // Suppression du message de la session
  }
}
function getUserByEmail($email)
{
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
function createUser($name, $email, $password)
{
  global $bdd;
  $hashPass = password_hash($password, PASSWORD_DEFAULT);
  $date = date('Y-m-d');
  $sql = "INSERT INTO liste_utilisateurs (Nom, email, password, dateInscription) VALUES (:nom, :email, :password, :dateInscription)";
  $req = $bdd->prepare($sql);
  $req->bindParam(':nom', $name);
  $req->bindParam(':email', $email);
  $req->bindParam(':password', $hashPass);
  $req->bindParam(':dateInscription', $date);
  if ($req->execute()) {
    $userId = $bdd->lastInsertId();
    $userRole = 1;
    $sql = "INSERT INTO liste_utilisateurs_roles (id_utilisateur, id_role) VALUES (:idUser, :idRole)";
    $req = $bdd->prepare($sql);
    $req->bindParam(':idUser', $userId);
    $req->bindParam(':idRole', $userRole);
    $req->execute();
    return ['id' => $userId, 'dateInscription' => $date];
  }
  return false;
}
function deleteUser($id)
{
  global $bdd;
  $sql = "DELETE FROM liste_utilisateurs WHERE id = :id";
  $req = $bdd->prepare($sql);
  $req->bindParam(':id', $id);
  $req->execute();
}
function validateUserExist($email)
{
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
function validateNotEmpty($field, $fieldName)
{
  if (empty($field)) {
    return "Le champ $fieldName ne peut pas être vide!";
  }
}
function validateUserName($name)
{
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
  $stmt = $bdd->prepare("SELECT COUNT(*) FROM liste_utilisateurs WHERE Nom = :name");
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
function validateEmail($email)
{
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
function validatePassword($password)
{
  if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{4,30}$/', $password)) {
    return "Le mot de passe doit être composé de 4 à 30 lettres et des chiffres!";
  }
  return null;
}
