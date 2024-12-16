<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216122044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations ADD end_time DATETIME NOT NULL, DROP duree, CHANGE date start_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE abonnement_id abonnement_id INT DEFAULT NULL, CHANGE user_role roles VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations ADD date DATETIME NOT NULL, ADD duree INT NOT NULL, DROP start_time, DROP end_time');
        $this->addSql('ALTER TABLE users CHANGE abonnement_id abonnement_id INT NOT NULL, CHANGE roles user_role VARCHAR(255) NOT NULL');
    }
}
