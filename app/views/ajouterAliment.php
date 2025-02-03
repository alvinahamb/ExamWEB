<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/assets/css/connexion.css">
    <link rel="icon" href="">
    <title>Admin - Ajouter Aliment</title>

    <style>
        /* Style pour centrer le formulaire et limiter la largeur */
        .form-container {
            margin-top: 15vh;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-control-sm {
            width: 100%; /* Prendre toute la largeur du conteneur */
        }

        .form-group {
            margin-bottom: 1rem; /* Espacement entre les champs */
        }

        button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="menu-fixe" style="box-shadow: 5px 5px 5px rgba(126, 126, 126, 0.575);">
        <div class="logo">
            <a href="home"><img width="80" height="80" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
        <div>
            <ul class="nav nav-tabs nav-justified">
                <li><a href="modifierAliment">Modifier</a></li>
                <li><a href="aliments">Aliments</a></li>
                <li>
                    <form action="deconnexion" method="get">
                        <button class="button">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="form-container">
        <h1 class="text-center">Ajouter un Aliment</h1>
        <p class="text-center">Complétez le formulaire ci-dessous pour ajouter un nouvel aliment.</p>

        <form action="addAliment" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nomAliment">Nom de l'Aliment :</label>
                <input type="text" class="form-control form-control-sm" id="nomAliment" name="nomAliment" required>
            </div>

            <div class="form-group">
                <label for="typeAnimal">Type d'Animal :</label>
                <input type="text" class="form-control form-control-sm" id="typeAnimal" name="typeAnimal" required>
            </div>

            <div class="form-group">
                <label for="pourcentageGainPoids">Pourcentage de Gain de Poids (%) :</label>
                <input type="number" class="form-control form-control-sm" id="pourcentageGainPoids" name="pourcentageGainPoids" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="prixUnitaire">Prix Unitaire (€) :</label>
                <input type="number" class="form-control form-control-sm" id="prixUnitaire" name="prixUnitaire" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock :</label>
                <input type="number" class="form-control form-control-sm" id="stock" name="stock" required>
            </div>

            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" class="form-control form-control-sm" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Ajouter</button>
        </form>
    </div>

    <footer>
        <p class="text-center">Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
    </footer>
</body>
</html>
