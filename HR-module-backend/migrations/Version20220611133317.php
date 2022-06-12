<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611133317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE department ADD main_competence_id INT NOT NULL');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18AA7D2AE36 FOREIGN KEY (main_competence_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD1DE18AA7D2AE36 ON department (main_competence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE department DROP CONSTRAINT FK_CD1DE18AA7D2AE36');
        $this->addSql('DROP INDEX UNIQ_CD1DE18AA7D2AE36');
        $this->addSql('ALTER TABLE department DROP main_competence_id');
    }
}
