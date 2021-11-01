<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101221650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD managing_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A13E1BC9C3 FOREIGN KEY (managing_id) REFERENCES employer (id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A13E1BC9C3 ON employee (managing_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A13E1BC9C3');
        $this->addSql('DROP INDEX IDX_5D9F75A13E1BC9C3 ON employee');
        $this->addSql('ALTER TABLE employee DROP managing_id');
    }
}
