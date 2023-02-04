<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204214545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, agency VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, info LONGTEXT DEFAULT NULL, price LONGTEXT DEFAULT NULL, paid INT DEFAULT NULL, order_id LONGTEXT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, email_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(10000) DEFAULT NULL');
    }
}
