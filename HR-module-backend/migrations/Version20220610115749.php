<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610115749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE skill_assessment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE skill_assessment (id INT NOT NULL, estimation INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE skills (id INT NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, description VARCHAR(3000) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE skill_assessment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_id_seq CASCADE');
        $this->addSql('DROP TABLE skill_assessment');
        $this->addSql('DROP TABLE skills');
    }
}
