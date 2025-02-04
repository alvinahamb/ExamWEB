<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="public/assets/css/admin.css">
    <link rel="stylesheet" href="public/assets/css/login.css">
</head>
<body>
    <!-- <div class="menu-fixe">
        <div class="logo">
            <a href="home"><img width="80" height="80" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
    </div> -->
    <div style="margin-top: 15vh;">
        <?php if (isset($erreur)) { ?>
            <div id="alert" class="alert alert-danger" role="alert"><?= $erreur ?></div>
        <?php }
        ?><br><br>
        <div class="card">
            <br><br><h2>Admin</h2>
            <h2><div class="card-info">
                <form action="adminLogin" method="POST">
                <div class="input-container">
        <input id="username" name="username" class="input-field" type="text" value="admin" required>
        <label for="username" class="input-label">Username</label>
        <span class="input-highlight"></span>
    </div>
    <div class="input-container">
        <input id="password" name="password" class="input-field" type="password" value="blessed" required>
        <label for="password" class="input-label">Password</label>
        <span class="input-highlight"></span>
    </div>
                    <p><button class="button" type="submit">Login<div class="hoverEffect"><div></div></div></button></p>
                    
                </form>
            </div><h2>
        </div>
    </div>
</body>
<footer>
        <p>&copy; <?= date('Y') ?>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
    </footer>
</html>
