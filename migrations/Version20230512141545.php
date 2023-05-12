<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512141545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ttitle (id INT AUTO_INCREMENT NOT NULL, tit_name VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taddress ADD idx_title_id INT NOT NULL');
        $this->addSql('ALTER TABLE taddress ADD CONSTRAINT FK_DD1AF0FC9EB6653 FOREIGN KEY (idx_title_id) REFERENCES ttitle (id)');
        $this->addSql('CREATE INDEX IDX_DD1AF0FC9EB6653 ON taddress (idx_title_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taddress DROP FOREIGN KEY FK_DD1AF0FC9EB6653');
        $this->addSql('DROP TABLE ttitle');
        $this->addSql('DROP INDEX IDX_DD1AF0FC9EB6653 ON taddress');
        $this->addSql('ALTER TABLE taddress DROP idx_title_id');
    }
}
