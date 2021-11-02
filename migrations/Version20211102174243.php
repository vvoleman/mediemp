<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211102174243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bug (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT NOT NULL, INDEX IDX_358CBF1412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bug_image (bug_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_C0FA1973FA3DB3D5 (bug_id), INDEX IDX_C0FA19733DA5256D (image_id), PRIMARY KEY(bug_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bug_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF1412469DE2 FOREIGN KEY (category_id) REFERENCES bug_category (id)');
        $this->addSql('ALTER TABLE bug_image ADD CONSTRAINT FK_C0FA1973FA3DB3D5 FOREIGN KEY (bug_id) REFERENCES bug (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bug_image ADD CONSTRAINT FK_C0FA19733DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug_image DROP FOREIGN KEY FK_C0FA1973FA3DB3D5');
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF1412469DE2');
        $this->addSql('ALTER TABLE bug_image DROP FOREIGN KEY FK_C0FA19733DA5256D');
        $this->addSql('DROP TABLE bug');
        $this->addSql('DROP TABLE bug_image');
        $this->addSql('DROP TABLE bug_category');
        $this->addSql('DROP TABLE image');
    }
}
