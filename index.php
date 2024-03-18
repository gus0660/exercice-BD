<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Liste d'inscription</title>
</head>
<body>
    <form class="m-5" action="#" method="post">
        <div class="form-group text-center">
            <label for="nameInput">Nom</label>
            <input type="text" class="form-control w-25" id="nameInput" name="nameInput">
            <button class="btn btn-primary" type="submit">S'enregistrer'</button>
    </form>

    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php
if (isset($_POST['nameInput'])) {
    $nameInput = $_POST['nameInput'];
    try{
        $bdd = new PDO('mysql:host=localhost:3306;dbname=Liste_inscription', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
      }
      catch (PDOException $e) {
          echo 'Echec de la connexion : ' . $e->getMessage();
          exit;
      }
      $sql = "INSERT INTO archives (Nom) VALUES (:nom)";
      $req = $bdd->prepare($sql);
      $req->bindValue(':nom', $nameInput);
      $req->execute();
      echo "Inscription effectuée avec succès";
      $sql = "SELECT * FROM archives";
      $req = $bdd->prepare($sql);
      $req->execute();
      $users = $req->fetchAll();
      foreach ($users as $user) {
          echo $user['Nom']."<br>";
      }
}
?>