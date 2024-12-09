<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209122459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books DROP comments, DROP note, CHANGE reservation reserved TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD books_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A7DD8AC20 ON comments (books_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books ADD comments LONGTEXT DEFAULT NULL, ADD note INT DEFAULT NULL, CHANGE reserved reservation TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A7DD8AC20');
        $this->addSql('DROP INDEX IDX_5F9E962A7DD8AC20 ON comments');
        $this->addSql('ALTER TABLE comments DROP books_id');
    }
}
