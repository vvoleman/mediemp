<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101083819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_appointment (id INT AUTO_INCREMENT NOT NULL, employer_course_id INT NOT NULL, date DATETIME NOT NULL, place VARCHAR(255) NOT NULL, capacity INT NOT NULL, INDEX IDX_8A56C890DB417098 (employer_course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_registration (id INT AUTO_INCREMENT NOT NULL, course_appointment_id INT NOT NULL, employee_id INT NOT NULL, absence SMALLINT NOT NULL, test_done SMALLINT NOT NULL, notification_status VARCHAR(32) NOT NULL, INDEX IDX_E362DF5A1A79D4CD (course_appointment_id), INDEX IDX_E362DF5A8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, employer_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, degree VARCHAR(32) NOT NULL, birthday DATE NOT NULL, birth_city VARCHAR(128) NOT NULL, citizenship VARCHAR(32) NOT NULL, designation_of_professional_competence VARCHAR(255) NOT NULL, diploma_number VARCHAR(64) NOT NULL, diploma_date DATE NOT NULL, specialized_competency LONGTEXT NOT NULL, special_professional_or_special_specialized_competencies LONGTEXT NOT NULL, identification_data_of_the_educational_establishment LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), INDEX IDX_5D9F75A141CD9E7A (employer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, provider_type VARCHAR(255) NOT NULL, form_of_care VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employer_course (id INT AUTO_INCREMENT NOT NULL, employer_id INT DEFAULT NULL, course_id INT NOT NULL, INDEX IDX_49D1931E41CD9E7A (employer_id), INDEX IDX_49D1931E591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE global_course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, focus LONGTEXT NOT NULL, specialization LONGTEXT NOT NULL, keywords LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_appointment ADD CONSTRAINT FK_8A56C890DB417098 FOREIGN KEY (employer_course_id) REFERENCES employer_course (id)');
        $this->addSql('ALTER TABLE course_registration ADD CONSTRAINT FK_E362DF5A1A79D4CD FOREIGN KEY (course_appointment_id) REFERENCES course_appointment (id)');
        $this->addSql('ALTER TABLE course_registration ADD CONSTRAINT FK_E362DF5A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A141CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id)');
        $this->addSql('ALTER TABLE employer_course ADD CONSTRAINT FK_49D1931E41CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id)');
        $this->addSql('ALTER TABLE employer_course ADD CONSTRAINT FK_49D1931E591CC992 FOREIGN KEY (course_id) REFERENCES global_course (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_registration DROP FOREIGN KEY FK_E362DF5A1A79D4CD');
        $this->addSql('ALTER TABLE course_registration DROP FOREIGN KEY FK_E362DF5A8C03F15C');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A141CD9E7A');
        $this->addSql('ALTER TABLE employer_course DROP FOREIGN KEY FK_49D1931E41CD9E7A');
        $this->addSql('ALTER TABLE course_appointment DROP FOREIGN KEY FK_8A56C890DB417098');
        $this->addSql('ALTER TABLE employer_course DROP FOREIGN KEY FK_49D1931E591CC992');
        $this->addSql('DROP TABLE course_appointment');
        $this->addSql('DROP TABLE course_registration');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employer');
        $this->addSql('DROP TABLE employer_course');
        $this->addSql('DROP TABLE global_course');
    }
}
