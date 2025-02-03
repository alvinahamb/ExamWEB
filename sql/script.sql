CREATE DATABASE 
use 
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

INSERT INTO Admin (Email, Nom, MotDePasse) 
VALUES ('admin@gmail.com', 'admin', 'admin');

INSERT INTO Utilisateur (Email, Nom, MotDePasse, Numero) 
VALUES 
('user1@gmail.com', 'User One', 'password1', '0123456789');