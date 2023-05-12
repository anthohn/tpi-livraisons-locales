<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512084401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taddress (id INT AUTO_INCREMENT NOT NULL, idx_user_id INT NOT NULL, add_address VARCHAR(100) NOT NULL, add_city VARCHAR(20) NOT NULL, add_pc SMALLINT NOT NULL, add_country VARCHAR(25) NOT NULL, add_latitude BIGINT NOT NULL, add_longitude BIGINT NOT NULL, INDEX IDX_DD1AF0FC656D3117 (idx_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tcart (id INT AUTO_INCREMENT NOT NULL, idx_product_id INT NOT NULL, idx_user_id INT NOT NULL, car_added_date DATE NOT NULL, INDEX IDX_E097E6B9527469A2 (idx_product_id), INDEX IDX_E097E6B9656D3117 (idx_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thave (id INT AUTO_INCREMENT NOT NULL, idx_order_id INT NOT NULL, idx_product_id INT NOT NULL, INDEX IDX_394A844E8EEB8CD6 (idx_order_id), INDEX IDX_394A844E527469A2 (idx_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE torder (id INT AUTO_INCREMENT NOT NULL, idx_status_id INT NOT NULL, idx_address_id INT NOT NULL, idx_user_id INT NOT NULL, idx_time_id INT NOT NULL, ord_date DATE NOT NULL, ord_price SMALLINT NOT NULL, INDEX IDX_127A8AF12C46BB23 (idx_status_id), INDEX IDX_127A8AF1E247A08D (idx_address_id), INDEX IDX_127A8AF1656D3117 (idx_user_id), INDEX IDX_127A8AF19CE93FB9 (idx_time_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tproduct (id INT AUTO_INCREMENT NOT NULL, pro_name VARCHAR(50) NOT NULL, pro_price SMALLINT NOT NULL, pro_quantity SMALLINT NOT NULL, pro_description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tstatus (id INT AUTO_INCREMENT NOT NULL, sta_name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ttime (id INT AUTO_INCREMENT NOT NULL, tim_slice VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tuser (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, use_first_name VARCHAR(20) NOT NULL, use_last_name VARCHAR(29) NOT NULL, use_created_date DATE NOT NULL, UNIQUE INDEX UNIQ_66A7B847E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taddress ADD CONSTRAINT FK_DD1AF0FC656D3117 FOREIGN KEY (idx_user_id) REFERENCES tuser (id)');
        $this->addSql('ALTER TABLE tcart ADD CONSTRAINT FK_E097E6B9527469A2 FOREIGN KEY (idx_product_id) REFERENCES tproduct (id)');
        $this->addSql('ALTER TABLE tcart ADD CONSTRAINT FK_E097E6B9656D3117 FOREIGN KEY (idx_user_id) REFERENCES tuser (id)');
        $this->addSql('ALTER TABLE thave ADD CONSTRAINT FK_394A844E8EEB8CD6 FOREIGN KEY (idx_order_id) REFERENCES torder (id)');
        $this->addSql('ALTER TABLE thave ADD CONSTRAINT FK_394A844E527469A2 FOREIGN KEY (idx_product_id) REFERENCES tproduct (id)');
        $this->addSql('ALTER TABLE torder ADD CONSTRAINT FK_127A8AF12C46BB23 FOREIGN KEY (idx_status_id) REFERENCES tstatus (id)');
        $this->addSql('ALTER TABLE torder ADD CONSTRAINT FK_127A8AF1E247A08D FOREIGN KEY (idx_address_id) REFERENCES taddress (id)');
        $this->addSql('ALTER TABLE torder ADD CONSTRAINT FK_127A8AF1656D3117 FOREIGN KEY (idx_user_id) REFERENCES tuser (id)');
        $this->addSql('ALTER TABLE torder ADD CONSTRAINT FK_127A8AF19CE93FB9 FOREIGN KEY (idx_time_id) REFERENCES ttime (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taddress DROP FOREIGN KEY FK_DD1AF0FC656D3117');
        $this->addSql('ALTER TABLE tcart DROP FOREIGN KEY FK_E097E6B9527469A2');
        $this->addSql('ALTER TABLE tcart DROP FOREIGN KEY FK_E097E6B9656D3117');
        $this->addSql('ALTER TABLE thave DROP FOREIGN KEY FK_394A844E8EEB8CD6');
        $this->addSql('ALTER TABLE thave DROP FOREIGN KEY FK_394A844E527469A2');
        $this->addSql('ALTER TABLE torder DROP FOREIGN KEY FK_127A8AF12C46BB23');
        $this->addSql('ALTER TABLE torder DROP FOREIGN KEY FK_127A8AF1E247A08D');
        $this->addSql('ALTER TABLE torder DROP FOREIGN KEY FK_127A8AF1656D3117');
        $this->addSql('ALTER TABLE torder DROP FOREIGN KEY FK_127A8AF19CE93FB9');
        $this->addSql('DROP TABLE taddress');
        $this->addSql('DROP TABLE tcart');
        $this->addSql('DROP TABLE thave');
        $this->addSql('DROP TABLE torder');
        $this->addSql('DROP TABLE tproduct');
        $this->addSql('DROP TABLE tstatus');
        $this->addSql('DROP TABLE ttime');
        $this->addSql('DROP TABLE tuser');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
