<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
    <div style="margin-top: 15vh;">
        <?php if (isset($erreur)): ?>
            <div id="alert" class="alert alert-danger" role="alert">
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <h2>Connexion</h2>
            <form action="CheckLogin" method="POST">
                <div class="input-container">
                    <input 
                        type="email" 
                        class="input-field" 
                        name="email" 
                        placeholder="Email" 
                        required 
                        autocomplete="email">
                    <label for="email" class="input-label">Email</label>
                </div>
                
                <div class="input-container">
                    <input 
                        type="password" 
                        class="input-field" 
                        name="password" 
                        placeholder="Mot de passe" 
                        required 
                        autocomplete="current-password">
                    <label for="password" class="input-label">Mot de passe</label>
                </div>
                <center><button type="submit" class="button">
    Se connecter
    <div class="hoverEffect"><div></div></div>
</button>
<p>
    <button class="button" type="button" onclick="location.href='admin'">Admin Login</button>
</p></center>
                </div>
            </form>
        </div>
    </div>
</body>
<footer>
    <p>&copy; <?= date('Y') ?>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
</footer>
</html>
