<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204211041 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invitations (id INT AUTO_INCREMENT NOT NULL, dateinvitation DATE NOT NULL, nbrpersonnes INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitations_consultants (invitations_id INT NOT NULL, consultants_id INT NOT NULL, INDEX IDX_CDEAF90B5A6F1243 (invitations_id), INDEX IDX_CDEAF90BDFED8898 (consultants_id), PRIMARY KEY(invitations_id, consultants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invitations_consultants ADD CONSTRAINT FK_CDEAF90B5A6F1243 FOREIGN KEY (invitations_id) REFERENCES invitations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invitations_consultants ADD CONSTRAINT FK_CDEAF90BDFED8898 FOREIGN KEY (consultants_id) REFERENCES consultants (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invitations_consultants DROP FOREIGN KEY FK_CDEAF90B5A6F1243');
        $this->addSql('DROP TABLE invitations');
        $this->addSql('DROP TABLE invitations_consultants');
    }
}
