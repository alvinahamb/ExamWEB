<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/assets/css/connexion.css">
    <link rel="icon" href="">
    <title>Admin - Modifier Aliments</title>
</head>

<body>
    <div class="menu-fixe" style="box-shadow: 5px 5px 5px rgba(126, 126, 126, 0.575);">
        <div class="logo">
            <a href="home"><img width="80" height="80" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
        <div>
            <ul class="nav nav-tabs nav-justified">
                <li><a href="ajouterAliment">Ajouter</a></li>
                <li><a href="animaux">Animaux</a></li>
                <li>
                    <form action="deconnexion" method="get">
                        <button class="button">Deconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div style="margin-top: 15vh;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Admin</h1>
                    <p>Bienvenue sur la page d'administration !</p>
                </div>
            </div>
        </div>

        <?php if (isset($extra['message'])): ?>
            <div id="alert" class="alert alert-success" role="alert"><?= $extra['message'] ?></div>
        <?php endif; ?>

        <h2>Liste des Aliments - Modifier</h2>
        <form action="updateAliments" method="post" enctype="multipart/form-data">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>NomAliment</th>
                    <th>TypeAnimal</th>
                    <th>% Gain Poids</th>
                    <th>Prix Unitaire ($)</th>
                    <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $Aliments) : ?>
                        <tr>
                            <td>
                                <input type="text" name="NomAliment[<?= $Aliments['IdAliment'] ?>]" value="<?= $Aliments['NomAliment'] ?>" required>
                            </td>
                            <td>
                                <input type="text" name="TypeAnimal[<?= $Aliments['IdAliment'] ?>]" value="<?= $Aliments['TypeAnimal'] ?>" required>
                            </td>
                            <td>
                                <input type="number" name="PourcentageGainPoids[<?= $Aliments['IdAliment'] ?>]" value="<?= $Aliments['PourcentageGainPoids'] ?>" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="PrixUnitaire[<?= $Aliments['IdAliment'] ?>]" value="<?= $Aliments['PrixUnitaire'] ?>" required>
                            </td>
                            <td>
                                <input type="number" name="Stock[<?= $Aliments['IdAliment'] ?>]" value="<?= $Aliments['Stock'] ?>" required>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p align="right"><input type="submit" value="Valider"></p>
        </form>
    </div>

    <footer>
        <p>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
    </footer>
</body>

</html>
