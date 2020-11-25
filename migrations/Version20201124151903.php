<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124151903 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6FF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, author_id, content, created_at, picture FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_83D44F6FF675F31B FOREIGN KEY (author_id) REFERENCES ducks (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack (id, author_id, content, created_at, picture) SELECT id, author_id, content, created_at, picture FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6FF675F31B ON quack (author_id)');
        $this->addSql('ALTER TABLE tag ADD COLUMN category_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_A1385669D3950CA9');
        $this->addSql('DROP INDEX IDX_A1385669BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag_quack AS SELECT tag_id, quack_id FROM tag_quack');
        $this->addSql('DROP TABLE tag_quack');
        $this->addSql('CREATE TABLE tag_quack (tag_id INTEGER NOT NULL, quack_id INTEGER NOT NULL, PRIMARY KEY(tag_id, quack_id), CONSTRAINT FK_A1385669BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A1385669D3950CA9 FOREIGN KEY (quack_id) REFERENCES quack (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tag_quack (tag_id, quack_id) SELECT tag_id, quack_id FROM __temp__tag_quack');
        $this->addSql('DROP TABLE __temp__tag_quack');
        $this->addSql('CREATE INDEX IDX_A1385669D3950CA9 ON tag_quack (quack_id)');
        $this->addSql('CREATE INDEX IDX_A1385669BAD26311 ON tag_quack (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6FF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, author_id, content, created_at, picture FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO quack (id, author_id, content, created_at, picture) SELECT id, author_id, content, created_at, picture FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6FF675F31B ON quack (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag AS SELECT id FROM tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO tag (id) SELECT id FROM __temp__tag');
        $this->addSql('DROP TABLE __temp__tag');
        $this->addSql('DROP INDEX IDX_A1385669BAD26311');
        $this->addSql('DROP INDEX IDX_A1385669D3950CA9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag_quack AS SELECT tag_id, quack_id FROM tag_quack');
        $this->addSql('DROP TABLE tag_quack');
        $this->addSql('CREATE TABLE tag_quack (tag_id INTEGER NOT NULL, quack_id INTEGER NOT NULL, PRIMARY KEY(tag_id, quack_id))');
        $this->addSql('INSERT INTO tag_quack (tag_id, quack_id) SELECT tag_id, quack_id FROM __temp__tag_quack');
        $this->addSql('DROP TABLE __temp__tag_quack');
        $this->addSql('CREATE INDEX IDX_A1385669BAD26311 ON tag_quack (tag_id)');
        $this->addSql('CREATE INDEX IDX_A1385669D3950CA9 ON tag_quack (quack_id)');
    }
}
