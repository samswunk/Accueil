<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225194155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultants_consultants DROP FOREIGN KEY FK_B40CF066E62B4F44');
        $this->addSql('ALTER TABLE consultants_consultants DROP FOREIGN KEY FK_B40CF066FFCE1FCB');
        $this->addSql('ALTER TABLE consultants_consultants ADD CONSTRAINT FK_B40CF066E62B4F44 FOREIGN KEY (consultants_source) REFERENCES consultants (id)');
        $this->addSql('ALTER TABLE consultants_consultants ADD CONSTRAINT FK_B40CF066FFCE1FCB FOREIGN KEY (consultants_target) REFERENCES consultants (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultants_consultants DROP FOREIGN KEY FK_B40CF066E62B4F44');
        $this->addSql('ALTER TABLE consultants_consultants DROP FOREIGN KEY FK_B40CF066FFCE1FCB');
        $this->addSql('ALTER TABLE consultants_consultants ADD CONSTRAINT FK_B40CF066E62B4F44 FOREIGN KEY (consultants_source) REFERENCES consultants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultants_consultants ADD CONSTRAINT FK_B40CF066FFCE1FCB FOREIGN KEY (consultants_target) REFERENCES consultants (id) ON DELETE CASCADE');
    }
}
