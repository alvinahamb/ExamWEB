<?php

namespace app\models;

use Flight;

class UserModel
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getIdUser($nom, $mdp)
    {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateur WHERE Email = ? AND MotDePasse = ?");
        $stmt->execute([$nom, $mdp]);
        $row = $stmt->fetch();
        return $row['IdUtilisateur'];
    }

    public function CheckLogin($nom, $mdp)
    {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateur WHERE Email = ? AND MotDePasse = ?");
        $stmt->execute([$nom, $mdp]);
        if ($stmt->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function CheckSignup($email,$nom)
    {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateur WHERE Nom = ? OR Email = ?");
        $stmt->execute([$nom,$email]);
        if ($stmt->rowCount() > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function InsertSignup($email,$nom,$mdp,$phone)
    {
        $stmt = $this->db->prepare("INSERT INTO Utilisateur (Email, Nom, MotDePasse, Numero) VALUES (?,?,?,?)");
        if ($this->CheckSignup($email,$nom) == 0) {
            return 0;
        }
        $stmt->execute([$email,$nom,$mdp,$phone]);
        return 1;
    }
}
