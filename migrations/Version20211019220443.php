<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019220443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE estampillado_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE estampillado (id INT NOT NULL, estatuto TEXT NOT NULL, num_expediente VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, qr TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2898C3D95A8BE498 ON estampillado (num_expediente)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2898C3D9D1B862B8 ON estampillado (hash)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(45) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE estampillado_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE estampillado');
        $this->addSql('DROP TABLE users');
    }
}
