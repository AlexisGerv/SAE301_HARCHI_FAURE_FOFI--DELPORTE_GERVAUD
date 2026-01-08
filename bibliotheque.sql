-- Table pour les utilisateurs

CREATE TABLE Etudiant ( --A modifier
id INT PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL,
prenom VARCHAR(100) NOT NULL,
mail_iut VARCHAR(255) NOT NULL UNIQUE,
num_etudiant VARCHAR(50) UNIQUE, 
formation VARCHAR(100), -- Ex: MMI, INFO-COM, GACO/GEA)
peut_emprunt boolean NOT NULL DEFAULT TRUE -- Peut emprunter des livres mais interdit si il rend trop de livre en retard ou en mauvais état
)

CREATE  TABLE Livre(
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(100) NOT NULL,
    isbn VARCHAR(13) NOT NULL UNIQUE,
    editeur VARCHAR(100),
    annee_publication INT,
    genre VARCHAR(50),
    _collection VARCHAR(100),
    nombre_pages INT,
    _resume TEXT,
    _image VARCHAR(255),
    stock INT NOT NULL,
    disponible BOOLEAN NOT NULL DEFAULT TRUE  -- Disponible = 1, Non disponible = 0 
)

CREATE TABLE Emprunt(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_etudiant INT NOT NULL,
    id_livre INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour DATE,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id),
    FOREIGN KEY (id_livre) REFERENCES Livre(id)
)

ALTER TABLE Emprunt ADD FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id);
ALTER TABLE Emprunt ADD FOREIGN KEY (id_livre) REFERENCES Livre(id);

CREATE TABLE bibliothécaire(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    mail_iut VARCHAR(255) NOT NULL UNIQUE,
    num_personnel VARCHAR(50) UNIQUE,
    _admin BOOLEAN NOT NULL DEFAULT TRUE
)   

