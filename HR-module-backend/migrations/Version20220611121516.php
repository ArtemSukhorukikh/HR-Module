<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611121516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE task_user');
        $this->addSql('ALTER TABLE competence ADD need_rating DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE task_user (task_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(task_id, user_id))');
        $this->addSql('CREATE INDEX idx_fe204232a76ed395 ON task_user (user_id)');
        $this->addSql('CREATE INDEX idx_fe2042328db60186 ON task_user (task_id)');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT fk_fe2042328db60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT fk_fe204232a76ed395 FOREIGN KEY (user_id) REFERENCES hr_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence DROP need_rating');
    }
}
