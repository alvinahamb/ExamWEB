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

    public function updateAnimaux($typeAnimal, $poidsMin, $poidsMax, $prixVente, $joursSansManger, $pourcentagePertePoids, $idAnimal)
    {
    
            // Récupération des données du formulaire
            foreach ($_POST['typeAnimal'] as $idAnimal => $typeAnimal) {
                $poidsMin = $_POST['poidsMin'][$idAnimal];
                $poidsMax = $_POST['poidsMax'][$idAnimal];
                $prixVente = $_POST['prixVente'][$idAnimal];
                $joursSansManger = $_POST['joursSansManger'][$idAnimal];
                $pourcentagePertePoids = $_POST['pourcentagePertePoids'][$idAnimal];
    
                // Préparation de la requête SQL pour mettre à jour les informations de l'animal
                $stmt = $this->db->prepare("UPDATE Animaux_Elevage 
                                            SET TypeAnimal = ?, PoidsMin = ?, PoidsMax = ?, PrixVenteParKg = ?, 
                                                JoursSansManger = ?, PourcentagePertePoids = ? 
                                            WHERE IdAnimal = ?");
                
                // Exécution de la requête avec les nouvelles valeurs
                $stmt->execute([$typeAnimal, $poidsMin, $poidsMax, $prixVente, $joursSansManger, $pourcentagePertePoids, $idAnimal]);
            }
    
            // Message de succès après mise à jour
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

}
