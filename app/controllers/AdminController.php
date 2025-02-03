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
}
