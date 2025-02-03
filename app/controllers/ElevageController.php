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
        $confirmation=$model->venteAnimaux($id,$idAnimal,$_SESSION['IdUser']);
        $message = "Vente effectué avec succès";
        $data = $model->getAnimaux();
        Flight::render('home',['data'=>$data,'message'=>$message]);
    }

    public function nourrirAnimaux(){
        $idAnimal = $_GET['idAnimal']; // idAnimal reste récupéré via GET pour une URL propre
        $quantite = $_POST['quantite']; // Quantité reçue du formulaire
        $aliment = $_POST['aliment'];   // Aliment sélectionné dans le formulaire
        $date = $_POST['date'];         // Date du nourrissage sélectionnée
        $model = new ElevageModel(Flight::db());
        $confirmation = $model->nourrirAnimaux($idAnimal, $_SESSION['IdUser'], $quantite, $aliment, $date);
        $message = "Nutrition effectuée avec succès";
        $data = $model->getAnimaux();
        Flight::render('home', ['data' => $data, 'message' => $message]);
    }
    

    public function pageNourrir(){
        $idAnimal=$_GET['idAnimal'];
        $model= new ElevageModel(Flight::db());
        $data=$model->getAnimalById($idAnimal);
        $data2=$model->getAlimentByAnimaux($idAnimal);
        Flight::render('pageNourrir', ['data'=>$data, 'aliment'=>$data2]);
    }

}
?>