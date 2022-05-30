<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527154405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE office_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE workplace_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE office (id INT NOT NULL, name VARCHAR(255) NOT NULL, floor INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE workplace (id INT NOT NULL, user_in_workplace_id INT DEFAULT NULL, office_id INT DEFAULT NULL, room_in_the_office INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D0FB92EE4F0F3820 ON workplace (user_in_workplace_id)');
        $this->addSql('CREATE INDEX IDX_D0FB92EEFFA0C224 ON workplace (office_id)');
        $this->addSql('ALTER TABLE workplace ADD CONSTRAINT FK_D0FB92EE4F0F3820 FOREIGN KEY (user_in_workplace_id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workplace ADD CONSTRAINT FK_D0FB92EEFFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE workplace DROP CONSTRAINT FK_D0FB92EEFFA0C224');
        $this->addSql('DROP SEQUENCE office_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE workplace_id_seq CASCADE');
        $this->addSql('DROP TABLE office');
        $this->addSql('DROP TABLE workplace');
    }
}
