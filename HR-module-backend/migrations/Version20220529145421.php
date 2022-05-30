<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529145421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE personal_achievements_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE personal_achievements (id INT NOT NULL, тфname VARCHAR(255) NOT NULL, description TEXT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE personal_achievements_user (personal_achievements_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(personal_achievements_id, user_id))');
        $this->addSql('CREATE INDEX IDX_5EEB2C4D60AC4AB8 ON personal_achievements_user (personal_achievements_id)');
        $this->addSql('CREATE INDEX IDX_5EEB2C4DA76ED395 ON personal_achievements_user (user_id)');
        $this->addSql('ALTER TABLE personal_achievements_user ADD CONSTRAINT FK_5EEB2C4D60AC4AB8 FOREIGN KEY (personal_achievements_id) REFERENCES personal_achievements (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_achievements_user ADD CONSTRAINT FK_5EEB2C4DA76ED395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE personal_achievements_user DROP CONSTRAINT FK_5EEB2C4D60AC4AB8');
        $this->addSql('DROP SEQUENCE personal_achievements_id_seq CASCADE');
        $this->addSql('DROP TABLE personal_achievements');
        $this->addSql('DROP TABLE personal_achievements_user');
    }
}
