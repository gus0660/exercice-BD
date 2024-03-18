<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Liste d'inscription</title>
</head>

<body>
    <div class="container">
        <form class="m-5" action="#" method="post">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group text-center">
                        <label for="nameInput">Nom</label>
                        <input type="text" class="form-control m-2 border border-4" id="nameInput" name="nameInput" placeholder="Entrez votre Nom">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <button class="btn btn-primary" type="submit">S'enregistrer'</button>
                </div>
            </div>

            <?php
            require 'db.php';

            // Vérifie si le formulaire à été soumis et que nameInput est présent
            if (isset($_POST['nameInput'])) {

                // Stocke la valeur entrée par l'utilisateur dans une variable
                $nameInput = $_POST['nameInput'];

                $qstmt = $bdd->prepare("SELECT COUNT(*) FROM liste_utilisateurs WHERE nom = :nameInput");
                $qstmt->bindParam(':nameInput', $nameInput);
                $qstmt->execute();
                $result = $qstmt->fetch();
                if ($result['COUNT(*)'] > 0) {
                    echo "<script>alert('Nom déjà utilisé');</script>";
                } else {
                    // Prépare la requète SQL pour insérer le nom dans la base de donnée
                    $sql = "INSERT INTO liste_utilisateurs (Nom) VALUES (:nom)";
                    $req = $bdd->prepare($sql);

                    // lie le paramètre nom à la valeur entrée par l'utilisateur
                    $req->bindValue(':nom', $nameInput);

                    // Exécute la requête
                    $req->execute();
                    echo "Inscription effectuée avec succès : ";
                }
            }
            // Prépare une requête SQL pour récupérer toutes les entrées de la table
            $sql = "SELECT * FROM liste_utilisateurs";
            $req = $bdd->prepare($sql);

            // Exécute la requête
            $req->execute();

            // Récupère tous les utilisateurs en tant qu'array
            $users = $req->fetchAll();

            // Parcourt et affiche le nom de chaque utilisateur
            foreach ($users as $user) {
                echo $user['Nom'] . "<br>";
            }
            ?>
            
        </form>

    </div>


    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>