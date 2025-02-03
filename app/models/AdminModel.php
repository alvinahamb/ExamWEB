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
        $stmt = $this->db->prepare("SELECT * FROM Admin_Elevage WHERE Nom = ? AND MotDePasse = ?");
        $stmt->execute([$nom, $mdp]);
        if ($stmt->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function getAnimaux()
    {
        $stmt = $this->db->query("SELECT * FROM Animaux_Elevage");
        $data=$stmt->fetchAll();
        return $data;
    }
    
    public function getAliments()
    {
        $stmt = $this->db->query("SELECT * FROM Alimentation_Elevage");
        $data=$stmt->fetchAll();
        return $data;
    }

    public function updateAnimaux($typeAnimal, $poidsMin, $poidsMax, $prixVente, $joursSansManger, $pourcentagePertePoids, $idAnimal)
    {
        $stmt = $this->db->prepare("UPDATE Animaux_Elevage 
                                    SET TypeAnimal = ?, PoidsMin = ?, PoidsMax = ?, PrixVenteParKg = ?, 
                                        JoursSansManger = ?, PourcentagePertePoids = ? 
                                    WHERE IdAnimal = ?");
        
        $stmt->execute([$typeAnimal, $poidsMin, $poidsMax, $prixVente, $joursSansManger, $pourcentagePertePoids, $idAnimal]);

        return "Mise à jour réussie!";
    }

    public function updateAliments($nomAliment, $typeAnimal, $pourcentageGainPoids, $prixUnitaire, $stock, $idAliment)
    {
            $stmt = $this->db->prepare("UPDATE Alimentation_Elevage 
                                        SET NomAliment = ?, TypeAnimal = ?, PourcentageGainPoids = ?, PrixUnitaire = ?, 
                                            Stock = ?
                                        WHERE IdAliment = ?");
            
            $stmt->execute([$nomAliment, $typeAnimal, $pourcentageGainPoids, $prixUnitaire, $stock, $idAliment]);
            
            return "Mise à jour réussie!";
    }

    public function deleteAnimaux($idAnimaux)
    {
        // Suppression de l'Animaux dans la table Animaux
        $stmt = $this->db->prepare("DELETE FROM Animaux_Elevage WHERE IdAnimal = ?");
        $stmt->execute([$idAnimaux]);
    
        // Vérification du nombre de lignes affectées
        if ($stmt->rowCount() > 0) {
            return "Suppression réussie!";
        } else {
            return "Aucune espece trouvée à supprimer!";
        }
    }


    public function deleteAliments($idAliments)
    {
        // Suppression de l'Aliments dans la table Aliments
        $stmt = $this->db->prepare("DELETE FROM Alimentation_Elevage WHERE IdAliment = ?");
        $stmt->execute([$idAliments]);
    
        // Vérification du nombre de lignes affectées
        if ($stmt->rowCount() > 0) {
            return "Suppression réussie!";
        } else {
            return "Aucun aliment trouvé à supprimer!";
        }
    }

    public function addAnimal($typeAnimal, $poidsMin, $poidsMax, $prixVente, $joursSansManger, $pourcentagePertePoids, $image) {
        // Préparation de la requête SQL pour insérer un nouvel animal
        $stmt = $this->db->prepare("INSERT INTO Animaux_Elevage (TypeAnimal, PoidsMin, PoidsMax, PrixVenteParKg, JoursSansManger, PourcentagePertePoids, Image) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([$typeAnimal, $poidsMin, $poidsMax, $prixVente, $joursSansManger, $pourcentagePertePoids, $image]);

        // Retourner un message de succès
        return "Animal ajouté avec succès!";
    }

    public function addAliment($nomAliment, $typeAnimal, $pourcentageGainPoids, $prixUnitaire, $stock, $image) {
        // Préparation de la requête SQL pour insérer un nouvel aliment
        $stmt = $this->db->prepare("INSERT INTO Alimentation_Elevage (NomAliment, TypeAnimal, PourcentageGainPoids, PrixUnitaire, Stock, Image) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
    
        // Exécution de la requête avec les données du formulaire
        $stmt->execute([$nomAliment, $typeAnimal, $pourcentageGainPoids, $prixUnitaire, $stock, $image]);
    
        // Retourner un message de succès
        return "Aliment ajouté avec succès !";
    }
    
}
