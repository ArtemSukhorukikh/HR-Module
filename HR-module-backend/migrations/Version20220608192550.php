<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608192550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE application_purchase_of_personal_training_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personal_training_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE application_purchase_of_personal_training (id INT NOT NULL, user__id INT NOT NULL, link VARCHAR(255) NOT NULL, note VARCHAR(3000) NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8BABF00A8D57A4BB ON application_purchase_of_personal_training (user__id)');
        $this->addSql('CREATE TABLE personal_training (id INT NOT NULL, application_id INT NOT NULL, contract_number VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_792D54C63E030ACD ON personal_training (application_id)');
        $this->addSql('ALTER TABLE application_purchase_of_personal_training ADD CONSTRAINT FK_8BABF00A8D57A4BB FOREIGN KEY (user__id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_training ADD CONSTRAINT FK_792D54C63E030ACD FOREIGN KEY (application_id) REFERENCES application_purchase_of_personal_training (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE personal_training DROP CONSTRAINT FK_792D54C63E030ACD');
        $this->addSql('DROP SEQUENCE application_purchase_of_personal_training_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personal_training_id_seq CASCADE');
        $this->addSql('DROP TABLE application_purchase_of_personal_training');
        $this->addSql('DROP TABLE personal_training');
    }
}
