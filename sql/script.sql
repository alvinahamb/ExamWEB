-- Création de la base de données
CREATE DATABASE IF NOT EXISTS Elevage;
USE Elevage;

-- Table des utilisateurs
CREATE TABLE Utilisateur_Elevage (
    IdUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Nom VARCHAR(100) NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL,
    Numero VARCHAR(15) NOT NULL,
    Capital INT NOT NULL
);

CREATE TABLE Admin_Elevage (
    IdAdmin INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Nom VARCHAR(100) NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL
);

-- Table des animaux
CREATE TABLE Animaux_Elevage (
    IdAnimal INT AUTO_INCREMENT PRIMARY KEY,
    TypeAnimal VARCHAR(50) NOT NULL,
    PoidsMin FLOAT NOT NULL,
    PoidsMax FLOAT NOT NULL,
    PrixVenteParKg FLOAT NOT NULL,
    JoursSansManger INT NOT NULL,
    PourcentagePertePoids FLOAT NOT NULL
);

-- Table des aliments
CREATE TABLE Alimentation_Elevage (
    IdAliment INT AUTO_INCREMENT PRIMARY KEY,
    NomAliment VARCHAR(100) NOT NULL,
    TypeAnimal VARCHAR(50) NOT NULL,
    PourcentageGainPoids FLOAT NOT NULL,
    PrixUnitaire DECIMAL(10,2) NOT NULL,
    Stock INT DEFAULT 0
);

-- Table des transactions (animaux)
CREATE TABLE TransactionsAnimaux_Elevage (
    IdTransaction INT AUTO_INCREMENT PRIMARY KEY,
    TypeTransaction ENUM('achat', 'vente') NOT NULL,
    DateTransaction DATE NOT NULL,
    Etat INT NULL,
    IdAnimal INT NOT NULL,
    IdUtilisateur INT NOT NULL,
    Poids DECIMAL(6,2) NOT NULL,
    Montant_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (IdAnimal) REFERENCES Animaux_Elevage(IdAnimal), 
    FOREIGN KEY (IdUtilisateur) REFERENCES Utilisateur_Elevage(IdUtilisateur)
);

-- Table des transactions (aliments)
CREATE TABLE TransactionsAlimentation_Elevage (
    IdTransaction INT AUTO_INCREMENT PRIMARY KEY,
    DateTransaction DATE NOT NULL,
    IdAliment INT NOT NULL,
    Quantite INT NOT NULL,
    IdUtilisateur INT NOT NULL,
    FOREIGN KEY (IdAliment) REFERENCES Alimentation_Elevage(IdAliment), 
    FOREIGN KEY (IdUtilisateur) REFERENCES Utilisateur_Elevage(IdUtilisateur) 
);

-- Ajout d'un administrateur
INSERT INTO Admin_Elevage (Email, Nom, MotDePasse) 
VALUES ('admin@gmail.com', 'admin', 'admin');

-- Ajout d'un utilisateur
INSERT INTO Utilisateur_Elevage (Email, Nom, MotDePasse, Numero, Capital) 
VALUES 
('user1@gmail.com', 'User One', 'password1', '0123456789', 1000);
