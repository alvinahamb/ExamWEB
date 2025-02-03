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
    Capital int not null 
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
    PoidsmAX FLOAT NOT NULL,
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

-- Table des transactions
CREATE TABLE TransactionsAnimaux_Elevage (
    IdTransaction INT AUTO_INCREMENT PRIMARY KEY,
    TyeTransaction ENUM('achat', 'vente') NOT NULL,
    DateTransaction DATE NOT NULL,
    Etat INT NULL,
    IdAnimal INT NOT NULL,
    IdUtilisateur INT NOT NULL,
    Poids DECIMAL(6,2) NOT NULL,
    Montant_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (IdAnimal) REFERENCES Animaux_Elevage(IdAnimal) ON DELETE SET NULL,
    FOREIGN KEY (IdUtilisateur) REFERENCES Utilisateurs_Elevage(IdAnimal) ON DELETE SET NULL
);

CREATE TABLE TransactionsAlimentation_Elevage (
    IdTransaction INT AUTO_INCREMENT PRIMARY KEY,
    DateTransaction DATE NOT NULL,
    IdAliment INT NOT NULL,
    Quantite INT NOT NULL,
    IdUtilisateur INT NOT NULL,
    FOREIGN KEY (IdAliment) REFERENCES Alimentation_Elevage(IdAliment) ON DELETE CASCADE, 
    FOREIGN KEY (IdUtilisateur) REFERENCES Utilisateurs_Elevage(IdAnimal) ON DELETE SET NULL
);

INSERT INTO Admin (Email, Nom, MotDePasse) 
VALUES ('admin@gmail.com', 'admin', 'admin');

INSERT INTO Utilisateur (Email, Nom, MotDePasse, Numero) 
VALUES 
('user1@gmail.com', 'User One', 'password1', '0123456789');