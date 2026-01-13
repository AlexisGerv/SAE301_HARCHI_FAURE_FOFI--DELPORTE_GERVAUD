
CREATE TABLE utilisateur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    mail_iut VARCHAR(255) NOT NULL UNIQUE,
    num_etudiant VARCHAR(50) UNIQUE, 
    formation VARCHAR(100), -- Ex: MMI, INFO-COM, GACO/GEA)
    est_admin boolean NOT NULL DEFAULT FALSE, -- Peut emprunter des livres mais interdit si il rend trop de livre en retard ou en mauvais état
    peut_emprunter boolean NOT NULL DEFAULT TRUE -- Peut emprunter des livres mais interdit si il rend trop de livre en retard ou en mauvais état
);

CREATE TABLE livre (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(100) NOT NULL,
    _resume TEXT,
    isbn VARCHAR(13) NOT NULL UNIQUE,
    categorie VARCHAR(50),
    nb_exemplaires_total INT NOT NULL,
    nb_exemplaires_disponible INT NOT NULL,
    est_disponible BOOLEAN NOT NULL DEFAULT TRUE,
    format VARCHAR(50),
    editeur VARCHAR(100),
    date_publication DATE,
    mots_cles VARCHAR(255),
    image_couverture VARCHAR(500),
    type_support VARCHAR(50), -- 'papier' ou 'numerique'
    _collection VARCHAR(100),
    nb_pages INT,
    sudoc VARCHAR(50)
);

CREATE TABLE emprunt (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    livre_id INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour_prevue DATE NOT NULL,
    est_en_retard BOOLEAN NOT NULL DEFAULT FALSE,
    nombre_prolongations INT NOT NULL DEFAULT 0,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id),
    FOREIGN KEY (livre_id) REFERENCES livre(id)
);

