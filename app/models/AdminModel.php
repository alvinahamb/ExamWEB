<?php

namespace app\models;

use Flight;

class AdminModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function CheckLogin($nom, $mdp)
    {
        $stmt = $this->db->prepare("SELECT * FROM Admin WHERE Nom = ? AND MotDePasse = ?");
        $stmt->execute([$nom, $mdp]);
        if ($stmt->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}
