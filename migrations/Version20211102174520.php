<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211102174520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF14B03A8386 FOREIGN KEY (created_by_id) REFERENCES employee (id)');
        $this->addSql('CREATE INDEX IDX_358CBF14B03A8386 ON bug (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF14B03A8386');
        $this->addSql('DROP INDEX IDX_358CBF14B03A8386 ON bug');
        $this->addSql('ALTER TABLE bug DROP created_by_id');
    }
}
