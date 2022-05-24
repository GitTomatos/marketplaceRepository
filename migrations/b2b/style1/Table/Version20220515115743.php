<?php

declare(strict_types=1);

namespace b2b\style1\Table;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515115743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO b2b_style1_organization
VALUES (1,
        'Первый организатор',
        'Российская Федерация, 116578, Нижний Новгород, ул. Архангельская, 85',
        '+79876543210',
        'test_organization@gmail.com')");

        $this->addSql("INSERT INTO b2b_style1_user
VALUES (1,
        'Пользователь 1',
        'Его организация');
");

        $this->addSql("INSERT INTO b2b_style1_purchase
VALUES (1,
        'electronicAuction',
        'Имя 1',
        'Информация 1',
        1,
        '2025-04-26 16:12:12',
        1),
       (4,
        'electronicAuction',
        'Имя 2',
        'Эл аукцион 1',
        700000,
        '2022-04-20 10:30:00',
        1),
       (5,
        'electronicAuction',
        'Имя 2',
        'Эл аукцион 2',
        30000,
        '2022-04-25 13:00:00',
        1),
       (6, 'electronicAuction',
        'Имя 3',
        'Эл аукцион 3',
        150000,
        '2022-04-15 10:30:00',
        1)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
