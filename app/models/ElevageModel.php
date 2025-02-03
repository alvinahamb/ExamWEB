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


    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateur_Elevage WHERE IdUtilisateur=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function checkSoldeApresAchat($idUser, $achat)
    {
        $capital = $this->getUserById($idUser)['Capital'];
        if ($capital - $achat < 0) {
            return false;
        }
        return true;
    }

    public function achatAliment($id, $quantite, $idUser)
    {
        $prixUnitaire = $this->getAlimentById($id)['PrixUnitaire'];
        $prix = $prixUnitaire * $quantite;

        if ($this->checkSoldeApresAchat($idUser, $prix)) {
            $stmtUpdate = $this->updateCapital($idUser, $prix);

            $stmt = $this->db->prepare("INSERT INTO TransactionsAlimentation_Elevage (DateTransaction, IdAliment, Quantite, IdUtilisateur) VALUES (NOW(), ?, ?, ?)");
            $stmt->execute([$id, $quantite, $idUser]);
        }
    }


    public function getAlimentByUser($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM TransactionsAlimentation_Elevage t 
                                    JOIN Alimentation_Elevage a ON t.IdAliment=a.IdAliment  WHERE IdUtilisateur=?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function getAnimauxByUser($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM TransactionsAnimaux_Elevage t 
                                JOIN Animaux_Elevage a ON t.IdAnimal = a.IdAnimal 
                                WHERE IdUtilisateur=? 
                                AND (t.TypeTransaction = 'achat')");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
    
    public function getAnimauxByUserDate($id, $date)
    {
        $stmt = $this->db->prepare("SELECT * FROM TransactionsAnimaux_Elevage t 
        JOIN Animaux_Elevage a ON t.IdAnimal = a.IdAnimal 
        WHERE IdUtilisateur=? 
        AND (t.TypeTransaction = 'achat') AND (DateTransaction BETWEEN ? AND ?)");
        $stmt->execute([$id, $date]);
        return $stmt->fetchAll();
    }
    

    public function getAnimaux()
    {
        $stmt1 = $this->db->prepare("SELECT * FROM TransactionsAnimaux_Elevage t JOIN Animaux_Elevage a ON a.IdAnimal=t.IdAnimal WHERE TypeTransaction='vente'");
        $stmt1->execute();
        $ventes = $stmt1->fetchAll();
        $stmt2 = $this->db->prepare("SELECT * FROM Animaux_Elevage");
        $stmt2->execute();
        $animaux = $stmt2->fetchAll();
        return array_merge($ventes, $animaux);
    }

    public function getAnimalById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Animaux_Elevage WHERE IdAnimal=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAlimentById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Alimentation_Elevage WHERE IdAliment=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function getCapital($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateur_Elevage WHERE IdUtilisateur=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateCapitalAchat($id, $montant)
    {
        $money = $this->getCapital($id)['Capital'] - $montant;
        if ($money < 0) {
            return 1;
        } else {
            $stmt = $this->db->prepare("UPDATE Utilisateur_Elevage SET Capital=? WHERE IdUtilisateur=?");
            $stmt->execute([$money, $id]);
            return 0;
        }
    }

    public function updateCapital($id, $montant)
    {
        $stmt = $this->db->prepare("UPDATE Utilisateur_Elevage SET Capital=? WHERE IdUtilisateur=?");
        $stmt->execute([$montant, $id]);
    }

    public function achatAnimaux($id, $idUser)
    {
        $poid = $this->getAnimalById($id)['Poids'];
        $prixkg = $this->getAnimalById($id)['PrixVenteParKg'];
        $Montant_total = $poid * $prixkg;
        $result = $this->updateCapitalAchat($idUser, $Montant_total);
        if ($result == 0) {
            $stmt = $this->db->prepare("INSERT INTO TransactionsAnimaux_Elevage (TypeTransaction,DateTransaction, IdAnimal,IdUtilisateur, Poids, Montant_total)  VALUES (?,NOW(),?,?,?,?)");
            $stmt->execute(['achat', $id, $idUser, $poid, $Montant_total]);
            return 0;
        } else {
            return 1;
        }
    }

    public function venteAnimaux($id,$idAnimal,$idUser)
    {
        $animal = $this->getAnimalById($idAnimal);
        $prixkg = $animal['PrixVenteParKg'];
        $poid = $animal['Poids']; 
        $Montant_total = $poid * $prixkg;
        $capital = $this->getCapital($idUser)['Capital']+$Montant_total;	
        $stmt = $this->db->prepare("UPDATE TransactionsAnimaux_Elevage SET TypeTransaction=? WHERE IdTransaction=?");
        $stmt->execute(['vente', $id]);
        $this->updateCapital($idUser, $capital);
    }
}
