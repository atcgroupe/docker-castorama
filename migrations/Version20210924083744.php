<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210924083744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aisle_sign_item_category DROP FOREIGN KEY FK_B7CE1FE36FC7C15');
        $this->addSql('DROP INDEX IDX_B7CE1FE36FC7C15 ON aisle_sign_item_category');
        $this->addSql('ALTER TABLE aisle_sign_item_category DROP sign_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aisle_sign_item_category ADD sign_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE aisle_sign_item_category ADD CONSTRAINT FK_B7CE1FE36FC7C15 FOREIGN KEY (sign_id) REFERENCES sign (id)');
        $this->addSql('CREATE INDEX IDX_B7CE1FE36FC7C15 ON aisle_sign_item_category (sign_id)');
    }
}
