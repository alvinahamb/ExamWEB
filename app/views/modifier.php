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
    <title>Admin - Modifier Animaux</title>
</head>

<body>
    <div class="menu-fixe" style="box-shadow: 5px 5px 5px rgba(126, 126, 126, 0.575);">
        <div class="logo">
            <a href="home"><img width="80" height="80" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
        <div>
            <ul class="nav nav-tabs nav-justified">
                <li><a href="ajouter">Ajouter</a></li>
                <li><a href="aliments">Aliments</a></li>
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

        <h2>Liste des animaux - Modifier</h2>
        <form action="update" method="post" enctype="multipart/form-data">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Espèce</th>
                        <th>Poids Minimal Vente</th>
                        <th>Poids Maximal</th>
                        <th>Prix de vente (par kg)</th>
                        <th>Nombre de jour sans manger</th>
                        <th>% perte de poids</th>
                        <th>Quota Nourriture Journalier (en kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $animaux) : ?>
                        <tr>
                            <td>
                                <input type="text" name="typeAnimal[<?= $animaux['IdAnimal'] ?>]" value="<?= $animaux['TypeAnimal'] ?>" required>
                            </td>
                            <td>
                                <input type="number" name="poidsMin[<?= $animaux['IdAnimal'] ?>]" value="<?= $animaux['PoidsMin'] ?>" required>
                            </td>
                            <td>
                                <input type="number" name="poidsMax[<?= $animaux['IdAnimal'] ?>]" value="<?= $animaux['PoidsMax'] ?>" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="prixVente[<?= $animaux['IdAnimal'] ?>]" value="<?= $animaux['PrixVenteParKg'] ?>" required>
                            </td>
                            <td>
                                <input type="number" name="joursSansManger[<?= $animaux['IdAnimal'] ?>]" value="<?= $animaux['JoursSansManger'] ?>" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="pourcentagePertePoids[<?= $animaux['IdAnimal'] ?>]" value="<?= $animaux['PourcentagePertePoids'] ?>" required>
                            </td>
                            <td>
                                <input type="number" name="QuotaNourritureJournalier[<?= $animaux['IdAnimal'] ?>]" value="<?= $animaux['QuotaNourritureJournalier'] ?>">
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
