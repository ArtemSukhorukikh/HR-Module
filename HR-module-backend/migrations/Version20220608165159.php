<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608165159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE competence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE competence (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(3000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competence_educational_resources (competence_id INT NOT NULL, educational_resources_id INT NOT NULL, PRIMARY KEY(competence_id, educational_resources_id))');
        $this->addSql('CREATE INDEX IDX_7FD31B4715761DAB ON competence_educational_resources (competence_id)');
        $this->addSql('CREATE INDEX IDX_7FD31B47E09430FD ON competence_educational_resources (educational_resources_id)');
        $this->addSql('ALTER TABLE competence_educational_resources ADD CONSTRAINT FK_7FD31B4715761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence_educational_resources ADD CONSTRAINT FK_7FD31B47E09430FD FOREIGN KEY (educational_resources_id) REFERENCES educational_resources (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hr_user ADD works_id INT NOT NULL');
        $this->addSql('ALTER TABLE hr_user ADD CONSTRAINT FK_754B2079F6CB822A FOREIGN KEY (works_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_754B2079F6CB822A ON hr_user (works_id)');
        $this->addSql('ALTER TABLE survey ADD status INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE competence_educational_resources DROP CONSTRAINT FK_7FD31B4715761DAB');
        $this->addSql('DROP SEQUENCE competence_id_seq CASCADE');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_educational_resources');
        $this->addSql('ALTER TABLE hr_user DROP CONSTRAINT FK_754B2079F6CB822A');
        $this->addSql('DROP INDEX IDX_754B2079F6CB822A');
        $this->addSql('ALTER TABLE hr_user DROP works_id');
        $this->addSql('ALTER TABLE survey DROP status');
    }
}
