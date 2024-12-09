<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209190837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, duree INT NOT NULL, INDEX IDX_4DA239A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle_de_travail (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, max_capacity INT NOT NULL, equipment JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE loans ADD user_id INT NOT NULL, ADD book_id INT NOT NULL');
        $this->addSql('ALTER TABLE loans ADD CONSTRAINT FK_82C24DBCA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE loans ADD CONSTRAINT FK_82C24DBC16A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('CREATE INDEX IDX_82C24DBCA76ED395 ON loans (user_id)');
        $this->addSql('CREATE INDEX IDX_82C24DBC16A2B381 ON loans (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE salle_de_travail');
        $this->addSql('ALTER TABLE loans DROP FOREIGN KEY FK_82C24DBCA76ED395');
        $this->addSql('ALTER TABLE loans DROP FOREIGN KEY FK_82C24DBC16A2B381');
        $this->addSql('DROP INDEX IDX_82C24DBCA76ED395 ON loans');
        $this->addSql('DROP INDEX IDX_82C24DBC16A2B381 ON loans');
        $this->addSql('ALTER TABLE loans DROP user_id, DROP book_id');
    }
}
