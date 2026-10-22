-- +--------------------------------------------------------------------+  
-- TP1 Projet musique
-- +--------------------------------------------------------------------+  
DROP DATABASE IF EXISTS musique;

CREATE DATABASE musique;

USE musique;

-- +--------------------------------------------------------------------+  
-- Tableau : ARTISTE
-- +--------------------------------------------------------------------+  
CREATE TABLE
    artiste (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        pays VARCHAR(100),
        date_naissance DATE,
        biographie TEXT
    );

-- +--------------------------------------------------------------------+ 
-- Tableau : ALBUM 
-- +--------------------------------------------------------------------+ 
CREATE TABLE
    album (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(100) NOT NULL,
        date_sortie DATE,
        description TEXT,
        artiste_id INT,
        CONSTRAINT fk_album_artiste FOREIGN KEY (artiste_id) REFERENCES artiste (id)
    );

-- +--------------------------------------------------------------------+  
-- Tableau : CHANSON 
-- +--------------------------------------------------------------------+
CREATE TABLE
    chanson (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(100) NOT NULL,
        duration TIME,
        date_sortie DATE,
        album_id INT,
        CONSTRAINT fk_chanson_album FOREIGN KEY (album_id) REFERENCES album (id)
    );

-- +--------------------------------------------------------------------+  
-- Tableau : GENRE 
-- +--------------------------------------------------------------------+
CREATE TABLE
    genre (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL
    );

-- +--------------------------------------------------------------------+  
-- Tableau : CHANSON_GENRE (Table de relation plusieurs-à-plusieurs entre CHANSON et GENRE)
-- +--------------------------------------------------------------------+
CREATE TABLE
    chanson_genre (
        chanson_id INT NOT NULL,
        genre_id INT NOT NULL,
        PRIMARY KEY (chanson_id, genre_id),
        CONSTRAINT fk_chansongenre_chanson FOREIGN KEY (chanson_id) REFERENCES chanson (id),
        CONSTRAINT fk_chansongenre_genre FOREIGN KEY (genre_id) REFERENCES genre (id)
    );

-- +--------------------------------------------------------------------+  
-- Données musique
-- +--------------------------------------------------------------------+ 
INSERT INTO artiste (nom, pays, date_naissance, biographie) VALUES
    (
        'Michael Jackson',
        'États-Unis',
        '1958-08-29',
        'Chanteur, composeur et danseur américain, largement reconnu comme le Roi de la Pop mondial.'
    ),
    (
        'Kendrick Lamar',
        'États-Unis',
        '1987-06-17',
        'Rappeur, auteur-compositeur et producteur américain, né le 17 juin 1987 à Compton, en Californie.'
    ),
    (
        'Richy Jay',
        'Haiti',
        '1980-01-01',
        'Chanteur, auteur-compositeur et artiste canado-haitien originaire de Port-au-Prince, en Haiti, qui mélange les rythmes du zouk, du kompa et de l''afropop.'
    ),
    (
        'Cowboys Fringants',
        'Canada',
        '1994-01-01',
        'Groupe de folk-rock et néo-traditionnel québécois formé à Repentigny.'
    );

INSERT INTO album (titre, date_sortie, description, artiste_id) VALUES
    (
        'Xscape',
        '2014-05-09',
        'Xscape est un album studio. Il s''agit du deuxième album studio posthume du chanteur après Michael.',
        1
    ),
    (
        'Damn',
        '2017-04-14',
        'Damn est le quatrième album studio sur les labels Top Dawg, Aftermath et Interscope.',
        2
    ),
    (
        'Caribbean Soul',
        '2019-09-27',
        'Caribbean Soul est un album de l''artiste canado-haĩtien Richy Jay.',
        3
    ),
    (
        'Que du vent',
        '2011-11-14',
        'Que du vent est le douzième album studio. Il remporte le prix Félix de l''album rock de l''année en 2012.',
        4
    );

INSERT INTO chanson (titre, duration, date_sortie, album_id) VALUES
    (
        'Chicago',
        '00:04:06',
        '2014-05-05',
        1
    ),
    (
        'PRIDE',
        '00:04:35',
        '2017-04-14',
        2
    ),
    (
        'Ayiti cheri',
        '00:03:20',
        '2019-09-27',
        3
    ),
    (
        'Paris-Montréal',
        '00:03:11',
        '2011-11-14',
        4
    );

INSERT INTO genre (nom) VALUES
    (
        'Pop'
    ),
    (
        'Hip-hop psychédélique'
    ),
    (
        'Kompa'
    ),
    (
        'Folk rock'
    );

INSERT INTO chanson_genre (chanson_id, genre_id) VALUES
    (
        1,
        1
    ),
    (
        2,
        2
    ),
    (
        3,
        3
    ),
    (
        4,
        4
    );