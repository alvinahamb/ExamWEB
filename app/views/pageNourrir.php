<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/assets/css/base.css">
    <link rel="icon" href="">
    <title>Elevage</title>
</head>
<body>
    <div class="menu-fixe-acceuil">
        <div>
            <ul class="nav nav-tabs nav-justified">
                <li>
                    <form action="admin" method="get">
                        <button class="button">Admin</button>
                    </form>
                </li>
                <li><a href="/home">Elevage</a></li>
                <li><a href="goToStock">Stock</a></li>
            </ul>
        </div>
        <div class="logo">
            <a href="home"><img width="50" height="50" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
        <div>
            <ul class="nav nav-tabs nav-justified">
                <li><a href="goToAchatAnimaux">Achat Animaux</a></li>
                <li><a href="goToAchatAliment">Achat Aliments</a></li>
                <li>
                    <form action="deconnexion" method="get">
                        <button class="button">Deconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Page Content -->
    <div style="margin-top:15vh">
        <div class="container">
            <h1 class="my-4">Nourrir l'Animal</h1>

            <!-- Affichage des détails de l'animal -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><?= $data['TypeAnimal'] ?> - Détails</h5>
                </div>
                <div class="card-body">
                    <p><strong>Poids :</strong> <?= $data['Poids'] ?> kg</p>
                    <p><strong>Poids Min :</strong> <?= $data['PoidsMin'] ?> kg</p>
                    <p><strong>Poids Max :</strong> <?= $data['PoidsMax'] ?> kg</p>
                    <p><strong>Prix par kg :</strong> <?= $data['PrixVenteParKg'] ?> €</p>
                    <p><strong>Jours sans manger :</strong> <?= $data['JoursSansManger'] ?> jours</p>
                    <p><strong>Perte de poids :</strong> <?= $data['PourcentagePertePoids'] ?> %</p>

                    <?php if (!empty($data['Image'])) : ?>
                        <img src="<?php echo file_exists('public/assets/images/' . $data['Image']) ? 'public/assets/images/' . $data['Image'] : 'public/uploads/' . $data['Image']; ?>" alt="Image" width="100">
                    <?php else : ?>
                        <span>Pas d'image</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Formulaire pour nourrir l'animal -->
            <h3>Aliments recommandés pour cet animal</h3>
            <form action="formulaireNourrir" method="post" class="mb-4">
                <input type="hidden" name="idAnimal" value="<?= $data['IdAnimal'] ?>">

                <div class="mb-3">
                    <label for="aliment" class="form-label">Sélectionner un aliment :</label>
                    <select name="aliment" id="aliment" class="form-select" required>
                        <?php foreach ($aliment as $item): ?>
                            <option value="<?= $item['IdAliment'] ?>"><?= $item['NomAliment'] ?> - <?= $item['PrixUnitaire'] ?> €</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité :</label>
                    <input type="number" id="quantite" name="quantite" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date de nourrissage :</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Nourrir l'animal</button>
            </form>

            <!-- Message de confirmation -->
            <?php if (isset($message)): ?>
                <div class="alert alert-success"><?= $message ?></div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
