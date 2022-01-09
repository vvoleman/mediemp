<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211205143906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employer ADD line_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employer ADD CONSTRAINT FK_DE4CF0664D7B7542 FOREIGN KEY (line_id) REFERENCES employer_line (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE4CF0664D7B7542 ON employer (line_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employer DROP FOREIGN KEY FK_DE4CF0664D7B7542');
        $this->addSql('DROP INDEX UNIQ_DE4CF0664D7B7542 ON employer');
        $this->addSql('ALTER TABLE employer DROP line_id');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
