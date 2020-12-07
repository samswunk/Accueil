<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203234112 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE convocations (id INT AUTO_INCREMENT NOT NULL, nti_id INT DEFAULT NULL, nbrpersonnes INT DEFAULT NULL, dateconvocation DATE NOT NULL, UNIQUE INDEX UNIQ_E01AB85150402D2D (nti_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE convocations ADD CONSTRAINT FK_E01AB85150402D2D FOREIGN KEY (nti_id) REFERENCES consultants (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE convocations');
    }
}
