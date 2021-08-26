<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826201434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aisle_order_sign (id INT AUTO_INCREMENT NOT NULL, item_one_id INT NOT NULL, item_two_id INT DEFAULT NULL, item_three_id INT DEFAULT NULL, order_id INT NOT NULL, aisle_number SMALLINT NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_272B01917D63BBDC (item_one_id), INDEX IDX_272B0191163F5C13 (item_two_id), INDEX IDX_272B01911BACC5AE (item_three_id), INDEX IDX_272B01918D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id VARCHAR(255) NOT NULL, label VARCHAR(60) NOT NULL, help VARCHAR(255) DEFAULT NULL, display_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_70E4FA78E7927C74 (email), INDEX IDX_70E4FA78A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_event (member_id INT NOT NULL, event_id VARCHAR(255) NOT NULL, INDEX IDX_598F9F547597D3FE (member_id), INDEX IDX_598F9F5471F7E88B (event_id), PRIMARY KEY(member_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, member_id INT DEFAULT NULL, status_id INT NOT NULL, title VARCHAR(100) NOT NULL, creation_time DATETIME NOT NULL, last_update_time DATETIME NOT NULL, delivery_date DATE DEFAULT NULL, customer_reference VARCHAR(20) DEFAULT NULL, INDEX IDX_F5299398A76ED395 (user_id), INDEX IDX_F52993987597D3FE (member_id), INDEX IDX_F52993986BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, event_id VARCHAR(255) NOT NULL, label VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_B88F75C971F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sector_order_sign (id INT AUTO_INCREMENT NOT NULL, item_one_id INT NOT NULL, item_two_id INT NOT NULL, order_id INT NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_26E8DD627D63BBDC (item_one_id), INDEX IDX_26E8DD62163F5C13 (item_two_id), INDEX IDX_26E8DD628D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, address VARCHAR(255) NOT NULL, post_code VARCHAR(5) NOT NULL, region VARCHAR(60) DEFAULT NULL, city VARCHAR(60) NOT NULL, delivery_info LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_AC6A4CA25E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sign (id INT AUTO_INCREMENT NOT NULL, class VARCHAR(150) NOT NULL, image VARCHAR(60) NOT NULL, title VARCHAR(60) NOT NULL, description VARCHAR(255) NOT NULL, weight NUMERIC(4, 2) NOT NULL, switch_flow_builder VARCHAR(30) NOT NULL, switch_flow_template_file VARCHAR(30) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sign_item (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, label VARCHAR(60) NOT NULL, image VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_1870EE7712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sign_item_category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, shop_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6494D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B01917D63BBDC FOREIGN KEY (item_one_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B0191163F5C13 FOREIGN KEY (item_two_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B01911BACC5AE FOREIGN KEY (item_three_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B01918D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE member_event ADD CONSTRAINT FK_598F9F547597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_event ADD CONSTRAINT FK_598F9F5471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993987597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE order_status ADD CONSTRAINT FK_B88F75C971F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE sector_order_sign ADD CONSTRAINT FK_26E8DD627D63BBDC FOREIGN KEY (item_one_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE sector_order_sign ADD CONSTRAINT FK_26E8DD62163F5C13 FOREIGN KEY (item_two_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE sector_order_sign ADD CONSTRAINT FK_26E8DD628D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE sign_item ADD CONSTRAINT FK_1870EE7712469DE2 FOREIGN KEY (category_id) REFERENCES sign_item_category (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member_event DROP FOREIGN KEY FK_598F9F5471F7E88B');
        $this->addSql('ALTER TABLE order_status DROP FOREIGN KEY FK_B88F75C971F7E88B');
        $this->addSql('ALTER TABLE member_event DROP FOREIGN KEY FK_598F9F547597D3FE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993987597D3FE');
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B01918D9F6D38');
        $this->addSql('ALTER TABLE sector_order_sign DROP FOREIGN KEY FK_26E8DD628D9F6D38');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494D16C4DD');
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B01917D63BBDC');
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B0191163F5C13');
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B01911BACC5AE');
        $this->addSql('ALTER TABLE sector_order_sign DROP FOREIGN KEY FK_26E8DD627D63BBDC');
        $this->addSql('ALTER TABLE sector_order_sign DROP FOREIGN KEY FK_26E8DD62163F5C13');
        $this->addSql('ALTER TABLE sign_item DROP FOREIGN KEY FK_1870EE7712469DE2');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP TABLE aisle_order_sign');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_event');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE sector_order_sign');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE sign');
        $this->addSql('DROP TABLE sign_item');
        $this->addSql('DROP TABLE sign_item_category');
        $this->addSql('DROP TABLE user');
    }
}
