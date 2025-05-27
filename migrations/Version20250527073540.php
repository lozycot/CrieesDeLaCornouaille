<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527073540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Drop all tables if they exist (simulate dropping the DB)
        $this->addSql('SET FOREIGN_KEY_CHECKS = 0;');
        $this->addSql('DROP TABLE IF EXISTS acheteur;');
        $this->addSql('DROP TABLE IF EXISTS bac;');
        $this->addSql('DROP TABLE IF EXISTS bateau;');
        $this->addSql('DROP TABLE IF EXISTS enchere;');
        $this->addSql('DROP TABLE IF EXISTS espece;');
        $this->addSql('DROP TABLE IF EXISTS facture;');
        $this->addSql('DROP TABLE IF EXISTS lot;');
        $this->addSql('DROP TABLE IF EXISTS messenger_messages;');
        $this->addSql('DROP TABLE IF EXISTS peche;');
        $this->addSql('DROP TABLE IF EXISTS presentation;');
        $this->addSql('DROP TABLE IF EXISTS qualite;');
        $this->addSql('DROP TABLE IF EXISTS taille;');
        $this->addSql('DROP TABLE IF EXISTS type_bateau;');
        $this->addSql('DROP TABLE IF EXISTS user;');
        $this->addSql('DROP TABLE IF EXISTS vente;');
        $this->addSql('SET FOREIGN_KEY_CHECKS = 1;');

        // Now recreate all tables in alphabetical order
        $this->addSql('CREATE TABLE acheteur (
            id INT AUTO_INCREMENT NOT NULL,
            raison_sociale_entreprise VARCHAR(50) DEFAULT NULL,
            num_rue VARCHAR(5) DEFAULT NULL,
            rue VARCHAR(50) DEFAULT NULL,
            ville VARCHAR(50) DEFAULT NULL,
            code_postal VARCHAR(5) DEFAULT NULL,
            num_habilitation VARCHAR(10) NOT NULL,
            user_id INT NOT NULL,
            INDEX IDX_304AFF9DA76ED395 (user_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE bac (
            id INT AUTO_INCREMENT NOT NULL,
            tare NUMERIC(9, 2) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE bateau (
            id INT AUTO_INCREMENT NOT NULL,
            type_bateau_id INT NOT NULL,
            taille_bateau INT DEFAULT NULL,
            nom_bateau VARCHAR(50) DEFAULT NULL,
            INDEX IDX_A664B05A1DB62419 (type_bateau_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE enchere (
            id INT AUTO_INCREMENT NOT NULL,
            acheteur_id INT NOT NULL,
            lot_id INT NOT NULL,
            prix_enchere NUMERIC(17, 2) DEFAULT NULL,
            heure_enchere TIME DEFAULT NULL,
            INDEX IDX_38D1870F96A7BB5F (acheteur_id),
            INDEX IDX_38D1870FA8CBA5F7 (lot_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE espece (
            id INT AUTO_INCREMENT NOT NULL,
            nom_espece VARCHAR(50) DEFAULT NULL,
            nom_commun_espece VARCHAR(50) DEFAULT NULL,
            nom_scientifique_espece VARCHAR(50) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE facture (
            id INT AUTO_INCREMENT NOT NULL,
            acheteur_id INT NOT NULL,
            INDEX IDX_FE86641096A7BB5F (acheteur_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE lot (
            id INT AUTO_INCREMENT NOT NULL,
            qualite_id INT DEFAULT NULL,
            bac_id INT NOT NULL,
            presentation_id INT NOT NULL,
            taille_id INT NOT NULL,
            espece_id INT NOT NULL,
            prix_plancher NUMERIC(17, 2) DEFAULT NULL,
            prix_depart NUMERIC(17, 2) DEFAULT NULL,
            prix_encheres_max NUMERIC(17, 2) DEFAULT NULL,
            poids_brut_lot INT DEFAULT NULL,
            facture_id INT DEFAULT NULL,
            vente_id INT NOT NULL,
            peche_id INT DEFAULT NULL,
            INDEX IDX_B81291BA6338570 (qualite_id),
            INDEX IDX_B81291BE03F15C0 (bac_id),
            INDEX IDX_B81291BAB627E8B (presentation_id),
            INDEX IDX_B81291BFF25611A (taille_id),
            INDEX IDX_B81291B2D191E7A (espece_id),
            INDEX IDX_B81291B7F2DEE08 (facture_id),
            INDEX IDX_B81291B7DC7170A (vente_id),
            INDEX IDX_B81291BA22677D0 (peche_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE messenger_messages (
            id BIGINT AUTO_INCREMENT NOT NULL,
            body LONGTEXT NOT NULL,
            headers LONGTEXT NOT NULL,
            queue_name VARCHAR(190) NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            INDEX IDX_75EA56E0FB7336F0 (queue_name),
            INDEX IDX_75EA56E0E3BD61CE (available_at),
            INDEX IDX_75EA56E016BA31DB (delivered_at),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE peche (
            id INT AUTO_INCREMENT NOT NULL,
            date_peche DATE NOT NULL,
            duree_maree INT DEFAULT NULL,
            bateau INT NOT NULL,
            INDEX IDX_E96511E2A664B05A (bateau),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE presentation (
            id INT AUTO_INCREMENT NOT NULL,
            denomination VARCHAR(50) DEFAULT NULL,
            code VARCHAR(5) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE qualite (
            id INT AUTO_INCREMENT NOT NULL,
            denomination VARCHAR(50) DEFAULT NULL,
            code VARCHAR(1) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE taille (
            id INT AUTO_INCREMENT NOT NULL,
            specification VARCHAR(50) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE type_bateau (
            id INT AUTO_INCREMENT NOT NULL,
            designation VARCHAR(50) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE user (
            id INT AUTO_INCREMENT NOT NULL,
            login VARCHAR(180) NOT NULL,
            roles JSON NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(50) NOT NULL,
            UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN (login),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE vente (
            id INT AUTO_INCREMENT NOT NULL,
            date_vente DATE NOT NULL,
            heure_debut TIME DEFAULT NULL,
            heure_fin TIME DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Foreign keys (keep as before)
        $this->addSql('ALTER TABLE acheteur ADD CONSTRAINT FK_304AFF9DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641096A7BB5F FOREIGN KEY (acheteur_id) REFERENCES acheteur (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BA6338570 FOREIGN KEY (qualite_id) REFERENCES qualite (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BE03F15C0 FOREIGN KEY (bac_id) REFERENCES bac (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BAB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B2D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BA22677D0 FOREIGN KEY (peche_id) REFERENCES peche (id)');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870F96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES acheteur (id)');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870FA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE peche ADD CONSTRAINT FK_E96511E2A664B05A FOREIGN KEY (bateau) REFERENCES bateau (id)');
        $this->addSql('ALTER TABLE bateau ADD CONSTRAINT FK_A664B05A1DB62419 FOREIGN KEY (type_bateau_id) REFERENCES type_bateau (id)');

        // Insert the admin user
        $this->addSql("INSERT INTO user (login, roles, password, email) VALUES ('admin', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '\$2y\$13\$Y24llt0UhNgB6EjP7684H.hwQz0lBc35EOGpu5anT6htbguA4QaTa', 'test@test.com');");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B7F2DEE08');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641096A7BB5F');
        $this->addSql('DROP TABLE facture');
        $this->addSql('ALTER TABLE acheteur DROP FOREIGN KEY FK_304AFF9DA76ED395');
        $this->addSql('DROP INDEX IDX_304AFF9DA76ED395 ON acheteur');
        $this->addSql('ALTER TABLE acheteur ADD login VARCHAR(50) NOT NULL, ADD pwd VARCHAR(50) NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B7DC7170A');
        $this->addSql('DROP INDEX IDX_B81291B7F2DEE08 ON lot');
        $this->addSql('DROP INDEX IDX_B81291B7DC7170A ON lot');
        $this->addSql('ALTER TABLE lot ADD date_enchere DATE DEFAULT NULL, ADD id_facture INT DEFAULT NULL, DROP vente_id, CHANGE facture_id acheteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES acheteur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B81291B96A7BB5F ON lot (acheteur_id)');
        $this->addSql('ALTER TABLE enchere ADD vente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870F7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_38D1870F7DC7170A ON enchere (vente_id)');
    }
}
