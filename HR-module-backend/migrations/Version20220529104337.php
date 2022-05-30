<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529104337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE grade_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE grade (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE grade_user (grade_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(grade_id, user_id))');
        $this->addSql('CREATE INDEX IDX_23F19B59FE19A1A8 ON grade_user (grade_id)');
        $this->addSql('CREATE INDEX IDX_23F19B59A76ED395 ON grade_user (user_id)');
        $this->addSql('ALTER TABLE grade_user ADD CONSTRAINT FK_23F19B59FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE grade_user ADD CONSTRAINT FK_23F19B59A76ED395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE grade_user DROP CONSTRAINT FK_23F19B59FE19A1A8');
        $this->addSql('DROP SEQUENCE grade_id_seq CASCADE');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE grade_user');
    }
}
