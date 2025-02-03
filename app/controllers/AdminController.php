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
            $data = ['contenue' => "okey"];
            Flight::render('admin', $data);
        }
    }
}
