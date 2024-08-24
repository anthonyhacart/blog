<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240821230323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE tag_content (tag_id INTEGER NOT NULL, content_id INTEGER NOT NULL, PRIMARY KEY(tag_id, content_id), CONSTRAINT FK_CCF41D03BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CCF41D0384A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CCF41D03BAD26311 ON tag_content (tag_id)');
        $this->addSql('CREATE INDEX IDX_CCF41D0384A0A3ED ON tag_content (content_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, content FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER NOT NULL, content CLOB NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_23A0E66BF396750 FOREIGN KEY (id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, content) SELECT id, content FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE TEMPORARY TABLE __temp__content AS SELECT id, title, discr, is_private, status, created_at, updated_at FROM content');
        $this->addSql('DROP TABLE content');
        $this->addSql('CREATE TABLE content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, is_private BOOLEAN NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO content (id, title, discr, is_private, status, created_at, updated_at) SELECT id, title, discr, is_private, status, created_at, updated_at FROM __temp__content');
        $this->addSql('DROP TABLE __temp__content');
        $this->addSql('CREATE TEMPORARY TABLE __temp__link AS SELECT id, url FROM link');
        $this->addSql('DROP TABLE link');
        $this->addSql('CREATE TABLE link (id INTEGER NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_36AC99F1BF396750 FOREIGN KEY (id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO link (id, url) SELECT id, url FROM __temp__link');
        $this->addSql('DROP TABLE __temp__link');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_content');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, content FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content CLOB NOT NULL, CONSTRAINT FK_23A0E66BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, content) SELECT id, content FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE TEMPORARY TABLE __temp__content AS SELECT id, title, is_private, status, created_at, updated_at, discr FROM content');
        $this->addSql('DROP TABLE content');
        $this->addSql('CREATE TABLE content (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, is_private BOOLEAN NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, discr VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO content (id, title, is_private, status, created_at, updated_at, discr) SELECT id, title, is_private, status, created_at, updated_at, discr FROM __temp__content');
        $this->addSql('DROP TABLE __temp__content');
        $this->addSql('CREATE TEMPORARY TABLE __temp__link AS SELECT id, url FROM link');
        $this->addSql('DROP TABLE link');
        $this->addSql('CREATE TABLE link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) NOT NULL, CONSTRAINT FK_36AC99F1BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO link (id, url) SELECT id, url FROM __temp__link');
        $this->addSql('DROP TABLE __temp__link');
    }
}
