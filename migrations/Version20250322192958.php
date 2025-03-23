<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322192958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, date_vente DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enchere ADD vente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE enchere ADD CONSTRAINT FK_38D1870F7DC7170A FOREIGN KEY (vente_id) REFERENCES vente (id)');
        $this->addSql('CREATE INDEX IDX_38D1870F7DC7170A ON enchere (vente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enchere DROP FOREIGN KEY FK_38D1870F7DC7170A');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP INDEX IDX_38D1870F7DC7170A ON enchere');
        $this->addSql('ALTER TABLE enchere DROP vente_id');
    }
}
