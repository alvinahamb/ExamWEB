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
    <div style="margin-top: 12vh;">
        <?php if (isset($data['message'])) { ?>
            <div id="alert" class="alert alert-success" role="alert"><?= $data['message'] ?></div>
        <?php }
        ?>
        <div class="home">
            <div>
                <h1>Bienvenue sur Farm – Votre partenaire en élevage</h1>
                <h3>Trouvez les meilleurs animaux</h3>
                <h3>Choisissez des aliments adaptés pour une croissance optimale</h3>
                <h3>Optimisez vos revenus avec une bonne gestion</h3>
                <br>
                <form action="#situation" method="get">
                    <button>Voir la situation de mon elevage</button>
                </form>
            </div>
        </div>
        <div id="situation">
            <h1>Situation des Animaux</h1>
            <?php if (isset($message)): ?>
                <div id="alert" class="alert alert-success" role="alert"><?= $message ?></div>
            <?php endif; ?>

            <form id="dateForm" style="width: 50%;margin-left:auto;margin-right:auto;">
                <br>
                <input type="date" class="form-control" id="debut" name="debut" placeholder="Date de début">
                <br>
                <button type="button" onclick="getData()">Confirmer</button>
            </form>
            <div style="margin-top: 10vh;" class="container">
                <div class="row" id="resultContainer"></div>
            </div>

            <script>
                function getData() {
                    var debut = document.getElementById("debut").value;

                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "getSituation?debut=" + debut, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var data = JSON.parse(xhr.responseText);

                            // Afficher les animaux
                            displayResults(data.animals);

                            // Afficher le message si il existe
                            if (data.message) {
                                var alertDiv = document.createElement('div');
                                alertDiv.className = 'alert alert-success';
                                alertDiv.role = 'alert';
                                alertDiv.textContent = data.message;
                                document.body.appendChild(alertDiv);
                            }
                        }
                    };
                    xhr.send();
                }

                function displayResults(data) {
                    var container = document.getElementById("resultContainer");
                    container.innerHTML = ""; // Vider l'ancien contenu

                    data.forEach(row => {
                        var div = document.createElement("div");
                        div.className = "col-md-4 mb-3";
                        div.innerHTML = `<hr>
                <div class="card">
                    <img src="${row.ImagePath}" class="card-img-top" alt="Image">
                    <div class="card-body">
                        <h4><b>${row.TypeAnimal}</b></h4>
                        <p class="card-text">
                            <strong>Date:</strong> ${row.DateTransaction} <br>
                            <strong>Poids:</strong> ${row.Poids} kg (Min: ${row.PoidsMin}, Max: ${row.PoidsMax}) <br>
                            <strong>Prix Vente/Kg:</strong> ${row.PrixVenteParKg} <br>
                            <strong>Jours sans manger:</strong> ${row.JoursSansManger} <br>
                            <strong>Perte Poids:</strong> ${row.PourcentagePertePoids}% <br>
                            <strong>Date Mort:</strong> ${row.DateMort || "N/A"}
                        </p>
                        <button class="btn btn-primary" onclick="vendre(${row.IdTransaction}, ${row.IdAnimal})">Vendre</button>
                    </div>
                </div>
            `;
                        container.appendChild(div);
                    });
                }
            </script>

            <script>
                function vendre(id, idAnimal) {
                    // Récupérer la date du champ "debut"
                    var date = document.getElementById("debut").value;

                    // Vérifier si une date a été saisie
                    if (!date) {
                        alert("Veuillez sélectionner une date dans le champ 'debut'.");
                        return;
                    }

                    // Envoi de la requête avec la date sélectionnée
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "vente?id=" + id + "&idAnimal=" + idAnimal + "&date=" + date, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            window.location.href = "vente?id=" + id + "&idAnimal=" + idAnimal + "&date=" + date;
                        }
                    };
                    xhr.send();
                }


                function nourrir(id) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "nourrir?idAnimal=" + id, true); // Utilisation de 'id' au lieu de 'idAnimal'
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            window.location.href = "nourrir?idAnimal=" + id; // Utilisation de 'id' au lieu de 'idAnimal'
                        }
                    };
                    xhr.send();
                }
            </script>
        </div>
        <footer>
            <p>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
        </footer>
</body>

</html>