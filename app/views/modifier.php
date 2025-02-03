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
    <title>Admin - Formulaire</title>
</head>

<body>
    <div class="menu-fixe" style="box-shadow: 5px 5px 5px rgba(126, 126, 126, 0.575);">
        <div class="logo">
            <a href="home"><img width="80" height="80" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
        <div>
            <ul class="nav nav-tabs nav-justified">
                <li><a href="#">Ajouter</a></li>
                <li><a href="#">Aliments</a></li>
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

        <h2>Formulaire d'ajout d'animaux</h2>
        <form action="updateAnimal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="typeAnimal">Espèce</label>
                <input type="text" class="form-control" id="typeAnimal" name="typeAnimal" value="<?= isset($animaux['TypeAnimal']) ? $animaux['TypeAnimal'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="poidsMin">Poids Minimal Vente</label>
                <input type="number" class="form-control" id="poidsMin" name="poidsMin" value="<?= isset($animaux['PoidsMin']) ? $animaux['PoidsMin'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="poidsMax">Poids Maximal</label>
                <input type="number" class="form-control" id="poidsMax" name="poidsMax" value="<?= isset($animaux['PoidsMax']) ? $animaux['PoidsMax'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="prixVente">Prix de vente (par kg)</label>
                <input type="number" step="0.01" class="form-control" id="prixVente" name="prixVente" value="<?= isset($animaux['PrixVenteParKg']) ? $animaux['PrixVenteParKg'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="joursSansManger">Nombre de jours sans manger</label>
                <input type="number" class="form-control" id="joursSansManger" name="joursSansManger" value="<?= isset($animaux['JoursSansManger']) ? $animaux['JoursSansManger'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="pourcentagePertePoids">% Perte de poids</label>
                <input type="number" step="0.01" class="form-control" id="pourcentagePertePoids" name="pourcentagePertePoids" value="<?= isset($animaux['PourcentagePertePoids']) ? $animaux['PourcentagePertePoids'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <?php if (!empty($animaux['Image'])) : ?>
                    <div class="mt-2">
                        <img src="public/assets/images/<?= $animaux['Image'] ?>" alt="Image" width="100">
                    </div>
                <?php else : ?>
                    <p>Pas d'image actuelle</p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>

    <footer>
        <p>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
    </footer>
</body>

</html>
