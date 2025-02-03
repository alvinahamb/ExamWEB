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
        $capital = $this->getUserById($idUser)['Capital'];
        $prixUnitaire = $this->getAlimentById($id)['PrixUnitaire'];
        $prix = $prixUnitaire * $quantite;

        if ($this->checkSoldeApresAchat($idUser, $prix)) {
            $stmtUpdate = $this->updateCapital($idUser,$capital-$prix);
            $stmt = $this->db->prepare("INSERT INTO TransactionsAlimentation_Elevage (DateTransaction, IdAliment, Quantite, IdUtilisateur) VALUES (NOW(), ?, ?, ?)");
            $stmt->execute([$id, $quantite, $idUser]);
            return 0;
        }
        return 1;
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
        // Requête SQL pour récupérer les animaux
        $stmt = $this->db->prepare("SELECT a.IdAnimal, a.TypeAnimal, a.PoidsMin, a.PoidsMax, a.PrixVenteParKg, 
                                        a.JoursSansManger, a.PourcentagePertePoids, t.DateTransaction
                                    FROM TransactionsAnimaux_Elevage t
                                    JOIN Animaux_Elevage a ON t.IdAnimal = a.IdAnimal 
                                    WHERE t.IdUtilisateur = ? 
                                    AND t.TypeTransaction = 'achat' 
                                    AND t.DateTransaction = ?");
        $stmt->execute([$id, $date]);

        // Récupération des résultats
        $animals = $stmt->fetchAll();

        // Calcul de l'état de vie de chaque animal
        foreach ($animals as &$animal) {
            // Calcul du poids actuel après perte
            $poidsActuel = $animal['PoidsMax'] - ($animal['PourcentagePertePoids'] * $animal['PoidsMax'] * $animal['JoursSansManger']);

            // Vérification si l'animal est vivant (poids actuel >= poids minimum)
            $animal['Vivant'] = $poidsActuel >= $animal['PoidsMin'];
        }

        // Retourne les animaux avec la colonne 'Vivant' ajoutée
        return $animals;
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
    
    public function getAlimentByAnimaux($idAnimaux)
    {
        // Correction ici : ajout du $ pour la variable typeAnimal
        $typeAnimal = $this->getAlimentById($idAnimaux)['TypeAnimal'];

        // Préparation et exécution de la requête pour récupérer les aliments correspondant au type d'animal
        $stmt = $this->db->prepare("SELECT * FROM Alimentation_Elevage WHERE TypeAnimal=?");
        $stmt->execute([$typeAnimal]);
        return $stmt->fetch(); // Renvoie un tableau de résultats
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
        // var_dump($Montant_total,$prixkg,$poid,$capital); exit;	
        $stmt = $this->db->prepare("UPDATE TransactionsAnimaux_Elevage SET TypeTransaction=? WHERE IdTransaction=?");
        $stmt->execute(['vente', $id]);
        $this->updateCapital($idUser,$capital);
    }

    public function reintialiser($id,$montant){
        $stmt1 = $this->db->prepare("DELETE FROM TransactionsAnimaux_Elevage");
        $stmt1->execute();
        $stmt2 = $this->db->prepare("DELETE FROM TransactionsAlimentation_Elevage");
        $stmt2->execute();
        $this->updateCapital($id,$montant);
    }
    
    public function checkStockAliment($idAliment, $quantite) {
        
        $stmt = $this->db->prepare("SELECT Stock FROM Alimentation_Elevage WHERE IdAliment = ?");
        $stmt->execute([$idAliment]);
    
        $result = $stmt->fetch();
    
        if ($result && $result['Stock'] >= $quantite) {
            return true;  // Le stock est suffisant
        } else {
            return false;  // Stock insuffisant ou aliment inexistant
        }
    }
    
    public function checkSurPoidsAnimaux($idAnimal, $idAliment, $quantite){
        $poidsPlus=$this->getAlimentByAnimaux($idAnimal)['PourcentageGainPoids'];
        $poidsActuel=$this->getAnimalById($idAnimal)['Poids'];
        $poidsMax=$this->getAnimalById($idAnimal)['PoidsMax'];
        $supposePoids=$poidsPlus*$poidsActuel;
        if($poidsMax<$supposePoids+$poidsActuel){
            return false;
        }
        return true;
    }

    public function nourrirAnimaux($idAnimal, $idUtilisateur, $quantite, $aliment, $date) {
        // Vérification du stock et du poids de l'animal
        if ($this->checkStockAliment($aliment, $quantite) && $this->checkSurPoidsAnimaux($idAnimal, $aliment, $quantite)) {
            $sql = "INSERT INTO Nutrition_Elevage (IdAnimal, IdUtilisateur, IdAliment, DateNourrissage, QuantiteNourriture)
                    VALUES (?, ?, ?, ?, ?)";
    
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idAnimal, $idUtilisateur, $aliment, $date, $quantite]);
    
            $poidsPlus = $this->getAlimentByAnimaux($idAnimal)['PourcentageGainPoids'];
            $poidsActuel = $this->getAnimalById($idAnimal)['Poids'];
    
            $nouveauPoids = $poidsActuel + ($poidsActuel * $poidsPlus);
    
            $updateSql = "UPDATE Animaux SET Poids = ? WHERE IdAnimal = ?";
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->execute([$nouveauPoids, $idAnimal]);
            return $stmt->rowCount() > 0 && $updateStmt->rowCount() > 0 ? true : false;
        }
    
        return false;
    }
    
    public function VieAnimal($idAnimal) {
        // Récupérer les informations de l'animal
        $sql = "SELECT Poids, PoidsMin, PourcentagePertePoids, JoursSansManger FROM Animaux_Elevage WHERE IdAnimal = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idAnimal]);
        $animal = $stmt->fetch();
    
        if ($animal) {
            // Calcul du poids actuel de l'animal
            $poidsActuel = $animal['Poids'] - ($animal['PourcentagePertePoids'] * $animal['Poids'] * $animal['JoursSansManger']);
    
            // Vérifier si l'animal est vivant
            if ($poidsActuel >= $animal['PoidsMin']) {
                return "En vie";  // L'animal est vivant
            }
        }
    
        return "Mort";  // L'animal n'est plus vivant
    }
    
    
}
