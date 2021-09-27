<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210924131506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aisle_small_order_sign (id INT AUTO_INCREMENT NOT NULL, item1_id INT NOT NULL, item2_id INT DEFAULT NULL, item3_id INT DEFAULT NULL, order_id INT NOT NULL, sign_id INT NOT NULL, aisle_number INT NOT NULL, quantity SMALLINT NOT NULL, INDEX IDX_7A458AAD5AAD3E32 (item1_id), INDEX IDX_7A458AAD481891DC (item2_id), INDEX IDX_7A458AADF0A4F6B9 (item3_id), INDEX IDX_7A458AAD8D9F6D38 (order_id), INDEX IDX_7A458AAD6FC7C15 (sign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aisle_small_order_sign ADD CONSTRAINT FK_7A458AAD5AAD3E32 FOREIGN KEY (item1_id) REFERENCES aisle_sign_item (id)');
        $this->addSql('ALTER TABLE aisle_small_order_sign ADD CONSTRAINT FK_7A458AAD481891DC FOREIGN KEY (item2_id) REFERENCES aisle_sign_item (id)');
        $this->addSql('ALTER TABLE aisle_small_order_sign ADD CONSTRAINT FK_7A458AADF0A4F6B9 FOREIGN KEY (item3_id) REFERENCES aisle_sign_item (id)');
        $this->addSql('ALTER TABLE aisle_small_order_sign ADD CONSTRAINT FK_7A458AAD8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE aisle_small_order_sign ADD CONSTRAINT FK_7A458AAD6FC7C15 FOREIGN KEY (sign_id) REFERENCES sign (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE aisle_small_order_sign');
    }
}
