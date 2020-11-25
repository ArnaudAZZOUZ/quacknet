<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125152756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6FF8697D13');
        $this->addSql('DROP INDEX IDX_83D44F6FF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, author_id, comment_id, content, created_at, picture FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, comment_id INTEGER DEFAULT NULL, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL COLLATE BINARY, critik VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_83D44F6FF675F31B FOREIGN KEY (author_id) REFERENCES ducks (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_83D44F6FF8697D13 FOREIGN KEY (comment_id) REFERENCES quack (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack (id, author_id, comment_id, content, created_at, picture) SELECT id, author_id, comment_id, content, created_at, picture FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6FF8697D13 ON quack (comment_id)');
        $this->addSql('CREATE INDEX IDX_83D44F6FF675F31B ON quack (author_id)');
        $this->addSql('DROP INDEX IDX_C7845150D3950CA9');
        $this->addSql('DROP INDEX IDX_C7845150BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack_tag AS SELECT quack_id, tag_id FROM quack_tag');
        $this->addSql('DROP TABLE quack_tag');
        $this->addSql('CREATE TABLE quack_tag (quack_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(quack_id, tag_id), CONSTRAINT FK_C7845150D3950CA9 FOREIGN KEY (quack_id) REFERENCES quack (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C7845150BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack_tag (quack_id, tag_id) SELECT quack_id, tag_id FROM __temp__quack_tag');
        $this->addSql('DROP TABLE __temp__quack_tag');
        $this->addSql('CREATE INDEX IDX_C7845150D3950CA9 ON quack_tag (quack_id)');
        $this->addSql('CREATE INDEX IDX_C7845150BAD26311 ON quack_tag (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_83D44F6FF675F31B');
        $this->addSql('DROP INDEX IDX_83D44F6FF8697D13');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, author_id, comment_id, content, created_at, picture FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, comment_id INTEGER DEFAULT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO quack (id, author_id, comment_id, content, created_at, picture) SELECT id, author_id, comment_id, content, created_at, picture FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6FF675F31B ON quack (author_id)');
        $this->addSql('CREATE INDEX IDX_83D44F6FF8697D13 ON quack (comment_id)');
        $this->addSql('DROP INDEX IDX_C7845150D3950CA9');
        $this->addSql('DROP INDEX IDX_C7845150BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack_tag AS SELECT quack_id, tag_id FROM quack_tag');
        $this->addSql('DROP TABLE quack_tag');
        $this->addSql('CREATE TABLE quack_tag (quack_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(quack_id, tag_id))');
        $this->addSql('INSERT INTO quack_tag (quack_id, tag_id) SELECT quack_id, tag_id FROM __temp__quack_tag');
        $this->addSql('DROP TABLE __temp__quack_tag');
        $this->addSql('CREATE INDEX IDX_C7845150D3950CA9 ON quack_tag (quack_id)');
        $this->addSql('CREATE INDEX IDX_C7845150BAD26311 ON quack_tag (tag_id)');
    }
}
