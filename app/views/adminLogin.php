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
    <div class="menu-fixe">
        <div class="logo">
            <a href="home"><img width="80" height="80" src="assets/images/logo.png" alt="logo"></a>
        </div>
    </div>
    <div style="margin-top: 15vh;">
        <?php if (isset($erreur)) { ?>
            <div id="alert" class="alert alert-danger" role="alert"><?= $erreur ?></div>
        <?php }
        ?>
        <div id="forbtn">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="margin-top:10vh;font-family:'Times New Roman', Times, serif;">
                <h1>Admin:</h1>
                <form action="adminLogin" method="POST">
                    <p><input type="text" name="username" class="form-control" placeholder="Username" value="Blessed" required></p>
                    <p><input type="password" name="password" class="form-control" placeholder="Password" value="blessed" required></p>
                    <p><button class="btn btn-lg btn-primary btn-block" type="submit">Login</button></p>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>