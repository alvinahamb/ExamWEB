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
    <link rel="stylesheet" href="public/assets/css/achat.css">
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
                        <button class="button">Reintialisation</button>
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
                <li>
                    <form action="deconnexion" method="get">
                        <button class="button">Deconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div style="margin-top: 15vh;">
        <?php if (isset($message)) { ?>
            <div class="alert alert-success" role="alert"><?= $message ?></div>
        <?php }
        ?>
        <h1>Achat d'animaux:</h1>
        <?php
        foreach ($data as $d) { ?>
            <div class="col-md-4">
                <div class="card">
                    <div id="card-img" class="col-md-4"><img src="<?php echo file_exists('public/assets/images/' . $d['Image']) ? 'public/assets/images/' . $d['Image'] : 'public/uploads/' . $d['Image']; ?>" alt="Image" width="100"></div>
                    <div class="col-md-8">
                        <h4><b><?= $d['TypeAnimal'] ?></b></h4>
                        <p>Poids:<?= $d['Poids'] ?> kg</p>
                        <p>Poids min:<?= $d['PoidsMin'] ?> kg</p>
                        <p>Poids max:<?= $d['PoidsMax'] ?> kg</p>
                        <p>Prix par Kg:<?= $d['PrixVenteParKg'] ?> Ar</p>
                        <p>Jours sans manger:<?= $d['JoursSansManger'] ?> jour</p>
                        <p>Pourcentage perte de poids:<?= $d['PourcentagePertePoids'] ?> %</p>
                        <!-- <form action="achatAnimaux" method="get"> -->
                        <form action="autoventeAchat" method="get">
                            <input type="hidden" name="id" value="<?= $d['IdAnimal'] ?>">
                            <button type="submit">Acheter</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php }
        ?>
    </div>
</body>

</html>