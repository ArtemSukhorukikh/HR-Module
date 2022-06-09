<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609124211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE application_purchase_of_personal_training_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personal_training_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_evaluation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE application_purchase_of_personal_training (id INT NOT NULL, user__id INT NOT NULL, link VARCHAR(255) NOT NULL, note VARCHAR(3000) NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8BABF00A8D57A4BB ON application_purchase_of_personal_training (user__id)');
        $this->addSql('CREATE TABLE user_task (user_id INT NOT NULL, task_id INT NOT NULL, PRIMARY KEY(user_id, task_id))');
        $this->addSql('CREATE INDEX IDX_28FF97ECA76ED395 ON user_task (user_id)');
        $this->addSql('CREATE INDEX IDX_28FF97EC8DB60186 ON user_task (task_id)');
        $this->addSql('CREATE TABLE personal_training (id INT NOT NULL, application_id INT NOT NULL, contract_number VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_792D54C63E030ACD ON personal_training (application_id)');
        $this->addSql('CREATE TABLE projects (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, status INT NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, closed_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE task (id INT NOT NULL, project_task_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, estimated_hours DOUBLE PRECISION DEFAULT NULL, close_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB251BA80DE3 ON task (project_task_id)');
        $this->addSql('CREATE TABLE task_user (task_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(task_id, user_id))');
        $this->addSql('CREATE INDEX IDX_FE2042328DB60186 ON task_user (task_id)');
        $this->addSql('CREATE INDEX IDX_FE204232A76ED395 ON task_user (user_id)');
        $this->addSql('CREATE TABLE task_evaluation (id INT NOT NULL, to_task_id INT DEFAULT NULL, description TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F30EEDA32E3C73 ON task_evaluation (to_task_id)');
        $this->addSql('ALTER TABLE application_purchase_of_personal_training ADD CONSTRAINT FK_8BABF00A8D57A4BB FOREIGN KEY (user__id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_task ADD CONSTRAINT FK_28FF97ECA76ED395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_task ADD CONSTRAINT FK_28FF97EC8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_training ADD CONSTRAINT FK_792D54C63E030ACD FOREIGN KEY (application_id) REFERENCES application_purchase_of_personal_training (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB251BA80DE3 FOREIGN KEY (project_task_id) REFERENCES projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE2042328DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE204232A76ED395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_evaluation ADD CONSTRAINT FK_F30EEDA32E3C73 FOREIGN KEY (to_task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE personal_training DROP CONSTRAINT FK_792D54C63E030ACD');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB251BA80DE3');
        $this->addSql('ALTER TABLE user_task DROP CONSTRAINT FK_28FF97EC8DB60186');
        $this->addSql('ALTER TABLE task_user DROP CONSTRAINT FK_FE2042328DB60186');
        $this->addSql('ALTER TABLE task_evaluation DROP CONSTRAINT FK_F30EEDA32E3C73');
        $this->addSql('DROP SEQUENCE application_purchase_of_personal_training_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personal_training_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_evaluation_id_seq CASCADE');
        $this->addSql('DROP TABLE application_purchase_of_personal_training');
        $this->addSql('DROP TABLE user_task');
        $this->addSql('DROP TABLE personal_training');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_user');
        $this->addSql('DROP TABLE task_evaluation');
    }
}
