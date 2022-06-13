<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613195313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE department ADD obeys_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A3CB13FB5 FOREIGN KEY (obeys_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD1DE18A3CB13FB5 ON department (obeys_id)');
        $this->addSql('ALTER TABLE hr_user ADD directs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hr_user ADD CONSTRAINT FK_754B20799E052687 FOREIGN KEY (directs_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_754B20799E052687 ON hr_user (directs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE hr_user DROP CONSTRAINT FK_754B20799E052687');
        $this->addSql('DROP INDEX UNIQ_754B20799E052687');
        $this->addSql('ALTER TABLE hr_user DROP directs_id');
        $this->addSql('ALTER TABLE department DROP CONSTRAINT FK_CD1DE18A3CB13FB5');
        $this->addSql('DROP INDEX UNIQ_CD1DE18A3CB13FB5');
        $this->addSql('ALTER TABLE department DROP obeys_id');
    }
}
