<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610132923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skills_competence (skills_id INT NOT NULL, competence_id INT NOT NULL, PRIMARY KEY(skills_id, competence_id))');
        $this->addSql('CREATE INDEX IDX_54BA97B27FF61858 ON skills_competence (skills_id)');
        $this->addSql('CREATE INDEX IDX_54BA97B215761DAB ON skills_competence (competence_id)');
        $this->addSql('ALTER TABLE skills_competence ADD CONSTRAINT FK_54BA97B27FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills_competence ADD CONSTRAINT FK_54BA97B215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence ADD type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_assessment ADD user__id INT NOT NULL');
        $this->addSql('ALTER TABLE skill_assessment ADD skills_id INT NOT NULL');
        $this->addSql('ALTER TABLE skill_assessment ADD CONSTRAINT FK_E2DBE1028D57A4BB FOREIGN KEY (user__id) REFERENCES hr_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skill_assessment ADD CONSTRAINT FK_E2DBE1027FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E2DBE1028D57A4BB ON skill_assessment (user__id)');
        $this->addSql('CREATE INDEX IDX_E2DBE1027FF61858 ON skill_assessment (skills_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE skills_competence');
        $this->addSql('ALTER TABLE skill_assessment DROP CONSTRAINT FK_E2DBE1028D57A4BB');
        $this->addSql('ALTER TABLE skill_assessment DROP CONSTRAINT FK_E2DBE1027FF61858');
        $this->addSql('DROP INDEX IDX_E2DBE1028D57A4BB');
        $this->addSql('DROP INDEX IDX_E2DBE1027FF61858');
        $this->addSql('ALTER TABLE skill_assessment DROP user__id');
        $this->addSql('ALTER TABLE skill_assessment DROP skills_id');
        $this->addSql('ALTER TABLE competence DROP type');
    }
}
