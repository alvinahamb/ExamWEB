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

    public function achatAliment(){
        $id=$_GET['id'];
        $quantite=$_GET['quantite'];
        $model= new ElevageModel(Flight::db());
        $model->achatAliment($id,$quantite,$_SESSION['IdUser']);
        $data = $model->getAliments();
        $message = "Achat effectué avec succès";
        Flight::render('achatAliment',['data'=>$data,'message'=>$message]);
    }
}
?>