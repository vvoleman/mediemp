<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117111208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, identity_id INT NOT NULL, UNIQUE INDEX UNIQ_880E0D76FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bug (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, created_by_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_358CBF1412469DE2 (category_id), INDEX IDX_358CBF14B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bug_image (bug_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_C0FA1973FA3DB3D5 (bug_id), INDEX IDX_C0FA19733DA5256D (image_id), PRIMARY KEY(bug_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bug_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_appointment (id INT AUTO_INCREMENT NOT NULL, employer_course_id INT NOT NULL, date DATETIME NOT NULL, place VARCHAR(255) NOT NULL, capacity INT NOT NULL, INDEX IDX_8A56C890DB417098 (employer_course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_registration (id INT AUTO_INCREMENT NOT NULL, course_appointment_id INT NOT NULL, employee_id INT NOT NULL, absence SMALLINT NOT NULL, test_done SMALLINT NOT NULL, notification_status VARCHAR(32) NOT NULL, INDEX IDX_E362DF5A1A79D4CD (course_appointment_id), INDEX IDX_E362DF5A8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_asset (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, schema_file VARCHAR(255) NOT NULL, source_link VARCHAR(255) NOT NULL, change_frequency_days INT DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4C1096C35E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_asset_version (id INT AUTO_INCREMENT NOT NULL, data_asset_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', process_time DOUBLE PRECISION NOT NULL, INDEX IDX_2DB086BFCF04D09D (data_asset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, employer_id INT NOT NULL, managing_id INT DEFAULT NULL, identity_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, degree VARCHAR(32) NOT NULL, birthday DATE NOT NULL, birth_city VARCHAR(128) NOT NULL, citizenship VARCHAR(32) NOT NULL, designation_of_professional_competence VARCHAR(255) NOT NULL, diploma_number VARCHAR(64) NOT NULL, diploma_date DATE NOT NULL, specialized_competency LONGTEXT NOT NULL, special_professional_or_special_specialized_competencies LONGTEXT NOT NULL, identification_data_of_the_educational_establishment LONGTEXT NOT NULL, INDEX IDX_5D9F75A141CD9E7A (employer_id), INDEX IDX_5D9F75A13E1BC9C3 (managing_id), UNIQUE INDEX UNIQ_5D9F75A1FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, provider_type VARCHAR(255) NOT NULL, form_of_care VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employer_course (id INT AUTO_INCREMENT NOT NULL, employer_id INT DEFAULT NULL, course_id INT NOT NULL, INDEX IDX_49D1931E41CD9E7A (employer_id), INDEX IDX_49D1931E591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE global_course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, focus LONGTEXT NOT NULL, specialization LONGTEXT NOT NULL, keywords LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C53D045FD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF1412469DE2 FOREIGN KEY (category_id) REFERENCES bug_category (id)');
        $this->addSql('ALTER TABLE bug ADD CONSTRAINT FK_358CBF14B03A8386 FOREIGN KEY (created_by_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE bug_image ADD CONSTRAINT FK_C0FA1973FA3DB3D5 FOREIGN KEY (bug_id) REFERENCES bug (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bug_image ADD CONSTRAINT FK_C0FA19733DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_appointment ADD CONSTRAINT FK_8A56C890DB417098 FOREIGN KEY (employer_course_id) REFERENCES employer_course (id)');
        $this->addSql('ALTER TABLE course_registration ADD CONSTRAINT FK_E362DF5A1A79D4CD FOREIGN KEY (course_appointment_id) REFERENCES course_appointment (id)');
        $this->addSql('ALTER TABLE course_registration ADD CONSTRAINT FK_E362DF5A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE data_asset_version ADD CONSTRAINT FK_2DB086BFCF04D09D FOREIGN KEY (data_asset_id) REFERENCES data_asset (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A141CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A13E1BC9C3 FOREIGN KEY (managing_id) REFERENCES employer (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employer_course ADD CONSTRAINT FK_49D1931E41CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id)');
        $this->addSql('ALTER TABLE employer_course ADD CONSTRAINT FK_49D1931E591CC992 FOREIGN KEY (course_id) REFERENCES global_course (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bug_image DROP FOREIGN KEY FK_C0FA1973FA3DB3D5');
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF1412469DE2');
        $this->addSql('ALTER TABLE course_registration DROP FOREIGN KEY FK_E362DF5A1A79D4CD');
        $this->addSql('ALTER TABLE data_asset_version DROP FOREIGN KEY FK_2DB086BFCF04D09D');
        $this->addSql('ALTER TABLE bug DROP FOREIGN KEY FK_358CBF14B03A8386');
        $this->addSql('ALTER TABLE course_registration DROP FOREIGN KEY FK_E362DF5A8C03F15C');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A141CD9E7A');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A13E1BC9C3');
        $this->addSql('ALTER TABLE employer_course DROP FOREIGN KEY FK_49D1931E41CD9E7A');
        $this->addSql('ALTER TABLE course_appointment DROP FOREIGN KEY FK_8A56C890DB417098');
        $this->addSql('ALTER TABLE employer_course DROP FOREIGN KEY FK_49D1931E591CC992');
        $this->addSql('ALTER TABLE bug_image DROP FOREIGN KEY FK_C0FA19733DA5256D');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76FF3ED4A8');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1FF3ED4A8');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE bug');
        $this->addSql('DROP TABLE bug_image');
        $this->addSql('DROP TABLE bug_category');
        $this->addSql('DROP TABLE course_appointment');
        $this->addSql('DROP TABLE course_registration');
        $this->addSql('DROP TABLE data_asset');
        $this->addSql('DROP TABLE data_asset_version');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employer');
        $this->addSql('DROP TABLE employer_course');
        $this->addSql('DROP TABLE global_course');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE user');
    }
}
