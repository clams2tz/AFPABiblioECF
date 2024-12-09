<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209191257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations ADD salle_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239DC304035 FOREIGN KEY (salle_id) REFERENCES salle_de_travail (id)');
        $this->addSql('CREATE INDEX IDX_4DA239DC304035 ON reservations (salle_id)');
        $this->addSql('ALTER TABLE users ADD user_abonnement_id INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E91F59E943 FOREIGN KEY (user_abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E91F59E943 ON users (user_abonnement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239DC304035');
        $this->addSql('DROP INDEX IDX_4DA239DC304035 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP salle_id');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E91F59E943');
        $this->addSql('DROP INDEX IDX_1483A5E91F59E943 ON users');
        $this->addSql('ALTER TABLE users DROP user_abonnement_id');
    }
}
