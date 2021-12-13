<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213153035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command_delivery_address (id INT AUTO_INCREMENT NOT NULL, command_shop_id INT NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, commentary LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_179623A8A27C973E (command_shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command_list_product (id INT AUTO_INCREMENT NOT NULL, command_shop_id INT NOT NULL, UNIQUE INDEX UNIQ_256F6536A27C973E (command_shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command_shop (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DC0E22FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_list_command_shop (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, list_product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_242EA8754584665A (product_id), INDEX IDX_242EA8759FA91286 (list_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command_delivery_address ADD CONSTRAINT FK_179623A8A27C973E FOREIGN KEY (command_shop_id) REFERENCES command_shop (id)');
        $this->addSql('ALTER TABLE command_list_product ADD CONSTRAINT FK_256F6536A27C973E FOREIGN KEY (command_shop_id) REFERENCES command_shop (id)');
        $this->addSql('ALTER TABLE command_shop ADD CONSTRAINT FK_DC0E22FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE content_list_command_shop ADD CONSTRAINT FK_242EA8754584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE content_list_command_shop ADD CONSTRAINT FK_242EA8759FA91286 FOREIGN KEY (list_product_id) REFERENCES command_list_product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_list_command_shop DROP FOREIGN KEY FK_242EA8759FA91286');
        $this->addSql('ALTER TABLE command_delivery_address DROP FOREIGN KEY FK_179623A8A27C973E');
        $this->addSql('ALTER TABLE command_list_product DROP FOREIGN KEY FK_256F6536A27C973E');
        $this->addSql('DROP TABLE command_delivery_address');
        $this->addSql('DROP TABLE command_list_product');
        $this->addSql('DROP TABLE command_shop');
        $this->addSql('DROP TABLE content_list_command_shop');
    }
}
