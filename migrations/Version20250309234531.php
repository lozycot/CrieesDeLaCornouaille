<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250309234531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheteur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(50) NOT NULL, pwd VARCHAR(50) NOT NULL, raison_sociale_entreprise VARCHAR(50) DEFAULT NULL, num_rue VARCHAR(5) DEFAULT NULL, rue VARCHAR(50) DEFAULT NULL, ville VARCHAR(50) DEFAULT NULL, code_postal VARCHAR(5) DEFAULT NULL, num_habilitation VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bac (id INT AUTO_INCREMENT NOT NULL, tare NUMERIC(9, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bateau (id INT AUTO_INCREMENT NOT NULL, type_bateau_id INT NOT NULL, taille_bateau INT DEFAULT NULL, nom_bateau VARCHAR(50) DEFAULT NULL, INDEX IDX_A664B05A1DB62419 (type_bateau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enchere (id INT AUTO_INCREMENT NOT NULL, acheteur_id INT NOT NULL, lot_id INT NOT NULL, prix_enchere NUMERIC(17, 2) DEFAULT NULL, heure_enchere TIME DEFAULT NULL, INDEX IDX_38D1870F96A7BB5F (acheteur_id), INDEX IDX_38D1870FA8CBA5F7 (lot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espece (id INT AUTO_INCREMENT NOT NULL, nom_espece VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lot (id INT NOT NULL, qualite_id INT DEFAULT NULL, acheteur_id INT DEFAULT NULL, bac_id INT NOT NULL, presentation_id INT NOT NULL, taille_id INT NOT NULL, espece_id INT NOT NULL, prix_plancher NUMERIC(17, 2) DEFAULT NULL, prix_depart NUMERIC(17, 2) DEFAULT NULL, prix_encheres_max NUMERIC(17, 2) DEFAULT NULL, date_enchere DATE DEFAULT NULL, heure_debut_enchere TIME DEFAULT NULL, code_etat VARCHAR(50) DEFAULT NULL, id_facture INT DEFAULT NULL, poids_brut_lot INT DEFAULT NULL, Peche INT NOT NULL, INDEX IDX_B81291B28A43EE6 (Peche), INDEX IDX_B81291BA6338570 (qualite_id), INDEX IDX_B81291B96A7BB5F (acheteur_id), INDEX IDX_B81291BE03F15C0 (bac_id), INDEX IDX_B81291BAB627E8B (presentation_id), INDEX IDX_B81291BFF25611A (taille_id), INDEX IDX_B81291B2D191E7A (espece_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE peche (id INT AUTO_INCREMENT NOT NULL, date_peche DATE NOT NULL, duree_maree INT DEFAULT NULL, Peche INT NOT NULL, INDEX IDX_E96511E228A43EE6 (Peche), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presentation (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qualite (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille (id INT AUTO_INCREMENT NOT NULL, specification VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bateau (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bateau ADD CONSTRAINT FK_A664B05A1DB62419 FOREIGN KEY (type_bateau_id) REFERENCES type_bateau (id)');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870F96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES acheteur (id)');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870FA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B28A43EE6 FOREIGN KEY (Peche) REFERENCES peche (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BA6338570 FOREIGN KEY (qualite_id) REFERENCES qualite (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES acheteur (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BE03F15C0 FOREIGN KEY (bac_id) REFERENCES bac (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BAB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B2D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id)');
        $this->addSql('ALTER TABLE peche ADD CONSTRAINT FK_E96511E228A43EE6 FOREIGN KEY (Peche) REFERENCES bateau (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bateau DROP FOREIGN KEY FK_A664B05A1DB62419');
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870F96A7BB5F');
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870FA8CBA5F7');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B28A43EE6');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BA6338570');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B96A7BB5F');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BE03F15C0');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BAB627E8B');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BFF25611A');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B2D191E7A');
        $this->addSql('ALTER TABLE peche DROP FOREIGN KEY FK_E96511E228A43EE6');
        $this->addSql('DROP TABLE acheteur');
        $this->addSql('DROP TABLE bac');
        $this->addSql('DROP TABLE bateau');
        $this->addSql('DROP TABLE enchere');
        $this->addSql('DROP TABLE espece');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE peche');
        $this->addSql('DROP TABLE presentation');
        $this->addSql('DROP TABLE qualite');
        $this->addSql('DROP TABLE taille');
        $this->addSql('DROP TABLE type_bateau');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
