<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214123336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239DC304035');
        $this->addSql('DROP INDEX IDX_4DA239DC304035 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP salle_id');
        $this->addSql('ALTER TABLE salle_de_travail ADD reservations_id INT NOT NULL');
        $this->addSql('ALTER TABLE salle_de_travail ADD CONSTRAINT FK_C71DB9A0D9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C71DB9A0D9A7F869 ON salle_de_travail (reservations_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_de_travail DROP FOREIGN KEY FK_C71DB9A0D9A7F869');
        $this->addSql('DROP INDEX UNIQ_C71DB9A0D9A7F869 ON salle_de_travail');
        $this->addSql('ALTER TABLE salle_de_travail DROP reservations_id');
        $this->addSql('ALTER TABLE reservations ADD salle_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239DC304035 FOREIGN KEY (salle_id) REFERENCES salle_de_travail (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4DA239DC304035 ON reservations (salle_id)');
    }
}
