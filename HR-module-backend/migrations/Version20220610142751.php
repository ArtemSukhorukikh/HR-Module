<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610142751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence_user (competence_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(competence_id, user_id))');
        $this->addSql('CREATE INDEX IDX_CA0BDC5215761DAB ON competence_user (competence_id)');
        $this->addSql('CREATE INDEX IDX_CA0BDC52A76ED395 ON competence_user (user_id)');
        $this->addSql('ALTER TABLE competence_user ADD CONSTRAINT FK_CA0BDC5215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence_user ADD CONSTRAINT FK_CA0BDC52A76ED395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE competence_user');
    }
}
