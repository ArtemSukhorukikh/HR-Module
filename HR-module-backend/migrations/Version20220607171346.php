<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220607171346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_for_training ADD compose_id INT NOT NULL');
        $this->addSql('ALTER TABLE application_for_training ADD included_id INT NOT NULL');
        $this->addSql('ALTER TABLE application_for_training ADD CONSTRAINT FK_33E428C42F2EC0B2 FOREIGN KEY (compose_id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE application_for_training ADD CONSTRAINT FK_33E428C43C39138C FOREIGN KEY (included_id) REFERENCES educational_resources (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_33E428C42F2EC0B2 ON application_for_training (compose_id)');
        $this->addSql('CREATE INDEX IDX_33E428C43C39138C ON application_for_training (included_id)');
        $this->addSql('ALTER TABLE application_purchase_of_training ADD compose_id INT NOT NULL');
        $this->addSql('ALTER TABLE application_purchase_of_training ADD CONSTRAINT FK_F2DB316F2F2EC0B2 FOREIGN KEY (compose_id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F2DB316F2F2EC0B2 ON application_purchase_of_training (compose_id)');
        $this->addSql('ALTER TABLE respone_survey ADD user__id INT NOT NULL');
        $this->addSql('ALTER TABLE respone_survey ADD survey_id INT NOT NULL');
        $this->addSql('ALTER TABLE respone_survey ADD CONSTRAINT FK_81D66E808D57A4BB FOREIGN KEY (user__id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE respone_survey ADD CONSTRAINT FK_81D66E80B3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_81D66E808D57A4BB ON respone_survey (user__id)');
        $this->addSql('CREATE INDEX IDX_81D66E80B3FE509D ON respone_survey (survey_id)');
        $this->addSql('ALTER TABLE survey ADD describe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFC9086384 FOREIGN KEY (describe_id) REFERENCES application_purchase_of_training (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AD5F9BFC9086384 ON survey (describe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE application_purchase_of_training DROP CONSTRAINT FK_F2DB316F2F2EC0B2');
        $this->addSql('DROP INDEX IDX_F2DB316F2F2EC0B2');
        $this->addSql('ALTER TABLE application_purchase_of_training DROP compose_id');
        $this->addSql('ALTER TABLE application_for_training DROP CONSTRAINT FK_33E428C42F2EC0B2');
        $this->addSql('ALTER TABLE application_for_training DROP CONSTRAINT FK_33E428C43C39138C');
        $this->addSql('DROP INDEX IDX_33E428C42F2EC0B2');
        $this->addSql('DROP INDEX IDX_33E428C43C39138C');
        $this->addSql('ALTER TABLE application_for_training DROP compose_id');
        $this->addSql('ALTER TABLE application_for_training DROP included_id');
        $this->addSql('ALTER TABLE survey DROP CONSTRAINT FK_AD5F9BFC9086384');
        $this->addSql('DROP INDEX UNIQ_AD5F9BFC9086384');
        $this->addSql('ALTER TABLE survey DROP describe_id');
        $this->addSql('ALTER TABLE respone_survey DROP CONSTRAINT FK_81D66E808D57A4BB');
        $this->addSql('ALTER TABLE respone_survey DROP CONSTRAINT FK_81D66E80B3FE509D');
        $this->addSql('DROP INDEX IDX_81D66E808D57A4BB');
        $this->addSql('DROP INDEX IDX_81D66E80B3FE509D');
        $this->addSql('ALTER TABLE respone_survey DROP user__id');
        $this->addSql('ALTER TABLE respone_survey DROP survey_id');
    }
}
