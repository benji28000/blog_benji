<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004124721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__utilisateur AS SELECT id, pseudo, mdp, mail FROM utilisateur');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('CREATE TABLE utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pseudo VARCHAR(100) NOT NULL, mdp VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO utilisateur (id, pseudo, mdp, email) SELECT id, pseudo, mdp, mail FROM __temp__utilisateur');
        $this->addSql('DROP TABLE __temp__utilisateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__utilisateur AS SELECT id, pseudo, mdp, email FROM utilisateur');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('CREATE TABLE utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pseudo VARCHAR(100) NOT NULL, mdp VARCHAR(100) NOT NULL, mail VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO utilisateur (id, pseudo, mdp, mail) SELECT id, pseudo, mdp, email FROM __temp__utilisateur');
        $this->addSql('DROP TABLE __temp__utilisateur');
    }
}
