<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220619155722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE response_to_request ADD application_id INT NOT NULL');
        $this->addSql('ALTER TABLE response_to_request ADD CONSTRAINT FK_66F7458A3E030ACD FOREIGN KEY (application_id) REFERENCES application_for_training (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_66F7458A3E030ACD ON response_to_request (application_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE response_to_request DROP CONSTRAINT FK_66F7458A3E030ACD');
        $this->addSql('DROP INDEX UNIQ_66F7458A3E030ACD');
        $this->addSql('ALTER TABLE response_to_request DROP application_id');
    }
}
