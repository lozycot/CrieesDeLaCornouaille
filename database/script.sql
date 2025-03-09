DROP DATABASE IF EXISTS criee_test;

CREATE DATABASE criee_test CHARACTER SET utf8mb4;
USE criee_test;

CREATE TABLE TAILLE(
   idTaille INT PRIMARY KEY AUTO_INCREMENT,
   specification VARCHAR(50)
);

CREATE TABLE BAC_(
   idBac INT PRIMARY KEY AUTO_INCREMENT,
   tare DECIMAL(7,2)
);

CREATE TABLE ACHETEUR(
   idAcheteur INT PRIMARY KEY AUTO_INCREMENT,
   login VARCHAR(50),
   pwd VARCHAR(50),
   raisonSocialeEntreprise VARCHAR(50),
   numRue VARCHAR(5),
   rue VARCHAR(50),
   ville VARCHAR(50),
   codePostal VARCHAR(5),
   numHabilitation VARCHAR(10)
);

CREATE TABLE TYPE_BATEAU(
   idTypeBateau INT PRIMARY KEY,
   designation VARCHAR(50)
);

CREATE TABLE BATEAU(
   idBateau INT PRIMARY KEY AUTO_INCREMENT,
   tailleBateau INT,
   nomBateau VARCHAR(50),
   idTypeBateau INT,
   CONSTRAINT fk_BATEAU_idTypeBateau
              FOREIGN KEY (idTypeBateau)
              REFERENCES TYPE_BATEAU(idTypeBateau)
              ON UPDATE CASCADE
              ON DELETE CASCADE
);

CREATE TABLE ESPECE(
   idEspece INT PRIMARY KEY AUTO_INCREMENT,
   nomEspece VARCHAR(50)
);

CREATE TABLE PECHE(
   idBateau INT,
   datePeche DATE NOT NULL,
   PRIMARY KEY(idBateau, datePeche),
   dureeMaree INT,
   CONSTRAINT fk_PECHE_bateau
            FOREIGN KEY (idBateau)
            REFERENCES BATEAU(idBateau)
            ON UPDATE CASCADE
            ON DELETE CASCADE
);

CREATE TABLE PRESENTATION(
   idPresentation INT PRIMARY KEY AUTO_INCREMENT,
   denomination VARCHAR(50)
);

CREATE TABLE QUALITE(
   idQualite VARCHAR(1) PRIMARY KEY,
   denomination VARCHAR(50)
);

CREATE TABLE LOT_(
   idBateau INT NOT NULL,
   datePeche DATE NOT NULL,
   CONSTRAINT fk_LOT_idBateau_datePeche
              FOREIGN KEY(idBateau, datePeche)
           REFERENCES PECHE(idBateau, datePeche)
           ON UPDATE CASCADE
           ON DELETE CASCADE,
   idLot INT NOT NULL,
   PRIMARY KEY(idBateau, datePeche, idLot),
   prixPlancher DECIMAL(15,2),
   prixDepart DECIMAL(15,2),
   prixEncheresMax DECIMAL(15,2),
   dateEnchere DATE,
   heureDebutEnchere DATE,
   codeEtat VARCHAR(50),
   idFacture INT,
   poidsBrutLot INT,
   idQualite VARCHAR(1),
   CONSTRAINT fk_LOT_idQualite
              FOREIGN KEY (idQualite)
              REFERENCES QUALITE(idQualite)
              ON UPDATE CASCADE
              ON DELETE CASCADE,
   idAcheteur INT,
   CONSTRAINT fk_LOT_idAcheteur
              FOREIGN KEY (idAcheteur)
              REFERENCES ACHETEUR(idAcheteur)
              ON UPDATE CASCADE
              ON DELETE CASCADE,
   idBac INT,
   CONSTRAINT fk_LOT_idBac
              FOREIGN KEY(idBac)
              REFERENCES BAC_(idBac)
              ON UPDATE CASCADE
              ON DELETE CASCADE,
   idPresentation INT,
   CONSTRAINT fk_LOT_idPresentation
              FOREIGN KEY(idPresentation)
              REFERENCES PRESENTATION(idPresentation)
              ON UPDATE CASCADE
              ON DELETE CASCADE,
   idTaille INT,
   CONSTRAINT fk_LOT_idTaille
              FOREIGN KEY(idTaille)
              REFERENCES TAILLE(idTaille)
              ON UPDATE CASCADE
              ON DELETE CASCADE,
   idEspece INT,
   CONSTRAINT fk_LOT_idEspece
              FOREIGN KEY(idEspece)
              REFERENCES ESPECE(idEspece)
              ON UPDATE CASCADE
              ON DELETE CASCADE
);

CREATE TABLE POSTER(
   idAcheteur INT,
   CONSTRAINT fk_POSTER_idAcheteur
              FOREIGN KEY(idAcheteur)
              REFERENCES ACHETEUR(idAcheteur)
              ON UPDATE CASCADE
              ON DELETE CASCADE,
   idBateau INT NOT NULL,
   datePeche DATE NOT NULL,
   idLot INT NOT NULL,
   CONSTRAINT fk_POSTER_idBateau_datePeche_idLot
              FOREIGN KEY(idBateau, datePeche, idLot)
              REFERENCES LOT_(idBateau, datePeche, idLot)
              ON UPDATE CASCADE
              ON DELETE CASCADE,
   idPoste INT NOT NULL,
   PRIMARY KEY(idAcheteur, idBateau, datePeche, idLot, idPoste),
   prixEnchere DECIMAL(15,2),
   heureEnchere DATE
);

INSERT INTO TYPE_BATEAU VALUES(1, 'Chalutier');
INSERT INTO BATEAU(tailleBateau, nomBateau, idTypeBateau) values(15, 'TestNomBateau', 1);

DROP USER IF EXISTS 'devuser';
flush privileges;
CREATE USER 'devuser'@'%' IDENTIFIED BY 'pa33swdoreVie65zefe';

GRANT SELECT, INSERT, UPDATE, DELETE ON * TO 'devuser'@'%';
