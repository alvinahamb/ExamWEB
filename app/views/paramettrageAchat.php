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
    <link rel="stylesheet" href="public/assets/css/achat.css">
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
        <h2><b>Paramètre d'achat :</b></h2>
        <form id="paramForm">
            <input type="hidden" id="animalId" value="<?= $data['id'] ?>">
            <label for="autovente">Autovente :</label>
            <select class="form-control" name="autovente" id="autovente">
                <option value="0">true</option>
                <option value="1">false</option>
            </select>
            <br>
            <div id="dateVenteDiv" style="display: none;">
                <label for="dateVente">Date de vente :</label>
                <input type="date" id="dateVente" class="form-control">
                <br>
            </div>
            <button type="button" id="confirmer">Confirmer</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let autoventeSelect = document.getElementById("autovente");
            let dateVenteDiv = document.getElementById("dateVenteDiv");
            let confirmerBtn = document.getElementById("confirmer");

            // Afficher ou cacher le champ date selon la sélection
            autoventeSelect.addEventListener("change", function() {
                if (this.value === "0") {
                    dateVenteDiv.style.display = "none";
                } else {
                    dateVenteDiv.style.display = "block";
                }
            });

            // Gérer le clic sur "Confirmer"
            confirmerBtn.addEventListener("click", function() {
                let autovente = autoventeSelect.value;
                let idAnimal = document.getElementById("animalId").value;
                let dateVente = document.getElementById("dateVente").value;

                if (autovente === "0") {
                    window.location.href = "achatAnimaux?id=" + idAnimal + "&autovente=" + autovente;
                } else {
                    if (dateVente === "") {
                        alert("Veuillez entrer une date de vente.");
                        return;
                    }
                    let xhr = new XMLHttpRequest();
                    let url = "achatAnimaux?id=" + idAnimal + "&date=" + dateVente + "&autovente=" + autovente + "&ajax=true";

                    xhr.open("GET", url, true);
                    xhr.send();

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Si la réponse est en JSON, traite la réponse
                            let response = JSON.parse(xhr.responseText);
                            alert(response.message); // Affichage du message

                            // Redirection après message
                            window.location.href = "goToAchatAnimaux?message=" + encodeURIComponent(response.message);
                        }
                    };

                }
            });
        });
    </script>
</body>

</html>