-- Création de la base de données
CREATE DATABASE IF NOT EXISTS Elevage;
USE Elevage;

-- Table des utilisateurs
CREATE TABLE Utilisateur (
    IdUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Nom VARCHAR(100) NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL,
    Numero VARCHAR(15) NOT NULL
);

CREATE TABLE Admin (
    IdAdmin INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Nom VARCHAR(100) NOT NULL,
    MotDePasse VARCHAR(255) NOT NULL
);

-- Table des animaux
CREATE TABLE Animaux (
    IdAnimal INT AUTO_INCREMENT PRIMARY KEY,
    TypeAnimal VARCHAR(50) NOT NULL,
    PoidsMin FLOAT NOT NULL,
    PoidsmAX FLOAT NOT NULL,
    PrixVenteParKg FLOAT NOT NULL,
    JoursSansManger INT NOT NULL,
    PourcentagePertePoids FLOAT NOT NULL
);

-- Table des aliments
CREATE TABLE Alimentation (
    IdAliment INT AUTO_INCREMENT PRIMARY KEY,
    NomAliment VARCHAR(100) NOT NULL,
    TypeAnimal VARCHAR(50) NOT NULL,
    PourcentageGainPoids FLOAT NOT NULL,
    Stock INT DEFAULT 0
);

-- Table des transactions
CREATE TABLE Transactions (
    IdTransaction INT AUTO_INCREMENT PRIMARY KEY,
    TyeTransaction ENUM('achat', 'vente') NOT NULL,
    DateTransaction DATE NOT NULL,
    IdAnimal INT NULL,
    IdAliment INT NULL,
    Quantite INT NOT NULL,
    Montant FLOAT NOT NULL,
    FOREIGN KEY (IdAnimal) REFERENCES Animaux(IdAnimal) ON DELETE SET NULL,
    FOREIGN KEY (IdAliment) REFERENCES Alimentation(IdAliment) ON DELETE SET NULL
);

INSERT INTO Admin (Email, Nom, MotDePasse) 
VALUES ('admin@gmail.com', 'admin', 'admin');

INSERT INTO Utilisateur (Email, Nom, MotDePasse, Numero) 
VALUES 
('user1@gmail.com', 'User One', 'password1', '0123456789');