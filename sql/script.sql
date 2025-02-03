-- Création de la base de données
CREATE DATABASE IF NOT EXISTS Elevage;
USE Elevage;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS Utilisateur_Elevage (
    IdUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Nom VARCHAR(100) NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL,
    Numero VARCHAR(15) NOT NULL,
    Capital INT NOT NULL
);

-- Table des administrateurs
CREATE TABLE IF NOT EXISTS Admin_Elevage (
    IdAdmin INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Nom VARCHAR(100) NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL
);

-- Table des animaux
CREATE TABLE IF NOT EXISTS Animaux_Elevage (
    IdAnimal INT AUTO_INCREMENT PRIMARY KEY,
    TypeAnimal VARCHAR(50) NOT NULL,
    PoidsMin FLOAT NOT NULL,
    PoidsMax FLOAT NOT NULL,
    PrixVenteParKg FLOAT NOT NULL,
    JoursSansManger INT NOT NULL,
    PourcentagePertePoids FLOAT NOT NULL,
    Image VARCHAR(50) NULL
);

-- Table des aliments
CREATE TABLE IF NOT EXISTS Alimentation_Elevage (
    IdAliment INT AUTO_INCREMENT PRIMARY KEY,
    NomAliment VARCHAR(100) NOT NULL,
    TypeAnimal VARCHAR(50) NOT NULL,
    PourcentageGainPoids FLOAT NOT NULL,
    PrixUnitaire DECIMAL(10,2) NOT NULL,
    Stock INT DEFAULT 0,
    Image VARCHAR(50) NULL
);

-- Table des transactions (animaux)
CREATE TABLE IF NOT EXISTS TransactionsAnimaux_Elevage (
    IdTransaction INT AUTO_INCREMENT PRIMARY KEY,
    TypeTransaction ENUM('achat', 'vente','vendu') NOT NULL,
    DateTransaction DATE NOT NULL,
    Etat INT NULL,
    IdAnimal INT NOT NULL,
    IdUtilisateur INT NOT NULL,
    Poids DECIMAL(6,2) NOT NULL,
    Montant_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (IdAnimal) REFERENCES Animaux_Elevage(IdAnimal) ON DELETE CASCADE,
    FOREIGN KEY (IdUtilisateur) REFERENCES Utilisateur_Elevage(IdUtilisateur) ON DELETE CASCADE
);

-- Table des transactions (aliments)
CREATE TABLE IF NOT EXISTS TransactionsAlimentation_Elevage (
    IdTransaction INT AUTO_INCREMENT PRIMARY KEY,
    DateTransaction DATE NOT NULL,
    IdAliment INT NOT NULL,
    Quantite INT NOT NULL,
    IdUtilisateur INT NOT NULL,
    FOREIGN KEY (IdAliment) REFERENCES Alimentation_Elevage(IdAliment) ON DELETE CASCADE,
    FOREIGN KEY (IdUtilisateur) REFERENCES Utilisateur_Elevage(IdUtilisateur) ON DELETE CASCADE
);

-- Ajout d'un administrateur
INSERT INTO Admin_Elevage (Email, Nom, MotDePasse) 
VALUES ('admin@gmail.com', 'admin', 'admin');

-- Ajout d'un utilisateur
INSERT INTO Utilisateur_Elevage (Email, Nom, MotDePasse, Numero, Capital) 
VALUES 
('user1@gmail.com', 'User One', 'password1', '0123456789', 1000),
('alice@example.com', 'Alice', 'motdepasse123', '0123456789', 1000),
('bob@example.com', 'Bob', 'motdepasse456', '0987654321', 2000),
('charlie@example.com', 'Charlie', 'motdepasse789', '0112233445', 1500),
('david@example.com', 'David', 'motdepasse101', '0667788990', 2500);

-- Ajout d'animaux avec image
INSERT INTO Animaux_Elevage (TypeAnimal, PoidsMin, PoidsMax, PrixVenteParKg, JoursSansManger, PourcentagePertePoids, Image)
VALUES
('Vache',500, 800, 3.5, 3, 0.2, 'Mouton.png'),
('Mouton', 30, 50, 4.0, 2, 0.1, 'Cheval.png'),
('Poulet', 1.5, 3.5, 5.0, 1, 0.05, 'Poulet2.png'),
('Cheval', 400, 600, 6.0, 5, 0.15, 'Vache.png');

-- Ajout d'aliments avec image
INSERT INTO Alimentation_Elevage (NomAliment, TypeAnimal, PourcentageGainPoids, PrixUnitaire, Stock, Image)
VALUES
('Foin', 'Vache', 0.05, 20.00, 100, 'Foin.png'),
('Herbe', 'Mouton', 0.04, 15.00, 150, 'Herbe.png'),
('Mais', 'Poulet', 0.1, 8.00, 200, 'Mais.png'),
('Avoine', 'Cheval', 0.08, 25.00, 80, 'Avoine.png');


-- Ajout de transactions sur les aliments
INSERT INTO TransactionsAlimentation_Elevage (DateTransaction, IdAliment, Quantite, IdUtilisateur)
VALUES
('2025-02-01', 1, 50, 1),
('2025-02-02', 2, 100, 2),
('2025-02-03', 3, 200, 3),
('2025-02-04', 4, 30, 4);

-- Ajout de transactions sur les animaux
INSERT INTO TransactionsAnimaux_Elevage (TypeTransaction, DateTransaction, Etat, IdAnimal, IdUtilisateur, Poids, Montant_total)
VALUES
('achat', '2025-02-01', 1, 1, 1, 600, 2100.00),
('vente', '2025-02-02', 1, 2, 2, 45, 180.00),
('achat', '2025-02-03', NULL, 3, 3, 3.2, 16.00),
('vente', '2025-02-04', 1, 4, 4, 500, 3000.00);