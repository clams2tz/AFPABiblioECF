<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209182340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_reservations DROP FOREIGN KEY FK_59AC6861A76ED395');
        $this->addSql('DROP TABLE book_reservations');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE salle_de_travail');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A7DD8AC20');
        $this->addSql('DROP INDEX IDX_5F9E962A7DD8AC20 ON comments');
        $this->addSql('ALTER TABLE comments ADD book_id INT NOT NULL, ADD user_id INT NOT NULL, DROP books_id, DROP borrower_id');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A16A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A16A2B381 ON comments (book_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AA76ED395 ON comments (user_id)');
        $this->addSql('ALTER TABLE loans DROP borrower_id, DROP book_id, DROP reserved');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_reservations (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_59AC6861A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_salle INT NOT NULL, id_borrower INT NOT NULL, duree INT NOT NULL, date DATE NOT NULL, time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE salle_de_travail (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, max_capacity INT NOT NULL, wifi TINYINT(1) NOT NULL, projector TINYINT(1) NOT NULL, tableau TINYINT(1) NOT NULL, television TINYINT(1) NOT NULL, climatisation TINYINT(1) NOT NULL, prises_electriques INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE book_reservations ADD CONSTRAINT FK_59AC6861A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A16A2B381');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('DROP INDEX IDX_5F9E962A16A2B381 ON comments');
        $this->addSql('DROP INDEX IDX_5F9E962AA76ED395 ON comments');
        $this->addSql('ALTER TABLE comments ADD books_id INT DEFAULT NULL, ADD borrower_id DATE NOT NULL, DROP book_id, DROP user_id');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5F9E962A7DD8AC20 ON comments (books_id)');
        $this->addSql('ALTER TABLE loans ADD borrower_id INT NOT NULL, ADD book_id VARCHAR(255) NOT NULL, ADD reserved INT DEFAULT NULL');
    }
}
