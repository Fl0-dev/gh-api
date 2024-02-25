<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225121159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__genre AS SELECT id, name, slug, description FROM genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('CREATE TABLE genre (id BLOB NOT NULL --(DC2Type:uuid)
        , name VARCHAR(30) NOT NULL, slug VARCHAR(30) NOT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO genre (id, name, slug, description) SELECT id, name, slug, description FROM __temp__genre');
        $this->addSql('DROP TABLE __temp__genre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__genre AS SELECT id, name, slug, description FROM genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(30) NOT NULL, slug VARCHAR(30) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO genre (id, name, slug, description) SELECT id, name, slug, description FROM __temp__genre');
        $this->addSql('DROP TABLE __temp__genre');
    }
}
