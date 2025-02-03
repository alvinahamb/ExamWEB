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
                        <button class="button">Reintialiser</button>
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
                <li><a href="#">Moi</a></li>
                <li>
                    <form action="deconnexion" method="get">
                        <button class="button">Deconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="home">
    <?php if (isset($data['message'])) { ?>
            <div id="alert" class="alert alert-success" role="alert"><?= $data['message'] ?></div>
        <?php }
        ?>
    </div>
    <div class="situation">
        <h1>Situation des Animaux</h1>

        <form id="dateForm">
            <input type="date" id="debut" name="debut" placeholder="Date de début">
            <button type="button" onclick="getData()">Confirmer</button>
        </form>

        <table border="1" cellspacing="0" id="resultTable">
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Poids</th>
                <th>PoidsMax</th>
                <th>Prix Vente Par Kg</th>
                <th>JoursSansManger</th>
                <th>Perte Poids (%)</th>
                <th>Prix d'achat</th>
                <th>Actions</th>
            </tr>
        </table>

        <script>
            function getData() {
                var debut = document.getElementById("debut").value;

                var xhr = new XMLHttpRequest();
                xhr.open("GET", "getSituation?debut=" + debut, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                        displayResults(data);
                    }
                };
                xhr.send();
            }

            function displayResults(data) {
                var table = document.getElementById("resultTable");

                // Supprime les anciennes lignes (sauf l'en-tête)
                while (table.rows.length > 1) {
                    table.deleteRow(1);
                }

                // Ajoute les nouvelles données
                data.forEach(row => {
                    var tr = document.createElement("tr");
                    tr.innerHTML = `
                    <td>${row.DateTransaction}</td>
                    <td><b>${row.TypeAnimal}</b></td>
                    <td>${row.Poids}</td>
                    <td>${row.PoidsMax}</td>
                    <td>${row.PrixVenteParKg}</td>
                    <td>${row.JoursSansManger}</td>
                    <td>${row.PourcentagePertePoids}</td>
                    <td>${row.Montant_total}</td>
                    <td>`
                    if (row.TypeTransaction === "vente") {
                        tr.innerHTML += `
                        Vente en cours
                        `;
                    } else {
                        tr.innerHTML += `
                        <button onclick="vendre(${row.IdTransaction},${row.IdAnimal})">Vendre</button>
                        `;
                    }
                    tr.innerHTML += `
                        <button onclick="nourrir(${row.IdTransaction})">Nourrir</button>
                    </td>
                `;

                    table.appendChild(tr);
                });
            }

            function vendre(id, idAnimal) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "vente?id=" + id + "&idAnimal=" + idAnimal, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        window.location.reload();
                        alert("Animal vendu !");
                    }
                };
                xhr.send();
            }



            function nourrir(id) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "nourrir?id=" + id, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert("Animal nourri !");
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