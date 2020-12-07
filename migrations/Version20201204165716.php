<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204165716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medinf (id INT AUTO_INCREMENT NOT NULL, fonction_id INT DEFAULT NULL, matricule BIGINT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(50) DEFAULT NULL, telmedinf BIGINT DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, INDEX IDX_F89757A557889920 (fonction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medinf_metier (medinf_id INT NOT NULL, metier_id INT NOT NULL, INDEX IDX_8C7FEBC122639737 (medinf_id), INDEX IDX_8C7FEBC1ED16FA20 (metier_id), PRIMARY KEY(medinf_id, metier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medinf ADD CONSTRAINT FK_F89757A557889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id)');
        $this->addSql('ALTER TABLE medinf_metier ADD CONSTRAINT FK_8C7FEBC122639737 FOREIGN KEY (medinf_id) REFERENCES medinf (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medinf_metier ADD CONSTRAINT FK_8C7FEBC1ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medinf_metier DROP FOREIGN KEY FK_8C7FEBC122639737');
        $this->addSql('DROP TABLE medinf');
        $this->addSql('DROP TABLE medinf_metier');
    }
}
