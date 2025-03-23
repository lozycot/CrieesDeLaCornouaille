<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323030600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B28A43EE6');
        $this->addSql('DROP INDEX IDX_B81291B28A43EE6 ON lot');
        $this->addSql('ALTER TABLE lot DROP Peche');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot ADD Peche INT NOT NULL');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B28A43EE6 FOREIGN KEY (Peche) REFERENCES peche (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B81291B28A43EE6 ON lot (Peche)');
    }
}
