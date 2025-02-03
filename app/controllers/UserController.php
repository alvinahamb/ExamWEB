<?php

namespace app\controllers;

use app\models\UserModel;
use app\models\ElevageModel;

use Flight;

class UserController
{
    public function __construct()
    {
        session_start();
    }

    public function login()
    {
        Flight::render('login');
    }
    public function signUp()
    {
        Flight::render('signup');
    }

    public function deconnexion()
    {
        session_unset();
        session_destroy();
        Flight::render('login');
    }

    public function CheckLogin()
    {
        $modele = new UserModel(Flight::db());
        $model = new ElevageModel(Flight::db());
        $nom = $_POST['email'];
        $mdp = $_POST['password'];
        $result = $modele->CheckLogin($nom, $mdp);
        $data = ['erreur' => "Wrong username or password, try again!"];
        if ($result == 0) {
            Flight::render('login', $data);
        } else {
            $_SESSION['IdUser'] = $modele->getIdUser($nom, $mdp);
            // $data = $model->getAnimauxByUser($_SESSION['IdUser']);
            Flight::render('home', $data);
        }
    }

    public function home()
    {
        $model = new ElevageModel(Flight::db());
        // $debut = $_GET['debut'];
        // $fin = $_GET['fin'];
        if (isset($_SESSION['IdUser'])) {
            // $data= $model->getAnimauxByUserDate($_SESSION['IdUser'],$debut,$fin);
            // $data = $model->getAnimauxByUser($_SESSION['IdUser']);
            // Flight::render('home', $data);
            Flight::render('home');
        } else {
            $data = ['message' => "You need to login first!"];
            Flight::render('login', $data);
        }
    }

    public function situation()
    {
        if (isset($_GET['debut'])) {
            $model = new ElevageModel(Flight::db());
            $debut = $_GET['debut'];
            $data = $model->getAnimauxByUserDate($_SESSION['IdUser'], $debut);

            // Retourne du JSON si AJAX
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }

        // Sinon, charge la page HTML normale
        Flight::render('situation');
    }



    public function InsertSignup()
    {
        $modele = new UserModel(Flight::db());
        $email = $_POST['email'];
        $nom = $_POST['username'];
        $mdp = $_POST['password'];
        $phone = $_POST['phone'];
        $result = $modele->InsertSignup($email, $nom, $mdp, $phone);
        if ($result == 0) {
            $data = ['erreur' => "Username or email already taken"];
            Flight::render('signup', $data);
        } else {
            $data = ['succes' => "Account created"];
            Flight::render('login', $data);
        }
    }
}
