<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209231644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_de_travail ADD wifi TINYINT(1) NOT NULL, ADD projecter TINYINT(1) NOT NULL, ADD tableau TINYINT(1) NOT NULL, ADD prises_electric INT NOT NULL, ADD television TINYINT(1) NOT NULL, ADD climatisation TINYINT(1) NOT NULL, DROP equipment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_de_travail ADD equipment JSON NOT NULL, DROP wifi, DROP projecter, DROP tableau, DROP prises_electric, DROP television, DROP climatisation');
    }
}
