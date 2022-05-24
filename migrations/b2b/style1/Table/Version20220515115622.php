<?php

declare(strict_types=1);

namespace b2b\style1\Table;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515115622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE b2b_style1_organization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, postal_address VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE b2b_style1_package (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, info VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, price INT NOT NULL, userId INT NOT NULL, purchaseId INT NOT NULL, UNIQUE INDEX UNIQ_C2D2A5A75E237E06 (name), INDEX IDX_C2D2A5A764B64DCC (userId), INDEX IDX_C2D2A5A7E7DB2F9F (purchaseId), UNIQUE INDEX UNIQ_C2D2A5A764B64DCCE7DB2F9F (userId, purchaseId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE b2b_style1_purchase (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, info VARCHAR(255) NOT NULL, maxPrice INT NOT NULL, closeDateTime DATETIME NOT NULL, organizerId INT NOT NULL, INDEX IDX_A9DC3A799ADB1B9 (organizerId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE b2b_style1_user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, organization VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE b2b_style1_package ADD CONSTRAINT FK_C2D2A5A764B64DCC FOREIGN KEY (userId) REFERENCES b2b_style1_user (id)');
        $this->addSql('ALTER TABLE b2b_style1_package ADD CONSTRAINT FK_C2D2A5A7E7DB2F9F FOREIGN KEY (purchaseId) REFERENCES b2b_style1_purchase (id)');
        $this->addSql('ALTER TABLE b2b_style1_purchase ADD CONSTRAINT FK_A9DC3A799ADB1B9 FOREIGN KEY (organizerId) REFERENCES b2b_style1_organization (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE b2b_style1_purchase DROP FOREIGN KEY FK_A9DC3A799ADB1B9');
        $this->addSql('ALTER TABLE b2b_style1_package DROP FOREIGN KEY FK_C2D2A5A7E7DB2F9F');
        $this->addSql('ALTER TABLE b2b_style1_package DROP FOREIGN KEY FK_C2D2A5A764B64DCC');
        $this->addSql('DROP TABLE b2b_style1_organization');
        $this->addSql('DROP TABLE b2b_style1_package');
        $this->addSql('DROP TABLE b2b_style1_purchase');
        $this->addSql('DROP TABLE b2b_style1_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
