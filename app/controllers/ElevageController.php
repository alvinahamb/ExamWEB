<?php

namespace app\controllers;

use app\models\ElevageModel;

use Flight;

class ElevageController
{
    public function __construct() {

    }

    public function goToAchatAliment()
    {
        $model= new ElevageModel(Flight::db());
        $data = $model->getAliments();
        Flight::render('achatAliment',$data);
    }
    public function goToAchatAnimaux()
    {
        $model= new ElevageModel(Flight::db());
        $data = $model->getAnimaux();
        Flight::render('achatAnimaux',$data);
    }
    public function goToStock()
    {
        $model= new ElevageModel(Flight::db());
        $data = $model-> getAlimentByUser($_SESSION['IdUser']);
        Flight::render('stockAliment',$data);
    }

    public function achatAliment(){
        $id=$_GET['id'];
        $quantite=$_GET['quantite'];
        $model= new ElevageModel(Flight::db());
        $model->achatAliment($id,$quantite,$_SESSION['IdUser']);
        $data = $model->getAliments();
        $message = "Achat effectué avec succès";
        Flight::render('achatAliment',['data'=>$data,'message'=>$message]);
    }

    public function achatAnimaux(){
        $id=$_GET['id'];
        $model= new ElevageModel(Flight::db());
        $model->achatAnimaux($id,$_SESSION['IdUser']);
        $data = $model->getAnimaux();
        $message = "Achat effectué avec succès";
        Flight::render('achatAnimaux',['data'=>$data,'message'=>$message]);
    }

    public function venteAnimaux(){
        $id=$_GET['id'];
        $idAnimal=$_GET['idAnimal'];
        $model= new ElevageModel(Flight::db());
        $model->venteAnimaux($id,$idAnimal,$_SESSION['IdUser']);
        $message = "Vente effectué avec succès";
        $data = $model->getAnimaux();
        Flight::render('home',['data'=>$data,'message'=>$message]);
    }

    public function goToReintialiser(){
        $model = new ElevageModel(Flight::db());
        // $model->reintialiser();
        Flight::render('reintialisation');
    }

    public function reintialisation(){
        $model = new ElevageModel(Flight::db());
        $montant=$_GET['capital'];
        $model->reintialiser($_SESSION['IdUser'],$montant);
        $data = ['message'=> 'Reintialisation reussi!'];
        Flight::render('home',$data);
    }
}
?>