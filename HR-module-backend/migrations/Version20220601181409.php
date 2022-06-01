<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601181409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback ADD authon_id INT NOT NULL');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458ECBA1B3C FOREIGN KEY (authon_id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D2294458ECBA1B3C ON feedback (authon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE feedback DROP CONSTRAINT FK_D2294458ECBA1B3C');
        $this->addSql('DROP INDEX IDX_D2294458ECBA1B3C');
        $this->addSql('ALTER TABLE feedback DROP authon_id');
    }
}
