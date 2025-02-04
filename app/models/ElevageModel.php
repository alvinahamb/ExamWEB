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
    
    public function getAnimauxByUserDate($idUser, $date)
    {
        $stmt = $this->db->prepare("
            SELECT a.Image, a.IdAnimal, a.TypeAnimal, a.PoidsMin, a.PoidsMax, a.Poids, a.PrixVenteParKg, 
                a.JoursSansManger, a.PourcentagePertePoids, a.QuotaNourritureJournalier, t.DateTransaction, t.IdTransaction, 
                t.AutoVente, t.DateVente, t.TypeTransaction
            FROM TransactionsAnimaux_Elevage t
            JOIN Animaux_Elevage a ON t.IdAnimal = a.IdAnimal
            WHERE t.IdUtilisateur = ?
            AND t.TypeTransaction = 'achat'
            AND t.DateTransaction = (
                SELECT MAX(t2.DateTransaction)
                FROM TransactionsAnimaux_Elevage t2
                WHERE t2.IdAnimal = t.IdAnimal
                    AND t2.DateTransaction <= ?
            )
        ");
        $stmt->execute([$idUser, $date]);
        $animals = $stmt->fetchAll();

        // Requête pour récupérer les aliments possédés par l'utilisateur
        $stmtAliments = $this->db->prepare("
            SELECT IdAliment, Quantite
            FROM TransactionsAlimentation_Elevage
            WHERE IdUtilisateur = ?
            AND DateTransaction <= ?
        ");
        $stmtAliments->execute([$idUser, $date]);
        $alimentsPossedes = $stmtAliments->fetchAll();
        $alimentsParUtilisateur = [];
        foreach ($alimentsPossedes as $aliment) {
            $alimentsParUtilisateur[$aliment['IdAliment']] = $aliment['Quantite'];
        }

        foreach ($animals as &$animal) {
            if (empty($animal['DateTransaction'])) {
                $animal['Vivant'] = "Non";
                $animal['DateMort'] = "Inconnue";
                $animal['ImagePath'] = 'public/uploads/default.png'; // Chemin par défaut si aucune image
                continue;
            }

            $dateTransaction = new \DateTime($animal['DateTransaction']);
            $dateNow = new \DateTime($date);
            $diff = $dateTransaction->diff($dateNow)->days;

            if ($diff > $animal['JoursSansManger']) {
                $animal['Vivant'] = "Non"; // L'animal est mort
                $dateMort = clone $dateTransaction;
                $dateMort->modify('+' . $animal['JoursSansManger'] . ' days');
                $animal['DateMort'] = $dateMort->format('Y-m-d');
            } else {
                $animal['Vivant'] = "Oui";
                $animal['DateMort'] = "Encore vivant";

                // Vérification des aliments disponibles pour l'utilisateur
                $idAlimentAnimal = $this->getIdAlimentByAnimaux($animal['IdAnimal']);
                if (isset($alimentsParUtilisateur[$idAlimentAnimal]) && $alimentsParUtilisateur[$idAlimentAnimal] > 0) {
                    // L'utilisateur possède l'aliment nécessaire
                    $animal['EtatAliment'] = "Disponible";
                } else {
                    // L'utilisateur ne possède pas l'aliment
                    $animal['EtatAliment'] = "Non disponible";
                }

                // Conditions de vente automatique
                if ($animal['AutoVente'] == 1 && $animal['Poids'] >= $animal['PoidsMin']) {
                    $this->venteAnimaux($animal['IdTransaction'], $animal['IdAnimal'], $idUser, $date);
                } elseif ($animal['DateVente'] !== null && $dateNow >= new \DateTime($animal['DateVente'])) {
                    $this->venteAnimaux($animal['IdTransaction'], $animal['IdAnimal'], $idUser, $date);
                }
            }

            // Ajouter le chemin de l'image
            $animal['ImagePath'] = file_exists('public/assets/images/' . $animal['Image']) 
                ? 'public/assets/images/' . $animal['Image'] 
                : 'public/uploads/' . $animal['Image'];
        }

        return $animals;
    }

    
    public function getAnimauxByUserDate1($id, $date)
    {
        $stmt = $this->db->prepare("
            SELECT a.Image, a.IdAnimal, a.TypeAnimal, a.PoidsMin, a.PoidsMax, a.Poids, a.PrixVenteParKg, 
                a.JoursSansManger, a.PourcentagePertePoids, a.QuotaNourritureJournalier, 
                t.DateTransaction, t.IdTransaction, t.AutoVente, t.DateVente, t.Etat
            FROM TransactionsAnimaux_Elevage t
            JOIN Animaux_Elevage a ON t.IdAnimal = a.IdAnimal
            WHERE t.IdUtilisateur = ?
            AND t.TypeTransaction = 'achat'
            AND t.DateTransaction = (
                SELECT MAX(t2.DateTransaction)
                FROM TransactionsAnimaux_Elevage t2
                WHERE t2.IdAnimal = t.IdAnimal
                    AND t2.DateTransaction <= ?
            )
        ");
        $stmt->execute([$id, $date]);
        $animals = $stmt->fetchAll();

        foreach ($animals as &$animal) {
            $dateNow = new \DateTime($date);
            $dateTransaction = new \DateTime($animal['DateTransaction']);
            $diff = $dateTransaction->diff($dateNow)->days;

            if ($diff > $animal['JoursSansManger']) {
                // Si l'animal est mort
                $animal['Vivant'] = "Non";
                $dateMort = clone $dateTransaction;
                $dateMort->modify('+' . $animal['JoursSansManger'] . ' days');
                $animal['DateMort'] = $dateMort->format('Y-m-d');
                $animal['Etat'] = "Mort";
            } else {
                // Si l'animal est vivant
                $animal['Vivant'] = "Oui";
                $animal['DateMort'] = "Encore vivant";

                if ($diff > 0) {
                    if (is_null($animal['QuotaNourritureJournalier']) || $animal['QuotaNourritureJournalier'] == 0) {
                        // Appliquer la perte de poids
                        $poidsPerdu = $diff * ($animal['PourcentagePertePoids'] / 100);
                        $nouveauPoids = $animal['Poids'] - $poidsPerdu;
                    } else {
                        // Appliquer le gain de poids
                        $poidsGagne = $diff * $animal['QuotaNourritureJournalier'] * (1 + $animal['PourcentagePertePoids'] / 100);
                        $nouveauPoids = $animal['Poids'] + $poidsGagne;
                    }

                    // Vérification des limites du poids
                    $nouveauPoids = max($animal['PoidsMin'], min($nouveauPoids, $animal['PoidsMax']));
                    $animal['Poids'] = $nouveauPoids;
                }

                // Gestion de la vente
                if ($animal['AutoVente'] == 1 && $animal['Poids'] >= $animal['PoidsMin']) {
                    $animal['Etat'] = "Vendu";
                } elseif ($animal['DateVente'] && new \DateTime($animal['DateVente']) <= $dateNow) {
                    $animal['Etat'] = "Vendu";
                } else {
                    $animal['Etat'] = "Possession";
                }
            }

            // Ajouter le chemin de l'image
            $animal['ImagePath'] = file_exists('public/assets/images/' . $animal['Image']) 
                ? 'public/assets/images/' . $animal['Image'] 
                : 'public/uploads/' . $animal['Image'];
        }

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
        return $stmt->fetchAll(); // Renvoie un tableau de résultats
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

    public function achatAnimaux($id, $idUser,$autovente,$date)
    {
        $poid = $this->getAnimalById($id)['Poids'];
        $prixkg = $this->getAnimalById($id)['PrixVenteParKg'];
        $Montant_total = $poid * $prixkg;
        $result = $this->updateCapitalAchat($idUser, $Montant_total);
        if ($result == 0) {
            $stmt = $this->db->prepare("INSERT INTO TransactionsAnimaux_Elevage (TypeTransaction,DateTransaction, IdAnimal,IdUtilisateur, Poids, Montant_total,Autovente,DateVente)  VALUES (?,NOW(),?,?,?,?,?,?)");
            $stmt->execute(['achat', $id, $idUser, $poid, $Montant_total,$autovente,$date]);
            return 0;
        } else {
            return 1;
        }
    }
    
    public function venteAnimaux($id, $idAnimal, $idUser, $date)
    {
        $animals = $this->getAnimauxByUserDate($idUser, $date);
        $animal = null;

        foreach ($animals as $a) {
            if ($a['IdAnimal'] == $idAnimal) {
                $animal = $a;
                break;
            }
        }

        if (!$animal) {
            return "L' animal n existe pas";
        }

        if ($animal['Vivant'] == "Non") {
            return "L' animal est mort";
        }

        $prixkg = $animal['PrixVenteParKg'];
        $poid = $animal['Poids'];
        $Montant_total = $poid * $prixkg;

        $capital = $this->getCapital($idUser)['Capital'] + $Montant_total;

        $stmt = $this->db->prepare("UPDATE TransactionsAnimaux_Elevage SET TypeTransaction=? WHERE IdTransaction=?");
        $success = $stmt->execute(['vente', $id]);

        if (!$success) {
            return "Erreur lors de l'update";
        }

        $this->updateCapital($idUser, $capital);

        return "L' animal est bel et bien vendu"; 
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
        $poidsPlus=$this->getAlimentById($idAliment)['PourcentageGainPoids'];
        $poidsActuel=$this->getAnimalById($idAnimal)['Poids'];
        $poidsMax=$this->getAnimalById($idAnimal)['PoidsMax'];
        $supposePoids=$poidsPlus*$poidsActuel;
        if($poidsMax<$supposePoids+$poidsActuel){
            return false;
        }
        return true;
    }
    public function nourrirAnimaux($idAnimal, $idUtilisateur, $quantite, $aliment, $date) {
        $animals = $this->getAnimauxByUserDate($idUtilisateur, $date);
        $animal = null;
        foreach ($animals as $a) {
            if ($a['IdAnimal'] == $idAnimal) {
                $animal = $a;
                break;
            }
        }
    
        if (!$animal || $animal['Vivant'] == "Non") {
            return false; 
        }
    
        if ($this->checkStockAliment($aliment, $quantite) && $this->checkSurPoidsAnimaux($idAnimal, $aliment, $quantite)) {
            $sql = "INSERT INTO Nutrition_Elevage (IdAnimal, IdUtilisateur, IdAliment, DateNourrissage, QuantiteNourriture)
                    VALUES (?, ?, ?, ?, ?)";
    
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idAnimal, $idUtilisateur, $aliment, $date, $quantite]);
    
            $poidsPlus = $this->getAlimentById($aliment)['PourcentageGainPoids'];
            $poidsActuel = $this->getAnimalById($idAnimal)['Poids'];
    
            $nouveauPoids = $poidsActuel + ($poidsActuel * $poidsPlus);
    
            $updateSql = "UPDATE Animaux_Elevage SET Poids = ? WHERE IdAnimal = ?";
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
