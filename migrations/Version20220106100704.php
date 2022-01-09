<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106100704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_appointment DROP FOREIGN KEY FK_8A56C890DB417098');
        $this->addSql('ALTER TABLE course_appointment ADD CONSTRAINT FK_8A56C890DB417098 FOREIGN KEY (employer_course_id) REFERENCES employer_course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_registration DROP FOREIGN KEY FK_E362DF5A1A79D4CD');
        $this->addSql('ALTER TABLE course_registration DROP FOREIGN KEY FK_E362DF5A8C03F15C');
        $this->addSql('ALTER TABLE course_registration ADD CONSTRAINT FK_E362DF5A1A79D4CD FOREIGN KEY (course_appointment_id) REFERENCES course_appointment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_registration ADD CONSTRAINT FK_E362DF5A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employer_course DROP FOREIGN KEY FK_49D1931E41CD9E7A');
        $this->addSql('ALTER TABLE employer_course CHANGE employer_id employer_id INT NOT NULL');
        $this->addSql('ALTER TABLE employer_course ADD CONSTRAINT FK_49D1931E41CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_appointment DROP FOREIGN KEY FK_8A56C890DB417098');
        $this->addSql('ALTER TABLE course_appointment ADD CONSTRAINT FK_8A56C890DB417098 FOREIGN KEY (employer_course_id) REFERENCES employer_course (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE course_registration DROP FOREIGN KEY FK_E362DF5A1A79D4CD');
        $this->addSql('ALTER TABLE course_registration DROP FOREIGN KEY FK_E362DF5A8C03F15C');
        $this->addSql('ALTER TABLE course_registration ADD CONSTRAINT FK_E362DF5A1A79D4CD FOREIGN KEY (course_appointment_id) REFERENCES course_appointment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE course_registration ADD CONSTRAINT FK_E362DF5A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE employer_course DROP FOREIGN KEY FK_49D1931E41CD9E7A');
        $this->addSql('ALTER TABLE employer_course CHANGE employer_id employer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employer_course ADD CONSTRAINT FK_49D1931E41CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
