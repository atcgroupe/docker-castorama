<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808101326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fixed_order_sign DROP FOREIGN KEY FK_89DA848E71AFFBB3');
        $this->addSql('CREATE TABLE custom_order_sign (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, sign_id INT NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_ED7097438D9F6D38 (order_id), INDEX IDX_ED7097436FC7C15 (sign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE custom_order_sign ADD CONSTRAINT FK_ED7097438D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE custom_order_sign ADD CONSTRAINT FK_ED7097436FC7C15 FOREIGN KEY (sign_id) REFERENCES sign (id)');
        $this->addSql('DROP TABLE fixed_order_sign');
        $this->addSql('DROP TABLE fixed_sign');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fixed_order_sign (id INT AUTO_INCREMENT NOT NULL, fixed_sign_id INT NOT NULL, order_id INT NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_89DA848E8D9F6D38 (order_id), INDEX IDX_89DA848E71AFFBB3 (fixed_sign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE fixed_sign (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, weight NUMERIC(4, 2) NOT NULL, is_active TINYINT(1) NOT NULL, price NUMERIC(5, 2) NOT NULL, customer_reference VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, category SMALLINT NOT NULL, name VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, width INT NOT NULL, height INT NOT NULL, print_faces VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, material VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, finish VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fixed_order_sign ADD CONSTRAINT FK_89DA848E71AFFBB3 FOREIGN KEY (fixed_sign_id) REFERENCES fixed_sign (id)');
        $this->addSql('ALTER TABLE fixed_order_sign ADD CONSTRAINT FK_89DA848E8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('DROP TABLE custom_order_sign');
        $this->addSql('ALTER TABLE aisle_sign_item CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE aisle_sign_item_category CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE event CHANGE id id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE help help VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email_message email_message VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE material_algeco_sign_item CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE material_dir_order_sign CHANGE title title VARCHAR(2) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE direction direction VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE material_sector_order_sign CHANGE alignment alignment VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE material_sector_sign_item CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE material_sector_sign_item_category CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE material_service_sign_item CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE member CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE member_event CHANGE event_id event_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `order` CHANGE status_id status_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE title title VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE customer_reference customer_reference VARCHAR(20) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE comment comment LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE order_status CHANGE id id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE event_id event_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sector_sign_item CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE color color VARCHAR(5) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE shop CHANGE name name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE post_code post_code VARCHAR(5) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE region region VARCHAR(60) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE delivery_info delivery_info LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sign CHANGE class class VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE title title VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE material material VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE finish finish VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE customer_reference customer_reference VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE switch_flow_builder switch_flow_builder VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE switch_flow_template_file switch_flow_template_file VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sign_category CHANGE label label VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
