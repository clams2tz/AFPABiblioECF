<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213165318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loans CHANGE borrow_date borrow_date DATETIME NOT NULL, CHANGE due_date due_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE loans ADD CONSTRAINT FK_82C24DBC16A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('CREATE INDEX IDX_82C24DBC16A2B381 ON loans (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loans DROP FOREIGN KEY FK_82C24DBC16A2B381');
        $this->addSql('DROP INDEX IDX_82C24DBC16A2B381 ON loans');
        $this->addSql('ALTER TABLE loans CHANGE borrow_date borrow_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE due_date due_date DATE NOT NULL');
    }
}
