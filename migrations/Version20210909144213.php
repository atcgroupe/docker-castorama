<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909144213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B0191163F5C13');
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B01911BACC5AE');
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B01917D63BBDC');
        $this->addSql('DROP INDEX IDX_272B0191163F5C13 ON aisle_order_sign');
        $this->addSql('DROP INDEX IDX_272B01917D63BBDC ON aisle_order_sign');
        $this->addSql('DROP INDEX IDX_272B01911BACC5AE ON aisle_order_sign');
        $this->addSql('ALTER TABLE aisle_order_sign ADD item2_id INT DEFAULT NULL, ADD item3_id INT DEFAULT NULL, DROP item_two_id, DROP item_three_id, CHANGE item_one_id item1_id INT NOT NULL');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B01915AAD3E32 FOREIGN KEY (item1_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B0191481891DC FOREIGN KEY (item2_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B0191F0A4F6B9 FOREIGN KEY (item3_id) REFERENCES sign_item (id)');
        $this->addSql('CREATE INDEX IDX_272B01915AAD3E32 ON aisle_order_sign (item1_id)');
        $this->addSql('CREATE INDEX IDX_272B0191481891DC ON aisle_order_sign (item2_id)');
        $this->addSql('CREATE INDEX IDX_272B0191F0A4F6B9 ON aisle_order_sign (item3_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B01915AAD3E32');
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B0191481891DC');
        $this->addSql('ALTER TABLE aisle_order_sign DROP FOREIGN KEY FK_272B0191F0A4F6B9');
        $this->addSql('DROP INDEX IDX_272B01915AAD3E32 ON aisle_order_sign');
        $this->addSql('DROP INDEX IDX_272B0191481891DC ON aisle_order_sign');
        $this->addSql('DROP INDEX IDX_272B0191F0A4F6B9 ON aisle_order_sign');
        $this->addSql('ALTER TABLE aisle_order_sign ADD item_two_id INT DEFAULT NULL, ADD item_three_id INT DEFAULT NULL, DROP item2_id, DROP item3_id, CHANGE item1_id item_one_id INT NOT NULL');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B0191163F5C13 FOREIGN KEY (item_two_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B01911BACC5AE FOREIGN KEY (item_three_id) REFERENCES sign_item (id)');
        $this->addSql('ALTER TABLE aisle_order_sign ADD CONSTRAINT FK_272B01917D63BBDC FOREIGN KEY (item_one_id) REFERENCES sign_item (id)');
        $this->addSql('CREATE INDEX IDX_272B0191163F5C13 ON aisle_order_sign (item_two_id)');
        $this->addSql('CREATE INDEX IDX_272B01917D63BBDC ON aisle_order_sign (item_one_id)');
        $this->addSql('CREATE INDEX IDX_272B01911BACC5AE ON aisle_order_sign (item_three_id)');
    }
}
