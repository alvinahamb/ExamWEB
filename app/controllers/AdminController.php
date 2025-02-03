<?php

namespace app\controllers;

use app\models\AdminModel;
use app\models\GiftModel;
use Flight;

class AdminController
{
    public function __construct() {}

    public function admin()
    {
        Flight::render('adminLogin');
    }

    public function CheckLogin()
    {
        $modele = new AdminModel(Flight::db());
        $nom = $_POST['username'];
        $mdp = $_POST['password'];
        $result = $modele->CheckLogin($nom, $mdp);
        $data = ['erreur' => "Wrong username or password, try again!"];
        if ($result == 0) {
            Flight::render('adminLogin', $data);
        } else {
            $data = $modele->getAnimaux();
            Flight::render('admin', $data);
        }
    }
    
    public function modifierAnimaux()
    {
        $modele = new AdminModel(Flight::db());
        $data = $modele->getAnimaux();
        Flight::render('modifier', $data);
    }
    
    
    public function modifierAliment()
    {
        $modele = new AdminModel(Flight::db());
        $data = $modele->getAliments();
        Flight::render('modifierAliment', $data);
    }
    
    public function ajouterAnimaux()
    {
        $modele = new AdminModel(Flight::db());
        Flight::render('ajouter');
    }
    
    
    public function ajouterAliment()
    {
        $modele = new AdminModel(Flight::db());
        Flight::render('ajouterAliment');
    }
    
    public function aliments()
    {
        $modele = new AdminModel(Flight::db());
        $data = $modele->getAliments();
        Flight::render('aliments', $data);
    }
    
    public function animaux()
    {
        $modele = new AdminModel(Flight::db());
        $data = $modele->getAnimaux();
        Flight::render('admin', $data);
    }
    
    public function deleteAnimaux()
    {
        $modele = new AdminModel(Flight::db());
        $id = $_GET['id'];
        $result = $modele->deleteAnimaux($id);
        $data = $modele->getAnimaux();

        if ($result === false) {
            $data2 = ['message' => "Erreur technique lors de la suppression"];
        } else if ($result === 0) {
            $data2 = ['message' => "Aucune espece trouvée avec cet ID"];
        } else {
            $data2 = ['message' => "L'espece a bien été supprimée"];
        }

        Flight::render('admin', ['data' => $data, 'extra' => $data2]);
    }

    
    public function deleteAliments()
    {
        $modele = new AdminModel(Flight::db());
        $id = $_GET['id'];
        $result = $modele->deleteAliments($id);
        $data = $modele->getAliments();

        if ($result === false) {
            $data2 = ['message' => "Erreur technique lors de la suppression"];
        } else if ($result === 0) {
            $data2 = ['message' => "Aucune aliment trouvée avec cet ID"];
        } else {
            $data2 = ['message' => "L'aliment a bien été supprimé"];
        }

        Flight::render('aliments', ['data' => $data, 'extra' => $data2]);
    }

    public function updateAnimaux()
    {
        $modele = new AdminModel(Flight::db());
        foreach ($_POST['typeAnimal'] as $idAnimal => $typeAnimal) {
            $poidsMin = $_POST['poidsMin'][$idAnimal];
            $poidsMax = $_POST['poidsMax'][$idAnimal];
            $prixVente = $_POST['prixVente'][$idAnimal];
            $joursSansManger = $_POST['joursSansManger'][$idAnimal];
            $pourcentagePertePoids = $_POST['pourcentagePertePoids'][$idAnimal];

            $message = $modele->updateAnimaux(
                $typeAnimal, 
                $poidsMin, 
                $poidsMax, 
                $prixVente, 
                $joursSansManger, 
                $pourcentagePertePoids, 
                $idAnimal
            );
        }

        $data = $modele->getAnimaux();
        $data2 = ['message' => $message];
        Flight::render('admin', ['data' => $data, 'extra' => $data2]);
       
    }

    public function updateAliments()
    {
        $modele = new AdminModel(Flight::db());

        // Parcours des aliments envoyés par le formulaire
        foreach ($_POST['NomAliment'] as $idAliment => $nomAliment) {
            $typeAnimal = $_POST['TypeAnimal'][$idAliment];
            $pourcentageGainPoids = $_POST['PourcentageGainPoids'][$idAliment];
            $prixUnitaire = $_POST['PrixUnitaire'][$idAliment];
            $stock = $_POST['Stock'][$idAliment];

            // Mise à jour dans la base de données via le modèle
            $message = $modele->updateAliments(
                $nomAliment,
                $typeAnimal,
                $pourcentageGainPoids,
                $prixUnitaire,
                $stock,
                $idAliment
            );
        }

        // Récupération des aliments mis à jour
        $data = $modele->getAliments();
        $data2 = ['message' => $message];

        // Rendu de la vue admin avec les données mises à jour
        Flight::render('aliments', ['data' => $data, 'extra' => $data2]);
    }

    public function addAnimal() {
        $modele = new AdminModel(Flight::db());
        $typeAnimal = $_POST['typeAnimal'];
        $poidsMin = $_POST['poidsMin'];
        $poidsMax = $_POST['poidsMax'];
        $prixVente = $_POST['prixVente'];
        $joursSansManger = $_POST['joursSansManger'];
        $pourcentagePertePoids = $_POST['pourcentagePertePoids'];
        $image = $_FILES['image']['name'];

        if (!empty($image)) {
            $targetDir = "public/uploads/";
            $targetFile = $targetDir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        }

        $message = $modele->addAnimal($typeAnimal, $poidsMin, $poidsMax, $prixVente, $joursSansManger, $pourcentagePertePoids, $image);

        $data = $modele->getAnimaux();
        $data2 = ['message' => $message];
        Flight::render('admin', ['data' => $data, 'extra' => $data2]);
    }

    public function addAliment() {
        $modele = new AdminModel(Flight::db());
    
        // Récupération des données du formulaire
        $nomAliment = $_POST['nomAliment'];
        $typeAnimal = $_POST['typeAnimal'];
        $pourcentageGainPoids = $_POST['pourcentageGainPoids'];
        $prixUnitaire = $_POST['prixUnitaire'];
        $stock = $_POST['stock'];
        $image = $_FILES['image']['name'];
    
        // Gestion de l'upload de l'image
        if (!empty($image)) {
            $targetDir = "public/uploads/";
            $targetFile = $targetDir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        } else {
            $image = null; // En cas d'absence d'image, on laisse la valeur NULL
        }
    
        // Appel de la méthode du modèle pour ajouter l'aliment
        $message = $modele->addAliment($nomAliment, $typeAnimal, $pourcentageGainPoids, $prixUnitaire, $stock, $image);
    
        // Récupération des données mises à jour
        $data = $modele->getAliments();
        $data2 = ['message' => $message];
    
        // Rendu de la vue
        Flight::render('aliments', ['data' => $data, 'extra' => $data2]);
    }
    
}
