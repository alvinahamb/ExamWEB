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
    <link rel="icon" href="">
    <title></title>
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
    <div style="margin-top: 15vh;">
        <p>Capital:</p>
        <h1>Home</h1>
        <p>Welcome to the home page!</p>
        <p>
        <form action="getSituation" method="get">
            <input type="date" name="debut" placeholder="date debut">
            <input type="date" name="fin" placeholder="date fin">
            <button>Confirmer</button>
        </form>
        </p>
        <?php foreach ($data as $d) { ?>
            <div class="col-md-3">
                <p>Date:<?= $d['DateTransaction'] ?></p>
                <p><b>Type:<?= $d['TypeAnimal'] ?></b></p>
                <p>PoidsMin:<?= $d['PoidsMin'] ?></p>
                <p>PoidsMax:<?= $d['PoidsMax'] ?>%</p>
                <p>Prix Vente Par Kg:<?= $d['PrixVenteParKg'] ?></p>
                <p>JoursSansManger:<?= $d['JoursSansManger'] ?></p>
                <p>PourcentagePertePoids:<?= $d['PourcentagePertePoids'] ?></p>
                <div style="display: flex;">
                    <form action="#" method="get">
                        <input type="hidden" name="id" value="<?= $d['IdAnimal'] ?>">
                        <button type="submit">Vendre</button>
                    </form>
                    <form action="#" method="get">
                        <input type="hidden" name="id" value="<?= $d['IdAnimal'] ?>">
                        <button type="submit">Nourir</button>
                    </form>
                </div>
            </div>
        <?php }
        ?>
    </div>
    <footer>
        <p>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU3244</p>
    </footer>
</body>

</html>