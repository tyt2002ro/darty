<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028122834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD throw_players_order VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE game_throw DROP FOREIGN KEY FK_7DA038B8C036E511');
        $this->addSql('ALTER TABLE game_throw DROP FOREIGN KEY FK_7DA038B84D77E7D8');
        //$this->addSql('DROP INDEX idx_7da038b84d77e7d8 ON game_throw');
        $this->addSql('CREATE INDEX IDX_7DA038B8E48FD905 ON game_throw (game_id)');
        $this->addSql('DROP INDEX idx_7da038b8c036e511 ON game_throw');
        $this->addSql('CREATE INDEX IDX_7DA038B899E6F5DF ON game_throw (player_id)');
        $this->addSql('ALTER TABLE game_throw ADD CONSTRAINT FK_7DA038B8C036E511 FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game_throw ADD CONSTRAINT FK_7DA038B84D77E7D8 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP throw_players_order');
        $this->addSql('ALTER TABLE game_throw DROP FOREIGN KEY FK_7DA038B8E48FD905');
        $this->addSql('ALTER TABLE game_throw DROP FOREIGN KEY FK_7DA038B899E6F5DF');
        $this->addSql('DROP INDEX idx_7da038b899e6f5df ON game_throw');
        $this->addSql('CREATE INDEX IDX_7DA038B8C036E511 ON game_throw (player_id)');
        $this->addSql('DROP INDEX idx_7da038b8e48fd905 ON game_throw');
        $this->addSql('CREATE INDEX IDX_7DA038B84D77E7D8 ON game_throw (game_id)');
        $this->addSql('ALTER TABLE game_throw ADD CONSTRAINT FK_7DA038B8E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_throw ADD CONSTRAINT FK_7DA038B899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
    }
}
