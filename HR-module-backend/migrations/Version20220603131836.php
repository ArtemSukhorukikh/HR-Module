<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603131836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE contacts_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE department_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE educational_resources_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE feedback_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE grade_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hr_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE office_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personal_achievements_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE projects_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE workplace_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contacts (id INT NOT NULL, user_contact_id INT NOT NULL, source VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3340157340C6E3A6 ON contacts (user_contact_id)');
        $this->addSql('CREATE TABLE department (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE educational_resources (id INT NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, description VARCHAR(3000) NOT NULL, link VARCHAR(255) NOT NULL, date DATE NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE feedback (id INT NOT NULL, authon_id INT NOT NULL, educational_resources_id INT NOT NULL, date DATE NOT NULL, estimation INT NOT NULL, note VARCHAR(3000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D2294458ECBA1B3C ON feedback (authon_id)');
        $this->addSql('CREATE INDEX IDX_D2294458E09430FD ON feedback (educational_resources_id)');
        $this->addSql('CREATE TABLE grade (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE grade_user (grade_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(grade_id, user_id))');
        $this->addSql('CREATE INDEX IDX_23F19B59FE19A1A8 ON grade_user (grade_id)');
        $this->addSql('CREATE INDEX IDX_23F19B59A76ED395 ON grade_user (user_id)');
        $this->addSql('CREATE TABLE hr_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, patronymic VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, date_of_hiring DATE NOT NULL, development_plan VARCHAR(3000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_754B2079F85E0677 ON hr_user (username)');
        $this->addSql('CREATE TABLE office (id INT NOT NULL, name VARCHAR(255) NOT NULL, floor INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE personal_achievements (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE personal_achievements_user (personal_achievements_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(personal_achievements_id, user_id))');
        $this->addSql('CREATE INDEX IDX_5EEB2C4D60AC4AB8 ON personal_achievements_user (personal_achievements_id)');
        $this->addSql('CREATE INDEX IDX_5EEB2C4DA76ED395 ON personal_achievements_user (user_id)');
        $this->addSql('CREATE TABLE projects (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, status INT NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, closed_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE task (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, estimated_hours DOUBLE PRECISION DEFAULT NULL, close_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE task_user (task_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(task_id, user_id))');
        $this->addSql('CREATE INDEX IDX_FE2042328DB60186 ON task_user (task_id)');
        $this->addSql('CREATE INDEX IDX_FE204232A76ED395 ON task_user (user_id)');
        $this->addSql('CREATE TABLE workplace (id INT NOT NULL, user_in_workplace_id INT DEFAULT NULL, office_id INT DEFAULT NULL, room_in_the_office INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D0FB92EE4F0F3820 ON workplace (user_in_workplace_id)');
        $this->addSql('CREATE INDEX IDX_D0FB92EEFFA0C224 ON workplace (office_id)');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_3340157340C6E3A6 FOREIGN KEY (user_contact_id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458ECBA1B3C FOREIGN KEY (authon_id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458E09430FD FOREIGN KEY (educational_resources_id) REFERENCES educational_resources (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade_user ADD CONSTRAINT FK_23F19B59FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade_user ADD CONSTRAINT FK_23F19B59A76ED395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_achievements_user ADD CONSTRAINT FK_5EEB2C4D60AC4AB8 FOREIGN KEY (personal_achievements_id) REFERENCES personal_achievements (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_achievements_user ADD CONSTRAINT FK_5EEB2C4DA76ED395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE2042328DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE204232A76ED395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workplace ADD CONSTRAINT FK_D0FB92EE4F0F3820 FOREIGN KEY (user_in_workplace_id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workplace ADD CONSTRAINT FK_D0FB92EEFFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D2294458E09430FD');
        $this->addSql('ALTER TABLE grade_user DROP CONSTRAINT FK_23F19B59FE19A1A8');
        $this->addSql('ALTER TABLE contacts DROP CONSTRAINT FK_3340157340C6E3A6');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D2294458ECBA1B3C');
        $this->addSql('ALTER TABLE grade_user DROP CONSTRAINT FK_23F19B59A76ED395');
        $this->addSql('ALTER TABLE personal_achievements_user DROP CONSTRAINT FK_5EEB2C4DA76ED395');
        $this->addSql('ALTER TABLE task_user DROP CONSTRAINT FK_FE204232A76ED395');
        $this->addSql('ALTER TABLE workplace DROP CONSTRAINT FK_D0FB92EE4F0F3820');
        $this->addSql('ALTER TABLE workplace DROP CONSTRAINT FK_D0FB92EEFFA0C224');
        $this->addSql('ALTER TABLE personal_achievements_user DROP CONSTRAINT FK_5EEB2C4D60AC4AB8');
        $this->addSql('ALTER TABLE task_user DROP CONSTRAINT FK_FE2042328DB60186');
        $this->addSql('DROP SEQUENCE contacts_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE department_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE educational_resources_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE feedback_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE grade_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hr_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE office_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personal_achievements_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE projects_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE workplace_id_seq CASCADE');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE educational_resources');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE grade_user');
        $this->addSql('DROP TABLE hr_user');
        $this->addSql('DROP TABLE office');
        $this->addSql('DROP TABLE personal_achievements');
        $this->addSql('DROP TABLE personal_achievements_user');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_user');
        $this->addSql('DROP TABLE workplace');
    }
}
