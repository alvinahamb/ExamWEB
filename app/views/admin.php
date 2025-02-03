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
    <title></title>
</head>

<body>
    <div class="menu-fixe" style="box-shadow: 5px 5px 5px rgba(126, 126, 126, 0.575);">
        <div class="logo">
            <a href="home"><img width="80" height="80" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
        <div>
            <ul class="nav nav-tabs nav-justified">
                <li><a href="modifier">Modifier</a></li>
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
    </div>
    <div style="margin-top: 15vh;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Admin</h1>
                    <p>Welcome to the admin page!</p>
                </div>
            </div>
        </div>

        <?php if (isset($extra['message'])): ?>
            <div id="alert" class="alert alert-success" role="alert"><?= $extra['message'] ?></div>
        <?php endif; ?>
        <h2>Liste des animaux</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Espece</th>
                    <th>Poids Minimal Vente</th>
                    <th>Poids Maximal</th>
                    <th>Prix de vente (par kg)</th>
                    <th>Nombre de jour sans manger</th>
                    <th>% perte de poids</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $animaux) : ?>
                    <tr>
                        <td><?= $animaux['TypeAnimal'] ?></td>
                        <td><?= $animaux['PoidsMin'] ?></td>
                        <td><?= $animaux['PoidsMax'] ?></td>
                        <td><?= $animaux['PrixVenteParKg'] ?>$</td>
                        <td><?= $animaux['JoursSansManger'] ?></td>
                        <td><?= $animaux['PourcentagePertePoids'] ?></td>
                        <td>
                            <?php if (!empty($animaux['Image'])) : ?>
                                <img src="public/assets/images/<?= $animaux['Image'] ?>" alt="Image" width="100">
                            <?php else : ?>
                                <span>Pas d'image</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-actions">
                            <a href="delete?id=<?= $animaux['IdAnimal'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <footer>
        <p>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
    </footer>
</body>

</html>