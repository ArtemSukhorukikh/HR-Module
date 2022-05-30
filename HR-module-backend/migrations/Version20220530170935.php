<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530170935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hr_user ADD last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE hr_user ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE hr_user ADD patronymic VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE hr_user ADD position VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE hr_user ADD date_of_hiring DATE NOT NULL');
        $this->addSql('ALTER TABLE hr_user ADD development_plan VARCHAR(3000) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE hr_user DROP last_name');
        $this->addSql('ALTER TABLE hr_user DROP first_name');
        $this->addSql('ALTER TABLE hr_user DROP patronymic');
        $this->addSql('ALTER TABLE hr_user DROP position');
        $this->addSql('ALTER TABLE hr_user DROP date_of_hiring');
        $this->addSql('ALTER TABLE hr_user DROP development_plan');
    }
}
