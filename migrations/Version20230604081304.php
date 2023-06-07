<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230604081304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tuser DROP use_number_phone, CHANGE email email VARCHAR(255) NOT NULL, CHANGE use_first_name use_first_name VARCHAR(50) NOT NULL, CHANGE use_last_name use_last_name VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tuser ADD use_number_phone VARCHAR(15) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE use_first_name use_first_name VARCHAR(20) NOT NULL, CHANGE use_last_name use_last_name VARCHAR(29) NOT NULL');
    }
}
