<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225120949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__platform AS SELECT id, name, slug, description FROM platform');
        $this->addSql('DROP TABLE platform');
        $this->addSql('CREATE TABLE platform (id BLOB NOT NULL --(DC2Type:uuid)
        , name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO platform (id, name, slug, description) SELECT id, name, slug, description FROM __temp__platform');
        $this->addSql('DROP TABLE __temp__platform');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__platform AS SELECT id, name, slug, description FROM platform');
        $this->addSql('DROP TABLE platform');
        $this->addSql('CREATE TABLE platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO platform (id, name, slug, description) SELECT id, name, slug, description FROM __temp__platform');
        $this->addSql('DROP TABLE __temp__platform');
    }
}
