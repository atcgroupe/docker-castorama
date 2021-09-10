<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910131424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aisle_order_sign ADD sign_id INT NOT NULL');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B01916FC7C15 FOREIGN KEY (sign_id) REFERENCES sign (id)');
        $this->addSql('CREATE INDEX IDX_272B01916FC7C15 ON aisle_order_sign (sign_id)');
        $this->addSql('ALTER TABLE sector_order_sign ADD sign_id INT NOT NULL');
        $this->addSql('ALTER TABLE sector_order_sign ADD CONSTRAINT FK_26E8DD626FC7C15 FOREIGN KEY (sign_id) REFERENCES sign (id)');
        $this->addSql('CREATE INDEX IDX_26E8DD626FC7C15 ON sector_order_sign (sign_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B01916FC7C15');
        $this->addSql('DROP INDEX IDX_272B01916FC7C15 ON aisle_order_sign');
        $this->addSql('ALTER TABLE aisle_order_sign DROP sign_id');
        $this->addSql('ALTER TABLE sector_order_sign DROP FOREIGN KEY FK_26E8DD626FC7C15');
        $this->addSql('DROP INDEX IDX_26E8DD626FC7C15 ON sector_order_sign');
        $this->addSql('ALTER TABLE sector_order_sign DROP sign_id');
    }
}
