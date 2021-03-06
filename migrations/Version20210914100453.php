<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914100453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archive ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE archive ADD CONSTRAINT FK_D5FC5D9CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_D5FC5D9CED5CA9E6 ON archive (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive DROP FOREIGN KEY FK_D5FC5D9CED5CA9E6');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP INDEX IDX_D5FC5D9CED5CA9E6 ON archive');
        $this->addSql('ALTER TABLE archive DROP service_id');
    }
}
