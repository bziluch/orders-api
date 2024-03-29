<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108192317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, order_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordered_product (id INT AUTO_INCREMENT NOT NULL, order__id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_E6F097B6251A8A50 (order__id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price_netto NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ordered_product ADD CONSTRAINT FK_E6F097B6251A8A50 FOREIGN KEY (order__id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE ordered_product ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE ordered_product ADD CONSTRAINT FK_E6F097B64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_E6F097B64584665A ON ordered_product (product_id)');
        $this->addSql('ALTER TABLE `order` ADD price_netto NUMERIC(10, 2) DEFAULT NULL, ADD price_vat NUMERIC(10, 2) DEFAULT NULL, ADD price_brutto NUMERIC(10, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP price_netto, DROP price_vat, DROP price_brutto');
        $this->addSql('ALTER TABLE ordered_product DROP FOREIGN KEY FK_E6F097B64584665A');
        $this->addSql('DROP INDEX IDX_E6F097B64584665A ON ordered_product');
        $this->addSql('ALTER TABLE ordered_product DROP product_id');
        $this->addSql('ALTER TABLE ordered_product DROP FOREIGN KEY FK_E6F097B6251A8A50');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE ordered_product');
        $this->addSql('DROP TABLE product');
    }
}
