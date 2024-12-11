<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241210171801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement ADD subscription_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE abonnement_id abonnement_id INT DEFAULT NULL, CHANGE user_role user_role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP subscription_type');
        $this->addSql('ALTER TABLE users CHANGE abonnement_id abonnement_id INT NOT NULL, CHANGE user_role user_role LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
    }
}
