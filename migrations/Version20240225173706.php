<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225173706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id BLOB NOT NULL --(DC2Type:uuid)
        , name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, rating INTEGER DEFAULT NULL, metacritic DOUBLE PRECISION NOT NULL, released DATE DEFAULT NULL, description CLOB DEFAULT NULL, developer VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE game_genre (game_id BLOB NOT NULL --(DC2Type:uuid)
        , genre_id BLOB NOT NULL --(DC2Type:uuid)
        , PRIMARY KEY(game_id, genre_id), CONSTRAINT FK_B1634A77E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B1634A774296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B1634A77E48FD905 ON game_genre (game_id)');
        $this->addSql('CREATE INDEX IDX_B1634A774296D31F ON game_genre (genre_id)');
        $this->addSql('CREATE TABLE game_platform (game_id BLOB NOT NULL --(DC2Type:uuid)
        , platform_id BLOB NOT NULL --(DC2Type:uuid)
        , PRIMARY KEY(game_id, platform_id), CONSTRAINT FK_92162FEDE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_92162FEDFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_92162FEDE48FD905 ON game_platform (game_id)');
        $this->addSql('CREATE INDEX IDX_92162FEDFFE6496F ON game_platform (platform_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_genre');
        $this->addSql('DROP TABLE game_platform');
    }
}
