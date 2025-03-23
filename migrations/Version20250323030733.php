<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323030733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot ADD peche_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BA22677D0 FOREIGN KEY (peche_id) REFERENCES peche (id)');
        $this->addSql('CREATE INDEX IDX_B81291BA22677D0 ON lot (peche_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BA22677D0');
        $this->addSql('DROP INDEX IDX_B81291BA22677D0 ON lot');
        $this->addSql('ALTER TABLE lot DROP peche_id');
    }
}
