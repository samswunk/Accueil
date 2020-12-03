<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203212923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultants (id INT AUTO_INCREMENT NOT NULL, enfant_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(50) DEFAULT NULL, numsecu BIGINT DEFAULT NULL, sexe INT DEFAULT NULL, ddn DATE DEFAULT NULL, INDEX IDX_BA9B4EF7450D2529 (enfant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultants ADD CONSTRAINT FK_BA9B4EF7450D2529 FOREIGN KEY (enfant_id) REFERENCES consultants (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultants DROP FOREIGN KEY FK_BA9B4EF7450D2529');
        $this->addSql('DROP TABLE consultants');
    }
}
