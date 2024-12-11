<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241210122744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books CHANGE etat book_condition VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE salle_de_travail ADD television TINYINT(1) NOT NULL, ADD climatisation TINYINT(1) NOT NULL, CHANGE projecter projector TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE user_role user_role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_de_travail ADD projecter TINYINT(1) NOT NULL, DROP projector, DROP television, DROP climatisation');
        $this->addSql('ALTER TABLE books CHANGE book_condition etat VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE user_role user_role LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
    }
}
