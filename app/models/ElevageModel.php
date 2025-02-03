<?php

namespace app\models;

use Flight;

class ElevageModel
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAliments()
    {
        $stmt = $this->db->prepare("SELECT * FROM Alimentation_Elevage");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function achatAliment($id,$quantite,$idUser){
        $stmt = $this->db->prepare("INSERT INTO TransactionsAlimentation_Elevage (DateTransaction, IdAliment, Quantite, IdUtilisateur)  VALUES (NOW(),?,?,?)");
        $stmt->execute([$id,$quantite,$idUser]);
    }
}

?>