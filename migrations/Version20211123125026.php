<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123125026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employer_line (id INT AUTO_INCREMENT NOT NULL, medical_facility_id INT NOT NULL, code INT NOT NULL, facility_name VARCHAR(255) NOT NULL, facility_type VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone_number INT NOT NULL, email VARCHAR(128) NOT NULL, web VARCHAR(128) NOT NULL, ico INT NOT NULL, field_of_care VARCHAR(255) NOT NULL, form_of_care VARCHAR(255) NOT NULL, type_of_care VARCHAR(255) NOT NULL, representative VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE employer_line');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
