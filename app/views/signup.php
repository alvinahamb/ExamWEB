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

<body class="signup">
    <div class="menu-fixe">
        <div class="logo">
            <a href="logo"><img width="50" height="50" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
        <div class="nav">
            <ul>
                <form action="admin" method="get">
                    <li><button class="button">Admin</button></li>
                </form>
            </ul>
        </div>
    </div>
    <div style="margin-top: 12vh;">
        <?php if (isset($erreur)) { ?>
            <div id="alert" class="alert alert-danger" role="alert"><?= $erreur ?></div>
        <?php }
        ?>
        <div >
            <div class="col-md-4" ></div>
            <div class="col-md-3" id="formulaire">
                <h3>Joignez-vous à nous!</h3>
                <form action="CheckSignUp" method="post">
                    <p><input type="email" name="email" class="form-control" placeholder="Email" required></p>
                    <p><input type="text" name="username" class="form-control" placeholder="Username" required></p>
                    <p><input type="password" name="password" class="form-control" placeholder="Password" required></p>
                    <p><input type="number" name="phone" class="form-control" placeholder="Phone number" required></p>
                    <p><button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button></p>
                    <p>
                        <center><a href="GoToLogIn">Login</a></center>
                    </p>
                </form>
            </div>
            <!-- <div class="col-md-7" id="image"></div> -->
        </div>
    </div>
    <footer>
            <p>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU3244</p>
        </footer>
</body>

</html>