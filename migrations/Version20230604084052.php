<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230604084052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taddress CHANGE add_address add_address VARCHAR(70) NOT NULL, CHANGE add_city add_city VARCHAR(50) NOT NULL, CHANGE add_latitude add_latitude DOUBLE PRECISION NOT NULL, CHANGE add_longitude add_longitude DOUBLE PRECISION NOT NULL, CHANGE add_first_name add_first_name VARCHAR(50) NOT NULL, CHANGE add_last_name add_last_name VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taddress CHANGE add_address add_address VARCHAR(100) NOT NULL, CHANGE add_city add_city VARCHAR(20) NOT NULL, CHANGE add_latitude add_latitude VARCHAR(20) NOT NULL, CHANGE add_longitude add_longitude VARCHAR(20) NOT NULL, CHANGE add_first_name add_first_name VARCHAR(20) NOT NULL, CHANGE add_last_name add_last_name VARCHAR(20) NOT NULL');
    }
}
