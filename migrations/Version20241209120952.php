<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209120952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrowers ADD abonnement_id_id INT NOT NULL, ADD user_role LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ADD birthday DATE NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE borrowers ADD CONSTRAINT FK_D7D928D3F483159E FOREIGN KEY (abonnement_id_id) REFERENCES abonnement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7D928D3F483159E ON borrowers (abonnement_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrowers DROP FOREIGN KEY FK_D7D928D3F483159E');
        $this->addSql('DROP INDEX UNIQ_D7D928D3F483159E ON borrowers');
        $this->addSql('ALTER TABLE borrowers DROP abonnement_id_id, DROP user_role, DROP birthday, DROP email, DROP password');
    }
}
