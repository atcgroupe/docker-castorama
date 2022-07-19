<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718140955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material_sector_order_sign (id INT AUTO_INCREMENT NOT NULL, item1_id INT NOT NULL, item2_id INT DEFAULT NULL, item3_id INT DEFAULT NULL, order_id INT NOT NULL, sign_id INT NOT NULL, aisle_number SMALLINT NOT NULL, alignment VARCHAR(10) NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_D0ABBFF75AAD3E32 (item1_id), INDEX IDX_D0ABBFF7481891DC (item2_id), INDEX IDX_D0ABBFF7F0A4F6B9 (item3_id), INDEX IDX_D0ABBFF78D9F6D38 (order_id), INDEX IDX_D0ABBFF76FC7C15 (sign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material_sector_sign_item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, label VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_51F7FAB412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF75AAD3E32 FOREIGN KEY (item1_id) REFERENCES material_sector_sign_item (id)');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF7481891DC FOREIGN KEY (item2_id) REFERENCES material_sector_sign_item (id)');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF7F0A4F6B9 FOREIGN KEY (item3_id) REFERENCES material_sector_sign_item (id)');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF78D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE material_sector_order_sign ADD CONSTRAINT FK_D0ABBFF76FC7C15 FOREIGN KEY (sign_id) REFERENCES sign (id)');
        $this->addSql('ALTER TABLE material_sector_sign_item ADD CONSTRAINT FK_51F7FAB412469DE2 FOREIGN KEY (category_id) REFERENCES material_sector_sign_item_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_sector_order_sign DROP FOREIGN KEY FK_D0ABBFF75AAD3E32');
        $this->addSql('ALTER TABLE material_sector_order_sign DROP FOREIGN KEY FK_D0ABBFF7481891DC');
        $this->addSql('ALTER TABLE material_sector_order_sign DROP FOREIGN KEY FK_D0ABBFF7F0A4F6B9');
        $this->addSql('DROP TABLE material_sector_order_sign');
        $this->addSql('DROP TABLE material_sector_sign_item');
        $this->addSql('ALTER TABLE aisle_sign_item CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE aisle_sign_item_category CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE event CHANGE id id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE help help VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email_message email_message VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE material_sector_sign_item_category CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE member CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE member_event CHANGE event_id event_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `order` CHANGE status_id status_id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE title title VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE customer_reference customer_reference VARCHAR(20) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE comment comment LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE order_status CHANGE id id VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE event_id event_id VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE label label VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sector_sign_item CHANGE label label VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE color color VARCHAR(5) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE shop CHANGE name name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE address address VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE post_code post_code VARCHAR(5) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE region region VARCHAR(60) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE delivery_info delivery_info LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sign CHANGE class class VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE title title VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE switch_flow_builder switch_flow_builder VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE switch_flow_template_file switch_flow_template_file VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE customer_reference customer_reference VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
