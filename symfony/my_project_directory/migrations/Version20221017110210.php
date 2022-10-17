<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017110210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_throw (id INT AUTO_INCREMENT NOT NULL, game_id_id INT NOT NULL, player_id_id INT NOT NULL, points INT NOT NULL, throw_order SMALLINT NOT NULL, INDEX IDX_7DA038B84D77E7D8 (game_id_id), INDEX IDX_7DA038B8C036E511 (player_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_throw ADD CONSTRAINT FK_7DA038B84D77E7D8 FOREIGN KEY (game_id_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_throw ADD CONSTRAINT FK_7DA038B8C036E511 FOREIGN KEY (player_id_id) REFERENCES player (id)');
        $this->addSql('DROP TABLE throws');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE throws (id INT AUTO_INCREMENT NOT NULL, points INT DEFAULT NULL, game_id INT NOT NULL, player_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE game_throw DROP FOREIGN KEY FK_7DA038B84D77E7D8');
        $this->addSql('ALTER TABLE game_throw DROP FOREIGN KEY FK_7DA038B8C036E511');
        $this->addSql('DROP TABLE game_throw');
    }
}
