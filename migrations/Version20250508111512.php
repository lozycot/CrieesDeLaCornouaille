<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250508111512 extends AbstractMigration
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
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B96A7BB5F');
        $this->addSql('DROP INDEX IDX_B81291B96A7BB5F ON lot');
        $this->addSql('ALTER TABLE lot ADD facture_id INT DEFAULT NULL, DROP acheteur_id, DROP id_facture');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE INDEX IDX_B81291B7F2DEE08 ON lot (facture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B7F2DEE08');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641096A7BB5F');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP INDEX IDX_B81291B7F2DEE08 ON lot');
        $this->addSql('ALTER TABLE lot ADD id_facture INT DEFAULT NULL, CHANGE facture_id acheteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES acheteur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B81291B96A7BB5F ON lot (acheteur_id)');
    }
}
