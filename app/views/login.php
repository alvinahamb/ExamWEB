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

<body class="login">
    <div class="menu-fixe">
        <div class="logo">
            <a href="logo"><img width="150" src="assets/images/logo.png" alt="logo"></a>
        </div>
        <div class="nav">
            <ul>
                <form action="admin" method="get">
                    <li><button class="button">Admin</button></li>
                </form>
            </ul>
        </div>
    </div>
    <div style="margin-top: 15vh;">
        <?php if (isset($erreur)) { ?>
            <div id="alert" class="alert alert-danger" role="alert"><?= $erreur ?></div>
        <?php }
        if (isset($succes)) { ?>
            <div id="alert" class="alert alert-success" role="alert"><?= $succes ?></div>
        <?php }
        if (isset($message)) { ?>
            <div id="alert" class="alert alert-warning" role="alert"><?= $message ?></div>
        <?php }
        ?>
        <div style="height: 85vh;">
            <div class="col-md-7"></div>
            <div class="col-md-3" id="formulaire">
                <h1><span style="font-size: xx-large;">Bienvenue!</span></h1>
                <br>
                <form action="CheckLogin" method="POST">
                    <p><input type="email" class="form-control" name="email" placeholder="Email" required></p>
                    <p><input type="password" class="form-control" name="password" placeholder="Password" required></p>
                    <p><button class="btn btn-lg btn-primary btn-block" type="submit">Login</button></p>
                    <p>
                        <center><a href="GoToSignUp">Sign Up</a></center>
                    </p>
                </form>
            </div>
        </div>
        <div style="height: 5vh;width:100%;background-color:rgba(240, 248, 255, 0.318);text-align:center;color:azure;font-size:larger;">
            <!-- <p>ETU003287 & ETU003326</p> -->
        </div>
    </div>
</body>

</html>