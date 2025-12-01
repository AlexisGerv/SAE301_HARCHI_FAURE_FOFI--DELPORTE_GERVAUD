-- Table pour les utilisateurs

CREATE TABLE Utilisateur (
id INT PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL,
prenom VARCHAR(100) NOT NULL,
mail_iut VARCHAR(255) NOT NULL UNIQUE,
num_etudiant VARCHAR(50) UNIQUE, # Peut être NULL pour les bibliothécaires
formation VARCHAR(100), # Ex: MMI, INFO-COM, GACO/GEA)