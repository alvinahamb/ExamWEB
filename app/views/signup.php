<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
    <div style="margin-top: 15vh;">
        <?php if (isset($erreur)) { ?>
            <div id="alert" class="alert alert-danger" role="alert"><?= $erreur ?></div>
        <?php } ?>
        <div class="card">
        <center><h1>Joignez-vous à nous!</h1></center>
            <form action="CheckSignUp" method="post">
            <center><div class="input-container">
                    <input type="email" name="email" class="input-field" placeholder="Email" required>
                    <label for="email" class="input-label">Email</label>
                </div>
                <div class="input-container">
                    <input type="text" name="username" class="input-field" placeholder="Username" required>
                    <label for="username" class="input-label">Username</label>
                </div>
                <div class="input-container">
                    <input type="password" name="password" class="input-field" placeholder="Password" required>
                    <label for="password" class="input-label">Password</label>
                </div>
                <div class="input-container">
                    <input type="number" name="phone" class="input-field" placeholder="Phone number" required>
                    <label for="phone" class="input-label">Phone number</label>
                </div></center>
                <p><center><button class="button" type="submit">Sign Up<div class="hoverEffect"><div></div></div></button></center></p>
<p>
    <center><a style="color:white;" href="GoToLogIn" class="button">Login</a></center>
</p>
<p>
<center><button class="button" type="button" onclick="location.href='adminLogin'">Admin Login</button></center>
</p> 
            </form>
        </div>
    </div>
</body>
<footer>
    <p>&copy; <?= date('Y') ?>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
</footer>
</html>