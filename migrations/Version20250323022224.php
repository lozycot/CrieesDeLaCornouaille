<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323022224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE peche DROP FOREIGN KEY FK_E96511E228A43EE6');
        $this->addSql('DROP INDEX IDX_E96511E228A43EE6 ON peche');
        $this->addSql('ALTER TABLE peche CHANGE Peche bateau INT NOT NULL');
        $this->addSql('ALTER TABLE peche ADD CONSTRAINT FK_E96511E2A664B05A FOREIGN KEY (bateau) REFERENCES bateau (id)');
        $this->addSql('CREATE INDEX IDX_E96511E2A664B05A ON peche (bateau)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE peche DROP FOREIGN KEY FK_E96511E2A664B05A');
        $this->addSql('DROP INDEX IDX_E96511E2A664B05A ON peche');
        $this->addSql('ALTER TABLE peche CHANGE bateau Peche INT NOT NULL');
        $this->addSql('ALTER TABLE peche ADD CONSTRAINT FK_E96511E228A43EE6 FOREIGN KEY (Peche) REFERENCES bateau (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E96511E228A43EE6 ON peche (Peche)');
    }
}
