<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526131020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, acheteur_id INT NOT NULL, INDEX IDX_FE86641096A7BB5F (acheteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641096A7BB5F FOREIGN KEY (acheteur_id) REFERENCES acheteur (id)');
        $this->addSql('ALTER TABLE acheteur ADD user_id INT NOT NULL, DROP login, DROP pwd');
        $this->addSql('ALTER TABLE acheteur ADD CONSTRAINT FK_304AFF9DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_304AFF9DA76ED395 ON acheteur (user_id)');
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870F7DC7170A');
        $this->addSql('DROP INDEX IDX_38D1870F7DC7170A ON enchere');
        $this->addSql('ALTER TABLE enchere DROP vente_id');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B96A7BB5F');
        $this->addSql('DROP INDEX IDX_B81291B96A7BB5F ON lot');
        $this->addSql('ALTER TABLE lot ADD facture_id INT DEFAULT NULL, ADD vente_id INT NOT NULL, DROP acheteur_id, DROP date_enchere, DROP id_facture');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('CREATE INDEX IDX_B81291B7F2DEE08 ON lot (facture_id)');
        $this->addSql('CREATE INDEX IDX_B81291B7DC7170A ON lot (vente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B7F2DEE08');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641096A7BB5F');
        $this->addSql('DROP TABLE facture');
        $this->addSql('ALTER TABLE enchere ADD vente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870F7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_38D1870F7DC7170A ON enchere (vente_id)');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B7DC7170A');
        $this->addSql('DROP INDEX IDX_B81291B7F2DEE08 ON lot');
        $this->addSql('DROP INDEX IDX_B81291B7DC7170A ON lot');
        $this->addSql('ALTER TABLE lot ADD date_enchere DATE DEFAULT NULL, ADD id_facture INT DEFAULT NULL, DROP vente_id, CHANGE facture_id acheteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES acheteur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B81291B96A7BB5F ON lot (acheteur_id)');
        $this->addSql('ALTER TABLE acheteur DROP FOREIGN KEY FK_304AFF9DA76ED395');
        $this->addSql('DROP INDEX IDX_304AFF9DA76ED395 ON acheteur');
        $this->addSql('ALTER TABLE acheteur ADD login VARCHAR(50) NOT NULL, ADD pwd VARCHAR(50) NOT NULL, DROP user_id');
    }
}
