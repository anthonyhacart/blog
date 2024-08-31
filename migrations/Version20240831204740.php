<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831204740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, content FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER NOT NULL, content CLOB NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_23A0E66BF396750 FOREIGN KEY (id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, content) SELECT id, content FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('ALTER TABLE content ADD COLUMN slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__link AS SELECT id, url FROM link');
        $this->addSql('DROP TABLE link');
        $this->addSql('CREATE TABLE link (id INTEGER NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_36AC99F1BF396750 FOREIGN KEY (id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO link (id, url) SELECT id, url FROM __temp__link');
        $this->addSql('DROP TABLE __temp__link');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, content FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content CLOB NOT NULL, CONSTRAINT FK_23A0E66BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, content) SELECT id, content FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE TEMPORARY TABLE __temp__content AS SELECT id, title, is_private, status, created_at, updated_at, meta_description, discr FROM content');
        $this->addSql('DROP TABLE content');
        $this->addSql('CREATE TABLE content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, is_private BOOLEAN NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , meta_description VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO content (id, title, is_private, status, created_at, updated_at, meta_description, discr) SELECT id, title, is_private, status, created_at, updated_at, meta_description, discr FROM __temp__content');
        $this->addSql('DROP TABLE __temp__content');
        $this->addSql('CREATE TEMPORARY TABLE __temp__link AS SELECT id, url FROM link');
        $this->addSql('DROP TABLE link');
        $this->addSql('CREATE TABLE link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) NOT NULL, CONSTRAINT FK_36AC99F1BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO link (id, url) SELECT id, url FROM __temp__link');
        $this->addSql('DROP TABLE __temp__link');
    }
}
