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
    <link rel="stylesheet" href="public/assets/css/home.css">
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
    <div style="margin-top: 13vh;padding:20vh;">
        <div class="reintialisation">
            <h1><b>Reintialisation:</b></h1>
            <H4>Capital actuelle:<?= $data['Capital'] ?></h4>
            <form action="reintialisationCapital" method="get">
                <input type="number" name="capital" class="form-control" placeholder="nouveau capital" required>
                <br>
                <button type="submit">Reintialiser</button>
            </form>
        </div>
    </div>
</body>

</html>