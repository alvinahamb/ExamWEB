<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/assets/css/connexion.css">
    <link rel="icon" href="">
    <title>Admin - Ajouter Animal</title>

    <style>
        /* Style pour centrer le formulaire et limiter la largeur */
        .form-container {
            margin-top: 15vh;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-control-sm {
            width: 100%; /* Prendre toute la largeur du conteneur */
        }

        .form-group {
            margin-bottom: 1rem; /* Espacement entre les champs */
        }

        button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="menu-fixe" style="box-shadow: 5px 5px 5px rgba(126, 126, 126, 0.575);">
        <div class="logo">
            <a href="home"><img width="80" height="80" src="public/assets/images/logo.png" alt="logo"></a>
        </div>
        <div>
            <ul class="nav nav-tabs nav-justified">
                <li><a href="modifier">Modifier</a></li>
                <li><a href="aliments">Aliments</a></li>
                <li>
                    <form action="deconnexion" method="get">
                        <button class="button">Deconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="form-container">
        <h1 class="text-center">Ajouter un Animal</h1>
        <p class="text-center">Complétez le formulaire ci-dessous pour ajouter un nouvel animal.</p>


        <form action="addAnimal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="typeAnimal">Espèce :</label>
                <input type="text" class="form-control form-control-sm" id="typeAnimal" name="typeAnimal" required>
            </div>

            <div class="form-group">
                <label for="poidsMin">Poids Min (kg) :</label>
                <input type="number" class="form-control form-control-sm" id="poidsMin" name="poidsMin" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="poidsMax">Poids Max (kg) :</label>
                <input type="number" class="form-control form-control-sm" id="poidsMax" name="poidsMax" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="prixVente">Prix Vente (€/kg) :</label>
                <input type="number" class="form-control form-control-sm" id="prixVente" name="prixVente" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="joursSansManger">Jours sans manger :</label>
                <input type="number" class="form-control form-control-sm" id="joursSansManger" name="joursSansManger" required>
            </div>

            <div class="form-group">
                <label for="pourcentagePertePoids">Perte de Poids (%) :</label>
                <input type="number" class="form-control form-control-sm" id="pourcentagePertePoids" name="pourcentagePertePoids" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="QuotaNourritureJournalier">Quota Nourriture Journalier :</label>
                <input type="number" class="form-control form-control-sm" id="QuotaNourritureJournalier" name="QuotaNourritureJournalier" step="0.01" value="null">
            </div>

            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" class="form-control form-control-sm" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Ajouter</button>
        </form>
    </div>

    <footer>
        <p class="text-center">Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
    </footer>
</body>
</html>
