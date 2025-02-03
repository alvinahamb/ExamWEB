<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/assets/css/base.css">
    <link rel="stylesheet" href="public/assets/css/stock.css">
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
                <li>
                    <form action="reintialiser" method="get">
                        <button class="button">Reintialiser</button>
                    </form>
                </li>
                <li><a href="home">Elevage</a></li>
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
                <!-- <li><a href="#">Moi</a></li> -->
                <li>
                    <form action="deconnexion" method="get">
                        <button class="button">Deconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div style="margin-top: 13vh;">
        <h1>Stock d'aliments</h1>
        <?php
        foreach ($data as $d) { ?>
            <div class="col-md-4" id="card">
                <div class="row" >
                    <div class="col-md-6">
                        <img src="public/assets/images/<?= $d['Image'] ?>" alt="<?= $d['Image'] ?>">
                    </div>
                    <div class="col-md-6">
                        <p><b>Nom aliment: <?= $d['NomAliment'] ?></b></p>
                        <p>Type animal: <?= $d['TypeAnimal'] ?></p>
                        <p>Gain en poids: <?= $d['PourcentageGainPoids'] ?>%</p>
                        <p>Quantite: <?= $d['Quantite'] ?></p>
                    </div>
                </div>
            </div>
        <?php }
        ?>
    </div>
    </div>

</body>

</html>