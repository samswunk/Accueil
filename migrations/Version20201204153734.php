<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204153734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, medinf_id INT DEFAULT NULL, libfonction VARCHAR(50) NOT NULL, INDEX IDX_900D5BD22639737 (medinf_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier (id INT AUTO_INCREMENT NOT NULL, medinf_id INT DEFAULT NULL, libmetier VARCHAR(50) NOT NULL, INDEX IDX_51A00D8C22639737 (medinf_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fonction ADD CONSTRAINT FK_900D5BD22639737 FOREIGN KEY (medinf_id) REFERENCES medinf (id)');
        $this->addSql('ALTER TABLE metier ADD CONSTRAINT FK_51A00D8C22639737 FOREIGN KEY (medinf_id) REFERENCES medinf (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE metier');
    }
}