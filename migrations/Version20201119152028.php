<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119152028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F3E591AD90361416');
        $this->addSql('DROP INDEX UNIQ_F3E591ADE7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ducks AS SELECT id, email, roles, password, firstname, lastname, duckname FROM ducks');
        $this->addSql('DROP TABLE ducks');
        $this->addSql('CREATE TABLE ducks (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , password VARCHAR(255) NOT NULL COLLATE BINARY, firstname VARCHAR(50) NOT NULL COLLATE BINARY, lastname VARCHAR(50) NOT NULL COLLATE BINARY, duckname VARCHAR(50) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO ducks (id, email, roles, password, firstname, lastname, duckname) SELECT id, email, roles, password, firstname, lastname, duckname FROM __temp__ducks');
        $this->addSql('DROP TABLE __temp__ducks');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3E591ADE7927C74 ON ducks (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F3E591ADE7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ducks AS SELECT id, email, roles, password, firstname, lastname, duckname FROM ducks');
        $this->addSql('DROP TABLE ducks');
        $this->addSql('CREATE TABLE ducks (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, duckname VARCHAR(50) NOT NULL)');
        $this->addSql('INSERT INTO ducks (id, email, roles, password, firstname, lastname, duckname) SELECT id, email, roles, password, firstname, lastname, duckname FROM __temp__ducks');
        $this->addSql('DROP TABLE __temp__ducks');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3E591ADE7927C74 ON ducks (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3E591AD90361416 ON ducks (duckname)');
    }
}
