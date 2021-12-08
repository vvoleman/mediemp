<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211207135139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A13E1BC9C3');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A141CD9E7A');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A13E1BC9C3 FOREIGN KEY (managing_id) REFERENCES employer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A141CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A141CD9E7A');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A13E1BC9C3');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A141CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A13E1BC9C3 FOREIGN KEY (managing_id) REFERENCES employer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
