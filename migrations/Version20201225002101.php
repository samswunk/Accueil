<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225002101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultants_consultants (consultants_source INT NOT NULL, consultants_target INT NOT NULL, INDEX IDX_B40CF066E62B4F44 (consultants_source), INDEX IDX_B40CF066FFCE1FCB (consultants_target), PRIMARY KEY(consultants_source, consultants_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultants_consultants ADD CONSTRAINT FK_B40CF066E62B4F44 FOREIGN KEY (consultants_source) REFERENCES consultants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultants_consultants ADD CONSTRAINT FK_B40CF066FFCE1FCB FOREIGN KEY (consultants_target) REFERENCES consultants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultants CHANGE prenom prenom VARCHAR(50) DEFAULT NULL, CHANGE nom nom VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE consultants_consultants');
        $this->addSql('ALTER TABLE consultants CHANGE nom nom VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
