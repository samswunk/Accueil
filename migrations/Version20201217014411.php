<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217014411 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultants DROP FOREIGN KEY FK_BA9B4EF7F17F8D0C');
        $this->addSql('DROP TABLE consultations');
        $this->addSql('DROP INDEX IDX_BA9B4EF7F17F8D0C ON consultants');
        $this->addSql('ALTER TABLE consultants CHANGE consultations_id convocations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultants ADD CONSTRAINT FK_BA9B4EF7DA415C9D FOREIGN KEY (convocations_id) REFERENCES convocations (id)');
        $this->addSql('CREATE INDEX IDX_BA9B4EF7DA415C9D ON consultants (convocations_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultations (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE consultants DROP FOREIGN KEY FK_BA9B4EF7DA415C9D');
        $this->addSql('DROP INDEX IDX_BA9B4EF7DA415C9D ON consultants');
        $this->addSql('ALTER TABLE consultants CHANGE convocations_id consultations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultants ADD CONSTRAINT FK_BA9B4EF7F17F8D0C FOREIGN KEY (consultations_id) REFERENCES consultations (id)');
        $this->addSql('CREATE INDEX IDX_BA9B4EF7F17F8D0C ON consultants (consultations_id)');
    }
}
