<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214141243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations ADD salle_de_travail_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239E938E1BF FOREIGN KEY (salle_de_travail_id) REFERENCES salle_de_travail (id)');
        $this->addSql('CREATE INDEX IDX_4DA239E938E1BF ON reservations (salle_de_travail_id)');
        $this->addSql('ALTER TABLE salle_de_travail DROP reservations_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_de_travail ADD reservations_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239E938E1BF');
        $this->addSql('DROP INDEX IDX_4DA239E938E1BF ON reservations');
        $this->addSql('ALTER TABLE reservations DROP salle_de_travail_id');
    }
}
