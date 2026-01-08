-- Table pour les utilisateurs

CREATE TABLE Utilisateur (
id INT PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL,
prenom VARCHAR(100) NOT NULL,
mail_iut VARCHAR(255) NOT NULL UNIQUE,
num_etudiant VARCHAR(50) UNIQUE, # Peut être NULL pour les bibliothécaires
formation VARCHAR(100), # Ex: MMI, INFO-COM, GACO/GEA)

CREATE  TABLE Livre(
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(100) NOT NULL,
    isbn VARCHAR(13) NOT NULL UNIQUE,
    editeur VARCHAR(100),
    annee_publication INT,
    genre VARCHAR(50),
    collection VARCHAR(100),
    nombre_pages INT,
    resume TEXT,
    image VARCHAR(255),
    stock INT NOT NULL,
    disponible BOOLEAN NOT NULL DEFAULT TRUE  -- Disponible = 1, Non disponible = 0 
)