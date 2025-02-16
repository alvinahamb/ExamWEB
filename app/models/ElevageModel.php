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
    
    public function getAnimauxByUserDate2($id, $date)
    {
        $stmt = $this->db->prepare("
            SELECT a.Image, a.IdAnimal, a.TypeAnimal, a.PoidsMin, a.PoidsMax, a.Poids, a.PrixVenteParKg, 
                a.JoursSansManger, a.PourcentagePertePoids, t.DateTransaction, t.IdTransaction
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
            if (empty($animal['DateTransaction'])) {
                $animal['Vivant'] = "Non"; 
                $animal['DateMort'] = "Inconnue"; 
                continue;
            }
            $animal['ImagePath'] = file_exists('public/assets/images/' . $animal['Image']) 
                ? 'public/assets/images/' . $animal['Image'] 
                : 'public/uploads/' . $animal['Image'];

            $dateTransaction = new \DateTime($animal['DateTransaction']);
            $dateNow = new \DateTime($date);
            $diff = $dateTransaction->diff($dateNow)->days;

            if ($diff > $animal['JoursSansManger']) {
                $animal['Vivant'] = "Non"; // L'animal est mort

                // Calcul de la date de décès
                $dateMort = clone $dateTransaction;
                $dateMort->modify('+' . $animal['JoursSansManger'] . ' days');
                $animal['DateMort'] = $dateMort->format('Y-m-d');
            } else {
                $animal['Vivant'] = "Oui"; // L'animal est vivant
                $animal['DateMort'] = "Encore vivant";
            }

            if ($diff > 0 && $animal['Vivant'] === "Oui") {
                // Perte de poids par jour en fonction du pourcentage
                $poidsPerdu = $diff * ($animal['PourcentagePertePoids'] / 100);
                $nouveauPoids = $animal['Poids'] - $poidsPerdu;

                // Si le poids tombe en dessous du poids minimal, on rétablit le poids minimal
                if ($nouveauPoids < $animal['PoidsMin']) {
                    $nouveauPoids = $animal['PoidsMin'];
                }

                // Mise à jour du poids de l'animal après la perte
                $animal['Poids'] = $nouveauPoids;
            }
        }

        return $animals;
    }

    public function getAnimauxByUserDate($id, $date)
    {
        $stmt = $this->db->prepare("
            SELECT a.Image, a.IdAnimal, a.TypeAnimal, a.PoidsMin, a.PoidsMax, a.Poids, a.PrixVenteParKg, 
                a.JoursSansManger, a.PourcentagePertePoids, a.QuotaNourritureJournalier, t.DateTransaction, t.IdTransaction
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
            if (empty($animal['DateTransaction'])) {
                $animal['Vivant'] = "Non";
                $animal['DateMort'] = "Inconnue";
                continue;
            }

            // Récupérer le pourcentage de gain de poids pour le type d'animal
            $alimentStmt = $this->db->prepare("
                SELECT AVG(PourcentageGainPoids) AS AvgPourcentageGainPoids
                FROM Alimentation_Elevage
                WHERE TypeAnimal = ?
            ");
            $alimentStmt->execute([$animal['TypeAnimal']]);
            $aliment = $alimentStmt->fetch();
            $pourcentageGainPoids = $aliment ? (float) $aliment['AvgPourcentageGainPoids'] : 0;

            $animal['ImagePath'] = file_exists('public/assets/images/' . $animal['Image']) 
                ? 'public/assets/images/' . $animal['Image'] 
                : 'public/uploads/' . $animal['Image'];

            $dateTransaction = new \DateTime($animal['DateTransaction']);
            $dateNow = new \DateTime($date);
            $diff = $dateTransaction->diff($dateNow)->days;

            if ($diff > $animal['JoursSansManger']) {
                $animal['Vivant'] = "Non"; // L'animal est mort

                // Calcul de la date de décès
                $dateMort = clone $dateTransaction;
                $dateMort->modify('+' . $animal['JoursSansManger'] . ' days');
                $animal['DateMort'] = $dateMort->format('Y-m-d');
            } else {
                $animal['Vivant'] = "Oui"; // L'animal est vivant
                $animal['DateMort'] = "Encore vivant";

                if ($diff > 0) {
                    if (is_null($animal['QuotaNourritureJournalier']) || $animal['QuotaNourritureJournalier'] == 0) {
                        // Si le quota journalier est NULL, appliquer la perte de poids
                        $poidsPerdu = $diff * ($animal['PourcentagePertePoids'] / 100);
                        $nouveauPoids = $animal['Poids'] - $poidsPerdu;
                    } else {
                        // Si le quota journalier est défini, appliquer le gain de poids avec le pourcentage
                        $poidsGagne = $diff * $animal['QuotaNourritureJournalier'] * (1 + $pourcentageGainPoids / 100);
                        $nouveauPoids = $animal['Poids'] + $poidsGagne;
                    }

                    // Vérification des limites du poids
                    if ($nouveauPoids < $animal['PoidsMin']) {
                        $nouveauPoids = $animal['PoidsMin'];
                    } elseif ($nouveauPoids > $animal['PoidsMax']) {
                        $nouveauPoids = $animal['PoidsMax'];
                    }

                    // Mise à jour du poids de l'animal
                    $animal['Poids'] = $nouveauPoids;
                }
            }
        }

        return $animals;
    }


    public function getAnimaux()
    {
        // $stmt1 = $this->db->prepare("SELECT * FROM TransactionsAnimaux_Elevage t JOIN Animaux_Elevage a ON a.IdAnimal=t.IdAnimal WHERE TypeTransaction='vente'");
        // $stmt1->execute();
        // $ventes = $stmt1->fetchAll();
        $stmt2 = $this->db->prepare("SELECT * FROM Animaux_Elevage");
        $stmt2->execute();
        $animaux = $stmt2->fetchAll();
        // return array_merge($ventes, $animaux);
        return $animaux;
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
            return "L' animal vendu";
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
