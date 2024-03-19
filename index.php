<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Liste d'inscription</title>
    <script>
        function confirmDelete() {
            return confirm("Êtes-vous sûr de vouloir vider la base de données ?");
        }
    </script>
</head>

<body>
    <div class="container">
        <form class="m-5" action="#" method="post">
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
                    <input class="btn btn-danger" type="submit" name="clearDB" value="Vider la base de données" onclick="return confirmDelete();">
                </div>
            </div>

            <?php
            require 'db.php';
            
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

            // Vérifie si le formulaire à été soumis et que nameInput est présent
            if (isset($_POST['submit'])) {

                // Stocke la valeur entrée par l'utilisateur dans une variable
                if (!empty($_POST['nameInput']) &&!empty($_POST['emailInput']) &&!empty($_POST['passInput'])) {
                $nameInput = $_POST['nameInput'];
                $emailInput = $_POST['emailInput'];
                $passInput = password_hash($_POST['passInput'], PASSWORD_DEFAULT);
                }else {
                    echo "<script>alert('Veuillez remplir tous les champs');</script>";
                    // header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }
                $qstmt = $bdd->prepare("SELECT COUNT(*) FROM liste_utilisateurs WHERE nom = :nameInput");
                $qstmt->bindParam(':nameInput', $nameInput);
                $qstmt->execute();
                $result = $qstmt->fetch();
                if ($result['COUNT(*)'] > 0) {
                    echo "<script>alert('Nom déjà utilisé');</script>";
                } else {
                    // Prépare la requète SQL pour insérer le nom dans la base de donnée
                    $sql = "INSERT INTO liste_utilisateurs (Nom, email, password) VALUES (:nom, :email, :password)";
                    $req = $bdd->prepare($sql);

                    // lie le paramètre nom à la valeur entrée par l'utilisateur
                    $req->bindValue(':nom', $nameInput);
                    // lie le paramètre email à la valeur entrée par l'utilisateur
                    $req->bindValue(':email', $emailInput);
                    // lie le paramètre password à la valeur entrée par l'utilisateur
                    $req->bindValue(':password', $passInput);

                    // Exécute la requête
                    $req->execute();
                    echo "Inscription effectuée avec succès : ";
                }
            }
            

// partie pour le bouton pour vider la base de données, pour suprimer ce bouton, suprimer le code qui suit,
// ne pas oublier de suprimer aussi le script "confirmDelete" dans le head et le "button Vider la base de données" html

            // Vérifie si le bouton pour vider la base de données a été cliqué
            if (isset($_POST['clearDB'])) {
                // Requête SQL pour vider la table
                $sql = "TRUNCATE TABLE liste_utilisateurs";
                $req = $bdd->prepare($sql);
                $req->execute();

                // Rediriger vers la même page pour rafraîchir les données affichées
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;

                echo "<script>alert('Base de données vidée');</script>";
            }

            ?>

        </form>

    </div>


    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>