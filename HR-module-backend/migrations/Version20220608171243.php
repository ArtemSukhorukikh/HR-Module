<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608171243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence_competence (competence_source INT NOT NULL, competence_target INT NOT NULL, PRIMARY KEY(competence_source, competence_target))');
        $this->addSql('CREATE INDEX IDX_BA54D08816691A6F ON competence_competence (competence_source)');
        $this->addSql('CREATE INDEX IDX_BA54D088F8C4AE0 ON competence_competence (competence_target)');
        $this->addSql('ALTER TABLE competence_competence ADD CONSTRAINT FK_BA54D08816691A6F FOREIGN KEY (competence_source) REFERENCES competence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence_competence ADD CONSTRAINT FK_BA54D088F8C4AE0 FOREIGN KEY (competence_target) REFERENCES competence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE competence_competence');
    }
}
