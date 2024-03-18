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
}
?>