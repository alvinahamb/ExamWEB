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
                <li><a href="/home">Elevage</a></li>
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
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream

    <div style="margin-top:15vh">
        <h1>Situation des Animaux</h1>
        <?php if (isset($message)): ?>
            <div id="alert" class="alert alert-success" role="alert"><?= $message ?></div>
        <?php endif; ?>
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    <div style="margin-top: 12vh;">
        <?php if (isset($data['message'])) { ?>
            <div id="alert" class="alert alert-success" role="alert"><?= $data['message'] ?></div>
        <?php }
        ?>
        <div class="home">
            <div>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

                <h1>Bienvenue sur Farm – Votre partenaire en élevage</h1>
                <h3>Trouvez les meilleurs animaux<h3>
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

<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
        <table border="1" cellspacing="0" id="resultTable">
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>PoidsMin</th>
                <th>PoidsMax</th>
                <th>Prix Vente Par Kg</th>
                <th>JoursSansManger</th>
                <th>Perte Poids (%)</th>
                <th>Vivant</th>
                <th>Action</th>
            </tr>
        </table>
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
            <form id="dateForm">
                <input type="date" id="debut" name="debut" placeholder="Date de début">
                <button type="button" onclick="getData()">Confirmer</button>
            </form>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

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
<<<<<<< Updated upstream
<<<<<<< Updated upstream

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

<<<<<<< Updated upstream
                // Ajoute les nouvelles données
                data.forEach(row => {
                    var tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${row.DateTransaction}</td>
                        <td><b>${row.TypeAnimal}</b></td>
                        <td>${row.PoidsMin}</td>
                        <td>${row.PoidsMax}</td>
                        <td>${row.PrixVenteParKg}</td>
                        <td>${row.JoursSansManger}</td>
                        <td>${row.PourcentagePertePoids}</td>
                        <td>${row.Vivant ? "Oui" : "Non"}</td> <!-- Affiche 'Oui' ou 'Non' selon l'état de l'animal -->
                        <td>
                            <button onclick="vendre(${row.IdTransaction},${row.IdAnimal})">Vendre</button>
                            <button onclick="nourrir(${row.IdAnimal})">Nourrir</button>
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
                        window.location.href = "vente?id=" + id + "&idAnimal=" + idAnimal;
                    }
                };
                xhr.send();
            }

            function nourrir(id) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "nourrir?idAnimal=" + id, true);  // Utilisation de 'id' au lieu de 'idAnimal'
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        window.location.href = "nourrir?idAnimal=" + id;  // Utilisation de 'id' au lieu de 'idAnimal'
                    }
                };
                xhr.send();
            }

        </script>
=======
                function displayResults(data) {
                    var table = document.getElementById("resultTable");

=======

=======

>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    </div>
    <footer>
        <p>Kasaina ETU003287 & Blessed ETU003326 & Kiady ETU003244</p>
    </footer>
</body>

</html>