<?php

use app\controllers\AdminController;
use app\controllers\UserController;
use app\controllers\ElevageController;
use flight\Engine;
use flight\net\Router;
// use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$AdminController = new AdminController();
$router->get('/admin', [ $AdminController, 'admin' ]);
$router->post('/adminLogin', [ $AdminController, 'CheckLogin' ]);
$router->get('/delete', [ $AdminController, 'deleteAnimaux' ]);
$router->get('/deleteAliments', [ $AdminController, 'deleteAliments' ]);
$router->get('/modifier', [ $AdminController, 'modifierAnimaux' ]);
$router->get('/modifierAliment', [ $AdminController, 'modifierAliment' ]);
$router->get('/ajouter', [ $AdminController, 'ajouterAnimaux' ]);
$router->get('/ajouterAliment', [ $AdminController, 'ajouterAliment' ]);
$router->post('/addAnimal', [ $AdminController, 'addAnimal' ]);
$router->post('/addAliment', [ $AdminController, 'addAliment' ]);
$router->post('/update', [ $AdminController, 'updateAnimaux' ]);
$router->post('/updateAliments', [ $AdminController, 'updateAliments' ]);
$router->get('/aliments', [ $AdminController, 'aliments' ]);
$router->get('/animaux', [ $AdminController, 'animaux' ]);

$UserController = new UserController();
$router->get('/', [ $UserController, 'login' ]);
$router->get('/GoToLogIn', [ $UserController, 'login' ]);
$router->get('/GoToSignUp', [ $UserController, 'signup' ]);
$router->post('/CheckLogin', [ $UserController, 'CheckLogin' ]);
$router->post('/CheckSignUp', [ $UserController, 'InsertSignup' ]);
$router->get('/deconnexion', [ $UserController, 'deconnexion' ]);
$router->get('/home', [ $UserController, 'home' ]);
$router->get('/getSituation', [ $UserController, 'situation' ]);
$router->get('/elevage', [ $UserController, 'elevage' ]);

$ElevageController = new ElevageController();
$router->get('/goToAchatAliment', [ $ElevageController, 'goToAchatAliment' ]);
$router->get('/achatAliment', [ $ElevageController, 'achatAliment' ]);
$router->get('/goToStock', [ $ElevageController, 'goToStock' ]);
$router->get('/goToAchatAnimaux', [ $ElevageController, 'goToAchatAnimaux' ]);
$router->get('/achatAnimaux', [ $ElevageController, 'achatAnimaux' ]);
$router->get('/vente', [ $ElevageController, 'venteAnimaux' ]);
$router->get('/reintialiser', [ $ElevageController, 'goToReintialiser' ]);
$router->get('/reintialisationCapital', [ $ElevageController, 'reintialisation' ]);

$router->get('/hello-world/@name', function($name) {
	echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
});