<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831223035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content_tag (content_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(content_id, tag_id), CONSTRAINT FK_B662E17684A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B662E176BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B662E17684A0A3ED ON content_tag (content_id)');
        $this->addSql('CREATE INDEX IDX_B662E176BAD26311 ON content_tag (tag_id)');
        $this->addSql('DROP TABLE tag_content');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, content FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER NOT NULL, content CLOB NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_23A0E66BF396750 FOREIGN KEY (id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, content) SELECT id, content FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE TEMPORARY TABLE __temp__link AS SELECT id, url FROM link');
        $this->addSql('DROP TABLE link');
        $this->addSql('CREATE TABLE link (id INTEGER NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_36AC99F1BF396750 FOREIGN KEY (id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO link (id, url) SELECT id, url FROM __temp__link');
        $this->addSql('DROP TABLE __temp__link');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag_content (tag_id INTEGER NOT NULL, content_id INTEGER NOT NULL, PRIMARY KEY(tag_id, content_id), CONSTRAINT FK_CCF41D03BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CCF41D0384A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CCF41D0384A0A3ED ON tag_content (content_id)');
        $this->addSql('CREATE INDEX IDX_CCF41D03BAD26311 ON tag_content (tag_id)');
        $this->addSql('DROP TABLE content_tag');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, content FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content CLOB NOT NULL, CONSTRAINT FK_23A0E66BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, content) SELECT id, content FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE TEMPORARY TABLE __temp__link AS SELECT id, url FROM link');
        $this->addSql('DROP TABLE link');
        $this->addSql('CREATE TABLE link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) NOT NULL, CONSTRAINT FK_36AC99F1BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO link (id, url) SELECT id, url FROM __temp__link');
        $this->addSql('DROP TABLE __temp__link');
    }
}
