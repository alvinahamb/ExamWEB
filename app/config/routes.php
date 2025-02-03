<?php

use app\controllers\AdminController;
use app\controllers\UserController;
use app\controllers\GeneralController;
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

$UserController = new UserController();
$router->get('/', [ $UserController, 'login' ]);
$router->get('/GoToLogIn', [ $UserController, 'login' ]);
$router->get('/GoToSignUp', [ $UserController, 'signup' ]);
$router->post('/CheckLogin', [ $UserController, 'CheckLogin' ]);
$router->post('/CheckSignUp', [ $UserController, 'InsertSignup' ]);
$router->get('/deconnexion', [ $UserController, 'deconnexion' ]);
$router->get('/home', [ $UserController, 'home' ]);


$router->get('/hello-world/@name', function($name) {
	echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
});